<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<main class="container-fluid py-4">

    <!-- ENCABEZADO -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">

        <div>
            <h2 class="mb-1">Productos</h2>
            <p class="text-muted mb-0">
                Gestión de productos e inventario.
            </p>
        </div>

        <a
            href="/Proyecto_majo/public/index.php?modulo=productos&accion=crear"
            class="btn btn-primary"
        >
            + Nuevo Producto
        </a>

    </div>


    <!-- TABLA DE PRODUCTOS -->
    <div class="card shadow-sm">

        <div class="card-header">
            <strong>Lista de productos</strong>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Stock mínimo</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
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

                                    <?php if ($producto['stock_actual'] <= 10): ?>

                                        <span class="badge bg-danger">
                                            Stock Bajo
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-success">
                                            Disponible
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <div class="d-flex flex-wrap gap-1">

                                        <a
                                            href="/Proyecto_majo/public/index.php?modulo=productos&accion=editar&id=<?= $producto['id_producto']; ?>"
                                            class="btn btn-warning btn-sm"
                                        >
                                            Editar
                                        </a>


                                        <a
                                            href="/Proyecto_majo/public/index.php?modulo=productos&accion=eliminar&id=<?= $producto['id_producto']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Deseas eliminar este producto?');"
                                        >
                                            Eliminar
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>
