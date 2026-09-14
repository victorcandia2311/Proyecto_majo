<?php

require_once __DIR__ . "/../../config/conexion.php";
require_once __DIR__ . "/../models/Dashboard.php";

class DashboardController
{
    private $dashboardModel;

    public function __construct()
    {
        global $conexion;

        $this->dashboardModel =
            new Dashboard($conexion);
    }


    // ==========================================
    // MOSTRAR DASHBOARD
    // ==========================================

    public function index()
    {
        $resumen =
            $this->dashboardModel
                ->obtenerResumenMes();


        $productosVendidos =
            $this->dashboardModel
                ->obtenerProductosVendidosMes();

        $productosVendidosPorMes =
            $this->dashboardModel
                ->obtenerProductosVendidosPorMes();
        
        
        $variacionVentas = 
            $this->dashboardModel
                ->obtenerVariacionVentas();

        
        $productoMasVendido =
            $this->dashboardModel
                ->obtenerProductoMasVendidoMes();

        
        $rankingProductos =
            $this->dashboardModel
                ->obtenerRankingProductosMes();

        
        $ventasPorMes =
            $this->dashboardModel
                ->obtenerVentasPorMes();


        $ventasPorMetodo =
            $this->dashboardModel
                ->obtenerVentasPorMetodoPago();


        $productosStockBajo =
            $this->dashboardModel
                ->obtenerProductosStockBajo(10);

        $cantidadProductosStockBajo =
            $this->dashboardModel
                ->contarProductosStockBajo(10);


        require_once __DIR__ .
            "/../views/dashboard/index.php";
    }
}