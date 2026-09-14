<?php

class Empleado
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // ==========================================
    // LISTAR EMPLEADOS
    // ==========================================

    public function obtenerEmpleados()
    {
        $sql = "
            SELECT
                id_empleado,
                nombres,
                documento_identidad,
                es_eventual
            FROM empleado
            ORDER BY id_empleado DESC
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // OBTENER EMPLEADO
    // ==========================================

    public function obtenerEmpleado($id_empleado)
    {
        $sql = "
            SELECT
                id_empleado,
                nombres,
                documento_identidad,
                es_eventual
            FROM empleado
            WHERE id_empleado = :id_empleado
        ";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':id_empleado' => $id_empleado
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // REGISTRAR EMPLEADO
    // ==========================================

    public function registrarEmpleado(
        $nombres,
        $documento_identidad,
        $es_eventual
    ) {
        $sql = "
            INSERT INTO empleado
            (
                nombres,
                documento_identidad,
                es_eventual
            )
            VALUES
            (
                :nombres,
                :documento_identidad,
                CAST(:es_eventual AS BOOLEAN)
            )
        ";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindValue(
            ':nombres',
            $nombres,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':documento_identidad',
            $documento_identidad,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':es_eventual',
            $es_eventual ? 'true' : 'false',
            PDO::PARAM_STR
        );

        return $stmt->execute();
    }

    // ==========================================
    // ACTUALIZAR EMPLEADO
    // ==========================================

    public function actualizarEmpleado(
        $id_empleado,
        $nombres,
        $documento_identidad,
        $es_eventual
    ) {
        $sql = "
            UPDATE empleado
            SET
                nombres = :nombres,
                documento_identidad = :documento_identidad,
                es_eventual = CAST(:es_eventual AS BOOLEAN)
            WHERE id_empleado = :id_empleado
        ";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindValue(
            ':id_empleado',
            $id_empleado,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':nombres',
            $nombres,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':documento_identidad',
            $documento_identidad,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':es_eventual',
            $es_eventual ? 'true' : 'false',
            PDO::PARAM_STR
        );

        return $stmt->execute();
    }

    // ==========================================
    // ELIMINAR EMPLEADO
    // ==========================================

    public function eliminarEmpleado($id_empleado)
    {
        $sql = "
            DELETE FROM empleado
            WHERE id_empleado = :id_empleado
        ";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_empleado' => $id_empleado
        ]);
    }
}