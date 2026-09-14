<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-4">

    <h2 class="mb-4">
        Gestión de Ventas
    </h2>


    <!-- ===================================== -->
    <!-- SELECCIONAR PRODUCTO -->
    <!-- ===================================== -->

    <div class="card mb-4">

        <div class="card-header">
            <strong>Agregar producto a la venta</strong>
        </div>


        <div class="card-body">

            <form
                action="/Proyecto_majo/public/index.php?modulo=ventas&accion=agregar"
                method="POST"
            >

                <div class="row">

                    <div class="col-md-6 mb-3">

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

                                    —
                                    Stock:
                                    <?= $producto['stock_actual']; ?>

                                    —
                                    S/
                                    <?= number_format(
                                        $producto['precio_venta'],
                                        2
                                    ); ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Cantidad
                        </label>

                        <input
                            type="number"
                            name="cantidad"
                            class="form-control"
                            min="1"
                            required
                        >

                    </div>


                    <div class="col-md-3 mb-3 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            + Agregar
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>



    <!-- ===================================== -->
    <!-- CARRITO -->
    <!-- ===================================== -->

    <div class="card mb-4">

        <div class="card-header">
            <strong>Detalle de la venta</strong>
        </div>


        <div class="card-body">

            <?php if (!empty($carrito)): ?>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead class="table-dark">

                            <tr>

                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>Subtotal</th>
                                <th>Acción</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php

                            $total = 0;

                            foreach ($carrito as $item):

                                $subtotal =
                                    $item['cantidad'] *
                                    $item['precio_unitario'];

                                $total += $subtotal;

                            ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars(
                                            $item['nombre_producto']
                                        ); ?>
                                    </td>


                                    <td>
                                        <?= $item['cantidad']; ?>
                                    </td>


                                    <td>
                                        S/
                                        <?= number_format(
                                            $item['precio_unitario'],
                                            2
                                        ); ?>
                                    </td>


                                    <td>
                                        S/
                                        <?= number_format(
                                            $subtotal,
                                            2
                                        ); ?>
                                    </td>


                                    <td>

                                        <a
                                            href="/Proyecto_majo/public/index.php?modulo=ventas&accion=eliminar&id=<?= $item['id_producto']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Eliminar este producto de la venta?');"
                                        >
                                            Eliminar
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>


                        <tfoot>

                            <tr>

                                <th colspan="3" class="text-end">
                                    TOTAL
                                </th>

                                <th colspan="2">

                                    S/
                                    <?= number_format(
                                        $total,
                                        2
                                    ); ?>

                                </th>

                            </tr>

                        </tfoot>

                    </table>

                </div>


                <!-- VACIAR -->

                <a
                    href="/Proyecto_majo/public/index.php?modulo=ventas&accion=vaciar"
                    class="btn btn-secondary"
                    onclick="return confirm('¿Vaciar toda la venta?');"
                >
                    Vaciar venta
                </a>


            <?php else: ?>

                <div class="alert alert-info">

                    No hay productos agregados a la venta.

                </div>

            <?php endif; ?>

        </div>

    </div>



    <!-- ===================================== -->
    <!-- DATOS DE LA VENTA -->
    <!-- ===================================== -->

    <?php if (!empty($carrito)): ?>

        <div class="card mb-4">

            <div class="card-header">
                <strong>Datos de facturación</strong>
            </div>


            <div class="card-body">

                <form
                    action="/Proyecto_majo/public/index.php?modulo=ventas&accion=confirmar"
                    method="POST"
                >

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Nombre del cliente
                            </label>

                            <input
                                type="text"
                                name="cliente_nombre"
                                class="form-control"
                                placeholder="Opcional"
                            >

                        </div>


                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Documento
                            </label>

                            <input
                                type="text"
                                name="cliente_documento"
                                class="form-control"
                                placeholder="DNI / RUC - Opcional"
                            >

                        </div>


                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Método de pago
                            </label>

                            <select
                                name="metodo_pago"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Seleccionar
                                </option>

                                <option value="Efectivo">
                                    Efectivo
                                </option>

                                <option value="Yape">
                                    Yape
                                </option>

                                <option value="Plin">
                                    Plin
                                </option>

                                <option value="Tarjeta">
                                    Tarjeta
                                </option>

                            </select>

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-success btn-lg"
                    >
                        Confirmar venta
                    </button>

                </form>

            </div>

        </div>

    <?php endif; ?>



    <!-- ===================================== -->
    <!-- HISTORIAL DE VENTAS -->
    <!-- ===================================== -->

    <div class="card">

        <div class="card-header">

            <strong>
                Historial de ventas
            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-secondary">

                        <tr>

                            <th>N.º</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Método de pago</th>
                            <th>Total</th>
                            <th>Acción</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php foreach ($ventas as $venta): ?>

                            <tr>

                                <td>
                                    #<?= $venta['id_venta']; ?>
                                </td>


                                <td>
                                    <?= $venta['fecha_hora']; ?>
                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $venta['cliente_nombre']
                                        ?? 'Cliente general'
                                    ); ?>

                                </td>


                                <td>
                                    <?= htmlspecialchars(
                                        $venta['metodo_pago']
                                    ); ?>
                                </td>


                                <td>

                                    S/
                                    <?= number_format(
                                        $venta['total_venta'],
                                        2
                                    ); ?>

                                </td>


                                <td>

                                    <a
                                        href="/Proyecto_majo/public/index.php?modulo=ventas&accion=detalle&id=<?= $venta['id_venta']; ?>"
                                        class="btn btn-info btn-sm"
                                    >
                                        Ver detalle
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<?php require_once __DIR__ . "/../layouts/footer.php"; ?>