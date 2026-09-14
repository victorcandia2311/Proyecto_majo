<?php

require_once __DIR__ . "/../../config/conexion.php";
require_once __DIR__ . "/../models/Inventario.php";


class InventarioController
{
    private $inventarioModel;


    public function __construct()
    {
        global $conexion;

        $this->inventarioModel = new Inventario($conexion);
    }


    // ==========================================
    // MOSTRAR INVENTARIO
    // ==========================================
    public function index()
    {
        $productos =
            $this->inventarioModel->obtenerProductos();

        $movimientos =
            $this->inventarioModel->obtenerMovimientos();

        require_once __DIR__ .
            "/../views/inventario/index.php";
    }


    // ==========================================
    // AUMENTAR STOCK
    // ==========================================
    public function aumentar()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            die("Método no permitido.");
        }


        $id_producto =
            $_POST["id_producto"] ?? null;

        $cantidad =
            $_POST["cantidad"] ?? null;

        $motivo =
            trim($_POST["motivo"] ?? "");


        // --------------------------------------
        // VALIDACIONES
        // --------------------------------------

        if (!$id_producto) {
            die("Debe seleccionar un producto.");
        }


        if (!$cantidad || $cantidad <= 0) {
            die("La cantidad debe ser mayor que 0.");
        }


        if ($motivo === "") {
            $motivo = "Reabastecimiento";
        }


        try {

            $this->inventarioModel->aumentarStock(
                $id_producto,
                $cantidad,
                $motivo
            );


            header(
                "Location: /Proyecto_majo/public/index.php?modulo=inventario"
            );

            exit;

        } catch (Exception $e) {

            die(
                "Error al aumentar inventario: "
                . $e->getMessage()
            );
        }
    }
}