<?php

class Venta
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }


    // ==========================================
    // OBTENER PRODUCTOS DISPONIBLES
    // ==========================================
    public function obtenerProductos()
    {
        $sql = "SELECT
                    id_producto,
                    nombre_producto,
                    stock_actual,
                    precio_venta
                FROM producto
                WHERE stock_actual > 0
                ORDER BY nombre_producto ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // OBTENER PRODUCTO POR ID
    // ==========================================
    public function obtenerProducto($id_producto)
    {
        $sql = "SELECT
                    id_producto,
                    nombre_producto,
                    stock_actual,
                    precio_venta
                FROM producto
                WHERE id_producto = :id_producto";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':id_producto' => $id_producto
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // REGISTRAR VENTA COMPLETA
    // ==========================================
    public function registrarVenta(
        $cliente_nombre,
        $cliente_documento,
        $metodo_pago,
        $carrito
    ) {
        try {

            // --------------------------------------
            // INICIAR TRANSACCIÓN
            // --------------------------------------

            $this->conexion->beginTransaction();


            // --------------------------------------
            // CALCULAR TOTAL
            // --------------------------------------

            $total_venta = 0;

            foreach ($carrito as $item) {

                $total_venta +=
                    $item['cantidad'] *
                    $item['precio_unitario'];
            }


            // --------------------------------------
            // REGISTRAR CABECERA DE VENTA
            // --------------------------------------

            $sql = "INSERT INTO venta
                    (
                        cliente_nombre,
                        cliente_documento,
                        metodo_pago,
                        total_venta
                    )
                    VALUES
                    (
                        :cliente_nombre,
                        :cliente_documento,
                        :metodo_pago,
                        :total_venta
                    )
                    RETURNING id_venta";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                ':cliente_nombre' =>
                    $cliente_nombre !== ''
                        ? $cliente_nombre
                        : null,

                ':cliente_documento' =>
                    $cliente_documento !== ''
                        ? $cliente_documento
                        : null,

                ':metodo_pago' => $metodo_pago,

                ':total_venta' => $total_venta
            ]);


            $id_venta = $stmt->fetchColumn();


            // --------------------------------------
            // PREPARAR CONSULTAS
            // --------------------------------------

            $sqlProducto = "
                SELECT
                    nombre_producto,
                    stock_actual
                FROM producto
                WHERE id_producto = :id_producto
                FOR UPDATE
            ";

            $stmtProducto =
                $this->conexion->prepare($sqlProducto);


            $sqlDetalle = "
                INSERT INTO detalle_venta
                (
                    id_venta,
                    id_producto,
                    cantidad,
                    precio_unitario
                )
                VALUES
                (
                    :id_venta,
                    :id_producto,
                    :cantidad,
                    :precio_unitario
                )
            ";

            $stmtDetalle =
                $this->conexion->prepare($sqlDetalle);


            $sqlStock = "
                UPDATE producto
                SET stock_actual =
                    stock_actual - :cantidad
                WHERE id_producto = :id_producto
            ";

            $stmtStock =
                $this->conexion->prepare($sqlStock);


            $sqlMovimiento = "
                INSERT INTO movimiento_inventario
                (
                    id_producto,
                    tipo_movimiento,
                    cantidad,
                    motivo
                )
                VALUES
                (
                    :id_producto,
                    'SALIDA',
                    :cantidad,
                    :motivo
                )
            ";

            $stmtMovimiento =
                $this->conexion->prepare($sqlMovimiento);


            // --------------------------------------
            // PROCESAR CADA PRODUCTO
            // --------------------------------------

            foreach ($carrito as $item) {

                $id_producto =
                    $item['id_producto'];

                $cantidad =
                    $item['cantidad'];


                // Verificar stock nuevamente
                $stmtProducto->execute([
                    ':id_producto' => $id_producto
                ]);

                $producto =
                    $stmtProducto->fetch(PDO::FETCH_ASSOC);


                if (!$producto) {

                    throw new Exception(
                        "El producto no existe."
                    );
                }


                if ($producto['stock_actual'] < $cantidad) {

                    throw new Exception(
                        "Stock insuficiente para: "
                        . $producto['nombre_producto']
                        . ". Stock disponible: "
                        . $producto['stock_actual']
                    );
                }


                // ----------------------------------
                // REGISTRAR DETALLE
                // ----------------------------------

                $stmtDetalle->execute([
                    ':id_venta' =>
                        $id_venta,

                    ':id_producto' =>
                        $id_producto,

                    ':cantidad' =>
                        $cantidad,

                    ':precio_unitario' =>
                        $item['precio_unitario']
                ]);


                // ----------------------------------
                // REDUCIR STOCK
                // ----------------------------------

                $stmtStock->execute([
                    ':cantidad' =>
                        $cantidad,

                    ':id_producto' =>
                        $id_producto
                ]);


                // ----------------------------------
                // REGISTRAR MOVIMIENTO
                // ----------------------------------

                $stmtMovimiento->execute([
                    ':id_producto' =>
                        $id_producto,

                    ':cantidad' =>
                        $cantidad,

                    ':motivo' =>
                        'Venta #' . $id_venta
                ]);
            }


            // --------------------------------------
            // CONFIRMAR
            // --------------------------------------

            $this->conexion->commit();

            return $id_venta;


        } catch (Exception $e) {

            if ($this->conexion->inTransaction()) {

                $this->conexion->rollBack();
            }

            throw $e;
        }
    }


    // ==========================================
    // OBTENER VENTA
    // ==========================================
    public function obtenerVenta($id_venta)
    {
        $sql = "SELECT *
                FROM venta
                WHERE id_venta = :id_venta";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':id_venta' => $id_venta
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // OBTENER DETALLES DE UNA VENTA
    // ==========================================
    public function obtenerDetalleVenta($id_venta)
    {
        $sql = "SELECT
                    dv.id_detalle,
                    dv.id_producto,
                    dv.cantidad,
                    dv.precio_unitario,
                    p.nombre_producto,

                    (
                        dv.cantidad *
                        dv.precio_unitario
                    ) AS subtotal

                FROM detalle_venta dv

                INNER JOIN producto p
                    ON dv.id_producto = p.id_producto

                WHERE dv.id_venta = :id_venta

                ORDER BY dv.id_detalle ASC";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':id_venta' => $id_venta
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // OBTENER VENTAS
    // ==========================================
    public function obtenerVentas()
    {
        $sql = "SELECT *
                FROM venta
                ORDER BY fecha_hora DESC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}