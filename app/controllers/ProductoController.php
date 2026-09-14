<?php

require_once __DIR__ . "/../../config/conexion.php";
require_once __DIR__ . "/../models/Producto.php";


class ProductoController
{
    private $productoModel;

    public function __construct()
    {
        global $conexion;

        $this->productoModel = new Producto($conexion);
    }


    // ==========================================
    // MOSTRAR PRODUCTOS
    // ==========================================
    public function index()
    {
        $productos = $this->productoModel->obtenerProductos();

        require_once __DIR__ . "/../views/productos/index.php";
    }


    // ==========================================
    // MOSTRAR FORMULARIO CREAR
    // ==========================================
    public function crear()
    {
        require_once __DIR__ . "/../views/productos/crear.php";
    }


    // ==========================================
    // GUARDAR PRODUCTO
    // ==========================================
    public function guardar()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $nombre = trim($_POST["nombre_producto"]);
            $stock = $_POST["stock_actual"];
            $stockMinimo = $_POST["stock_minimo_alerta"];
            $precio = $_POST["precio_venta"];

            $this->productoModel->registrar(
                $nombre,
                $stock,
                $stockMinimo,
                $precio
            );

            header(
                "Location: /Proyecto_majo/public/index.php?modulo=productos"
            );

            exit;
        }
    }


    // ==========================================
    // MOSTRAR FORMULARIO EDITAR
    // ==========================================
    public function editar()
    {
        if (!isset($_GET["id"])) {
            die("Producto no especificado.");
        }

        $id = $_GET["id"];

        $producto = $this->productoModel->obtenerPorId($id);

        if (!$producto) {
            die("Producto no encontrado.");
        }

        require_once __DIR__ . "/../views/productos/editar.php";
    }


    // ==========================================
    // ACTUALIZAR PRODUCTO
    // ==========================================
    public function actualizar()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $id = $_POST["id_producto"];
            $nombre = trim($_POST["nombre_producto"]);
            $stockMinimo = $_POST["stock_minimo_alerta"];
            $precio = $_POST["precio_venta"];

            $this->productoModel->actualizar(
                $id,
                $nombre,
                $stockMinimo,
                $precio
            );

            header(
                "Location: /Proyecto_majo/public/index.php?modulo=productos"
            );

            exit;
        }
    }


    // ==========================================
    // ELIMINAR PRODUCTO
    // ==========================================
    public function eliminar()
    {
        if (!isset($_GET["id"])) {
            die("Producto no especificado.");
        }

        $id = $_GET["id"];

        $this->productoModel->eliminar($id);

        header(
            "Location: /Proyecto_majo/public/index.php?modulo=productos"
        );

        exit;
    }
}
