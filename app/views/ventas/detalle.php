<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Venta #<?= $venta['id_venta']; ?>
        </h2>

        <a
            href="/Proyecto_majo/public/index.php?modulo=ventas"
            class="btn btn-secondary"
        >
            Volver
        </a>

    </div>


    <!-- DATOS DE LA VENTA -->

    <div class="card mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-4">

                    <strong>Fecha:</strong><br>

                    <?= $venta['fecha_hora']; ?>

                </div>


                <div class="col-md-4">

                    <strong>Cliente:</strong><br>

                    <?= htmlspecialchars(
                        $venta['cliente_nombre']
                        ?? 'Cliente general'
                    ); ?>

                </div>


                <div class="col-md-4">

                    <strong>Método de pago:</strong><br>

                    <?= htmlspecialchars(
                        $venta['metodo_pago']
                    ); ?>

                </div>

            </div>

        </div>

    </div>



    <!-- PRODUCTOS -->

    <div class="card">

        <div class="card-header">

            <strong>
                Productos vendidos
            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead class="table-dark">

                        <tr>

                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Subtotal</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php foreach ($detalles as $detalle): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars(
                                        $detalle['nombre_producto']
                                    ); ?>
                                </td>


                                <td>
                                    <?= $detalle['cantidad']; ?>
                                </td>


                                <td>

                                    S/
                                    <?= number_format(
                                        $detalle['precio_unitario'],
                                        2
                                    ); ?>

                                </td>


                                <td>

                                    S/
                                    <?= number_format(
                                        $detalle['subtotal'],
                                        2
                                    ); ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>


                    <tfoot>

                        <tr>

                            <th
                                colspan="3"
                                class="text-end"
                            >
                                TOTAL
                            </th>

                            <th>

                                S/
                                <?= number_format(
                                    $venta['total_venta'],
                                    2
                                ); ?>

                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

</div>

<div class="mt-4 d-flex gap-2">
    <a
    href="index.php?modulo=ventas&accion=pdf&id=<?= $venta['id_venta'] ?>"
    class="btn btn-danger"
    target="_blank"
    >
        Descargar PDF
    </a>
<br><br>
    <a
        href="/Proyecto_majo/public/index.php?modulo=ventas"
        class="btn btn-secondary"
    >
        Volver a ventas
    </a>

</div>
<?php require_once __DIR__ . "/../layouts/footer.php"; ?>

