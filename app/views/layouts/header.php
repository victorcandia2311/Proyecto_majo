<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#1f2937">

    <title>Sistema de Inventario</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <!-- Estilos propios -->
    <link
        rel="stylesheet"
        href="/Proyecto_majo/public/css/style.css"
    >
    <link
        rel="stylesheet"
        href="/Proyecto_majo/public/assets/css/responsive.css"
    >
</head>

<body class="app-body">
<div class="app-wrapper">
    <header class="main-header">
        <div class="header-inner">
            <button
                class="sidebar-toggle"
                type="button"
                aria-controls="appSidebar"
                aria-expanded="false"
                aria-label="Mostrar navegación"
                data-sidebar-toggle
            >
                <i class="bi bi-list" aria-hidden="true"></i>
            </button>
            <a class="header-brand" href="index.php?modulo=dashboard">
                <i class="bi bi-box-seam-fill" aria-hidden="true"></i>
                <span>Sistema de Inventario</span>
            </a>
            <div class="header-status">
                <i class="bi bi-shield-check" aria-hidden="true"></i>
                Panel administrativo
            </div>
        </div>
    </header>

    <aside class="main-sidebar" id="appSidebar">
        <div class="sidebar-brand">
            <span class="brand-mark"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
            <span>MAJO</span>
        </div>
        <div class="sidebar-label">NAVEGACIÓN PRINCIPAL</div>
        <nav class="sidebar-nav" aria-label="Navegación principal">
            <a class="sidebar-link" href="index.php?modulo=dashboard">
                <i class="bi bi-speedometer2" aria-hidden="true"></i><span>Dashboard</span>
            </a>
            <a class="sidebar-link" href="index.php?modulo=productos">
                <i class="bi bi-box2" aria-hidden="true"></i><span>Productos</span>
            </a>
            <a class="sidebar-link" href="index.php?modulo=inventario">
                <i class="bi bi-clipboard-data" aria-hidden="true"></i><span>Inventario</span>
            </a>
            <a class="sidebar-link" href="index.php?modulo=proveedores">
                <i class="bi bi-truck" aria-hidden="true"></i><span>Proveedores</span>
            </a>
            <a class="sidebar-link" href="index.php?modulo=ventas">
                <i class="bi bi-receipt" aria-hidden="true"></i><span>Ventas</span>
            </a>
            <a class="sidebar-link" href="index.php?modulo=empleados">
                <i class="bi bi-people" aria-hidden="true"></i><span>Empleados</span>
            </a>
            <a class="sidebar-link" href="index.php?modulo=asistencia">
                <i class="bi bi-calendar2-check" aria-hidden="true"></i><span>Asistencia</span>
            </a>
        </nav>
    </aside>

    <div class="sidebar-overlay" data-sidebar-toggle></div>
    <main class="main-content">
        <div class="content-header">
            <div class="content-header-inner">
                <span class="content-kicker">GESTIÓN EMPRESARIAL</span>
                <span class="content-path"><i class="bi bi-house-door" aria-hidden="true"></i> / Panel</span>
            </div>
        </div>
        <div class="content-body">


