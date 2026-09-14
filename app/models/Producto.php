<?php

class Producto
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // ==========================================
    // MOSTRAR TODOS LOS PRODUCTOS
    // ==========================================
    public function obtenerProductos()
    {
        $sql = "SELECT * 
                FROM producto
                ORDER BY id_producto ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // OBTENER UN PRODUCTO POR ID
    // ==========================================
    public function obtenerPorId($id_producto)
    {
        $sql = "SELECT *
                FROM producto
                WHERE id_producto = :id_producto";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':id_producto' => $id_producto
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // REGISTRAR PRODUCTO
    // ==========================================
    public function registrar(
        $nombre_producto,
        $stock_actual,
        $stock_minimo_alerta,
        $precio_venta
    ) {
        $sql = "INSERT INTO producto (
                    nombre_producto,
                    stock_actual,
                    stock_minimo_alerta,
                    precio_venta
                )
                VALUES (
                    :nombre_producto,
                    :stock_actual,
                    :stock_minimo_alerta,
                    :precio_venta
                )";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombre_producto' => $nombre_producto,
            ':stock_actual' => $stock_actual,
            ':stock_minimo_alerta' => $stock_minimo_alerta,
            ':precio_venta' => $precio_venta
        ]);
    }


    // ==========================================
    // ACTUALIZAR PRODUCTO
    // ==========================================
    public function actualizar(
        $id_producto,
        $nombre_producto,
        $stock_minimo_alerta,
        $precio_venta
    ) {
        $sql = "UPDATE producto
                SET nombre_producto = :nombre_producto,
                    stock_minimo_alerta = :stock_minimo_alerta,
                    precio_venta = :precio_venta
                WHERE id_producto = :id_producto";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_producto' => $id_producto,
            ':nombre_producto' => $nombre_producto,
            ':stock_minimo_alerta' => $stock_minimo_alerta,
            ':precio_venta' => $precio_venta
        ]);
    }


    // ==========================================
    // ELIMINAR PRODUCTO
    // ==========================================
    public function eliminar($id_producto)
    {
        $sql = "DELETE FROM producto
                WHERE id_producto = :id_producto";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_producto' => $id_producto
        ]);
    }


    // ==========================================
    // PRODUCTOS CON STOCK BAJO
    // ==========================================
    public function obtenerStockBajo()
    {
        $sql = "SELECT *
                FROM producto
                WHERE stock_actual <= 10
                ORDER BY stock_actual ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

    // ==========================================
    // CONTAR PRODUCTOS STOCK BAJO
    // ==========================================
    public function contarProductosStockBajo($limite = 10)
    {
        $sql = "SELECT COUNT(*)
                FROM producto
                WHERE stock_actual <= :limite";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}
