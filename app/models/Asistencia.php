<?php

class Asistencia
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // ==========================================
    // OBTENER EMPLEADOS
    // ==========================================

    public function obtenerEmpleados()
    {
        $sql = "
            SELECT
                id_empleado,
                nombres,
                documento_identidad
            FROM empleado
            ORDER BY nombres ASC
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // LISTAR ASISTENCIAS
    // ==========================================

    public function obtenerAsistencias()
    {
        $sql = "
            SELECT
                a.id_asistencia,
                a.id_empleado,
                a.fecha,
                a.hora_ingreso,
                a.hora_salida,
                e.nombres,
                e.documento_identidad,
                e.es_eventual
            FROM asistencia a
            INNER JOIN empleado e
                ON a.id_empleado = e.id_empleado
            ORDER BY
                a.fecha DESC,
                a.hora_ingreso DESC NULLS LAST,
                e.nombres ASC
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // OBTENER UNA ASISTENCIA
    // ==========================================

    public function obtenerAsistencia($id_asistencia)
    {
        $sql = "
            SELECT
                id_asistencia,
                id_empleado,
                fecha,
                hora_ingreso,
                hora_salida
            FROM asistencia
            WHERE id_asistencia = :id_asistencia
        ";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':id_asistencia' => $id_asistencia
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // VERIFICAR ASISTENCIA DEL DÍA
    // ==========================================

    public function existeAsistencia($id_empleado, $fecha)
    {
        $sql = "
            SELECT COUNT(*)
            FROM asistencia
            WHERE id_empleado = :id_empleado
              AND fecha = :fecha
        ";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':id_empleado' => $id_empleado,
            ':fecha' => $fecha
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    // ==========================================
    // REGISTRAR ASISTENCIA
    // ==========================================

    public function registrarAsistencia(
        $id_empleado,
        $fecha,
        $hora_ingreso,
        $hora_salida
    ) {
        $sql = "
            INSERT INTO asistencia
            (
                id_empleado,
                fecha,
                hora_ingreso,
                hora_salida
            )
            VALUES
            (
                :id_empleado,
                :fecha,
                :hora_ingreso,
                :hora_salida
            )
        ";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_empleado' => $id_empleado,
            ':fecha' => $fecha,
            ':hora_ingreso' => $hora_ingreso !== '' ? $hora_ingreso : null,
            ':hora_salida' => $hora_salida !== '' ? $hora_salida : null
        ]);
    }

    // ==========================================
    // OBTENER ASISTENCIA POR ID
    // ==========================================
        public function obtenerPorId($id)
        {
            $sql = "SELECT 
                    a.id_asistencia,
                    a.id_empleado,
                    a.fecha,
                    a.hora_ingreso,
                    a.hora_salida,
                    e.nombres
                FROM asistencia a
                INNER JOIN empleado e 
                    ON a.id_empleado = e.id_empleado
                WHERE a.id_asistencia = :id";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

    // ==========================================
    // ACTUALIZAR ASISTENCIA
    // ==========================================

    public function actualizarAsistencia(
        $id_asistencia,
        $id_empleado,
        $fecha,
        $hora_ingreso,
        $hora_salida
    ) {
        $sql = "
            UPDATE asistencia
            SET
                id_empleado = :id_empleado,
                fecha = :fecha,
                hora_ingreso = :hora_ingreso,
                hora_salida = :hora_salida
            WHERE id_asistencia = :id_asistencia
        ";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_asistencia' => $id_asistencia,
            ':id_empleado' => $id_empleado,
            ':fecha' => $fecha,
            ':hora_ingreso' => $hora_ingreso !== '' ? $hora_ingreso : null,
            ':hora_salida' => $hora_salida !== '' ? $hora_salida : null
        ]);
    }

    // ==========================================
    // ObBTENER ASISTENCIA ABIERTA DEL EMPLEADO
    // ==========================================

    public function obtenerAsistenciaAbierta($idEmpleado)
    {
        $sql = "SELECT *
                FROM asistencia
                WHERE id_empleado = :id_empleado
                AND fecha = CURRENT_DATE
                AND hora_ingreso IS NOT NULL
                AND hora_salida IS NULL
                ORDER BY id_asistencia DESC
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id_empleado', $idEmpleado, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // REGISTRAR SOLO INGRESO
    // ==========================================

        public function registrarIngreso($idEmpleado)
    {
        $sql = "INSERT INTO asistencia (
                    id_empleado,
                    fecha,
                    hora_ingreso
                )
                VALUES (
                    :id_empleado,
                    CURRENT_DATE,
                    CURRENT_TIME
                )";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id_empleado', $idEmpleado, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // ==========================================
    // REGISTRAR SOLO SALIDA
    // ==========================================
    
        public function registrarSalida($idEmpleado)
    {
        $asistencia = $this->obtenerAsistenciaAbierta($idEmpleado);

        if (!$asistencia) {
            return false;
        }

        $sql = "UPDATE asistencia
                SET hora_salida = CURRENT_TIME
                WHERE id_asistencia = :id_asistencia";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(
            ':id_asistencia',
            $asistencia['id_asistencia'],
            PDO::PARAM_INT
        );

        return $stmt->execute();
    }

    // ==========================================
    // VERIFICAR ASISTENCIAS ABIERTAS
    // ==========================================
    
        public function tieneIngresoAbierto($idEmpleado)
    {
        $sql = "SELECT COUNT(*)
                FROM asistencia
                WHERE id_empleado = :id_empleado
                AND fecha = CURRENT_DATE
                AND hora_ingreso IS NOT NULL
                AND hora_salida IS NULL";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id_empleado', $idEmpleado, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn() > 0;
    }

    // ==========================================
    // ELIMINAR ASISTENCIA
    // ==========================================

    public function eliminarAsistencia($id_asistencia)
    {
        $sql = "
            DELETE FROM asistencia
            WHERE id_asistencia = :id_asistencia
        ";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_asistencia' => $id_asistencia
        ]);
    }
}