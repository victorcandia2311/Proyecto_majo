<?php

require_once __DIR__ . "/../../config/conexion.php";
require_once __DIR__ . "/../models/Venta.php";
require_once __DIR__ . "/../pdf/ReciboPDF.php";


class VentaController
{
    private $ventaModel;


    public function __construct()
    {
        global $conexion;

        $this->ventaModel =
            new Venta($conexion);


        // Iniciar sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        // Crear carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }


    // ==========================================
    // MOSTRAR VENTAS
    // ==========================================
    public function index()
    {
        $productos =
            $this->ventaModel
                ->obtenerProductos();

        $ventas =
            $this->ventaModel
                ->obtenerVentas();

        $carrito =
            $_SESSION['carrito'];


        require_once __DIR__ .
            "/../views/ventas/index.php";
    }


    // ==========================================
    // AGREGAR PRODUCTO AL CARRITO
    // ==========================================
    public function agregar()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            die("Método no permitido.");
        }


        $id_producto =
            $_POST["id_producto"] ?? null;

        $cantidad =
            $_POST["cantidad"] ?? null;


        if (!$id_producto || !$cantidad) {
            die("Datos incompletos.");
        }


        $cantidad = (int) $cantidad;


        if ($cantidad <= 0) {
            die("La cantidad debe ser mayor que 0.");
        }


        $producto =
            $this->ventaModel
                ->obtenerProducto($id_producto);


        if (!$producto) {
            die("Producto no encontrado.");
        }


        if ($producto['stock_actual'] < $cantidad) {

            die(
                "Stock insuficiente. "
                . "Disponible: "
                . $producto['stock_actual']
            );
        }


        // --------------------------------------
        // SI YA ESTÁ EN EL CARRITO
        // --------------------------------------

        if (
            isset(
                $_SESSION['carrito'][$id_producto]
            )
        ) {

            $nuevaCantidad =
                $_SESSION['carrito']
                [$id_producto]['cantidad']
                + $cantidad;


            if (
                $nuevaCantidad >
                $producto['stock_actual']
            ) {

                die(
                    "La cantidad solicitada supera "
                    . "el stock disponible."
                );
            }


            $_SESSION['carrito']
                [$id_producto]['cantidad']
                = $nuevaCantidad;

        } else {

            $_SESSION['carrito']
                [$id_producto] = [

                'id_producto' =>
                    $producto['id_producto'],

                'nombre_producto' =>
                    $producto['nombre_producto'],

                'cantidad' =>
                    $cantidad,

                'precio_unitario' =>
                    $producto['precio_venta']
            ];
        }


        header(
            "Location: /Proyecto_majo/public/index.php?modulo=ventas"
        );

        exit;
    }


    // ==========================================
    // ELIMINAR PRODUCTO DEL CARRITO
    // ==========================================
    public function eliminar()
    {
        $id_producto =
            $_GET["id"] ?? null;


        if ($id_producto) {

            unset(
                $_SESSION['carrito'][$id_producto]
            );
        }


        header(
            "Location: /Proyecto_majo/public/index.php?modulo=ventas"
        );

        exit;
    }


    // ==========================================
    // VACIAR CARRITO
    // ==========================================
    public function vaciar()
    {
        $_SESSION['carrito'] = [];


        header(
            "Location: /Proyecto_majo/public/index.php?modulo=ventas"
        );

        exit;
    }


    // ==========================================
    // CONFIRMAR VENTA
    // ==========================================
    public function confirmar()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            die("Método no permitido.");
        }


        if (empty($_SESSION['carrito'])) {

            die(
                "El carrito está vacío."
            );
        }


        $cliente_nombre =
            trim(
                $_POST["cliente_nombre"] ?? ""
            );


        $cliente_documento =
            trim(
                $_POST["cliente_documento"] ?? ""
            );


        $metodo_pago =
            $_POST["metodo_pago"] ?? "";


        $metodosPermitidos = [
            "Efectivo",
            "Yape",
            "Plin",
            "Tarjeta"
        ];


        if (
            !in_array(
                $metodo_pago,
                $metodosPermitidos,
                true
            )
        ) {

            die(
                "Método de pago no válido."
            );
        }


        try {

            $id_venta =
                $this->ventaModel
                    ->registrarVenta(
                        $cliente_nombre,
                        $cliente_documento,
                        $metodo_pago,
                        $_SESSION['carrito']
                    );


            // Vaciar carrito
            $_SESSION['carrito'] = [];


            // Guardar venta recién creada
            $_SESSION['venta_exitosa'] =
                $id_venta;


            header(
                "Location: /Proyecto_majo/public/index.php?modulo=ventas"
            );

            exit;


        } catch (Exception $e) {

            die(
                "No se pudo registrar la venta: "
                . $e->getMessage()
            );
        }
    }


    // ==========================================
    // VER DETALLE DE VENTA
    // ==========================================
    public function detalle()
    {
        $id_venta =
            $_GET["id"] ?? null;


        if (!$id_venta) {
            die("Venta no especificada.");
        }


        $venta =
            $this->ventaModel
                ->obtenerVenta($id_venta);


        if (!$venta) {
            die("Venta no encontrada.");
        }


        $detalles =
            $this->ventaModel
                ->obtenerDetalleVenta(
                    $id_venta
                );


        require_once __DIR__ .
            "/../views/ventas/detalle.php";
    }

    // ==========================================
    // GENERAR RECIBO PDF
    // ==========================================
    public function pdf()
{
    if (!isset($_GET['id'])) {
        echo "Venta no especificada.";
        return;
    }

    $id_venta = intval($_GET['id']);

    $venta = $this->ventaModel->obtenerVenta($id_venta);
    $detalle = $this->ventaModel->obtenerDetalleVenta($id_venta);

    if (!$venta) {
        echo "La venta no existe.";
        return;
    }

    ReciboPDF::generar($venta, $detalle);
}
}