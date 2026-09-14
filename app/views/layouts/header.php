<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#212529">

    <title>Sistema de Inventario</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Estilos propios -->
    <link
        rel="stylesheet"
        href="/Proyecto_majo/public/assets/css/responsive.css"
    >
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">

        <a
            class="navbar-brand fw-bold"
            href="index.php?modulo=dashboard"
        >
            Sistema de Inventario
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuPrincipal"
            aria-controls="menuPrincipal"
            aria-expanded="false"
            aria-label="Mostrar menú"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div
            class="collapse navbar-collapse"
            id="menuPrincipal"
        >
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="index.php?modulo=dashboard"
                    >
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="index.php?modulo=productos"
                    >
                        Productos
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="index.php?modulo=inventario"
                    >
                        Inventario
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="index.php?modulo=proveedores"
                    >
                        Proveedores
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="index.php?modulo=ventas"
                    >
                        Ventas
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="index.php?modulo=empleados"
                    >
                        Empleados
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="index.php?modulo=asistencia"
                    >
                        Asistencia
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>


