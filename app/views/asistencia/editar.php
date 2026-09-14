<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar asistencia</h2>

        <a href="index.php?modulo=asistencia" class="btn btn-secondary">
            Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="index.php?modulo=asistencia&accion=actualizar" method="POST">

                <input 
                    type="hidden" 
                    name="id_asistencia" 
                    value="<?= htmlspecialchars($asistencia['id_asistencia']) ?>"
                >

                <div class="mb-3">
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
                            <option 
                                value="<?= htmlspecialchars($empleado['id_empleado']) ?>"
                                <?= $empleado['id_empleado'] == $asistencia['id_empleado'] ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($empleado['nombres']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">
                        Fecha
                    </label>

                    <input
                        type="date"
                        name="fecha"
                        id="fecha"
                        class="form-control"
                        value="<?= htmlspecialchars($asistencia['fecha']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="hora_ingreso" class="form-label">
                        Hora de ingreso
                    </label>

                    <input
                        type="time"
                        name="hora_ingreso"
                        id="hora_ingreso"
                        class="form-control"
                        value="<?= htmlspecialchars(substr($asistencia['hora_ingreso'] ?? '', 0, 5)) ?>"
                    >
                </div>

                <div class="mb-3">
                    <label for="hora_salida" class="form-label">
                        Hora de salida
                    </label>

                    <input
                        type="time"
                        name="hora_salida"
                        id="hora_salida"
                        class="form-control"
                        value="<?= htmlspecialchars(substr($asistencia['hora_salida'] ?? '', 0, 5)) ?>"
                    >
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Actualizar asistencia
                    </button>

                    <a 
                        href="index.php?modulo=asistencia" 
                        class="btn btn-secondary"
                    >
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>