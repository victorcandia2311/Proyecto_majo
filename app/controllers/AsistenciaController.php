<?php

require_once __DIR__ . "/../../config/conexion.php";
require_once __DIR__ . "/../models/Asistencia.php";

class AsistenciaController
{
    private $asistenciaModel;

    public function __construct()
    {
        global $conexion;

        $this->asistenciaModel = new Asistencia($conexion);
    }

    // ==========================================
    // LISTAR ASISTENCIAS
    // ==========================================

    public function index()
    {
        $empleados = $this->asistenciaModel->obtenerEmpleados();
        $asistencias = $this->asistenciaModel->obtenerAsistencias();

        require_once __DIR__ . "/../views/asistencia/index.php";
    }

    // ==========================================
    // REGISTRAR ASISTENCIA
    // ==========================================

    public function guardar()
    {
        $id_empleado = $_POST['id_empleado'] ?? null;
        $fecha = $_POST['fecha'] ?? '';
        $hora_ingreso = $_POST['hora_ingreso'] ?? '';
        $hora_salida = $_POST['hora_salida'] ?? '';

        if (
            !$id_empleado ||
            $fecha === ''
        ) {
            header(
                "Location: /Proyecto_majo/public/index.php?modulo=asistencia"
            );
            exit;
        }

        $existe = $this->asistenciaModel->existeAsistencia(
            $id_empleado,
            $fecha
        );

        if ($existe) {
            header(
                "Location: /Proyecto_majo/public/index.php?modulo=asistencia&error=duplicado"
            );
            exit;
        }

        $this->asistenciaModel->registrarAsistencia(
            $id_empleado,
            $fecha,
            $hora_ingreso,
            $hora_salida
        );

        header(
            "Location: /Proyecto_majo/public/index.php?modulo=asistencia&mensaje=registrado"
        );
        exit;
    }

    // ==========================================
    // EDITAR ASISTENCIA
    // ==========================================

    public function editar()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header(
                "Location: /Proyecto_majo/public/index.php?modulo=asistencia"
            );
            exit;
        }

        $asistencia = $this->asistenciaModel->obtenerAsistencia($id);

        if (!$asistencia) {
            header(
                "Location: /Proyecto_majo/public/index.php?modulo=asistencia"
            );
            exit;
        }

        $empleados = $this->asistenciaModel->obtenerEmpleados();

        require_once __DIR__ . "/../views/asistencia/editar.php";
    }

    // ==========================================
    // ACTUALIZAR ASISTENCIA
    // ==========================================

    public function actualizar()
    {
        $id_asistencia = $_POST['id_asistencia'] ?? null;
        $id_empleado = $_POST['id_empleado'] ?? null;
        $fecha = $_POST['fecha'] ?? '';
        $hora_ingreso = $_POST['hora_ingreso'] ?? '';
        $hora_salida = $_POST['hora_salida'] ?? '';

        if (
            !$id_asistencia ||
            !$id_empleado ||
            $fecha === ''
        ) {
            header(
                "Location: /Proyecto_majo/public/index.php?modulo=asistencia"
            );
            exit;
        }

        $this->asistenciaModel->actualizarAsistencia(
            $id_asistencia,
            $id_empleado,
            $fecha,
            $hora_ingreso,
            $hora_salida
        );

        header(
            "Location: /Proyecto_majo/public/index.php?modulo=asistencia&mensaje=actualizado"
        );
        exit;
    }

    // ==========================================
    // REGISTRAR INGRESO
    // ==========================================

        public function registrarIngreso()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?modulo=asistencia");
            exit;
        }

        $idEmpleado = $_POST['id_empleado'];

        if ($this->asistenciaModel->tieneIngresoAbierto($idEmpleado)) {
            echo "<script>
                    alert('Este empleado ya tiene un ingreso abierto.');
                    window.location.href = 'index.php?modulo=asistencia';
                </script>";
            exit;
        }

        $this->asistenciaModel->registrarIngreso($idEmpleado);

        header("Location: index.php?modulo=asistencia");
        exit;
    }

    // ==========================================
    // REGISTRAR SALIDA
    // ==========================================

        public function registrarSalida()
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header("Location: index.php?modulo=asistencia");
                exit;
            }

            $idEmpleado = $_POST['id_empleado'];

            $asistencia = $this->asistenciaModel->obtenerAsistenciaAbierta($idEmpleado);

            if (!$asistencia) {
                echo "<script>
                    alert('Este empleado no tiene un ingreso abierto para registrar la salida.');
                    window.location.href = 'index.php?modulo=asistencia';
                    </script>";
                exit;
            }

            $this->asistenciaModel->registrarSalida($idEmpleado);

            header("Location: index.php?modulo=asistencia");
            exit;
        }


    // ==========================================
    // ELIMINAR ASISTENCIA
    // ==========================================

    public function eliminar()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->asistenciaModel->eliminarAsistencia($id);
        }

        header(
            "Location: /Proyecto_majo/public/index.php?modulo=asistencia&mensaje=eliminado"
        );
        exit;
    }
}