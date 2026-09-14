<?php

require_once __DIR__ . "/../app/controllers/ProductoController.php";
require_once __DIR__ . "/../app/controllers/InventarioController.php";
require_once __DIR__ . "/../app/controllers/ProveedorController.php";
require_once __DIR__ . "/../app/controllers/VentaController.php";
require_once __DIR__ . "/../app/controllers/DashboardController.php";
require_once __DIR__ . "/../app/controllers/EmpleadoController.php";
require_once __DIR__ . "/../app/controllers/AsistenciaController.php";


$modulo = $_GET["modulo"] ?? "productos";
$accion = $_GET["accion"] ?? "index";


switch ($modulo) {

    // ==========================================
    // PRODUCTOS
    // ==========================================

    case "productos":

        $controller = new ProductoController();

        if (method_exists($controller, $accion)) {

            $controller->$accion();

        } else {

            echo " Acción no encontrada.";
        }

        break;


    // ==========================================
    // INVENTARIO
    // ==========================================

    case "inventario":

        $controller = new InventarioController();

        if (method_exists($controller, $accion)) {

            $controller->$accion();

        } else {

            echo " Acción no encontrada.";
        }

        break;


    // ==========================================
    // PROVEEDORES
    // ==========================================

    case "proveedores":

        $controller = new ProveedorController();

        if (method_exists($controller, $accion)) {

            $controller->$accion();

        } else {

            echo " Acción no encontrada.";
        }

        break;

    // ==========================================
    // VENTAS
    // ==========================================
    
    case "ventas":

        $controller = new VentaController();

        if (method_exists($controller, $accion)) {

            $controller->$accion();

        } else {

            echo " Acción no encontrada.";
        }

        break;

    // ==========================================
    // DASHBOARD
    // ==========================================

    case "dashboard":

        $controller = new DashboardController();

        if (method_exists($controller, $accion)) {

            $controller->$accion();

        } else {

            echo " Acción no encontrada.";
        }

        break;

    // ==========================================
    // EMPLEADOS
    // ==========================================

        case "empleados":
            $controller = new EmpleadoController();

            if (method_exists($controller, $accion)) {
            $controller->$accion();
            } else {
                echo " Acción no encontrada.";
            }

            break;

    // ==========================================
    // ASISTENCIA
    // ==========================================
        case "asistencia":
            $controller = new AsistenciaController();

            if (method_exists($controller, $accion)) {
                $controller->$accion();
            } else {
                echo " Acción no encontrada.";
            }

            break;


    // ==========================================
    // DEFAULT
    // ==========================================

    default:

        echo " Módulo no encontrado.";

        break;

}
