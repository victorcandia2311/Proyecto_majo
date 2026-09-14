<?php

require_once __DIR__ . "/../../config/conexion.php";
require_once __DIR__ . "/../models/Proveedor.php";


class ProveedorController
{
    private $proveedorModel;


    public function __construct()
    {
        global $conexion;

        $this->proveedorModel =
            new Proveedor($conexion);
    }


    // ==========================================
    // MOSTRAR MÓDULO
    // ==========================================
    public function index()
    {
        $proveedores =
            $this->proveedorModel
                ->obtenerProveedores();

        $productos =
            $this->proveedorModel
                ->obtenerProductos();

        $precios =
            $this->proveedorModel
                ->obtenerPreciosProveedores();


        require_once __DIR__ .
            "/../views/proveedores/index.php";
    }


    // ==========================================
    // REGISTRAR PROVEEDOR
    // ==========================================
    public function guardar()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            die("Método no permitido.");
        }


        $nombre_empresa =
            trim($_POST["nombre_empresa"] ?? "");


        if ($nombre_empresa === "") {
            die("Debe ingresar el nombre del proveedor.");
        }


        $this->proveedorModel
            ->registrar($nombre_empresa);


        header(
            "Location: /Proyecto_majo/public/index.php?modulo=proveedores"
        );

        exit;
    }


    // ==========================================
    // EDITAR PROVEEDOR
    // ==========================================
    public function actualizar()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            die("Método no permitido.");
        }


        $id_proveedor =
            $_POST["id_proveedor"] ?? null;

        $nombre_empresa =
            trim($_POST["nombre_empresa"] ?? "");


        if (!$id_proveedor || $nombre_empresa === "") {
            die("Datos incompletos.");
        }


        $this->proveedorModel
            ->actualizar(
                $id_proveedor,
                $nombre_empresa
            );


        header(
            "Location: /Proyecto_majo/public/index.php?modulo=proveedores"
        );

        exit;
    }


    // ==========================================
    // ELIMINAR PROVEEDOR
    // ==========================================
    public function eliminar()
    {
        $id_proveedor =
            $_GET["id"] ?? null;


        if (!$id_proveedor) {
            die("Proveedor no especificado.");
        }


        $this->proveedorModel
            ->eliminar($id_proveedor);


        header(
            "Location: /Proyecto_majo/public/index.php?modulo=proveedores"
        );

        exit;
    }


    // ==========================================
    // GUARDAR PRECIO
    // ==========================================
    public function guardarPrecio()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            die("Método no permitido.");
        }


        $id_producto =
            $_POST["id_producto"] ?? null;

        $id_proveedor =
            $_POST["id_proveedor"] ?? null;

        $precio_compra =
            $_POST["precio_compra"] ?? null;


        if (
            !$id_producto ||
            !$id_proveedor ||
            $precio_compra === null ||
            $precio_compra < 0
        ) {
            die("Datos incompletos o incorrectos.");
        }


        try {

            $this->proveedorModel
                ->registrarPrecio(
                    $id_producto,
                    $id_proveedor,
                    $precio_compra
                );

        } catch (PDOException $e) {

            // Error cuando ya existe
            // la relación producto-proveedor
            if ($e->getCode() === "23505") {

                die(
                    "Este producto ya tiene un precio registrado para este proveedor."
                );
            }

            throw $e;
        }


        header(
            "Location: /Proyecto_majo/public/index.php?modulo=proveedores"
        );

        exit;
    }


    // ==========================================
    // ACTUALIZAR PRECIO
    // ==========================================
    public function actualizarPrecio()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            die("Método no permitido.");
        }


        $id_producto =
            $_POST["id_producto"] ?? null;

        $id_proveedor =
            $_POST["id_proveedor"] ?? null;

        $precio_compra =
            $_POST["precio_compra"] ?? null;


        if (
            !$id_producto ||
            !$id_proveedor ||
            $precio_compra === null ||
            $precio_compra < 0
        ) {
            die("Datos incorrectos.");
        }


        $this->proveedorModel
            ->actualizarPrecio(
                $id_producto,
                $id_proveedor,
                $precio_compra
            );


        header(
            "Location: /Proyecto_majo/public/index.php?modulo=proveedores"
        );

        exit;
    }


    // ==========================================
    // ELIMINAR PRECIO
    // ==========================================
    public function eliminarPrecio()
    {
        $id_producto =
            $_GET["producto"] ?? null;

        $id_proveedor =
            $_GET["proveedor"] ?? null;


        if (!$id_producto || !$id_proveedor) {
            die("Datos incompletos.");
        }


        $this->proveedorModel
            ->eliminarPrecio(
                $id_producto,
                $id_proveedor
            );


        header(
            "Location: /Proyecto_majo/public/index.php?modulo=proveedores"
        );

        exit;
    }
}