<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-4">

    <h2 class="mb-4">
        Dashboard
    </h2>


    <!-- ============================= -->
    <!-- TARJETAS -->
    <!-- ============================= -->

    <div class="row g-4 mb-4">

        <div class="col-12 col-sm-6 col-lg-3">
        
            <div class="card h-100 shadow-sm">

                <div class="card-body">

                    <h5 class="card-title">
                        Ventas del mes
                    </h5>

                    <h2>
                        <?= $resumen['cantidad_ventas']; ?>
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-12 col-sm-6 col-lg-3">
        
            <div class="card h-100 shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">
                        Ingresos del mes
                    </h6>

                    <h3>
                        S/
                        <?= number_format($resumen['ingresos'], 2); ?>
                    </h3>

                    <?php if ($variacionVentas['variacion'] > 0): ?>

                        <p class="text-success mb-0">
                ▲
                            <?= number_format(
                                $variacionVentas['variacion'],
                                2
                            ); ?>%
                            respecto al mes anterior
                        </p>

                    <?php elseif ($variacionVentas['variacion'] < 0): ?>

                        <p class="text-danger mb-0">
                ▼
                            <?= number_format(
                                abs($variacionVentas['variacion']),
                                2
                            ); ?>%
                            respecto al mes anterior
                        </p>

                    <?php else: ?>

                        <p class="text-muted mb-0">
                            Sin variación respecto al mes anterior
                        </p>

                    <?php endif; ?>

                </div>

            </div>

        </div>


        <div class="col-12 col-sm-6 col-lg-3">
        
            <div class="card h-100 shadow-sm">

                <div class="card-body">

                    <h5 class="card-title">
                        Productos vendidos
                    </h5>

                    <h2>
                        <?= $productosVendidos['productos_vendidos']; ?>
                    </h2>

                </div>

            </div>

        </div>

                    </div>

    <br>

    <!-- ============================= -->
    <!-- VENTAS POR MES -->
    <!-- ============================= -->

    <div class="row g-3">

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-header">
                        <strong>
                            Ventas por mes
                        </strong>
                    </div>

                    <div class="card-body">
                        <canvas id="graficoVentas"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-12, col-sm-6, col-lg-3">
                <div class="card shadow-sm mt-4">
                    <div class="card-header">
                        <strong>Productos vendidos por mes</strong>
                    </div>

                    <div class="card-body">
                        <canvas id="graficoProductosVendidos"></canvas>
                    </div>
                </div>
            </div>

    </div>


    <br>

    <!-- ============================= -->
    <!-- PRODUCTO MÁS VENDIDO -->
    <!-- ============================= -->

    <div class="col-12 col-sm-6 col-lg-3">
        
        <div class="card h-100 shadow-sm">

            <div class="card-body">

                <h6 class="text-muted">
                    Producto más vendido
                </h6>

                <?php if ($productoMasVendido): ?>

                    <h5 class="mt-3">
                        <?= htmlspecialchars(
                            $productoMasVendido['nombre_producto']
                        ); ?>
                    </h5>

                    <p class="mb-0">
                        <strong>
                            <?= $productoMasVendido['cantidad_vendida']; ?>
                        </strong>
                        unidades vendidas
                    </p>

                <?php else: ?>

                    <p class="text-muted mt-3 mb-0">
                        No hay ventas este mes.
                    </p>

                <?php endif; ?>
                
            </div>

        </div>

    </div>

</div>

<br><br>

    <!-- ============================= -->
    <!-- MÉTODOS DE PAGO -->
    <!-- ============================= -->

        <div class="col-12 col-sm-6 col-lg-3">
        
            <div class="card h-100 shadow-sm">

                <div class="card-body">

                    <strong>
                        Ventas por método de pago
                    </strong>

                </div>

                <div class="card-body">

                    <canvas id="graficoMetodos"></canvas>

                <div class="table-responsive mt-4">

                <br>

                <table class="table table-bordered table-sm">

                    <thead class="table-dark">
                        <tr>
                            <th>Método de pago</th>
                            <th>Cantidad de ventas</th>
                            <th>Total</th>
                            <th>Porcentaje</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($ventasPorMetodo as $metodo): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($metodo['metodo_pago']); ?>
                                </td>

                                <td>
                                    <?= $metodo['cantidad']; ?>
                                </td>

                                <td>
                                    S/
                                    <?= number_format(
                                        $metodo['total'],
                                    2
                                    ); ?>
                                </td>

                                <td>
                                    <strong>
                                        <?= number_format(
                                        $metodo['porcentaje'],
                                        2
                                        ); ?>%
                                    </strong>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

<br>
    <!-- ============================= -->
    <!-- STOCK BAJO -->
    <!-- ============================= -->

    <div class="col-12 col-sm-6 col-lg-3">
        
            <div class="card h-100 shadow-sm">

                <div class="card-body">

                <h3 class="text-muted">
                    Productos con stock bajo
                </h3>

                <h2 class="text-warning">
                    <?= htmlspecialchars($cantidadProductosStockBajo) ?>
                </h2>

                <p class="mb-0">
                    Productos con 10 unidades o menos.
                </p>

            </div>

        <div class="card-body">

            <?php if (empty($productosStockBajo)): ?>

                <div class="alert alert-success">
                    No hay productos con stock bajo.
                </div>

            <?php else: ?>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead class="table-warning">

                            <tr>

                                <th>Producto</th>
                                <th>Stock actual</th>
                                <th>Stock mínimo</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach (
                                $productosStockBajo
                                as $producto
                            ): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars(
                                            $producto['nombre_producto']
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= $producto['stock_actual']; ?>
                                    </td>

                                    <td>
                                        <?= $producto['stock_minimo_alerta']; ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // ==========================================
    // NOMBRES DE LOS MESES
    // ==========================================

    const nombresMeses = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    ];

    // ==========================================
    // GRÁFICO DE VENTAS POR MES
    // ==========================================

    const ventasMeses = 
        <?= json_encode($ventasPorMes); ?>;
    

    const etiquetasMeses =
        ventasMeses.map(item => {

        const partes = item.mes.split('-');

        const año = partes[0];
        const numeroMes = parseInt(partes[1], 10);

        return nombresMeses[numeroMes - 1] + ' ' + año;
    });

    const valoresVentas =
        ventasMeses.map(item => Number(item.total));


    new Chart(
        document.getElementById('graficoVentas'),
        {
            type: 'bar',

            data: {

                labels: etiquetasMeses,

                datasets: [
                    {
                        label: 'Ventas (S/)',
                        data: valoresVentas
                    }
                ]

            },

            options: {

                responsive: true,

                scales: {

                    y: {
                        beginAtZero: true
                    }

                }

            }

        }
    );


    // ==========================================
    // GRÁFICO MÉTODOS DE PAGO
    // ==========================================

    const metodosPago =
        <?= json_encode($ventasPorMetodo); ?>;


    const etiquetasMetodos =
        metodosPago.map(item => item.metodo_pago);


    const valoresMetodos =
        metodosPago.map(item => Number(item.total));


    new Chart(
        document.getElementById('graficoMetodos'),
        {
            type: 'doughnut',

            data: {

                labels: etiquetasMetodos,

                datasets: [
                    {
                        label: 'Ventas',
                        data: valoresMetodos
                    }
                ]

            },

            options: {

                responsive: true

            }

        }
    );

    // ==========================================
    // GRÁFICO PRODUCTOS VENDIDOS POR MES
    // ==========================================

    const datosProductosVendidos =
        <?= json_encode($productosVendidosPorMes); ?>;

const mesesProductos =
    datosProductosVendidos.map(item => {

        const partes = item.mes.split('-');

        const año = partes[0];
        const numeroMes = parseInt(partes[1], 10);

        return nombresMeses[numeroMes - 1] + ' ' + año;
    });

    const cantidadesProductos =
        datosProductosVendidos.map(
            item => Number(item.unidades_vendidas)
        );

    new Chart(
        document.getElementById(
            'graficoProductosVendidos'
        ),
        {
            type: 'line',

            data: {

                labels: mesesProductos,

                datasets: [

                    {
                        label: 'Unidades vendidas',

                        data: cantidadesProductos,

                        tension: 0.3,

                        fill: false
                    }

                ]

            },

            options: {

                responsive: true,

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {

                            precision: 0

                        }

                    }

                }

            }

        }
    );

</script>

<br>

<div class="col-12 col-sm-6 col-lg-3">
        
            <div class="card h-100 shadow-sm">

                <div class="card-body">
                    <strong>Top 3 productos más vendidos del mes</strong>
                </div>

                <div class="card-body">

                    <?php if (!empty($rankingProductos)): ?>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead class="table-dark">

                                <tr>
                                    <th>Puesto</th>
                                    <th>Producto</th>
                                    <th>Unidades vendidas</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                    $puesto = 1;
                                ?>

                                <?php foreach ($rankingProductos as $producto): ?>

                                <tr>

                                    <td>
                                        <?php if ($puesto === 1): ?>
                                            1
                                        <?php elseif ($puesto === 2): ?>
                                            2
                                        <?php elseif ($puesto === 3): ?>
                                            3
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $producto['nombre_producto']
                                        ); ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= $producto['cantidad_vendida']; ?>
                                        </strong>
                                        unidades
                                    </td>

                                </tr>

                                <?php
                                    $puesto++;
                                ?>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                    <?php else: ?>

                        <p class="text-muted mb-0">
                        No hay productos vendidos durante este mes.
                        </p>

                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
    
        
<?php require_once __DIR__ . "/../layouts/footer.php"; ?>