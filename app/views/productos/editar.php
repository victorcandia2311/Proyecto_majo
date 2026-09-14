<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<main class="container-fluid py-4">

    <div class="row justify-content-center">

        <div class="col-12 col-md-10 col-lg-8 col-xl-6">

            <div class="card shadow-sm">

                <div class="card-header">
                    <h2 class="h4 mb-0">Editar Producto</h2>
                </div>

                <div class="card-body">

                    <form
                        action="/Proyecto_majo/public/index.php?modulo=productos&accion=actualizar"
                        method="POST"
                    >

                        <input
                            type="hidden"
                            name="id_producto"
                            value="<?= $producto['id_producto']; ?>"
                        >


                        <!-- NOMBRE -->
                        <div class="mb-3">

                            <label class="form-label">
                                Nombre del producto
                            </label>

                            <input
                                type="text"
                                name="nombre_producto"
                                class="form-control"
                                value="<?= htmlspecialchars($producto['nombre_producto']); ?>"
                                required
                            >

                        </div>


                        <!-- STOCK ACTUAL -->
                        <div class="mb-3">

                            <label class="form-label">
                                Stock actual
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                value="<?= $producto['stock_actual']; ?>"
                                disabled
                            >

                            <div class="form-text">
                                El stock se modifica desde el módulo de
                                Inventario.
                            </div>

                        </div>


                        <!-- STOCK MÍNIMO -->
                        <div class="mb-3">

                            <label class="form-label">
                                Stock mínimo para alerta
                            </label>

                            <input
                                type="number"
                                name="stock_minimo_alerta"
                                class="form-control"
                                value="<?= $producto['stock_minimo_alerta']; ?>"
                                min="0"
                                required
                            >

                        </div>


                        <!-- PRECIO -->
                        <div class="mb-4">

                            <label class="form-label">
                                Precio de venta
                            </label>

                            <input
                                type="number"
                                name="precio_venta"
                                class="form-control"
                                step="0.01"
                                min="0"
                                value="<?= $producto['precio_venta']; ?>"
                                required
                            >

                        </div>


                        <!-- BOTONES -->
                        <div class="d-flex flex-wrap gap-2">

                            <button
                                type="submit"
                                class="btn btn-success"
                            >
                                Actualizar Producto
                            </button>

                            <a
                                href="/Proyecto_majo/public/index.php?modulo=productos"
                                class="btn btn-secondary"
                            >
                                Cancelar
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</main>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>
