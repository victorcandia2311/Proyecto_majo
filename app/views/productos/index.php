<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-4">

```
<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>Productos</h2>

    <a
        href="/Proyecto_majo/public/index.php?modulo=productos&accion=crear"
        class="btn btn-primary"
    >
        + Nuevo Producto
    </a>

</div>


<table class="table table-bordered table-hover">

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
                            ⚠ Stock Bajo
                        </span>

                    <?php else: ?>

                        <span class="badge bg-success">
                            Disponible
                        </span>

                    <?php endif; ?>

                </td>


                <td>

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

                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>
```

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>
