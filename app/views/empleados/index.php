<?php

require_once __DIR__ . "/../layouts/header.php";

?>

<div class="container mt-4">

    <!-- ========================================== -->
    <!-- TÍTULO -->
    <!-- ========================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Gestión de empleados</h2>
            <p class="text-muted">
                Registro y administración de empleados.
            </p>
        </div>

    </div>


    <!-- ========================================== -->
    <!-- FORMULARIO DE REGISTRO -->
    <!-- ========================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <strong>Registrar empleado</strong>
        </div>

        <div class="card-body">

            <form
                method="POST"
                action="/Proyecto_majo/public/index.php?modulo=empleados&accion=guardar"
            >

                <div class="row">

                    <!-- NOMBRES -->

                    <div class="col-md-5 mb-3">

                        <label class="form-label">
                            Nombres completos
                        </label>

                        <input
                            type="text"
                            name="nombres"
                            class="form-control"
                            placeholder="Ingrese nombres completos"
                            required
                        >

                    </div>


                    <!-- DOCUMENTO -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Documento de identidad
                        </label>

                        <input
                            type="text"
                            name="documento_identidad"
                            class="form-control"
                            placeholder="Ingrese documento"
                            required
                        >

                    </div>


                    <!-- TIPO DE EMPLEADO -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Tipo de empleado
                        </label>

                        <select
                            name="es_eventual"
                            class="form-select"
                            required
                        >
                            <option value="false" selected>
                                Permanente
                            </option>

                        <option value="true">
                            Eventual
                        </option>
                    </select>

                </div>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Registrar empleado
                </button>

            </form>

        </div>

    </div>


    <!-- ========================================== -->
    <!-- LISTA DE EMPLEADOS -->
    <!-- ========================================== -->

    <div class="card shadow-sm">

        <div class="card-header">
            <strong>Empleados registrados</strong>
        </div>

        <div class="card-body">

            <?php if (empty($empleados)): ?>

                <div class="alert alert-info">
                    No hay empleados registrados.
                </div>

            <?php else: ?>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>

                                <th>Nombres</th>

                                <th>Documento</th>

                                <th>Tipo</th>

                                <th class="text-center">
                                    Acciones
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($empleados as $empleado): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars(
                                            $empleado['id_empleado']
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $empleado['nombres']
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $empleado['documento_identidad']
                                        ); ?>
                                    </td>

                                    <td>

                                        <?php if ($empleado['es_eventual']): ?>

                                            <span class="badge bg-warning text-dark">
                                                Eventual
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-success">
                                                Permanente
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td class="text-center">

                                        <a
                                            href="/Proyecto_majo/public/index.php?modulo=empleados&accion=editar&id=<?= $empleado['id_empleado']; ?>"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="/Proyecto_majo/public/index.php?modulo=empleados&accion=eliminar&id=<?= $empleado['id_empleado']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Está seguro de eliminar este empleado?');"
                                        >
                                            Eliminar
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>


<?php

require_once __DIR__ . "/../layouts/footer.php";

?>