<?php

class Dashboard
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // ==========================================
    // RESUMEN DEL MES ACTUAL
    // ==========================================

    public function obtenerResumenMes()
    {
        $sql = "
            SELECT
                COUNT(*) AS cantidad_ventas,
                COALESCE(SUM(total_venta), 0) AS ingresos
            FROM venta
            WHERE DATE_TRUNC('month', fecha_hora)
                  = DATE_TRUNC('month', CURRENT_DATE)
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerVariacionVentas()
    {
        $sql = "
            SELECT
                COALESCE(
                    SUM(
                        CASE
                            WHEN fecha_hora >= DATE_TRUNC('month', CURRENT_DATE)
                            THEN total_venta
                            ELSE 0
                        END
                    ),
                    0
                ) AS ventas_mes_actual,

                COALESCE(
                    SUM(
                        CASE
                            WHEN fecha_hora >= DATE_TRUNC('month', CURRENT_DATE - INTERVAL '1 month')
                            AND fecha_hora < DATE_TRUNC('month', CURRENT_DATE)
                            THEN total_venta
                            ELSE 0
                        END
                    ),
                    0
                ) AS ventas_mes_anterior

            FROM venta
            WHERE fecha_hora >= DATE_TRUNC('month', CURRENT_DATE - INTERVAL '1 month')
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        $ventasActual = (float) $resultado['ventas_mes_actual'];
        $ventasAnterior = (float) $resultado['ventas_mes_anterior'];

        if ($ventasAnterior > 0) {
            $variacion = (
                ($ventasActual - $ventasAnterior)
                / $ventasAnterior
            ) * 100;
        } else {
            $variacion = $ventasActual > 0 ? 100 : 0;
        }

        return [
            'ventas_actual' => $ventasActual,
            'ventas_anterior' => $ventasAnterior,
            'variacion' => $variacion
        ];
    }


    // ==========================================
    // PRODUCTOS VENDIDOS DEL MES
    // ==========================================

    public function obtenerProductosVendidosMes()
    {
        $sql = "
            SELECT
                COALESCE(SUM(dv.cantidad), 0) AS productos_vendidos
            FROM detalle_venta dv

            INNER JOIN venta v
                ON dv.id_venta = v.id_venta

            WHERE DATE_TRUNC('month', v.fecha_hora)
                  = DATE_TRUNC('month', CURRENT_DATE)
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // VENTAS POR MES
    // ==========================================

    public function obtenerVentasPorMes()
    {
        $sql = "
            SELECT
                TO_CHAR(
                    DATE_TRUNC('month', fecha_hora),
                    'YYYY-MM'
                ) AS mes,

                COALESCE(SUM(total_venta), 0) AS total

            FROM venta

            GROUP BY DATE_TRUNC('month', fecha_hora)

            ORDER BY DATE_TRUNC('month', fecha_hora)
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // MÉTODOS DE PAGO
    // ==========================================

    public function obtenerVentasPorMetodoPago()
    {
        $sql = "
            SELECT
                metodo_pago,
                COUNT(*) AS cantidad,
                COALESCE(SUM(total_venta), 0) AS total,

                ROUND(
                    (
                        SUM(total_venta) /
                        NULLIF(
                            (
                                SELECT COALESCE(SUM(total_venta), 0)
                                FROM venta
                                WHERE fecha_hora >= DATE_TRUNC('month', CURRENT_DATE)
                                AND fecha_hora < DATE_TRUNC(
                                    'month',
                                    CURRENT_DATE + INTERVAL '1 month'
                                )
                            ),
                            0
                        )
                    ) * 100,
                    2
                ) AS porcentaje

            FROM venta

            WHERE fecha_hora >= DATE_TRUNC('month', CURRENT_DATE)
            AND fecha_hora < DATE_TRUNC(
                'month',
                CURRENT_DATE + INTERVAL '1 month'
            )

            GROUP BY metodo_pago

            ORDER BY total DESC
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // PRODUCTOS CON STOCK BAJO
    // ==========================================

    public function obtenerProductosStockBajo()
    {
        $sql = "
            SELECT
                id_producto,
                nombre_producto,
                stock_actual,
                stock_minimo_alerta

            FROM producto

            WHERE stock_actual <= stock_minimo_alerta

            ORDER BY stock_actual ASC
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // CONTAR PRODUCTOS CON STOCK BAJO
    // ==========================================
    public function contarProductosStockBajo($limite = 10)
    {
        $sql = "
            SELECT COUNT(*)
            FROM producto
            WHERE stock_actual <= :limite
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    // ==========================================
    // PRODUCTO MÁS VENDIDO DEL MES
    // ==========================================
    public function obtenerProductoMasVendidoMes()
    {
        $sql = "
            SELECT
                p.id_producto,
                p.nombre_producto,
                SUM(dv.cantidad) AS cantidad_vendida
            FROM detalle_venta dv

            INNER JOIN venta v
                ON dv.id_venta = v.id_venta

            INNER JOIN producto p
                ON dv.id_producto = p.id_producto

            WHERE v.fecha_hora >= DATE_TRUNC('month', CURRENT_DATE)
            AND v.fecha_hora < DATE_TRUNC(
                'month',
                CURRENT_DATE + INTERVAL '1 month'
            )

            GROUP BY
                p.id_producto,
                p.nombre_producto

            ORDER BY cantidad_vendida DESC

            LIMIT 1
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // RANKING DE PRODUCTOS MÁS VENDIDOS DEL MES
    // ==========================================

    public function obtenerRankingProductosMes()
    {
        $sql = "
            SELECT
                p.id_producto,
                p.nombre_producto,
                SUM(dv.cantidad) AS cantidad_vendida
            FROM detalle_venta dv

            INNER JOIN venta v
                ON dv.id_venta = v.id_venta

            INNER JOIN producto p
                ON dv.id_producto = p.id_producto

            WHERE v.fecha_hora >= DATE_TRUNC('month', CURRENT_DATE)
            AND v.fecha_hora < DATE_TRUNC(
                'month',
                CURRENT_DATE + INTERVAL '1 month'
            )

            GROUP BY
                p.id_producto,
                p.nombre_producto

            ORDER BY cantidad_vendida DESC

            LIMIT 3
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosVendidosPorMes()
    {
        $sql = "
            SELECT
                TO_CHAR(
                    DATE_TRUNC('month', v.fecha_hora),
                    'YYYY-MM'
                ) AS mes,

                COALESCE(
                    SUM(dv.cantidad),
                    0
                ) AS unidades_vendidas

            FROM detalle_venta dv

            INNER JOIN venta v
                ON dv.id_venta = v.id_venta

            GROUP BY
                DATE_TRUNC('month', v.fecha_hora)

            ORDER BY
                DATE_TRUNC('month', v.fecha_hora)
        ";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}