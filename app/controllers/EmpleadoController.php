<?php

require_once __DIR__ . "/../../config/conexion.php";
require_once __DIR__ . "/../models/Empleado.php";

class EmpleadoController
{
    private $empleadoModel;

    public function __construct()
    {
        global $conexion;

        $this->empleadoModel = new Empleado($conexion);
    }

    // ==========================================
    // LISTAR EMPLEADOS
    // ==========================================

    public function index()
    {
        $empleados = $this->empleadoModel->obtenerEmpleados();

        require_once __DIR__ . "/../views/empleados/index.php";
    }

    // ==========================================
    // GUARDAR
    // ==========================================

    public function guardar()
    {
        $nombres = trim($_POST['nombres'] ?? '');
        $documento = trim($_POST['documento_identidad'] ?? '');

        $es_eventual = ($_POST['es_eventual'] ?? 'false') === 'true';

        if ($nombres === '' || $documento === '') {
            header("Location: /Proyecto_majo/public/index.php?modulo=empleados");
            exit;
        }

        $this->empleadoModel->registrarEmpleado(
            $nombres,
            $documento,
            $es_eventual
        );

        header("Location: /Proyecto_majo/public/index.php?modulo=empleados");
        exit;
    }

    // ==========================================
    // EDITAR EMPLEADO
    // ==========================================

    public function editar()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /Proyecto_majo/public/index.php?modulo=empleados");
            exit;
        }

        $empleado = $this->empleadoModel->obtenerEmpleado($id);

        if (!$empleado) {
            header("Location: /Proyecto_majo/public/index.php?modulo=empleados");
            exit;
        }

        require_once __DIR__ . "/../views/empleados/editar.php";
    }

    // ==========================================
    // ACTUALIZAR
    // ==========================================

    public function actualizar()
    {
        $id = $_POST['id_empleado'] ?? null;
        $nombres = trim($_POST['nombres'] ?? '');
        $documento = trim($_POST['documento_identidad'] ?? '');
        
        $es_eventual = ($_POST['es_eventual'] ?? 'false') === 'true';

        if (!$id || $nombres === '' || $documento === '') {
            header("Location: /Proyecto_majo/public/index.php?modulo=empleados");
            exit;
        }

        $this->empleadoModel->actualizarEmpleado(
            $id,
            $nombres,
            $documento,
            $es_eventual
        );

        header("Location: /Proyecto_majo/public/index.php?modulo=empleados");
        exit;
    }

    // ==========================================
    // ELIMINAR
    // ==========================================

    public function eliminar()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->empleadoModel->eliminarEmpleado($id);
        }

        header("Location: /Proyecto_majo/public/index.php?modulo=empleados");
        exit;
    }
}