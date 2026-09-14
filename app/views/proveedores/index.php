<?php require_once __DIR__ . "/../layouts/header.php"; ?>


<div class="container mt-4">

    <h2 class="mb-4">
        Gestión de Proveedores
    </h2>


    <!-- ===================================== -->
    <!-- REGISTRAR PROVEEDOR -->
    <!-- ===================================== -->

    <div class="card mb-4">

        <div class="card-header">
            <strong>Registrar proveedor</strong>
        </div>


        <div class="card-body">

            <form
                action="/Proyecto_majo/public/index.php?modulo=proveedores&accion=guardar"
                method="POST"
            >

                <div class="row">

                    <div class="col-md-8">

                        <label class="form-label">
                            Nombre de la empresa
                        </label>

                        <input
                            type="text"
                            name="nombre_empresa"
                            class="form-control"
                            placeholder="Ej. Distribuidora Majo S.A.C."
                            required
                        >

                    </div>


                    <div class="col-md-4 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-success w-100"
                        >
                            + Registrar proveedor
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>



    <!-- ===================================== -->
    <!-- LISTA DE PROVEEDORES -->
    <!-- ===================================== -->

    <div class="card mb-4">

        <div class="card-header">

            <strong>
                Proveedores registrados
            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>
                            <th>Empresa</th>
                            <th>Acciones</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php foreach ($proveedores as $proveedor): ?>

                            <tr>

                                <td>
                                    <?= $proveedor['id_proveedor']; ?>
                                </td>


                                <td>
                                    <?= htmlspecialchars(
                                        $proveedor['nombre_empresa']
                                    ); ?>
                                </td>


                                <td>

                                    <!-- EDITAR -->

                                    <form
                                        action="/Proyecto_majo/public/index.php?modulo=proveedores&accion=actualizar"
                                        method="POST"
                                        class="d-inline"
                                    >

                                        <input
                                            type="hidden"
                                            name="id_proveedor"
                                            value="<?= $proveedor['id_proveedor']; ?>"
                                        >


                                        <input
                                            type="text"
                                            name="nombre_empresa"
                                            value="<?= htmlspecialchars($proveedor['nombre_empresa']); ?>"
                                            class="form-control d-inline-block"
                                            style="width: 250px;"
                                            required
                                        >


                                        <button
                                            type="submit"
                                            class="btn btn-warning btn-sm mt-1"
                                        >
                                            Editar
                                        </button>

                                    </form>


                                    <!-- ELIMINAR -->

                                    <a
                                        href="/Proyecto_majo/public/index.php?modulo=proveedores&accion=eliminar&id=<?= $proveedor['id_proveedor']; ?>"
                                        class="btn btn-danger btn-sm mt-1"
                                        onclick="return confirm('¿Deseas eliminar este proveedor?');"
                                    >
                                        Eliminar
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    <!-- ===================================== -->
    <!-- REGISTRAR PRECIO -->
    <!-- ===================================== -->

    <div class="card mb-4">

        <div class="card-header">

            <strong>
                Registrar precio de proveedor
            </strong>

        </div>


        <div class="card-body">

            <form
                action="/Proyecto_majo/public/index.php?modulo=proveedores&accion=guardarPrecio"
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

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- PROVEEDOR -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Proveedor
                        </label>

                        <select
                            name="id_proveedor"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Seleccionar proveedor
                            </option>


                            <?php foreach ($proveedores as $proveedor): ?>

                                <option
                                    value="<?= $proveedor['id_proveedor']; ?>"
                                >

                                    <?= htmlspecialchars(
                                        $proveedor['nombre_empresa']
                                    ); ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- PRECIO -->

                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Precio de compra
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                S/
                            </span>

                            <input
                                type="number"
                                name="precio_compra"
                                class="form-control"
                                min="0"
                                step="0.01"
                                required
                            >

                        </div>

                    </div>


                    <!-- BOTÓN -->

                    <div class="col-md-2 mb-3 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Guardar

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>



    <!-- ===================================== -->
    <!-- PRECIOS DE PROVEEDORES -->
    <!-- ===================================== -->

    <div class="card">

        <div class="card-header">

            <strong>
                Precios por proveedor
            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-secondary">

                        <tr>

                            <th>Producto</th>
                            <th>Proveedor</th>
                            <th>Precio de compra</th>
                            <th>Acciones</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (count($precios) > 0): ?>

                            <?php foreach ($precios as $precio): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars(
                                            $precio['nombre_producto']
                                        ); ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $precio['nombre_empresa']
                                        ); ?>
                                    </td>


                                    <td>

                                        S/
                                        <?= number_format(
                                            $precio['precio_compra'],
                                            2
                                        ); ?>

                                    </td>


                                    <td>

                                        <!-- ACTUALIZAR PRECIO -->

                                        <form
                                            action="/Proyecto_majo/public/index.php?modulo=proveedores&accion=actualizarPrecio"
                                            method="POST"
                                            class="d-inline"
                                        >

                                            <input
                                                type="hidden"
                                                name="id_producto"
                                                value="<?= $precio['id_producto']; ?>"
                                            >


                                            <input
                                                type="hidden"
                                                name="id_proveedor"
                                                value="<?= $precio['id_proveedor']; ?>"
                                            >


                                            <input
                                                type="number"
                                                name="precio_compra"
                                                value="<?= $precio['precio_compra']; ?>"
                                                min="0"
                                                step="0.01"
                                                class="form-control d-inline-block"
                                                style="width: 120px;"
                                                required
                                            >


                                            <button
                                                type="submit"
                                                class="btn btn-warning btn-sm"
                                            >
                                                Actualizar
                                            </button>

                                        </form>


                                        <!-- ELIMINAR -->

                                        <a
                                            href="/Proyecto_majo/public/index.php?modulo=proveedores&accion=eliminarPrecio&producto=<?= $precio['id_producto']; ?>&proveedor=<?= $precio['id_proveedor']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Deseas eliminar este precio?');"
                                        >
                                            Eliminar
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center"
                                >
                                    No hay precios de proveedores registrados.

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