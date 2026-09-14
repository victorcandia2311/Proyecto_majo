<?php

require_once __DIR__ . "/../layouts/header.php";

?>

<div class="container mt-4">

    <!-- ========================================== -->
    <!-- TÍTULO -->
    <!-- ========================================== -->

    <div class="mb-4">

        <h2>Control de asistencia</h2>

        <p class="text-muted">
            Registre manualmente la fecha, hora de ingreso y hora de salida
            de los empleados.
        </p>

    </div>


    <!-- ========================================== -->
    <!-- MENSAJES -->
    <!-- ========================================== -->

    <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicado'): ?>

        <div class="alert alert-warning">
            El empleado ya tiene una asistencia registrada para esa fecha.
        </div>

    <?php endif; ?>


    <?php if (isset($_GET['mensaje'])): ?>

        <?php if ($_GET['mensaje'] === 'registrado'): ?>

            <div class="alert alert-success">
                Asistencia registrada correctamente.
            </div>

        <?php elseif ($_GET['mensaje'] === 'actualizado'): ?>

            <div class="alert alert-success">
                Asistencia actualizada correctamente.
            </div>

        <?php elseif ($_GET['mensaje'] === 'eliminado'): ?>

            <div class="alert alert-success">
                Asistencia eliminada correctamente.
            </div>

        <?php endif; ?>

    <?php endif; ?>


    <!-- ========================================== -->
    <!-- FORMULARIO DE REGISTRO -->
    <!-- ========================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <strong>Registrar asistencia</strong>
        </div>

        <div class="card-body">

            <form
                method="POST"
                action="/Proyecto_majo/public/index.php?modulo=asistencia&accion=guardar"
            >

                <div class="row">

                    <!-- EMPLEADO -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Empleado
                        </label>

                        <select
                            name="id_empleado"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Seleccione un empleado
                            </option>

                            <?php foreach ($empleados as $empleado): ?>

                                <option
                                    value="<?= $empleado['id_empleado']; ?>"
                                >
                                    <?= htmlspecialchars(
                                        $empleado['nombres']
                                    ); ?>
                                    -
                                    <?= htmlspecialchars(
                                        $empleado['documento_identidad']
                                    ); ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- FECHA -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Fecha
                        </label>

                        <input
                            type="date"
                            name="fecha"
                            class="form-control"
                            value="<?= date('Y-m-d'); ?>"
                            required
                        >

                    </div>


                    <!-- HORA INGRESO -->

                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Hora de ingreso
                        </label>

                        <input
                            type="time"
                            name="hora_ingreso"
                            class="form-control"
                        >

                    </div>


                    <!-- HORA SALIDA -->

                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Hora de salida
                        </label>

                        <input
                            type="time"
                            name="hora_salida"
                            class="form-control"
                        >

                    </div>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Registrar asistencia
                </button>

            </form>

        </div>

    </div>

    <!-- ========================================== -->
    <!-- FORMULARIO DE ASISTENCIAS -->
    <!-- ========================================== -->

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h4 class="mb-3">Control de asistencia</h4>

            <form method="POST" class="row g-3">

                <div class="col-md-6">
                    <label for="id_empleado" class="form-label">
                        Empleado
                    </label>

                    <select
                        name="id_empleado"
                        id="id_empleado"
                        class="form-select"
                        required
                    >
                        <option value="">Seleccione un empleado</option>

                        <?php foreach ($empleados as $empleado): ?>
                            <option value="<?= htmlspecialchars($empleado['id_empleado']) ?>">
                                <?= htmlspecialchars($empleado['nombres']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 d-flex align-items-end gap-2">

                    <button
                        type="submit"
                        formaction="index.php?modulo=asistencia&accion=registrarIngreso"
                        class="btn btn-success"
                    >
                        Registrar ingreso
                    </button>

                    <button
                        type="submit"
                        formaction="index.php?modulo=asistencia&accion=registrarSalida"
                        class="btn btn-primary"
                    >
                        Registrar salida
                    </button>

                </div>

            </form>

        </div>
    </div>


    <!-- ========================================== -->
    <!-- TABLA DE ASISTENCIAS -->
    <!-- ========================================== -->

    <div class="card shadow-sm">

        <div class="card-header">
            <strong>Asistencias registradas</strong>
        </div>

        <div class="card-body">

            <?php if (empty($asistencias)): ?>

                <div class="alert alert-info">
                    No hay asistencias registradas.
                </div>

            <?php else: ?>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>
                                <th>Empleado</th>
                                <th>Documento</th>
                                <th>Fecha</th>
                                <th>Ingreso</th>
                                <th>Salida</th>
                                <th>Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($asistencias as $asistencia): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars(
                                            $asistencia['id_asistencia']
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $asistencia['nombres']
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $asistencia['documento_identidad']
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $asistencia['fecha']
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= $asistencia['hora_ingreso']
                                            ? htmlspecialchars(
                                                $asistencia['hora_ingreso']
                                            )
                                            : '—'; ?>
                                    </td>

                                    <td>
                                        <?= $asistencia['hora_salida']
                                            ? htmlspecialchars(
                                                $asistencia['hora_salida']
                                            )
                                            : '—'; ?>
                                    </td>

                                    <td>

                                        <a
                                            href="/Proyecto_majo/public/index.php?modulo=asistencia&accion=editar&id=<?= $asistencia['id_asistencia']; ?>"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="/Proyecto_majo/public/index.php?modulo=asistencia&accion=eliminar&id=<?= $asistencia['id_asistencia']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Está seguro de eliminar esta asistencia?');"
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