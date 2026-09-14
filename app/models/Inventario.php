<?php

class Inventario
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }


    // ==========================================
    // OBTENER PRODUCTOS
    // ==========================================
    public function obtenerProductos()
    {
        $sql = "SELECT *
                FROM producto
                ORDER BY nombre_producto ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // AUMENTAR INVENTARIO
    // ==========================================
    public function aumentarStock(
        $id_producto,
        $cantidad,
        $motivo
    ) {
        try {

            // Iniciamos una transacción
            $this->conexion->beginTransaction();


            // --------------------------------------
            // 1. Verificar que el producto exista
            // --------------------------------------
            $sql = "SELECT stock_actual
                    FROM producto
                    WHERE id_producto = :id_producto
                    FOR UPDATE";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                ':id_producto' => $id_producto
            ]);

            $producto = $stmt->fetch(PDO::FETCH_ASSOC);


            if (!$producto) {

                throw new Exception(
                    "El producto no existe."
                );
            }


            // --------------------------------------
            // 2. Aumentar stock
            // --------------------------------------
            $sql = "UPDATE producto
                    SET stock_actual = stock_actual + :cantidad
                    WHERE id_producto = :id_producto";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                ':cantidad' => $cantidad,
                ':id_producto' => $id_producto
            ]);


            // --------------------------------------
            // 3. Registrar movimiento
            // --------------------------------------
            $sql = "INSERT INTO movimiento_inventario
                    (
                        id_producto,
                        tipo_movimiento,
                        cantidad,
                        motivo
                    )
                    VALUES
                    (
                        :id_producto,
                        'ENTRADA',
                        :cantidad,
                        :motivo
                    )";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                ':id_producto' => $id_producto,
                ':cantidad' => $cantidad,
                ':motivo' => $motivo
            ]);


            // --------------------------------------
            // 4. Confirmar operación
            // --------------------------------------
            $this->conexion->commit();

            return true;

        } catch (Exception $e) {

            // Si algo falla, deshacemos todo
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            throw $e;
        }
    }


    // ==========================================
    // OBTENER MOVIMIENTOS
    // ==========================================
    public function obtenerMovimientos()
    {
        $sql = "SELECT
                    m.id_movimiento,
                    m.tipo_movimiento,
                    m.cantidad,
                    m.motivo,
                    m.fecha_hora,
                    p.nombre_producto

                FROM movimiento_inventario m

                INNER JOIN producto p
                    ON m.id_producto = p.id_producto

                ORDER BY m.fecha_hora DESC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}