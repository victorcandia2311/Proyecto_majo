<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-4">

```
<h2>Registrar Producto</h2>

<form
    action="/Proyecto_majo/public/index.php?modulo=productos&accion=guardar"
    method="POST"
>

    <div class="mb-3">

        <label class="form-label">
            Nombre del producto
        </label>

        <input
            type="text"
            name="nombre_producto"
            class="form-control"
            required
        >

    </div>


    <div class="mb-3">

        <label class="form-label">
            Stock inicial
        </label>

        <input
            type="number"
            name="stock_actual"
            class="form-control"
            min="0"
            required
        >

    </div>


    <div class="mb-3">

        <label class="form-label">
            Stock mínimo para alerta
        </label>

        <input
            type="number"
            name="stock_minimo_alerta"
            class="form-control"
            value="10"
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
            required
        >

    </div>


    <button
        type="submit"
        class="btn btn-success"
    >
        Guardar Producto
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
