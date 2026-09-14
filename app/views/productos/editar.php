<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-4">

```
<h2>Editar Producto</h2>

<form
    action="/Proyecto_majo/public/index.php?modulo=productos&accion=actualizar"
    method="POST"
>

    <input
        type="hidden"
        name="id_producto"
        value="<?= $producto['id_producto']; ?>"
    >


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

        <small class="text-muted">
            El stock se modifica desde el módulo de Inventario.
        </small>

    </div>


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


    <div class="mb-3">

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

</form>
```

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>
