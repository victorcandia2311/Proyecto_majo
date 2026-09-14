<?php

class Proveedor
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }


    // ==========================================
    // OBTENER TODOS LOS PROVEEDORES
    // ==========================================
    public function obtenerProveedores()
    {
        $sql = "SELECT *
                FROM proveedor
                ORDER BY id_proveedor ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // OBTENER PROVEEDOR POR ID
    // ==========================================
    public function obtenerPorId($id_proveedor)
    {
        $sql = "SELECT *
                FROM proveedor
                WHERE id_proveedor = :id_proveedor";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':id_proveedor' => $id_proveedor
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // REGISTRAR PROVEEDOR
    // ==========================================
    public function registrar($nombre_empresa)
    {
        $sql = "INSERT INTO proveedor
                (nombre_empresa)
                VALUES
                (:nombre_empresa)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombre_empresa' => $nombre_empresa
        ]);
    }


    // ==========================================
    // ACTUALIZAR PROVEEDOR
    // ==========================================
    public function actualizar(
        $id_proveedor,
        $nombre_empresa
    ) {
        $sql = "UPDATE proveedor
                SET nombre_empresa = :nombre_empresa
                WHERE id_proveedor = :id_proveedor";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_proveedor' => $id_proveedor,
            ':nombre_empresa' => $nombre_empresa
        ]);
    }


    // ==========================================
    // ELIMINAR PROVEEDOR
    // ==========================================
    public function eliminar($id_proveedor)
    {
        $sql = "DELETE FROM proveedor
                WHERE id_proveedor = :id_proveedor";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_proveedor' => $id_proveedor
        ]);
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
    // OBTENER PRECIOS DE PROVEEDORES
    // ==========================================
    public function obtenerPreciosProveedores()
    {
        $sql = "SELECT
                    pp.id_producto,
                    pp.id_proveedor,
                    pp.precio_compra,
                    p.nombre_producto,
                    pr.nombre_empresa

                FROM producto_proveedor pp

                INNER JOIN producto p
                    ON pp.id_producto = p.id_producto

                INNER JOIN proveedor pr
                    ON pp.id_proveedor = pr.id_proveedor

                ORDER BY p.nombre_producto ASC,
                         pr.nombre_empresa ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // REGISTRAR PRECIO DE PROVEEDOR
    // ==========================================
    public function registrarPrecio(
        $id_producto,
        $id_proveedor,
        $precio_compra
    ) {
        $sql = "INSERT INTO producto_proveedor
                (
                    id_producto,
                    id_proveedor,
                    precio_compra
                )
                VALUES
                (
                    :id_producto,
                    :id_proveedor,
                    :precio_compra
                )";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_producto' => $id_producto,
            ':id_proveedor' => $id_proveedor,
            ':precio_compra' => $precio_compra
        ]);
    }


    // ==========================================
    // ACTUALIZAR PRECIO
    // ==========================================
    public function actualizarPrecio(
        $id_producto,
        $id_proveedor,
        $precio_compra
    ) {
        $sql = "UPDATE producto_proveedor
                SET precio_compra = :precio_compra
                WHERE id_producto = :id_producto
                AND id_proveedor = :id_proveedor";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_producto' => $id_producto,
            ':id_proveedor' => $id_proveedor,
            ':precio_compra' => $precio_compra
        ]);
    }


    // ==========================================
    // ELIMINAR PRECIO DE PROVEEDOR
    // ==========================================
    public function eliminarPrecio(
        $id_producto,
        $id_proveedor
    ) {
        $sql = "DELETE FROM producto_proveedor
                WHERE id_producto = :id_producto
                AND id_proveedor = :id_proveedor";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id_producto' => $id_producto,
            ':id_proveedor' => $id_proveedor
        ]);
    }
}