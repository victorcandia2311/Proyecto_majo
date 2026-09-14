<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<main class="container-fluid py-4">

    <!-- ====================================================== -->
    <!-- TÍTULO DEL DASHBOARD                                   -->
    <!-- ====================================================== -->

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">

        <div>
            <h2 class="dashboard-title mb-1">
                Dashboard
            </h2>

            <p class="text-muted mb-0">
                Resumen general del sistema de inventario.
            </p>
        </div>

    </div>


    <!-- ====================================================== -->
    <!-- TARJETAS ESTADÍSTICAS                                  -->
    <!-- ====================================================== -->

    <div class="row g-3 mb-4">

        <!-- Ventas del mes -->
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card dashboard-card h-100 shadow-sm">

                <div class="card-body">

                    <p class="text-muted mb-2">
                        Ventas del mes
                    </p>

                    <h3 class="mb-0">
                        <?= $resumen['cantidad_ventas']; ?>
                    </h3>

                </div>

            </div>

        </div>


        <!-- Ingresos del mes -->
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card dashboard-card h-100 shadow-sm">

                <div class="card-body">

                    <p class="text-muted mb-2">
                        Ingresos del mes
                    </p>

                    <h3 class="mb-2">

                        S/
                        <?= number_format(
                            $resumen['ingresos'],
                            2
                        ); ?>

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


        <!-- Productos vendidos -->
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card dashboard-card h-100 shadow-sm">

                <div class="card-body">

                    <p class="text-muted mb-2">
                        Productos vendidos
                    </p>

                    <h3 class="mb-0">
                        <?= $productosVendidos['productos_vendidos']; ?>
                    </h3>

                </div>

            </div>

        </div>


        <!-- Stock bajo -->
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card dashboard-card h-100 shadow-sm border-warning">

                <div class="card-body">

                    <p class="text-muted mb-2">
                        Productos con stock bajo
                    </p>

                    <h3 class="text-warning mb-2">

                        <?= htmlspecialchars(
                            $cantidadProductosStockBajo
                        ) ?>

                    </h3>

                    <p class="mb-0">
                        Productos con 10 unidades o menos.
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- ====================================================== -->
    <!-- GRÁFICOS PRINCIPALES                                   -->
    <!-- ====================================================== -->

    <div class="row g-4 mb-4">

        <!-- Ventas por mes -->
        <div class="col-12 col-lg-6">

            <div class="card h-100 shadow-sm">

                <div class="card-header">
                    <strong>
                        Ventas por mes
                    </strong>
                </div>

                <div class="card-body">

                    <div class="chart-container">
                        <canvas id="graficoVentas"></canvas>
                    </div>

                </div>

            </div>

        </div>


        <!-- Productos vendidos por mes -->
        <div class="col-12 col-lg-6">

            <div class="card h-100 shadow-sm">

                <div class="card-header">

                    <strong>
                        Productos vendidos por mes
                    </strong>

                </div>

                <div class="card-body">

                    <div class="chart-container">
                        <canvas id="graficoProductosVendidos"></canvas>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ====================================================== -->
    <!-- STOCK BAJO + MÉTODOS DE PAGO                           -->
    <!-- ====================================================== -->

    <div class="row g-4 mb-4">


        <!-- STOCK BAJO -->
        <div class="col-12 col-xl-6">

            <div class="card h-100 shadow-sm">

                <div class="card-header table-warning">

                    <strong>
                        Alerta de stock bajo
                    </strong>

                </div>

                <div class="card-body">

                    <?php if (empty($productosStockBajo)): ?>

                        <div class="alert alert-success mb-0">

                            No hay productos con stock bajo.

                        </div>

                    <?php else: ?>

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover align-middle mb-0">

                                <thead class="table-warning">

                                    <tr>

                                        <th>
                                            Producto
                                        </th>

                                        <th>
                                            Stock actual
                                        </th>

                                        <th>
                                            Stock mínimo
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach ($productosStockBajo as $producto): ?>

                                        <tr>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $producto['nombre_producto']
                                                ); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $producto['stock_actual']
                                                ); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $producto['stock_minimo_alerta']
                                                ); ?>
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


        <!-- MÉTODOS DE PAGO -->
        <div class="col-12 col-xl-6">

            <div class="card h-100 shadow-sm">

                <div class="card-header">

                    <strong>
                        Ventas por método de pago
                    </strong>

                </div>

                <div class="card-body">

                    <div class="chart-container mb-4">
                        <canvas id="graficoMetodos"></canvas>
                    </div>


                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle mb-0">

                            <thead class="table-dark">

                                <tr>

                                    <th>
                                        Método de pago
                                    </th>

                                    <th>
                                        Cantidad
                                    </th>

                                    <th>
                                        Total
                                    </th>

                                    <th>
                                        Porcentaje
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($ventasPorMetodo as $metodo): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars(
                                                $metodo['metodo_pago']
                                            ); ?>
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

        </div>

    </div>


    <!-- ====================================================== -->
    <!-- PRODUCTO MÁS VENDIDO                                   -->
    <!-- ====================================================== -->

    <div class="row g-4 mb-4">

        <div class="col-12">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5 class="text-muted mb-3">
                        Producto más vendido
                    </h5>


                    <?php if ($productoMasVendido): ?>

                        <h4 class="mt-3">

                            <?= htmlspecialchars(
                                $productoMasVendido['nombre_producto']
                            ); ?>

                        </h4>

                        <p class="mb-0">

                            <strong>
                                <?= $productoMasVendido['cantidad_vendida']; ?>
                            </strong>

                            unidades vendidas

                        </p>

                    <?php else: ?>

                        <p class="text-muted mb-0">
                            No hay ventas este mes.
                        </p>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>


    <!-- ====================================================== -->
    <!-- TOP 3 PRODUCTOS MÁS VENDIDOS                           -->
    <!-- ====================================================== -->

    <div class="row g-4 mb-4">

        <div class="col-12">

            <div class="card shadow-sm">

                <div class="card-header">

                    <strong>
                        Top 3 productos más vendidos del mes
                    </strong>

                </div>


                <div class="card-body">

                    <?php if (!empty($rankingProductos)): ?>

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-dark">

                                    <tr>

                                        <th>
                                            Puesto
                                        </th>

                                        <th>
                                            Producto
                                        </th>

                                        <th>
                                            Unidades vendidas
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    <?php $puesto = 1; ?>

                                    <?php foreach ($rankingProductos as $producto): ?>

                                        <tr>

                                            <td>
                                                <?= $puesto; ?>
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

                                        <?php $puesto++; ?>

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

</main>


<!-- ====================================================== -->
<!-- CHART.JS                                               -->
<!-- ====================================================== -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // =====================================================
    // NOMBRES DE LOS MESES
    // =====================================================

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


    // =====================================================
    // GRÁFICO DE VENTAS POR MES
    // =====================================================

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
        ventasMeses.map(item =>
            Number(item.total)
        );


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

                maintainAspectRatio: false,

                scales: {

                    y: {
                        beginAtZero: true
                    }

                }

            }

        }
    );


    // =====================================================
    // GRÁFICO MÉTODOS DE PAGO
    // =====================================================

    const metodosPago =
        <?= json_encode($ventasPorMetodo); ?>;


    const etiquetasMetodos =
        metodosPago.map(
            item => item.metodo_pago
        );


    const valoresMetodos =
        metodosPago.map(
            item => Number(item.total)
        );


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

                responsive: true,

                maintainAspectRatio: false

            }

        }
    );


    // =====================================================
    // GRÁFICO PRODUCTOS VENDIDOS POR MES
    // =====================================================

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

                maintainAspectRatio: false,

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


<?php require_once __DIR__ . "/../layouts/footer.php"; ?>
