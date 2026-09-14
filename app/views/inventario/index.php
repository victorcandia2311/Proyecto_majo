<?php require_once __DIR__ . "/../layouts/header.php"; ?>


<div class="container mt-4">

    <h2 class="mb-4">
        Gestión de Inventario
    </h2>


    <!-- ===================================== -->
    <!-- FORMULARIO AUMENTAR INVENTARIO -->
    <!-- ===================================== -->

    <div class="card mb-4">

        <div class="card-header">
            <strong>Aumentar inventario</strong>
        </div>


        <div class="card-body">

            <form
                action="/Proyecto_majo/public/index.php?modulo=inventario&accion=aumentar"
                method="POST"
            >

                <div class="row">

                    <!-- PRODUCTO -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Producto
                        </label>

                        <select
                            name="id_producto"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Seleccionar producto
                            </option>


                            <?php foreach ($productos as $producto): ?>

                                <option
                                    value="<?= $producto['id_producto']; ?>"
                                >

                                    <?= htmlspecialchars(
                                        $producto['nombre_producto']
                                    ); ?>

                                    — Stock:
                                    <?= $producto['stock_actual']; ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- CANTIDAD -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Cantidad a ingresar
                        </label>

                        <input
                            type="number"
                            name="cantidad"
                            class="form-control"
                            min="1"
                            required
                        >

                    </div>


                    <!-- MOTIVO -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Motivo
                        </label>

                        <input
                            type="text"
                            name="motivo"
                            class="form-control"
                            placeholder="Ej. Reabastecimiento"
                        >

                    </div>


                    <!-- BOTÓN -->

                    <div class="col-md-2 mb-3 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-success w-100"
                        >
                            + Aumentar
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>



    <!-- ===================================== -->
    <!-- TABLA DE INVENTARIO -->
    <!-- ===================================== -->

    <div class="card mb-4">

        <div class="card-header">

            <strong>
                Inventario actual
            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>
                            <th>Producto</th>
                            <th>Stock actual</th>
                            <th>Stock mínimo</th>
                            <th>Precio</th>
                            <th>Estado</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php foreach ($productos as $producto): ?>

                            <tr>

                                <td>
                                    <?= $producto['id_producto']; ?>
                                </td>


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


                                <td>
                                    S/
                                    <?= number_format(
                                        $producto['precio_venta'],
                                        2
                                    ); ?>
                                </td>


                                <td>

                                    <?php
                                    if ($producto['stock_actual'] <= 10):
                                    ?>

                                        <span class="badge bg-danger">
                                            Stock bajo
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-success">
                                            Disponible
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    <!-- ===================================== -->
    <!-- HISTORIAL DE MOVIMIENTOS -->
    <!-- ===================================== -->

    <div class="card">

        <div class="card-header">

            <strong>
                Historial de movimientos
            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead class="table-secondary">

                        <tr>

                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Motivo</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (count($movimientos) > 0): ?>

                            <?php foreach ($movimientos as $movimiento): ?>

                                <tr>

                                    <td>
                                        <?= $movimiento['fecha_hora']; ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $movimiento['nombre_producto']
                                        ); ?>
                                    </td>


                                    <td>

                                        <?php if (
                                            $movimiento['tipo_movimiento']
                                            === 'ENTRADA'
                                        ): ?>

                                            <span class="badge bg-success">
                                                ENTRADA
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-danger">
                                                SALIDA
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <td>
                                        <?= $movimiento['cantidad']; ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $movimiento['motivo'] ?? ''
                                        ); ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center"
                                >
                                    No existen movimientos registrados.
                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<?php require_once __DIR__ . "/../layouts/footer.php"; ?>