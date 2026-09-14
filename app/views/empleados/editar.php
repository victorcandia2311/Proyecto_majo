<?php

require_once __DIR__ . "/../layouts/header.php";

?>

<div class="container mt-4">

    <!-- ========================================== -->
    <!-- TÍTULO -->
    <!-- ========================================== -->

    <div class="mb-4">

        <h2>Editar empleado</h2>

        <p class="text-muted">
            Modifique los datos del empleado seleccionado.
        </p>

    </div>


    <!-- ========================================== -->
    <!-- FORMULARIO -->
    <!-- ========================================== -->

    <div class="card shadow-sm">

        <div class="card-header">
            <strong>Datos del empleado</strong>
        </div>

        <div class="card-body">

            <form
                method="POST"
                action="/Proyecto_majo/public/index.php?modulo=empleados&accion=actualizar"
            >

                <!-- ID DEL EMPLEADO -->

                <input
                    type="hidden"
                    name="id_empleado"
                    value="<?= htmlspecialchars($empleado['id_empleado']); ?>"
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
                            value="<?= htmlspecialchars($empleado['nombres']); ?>"
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
                            value="<?= htmlspecialchars($empleado['documento_identidad']); ?>"
                            required
                        >

                    </div>


                    <!-- TIPO -->

                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            Tipo de empleado
                        </label>

                        <select
                            name="es_eventual"
                            class="form-select"
                            required
                        >

                            <option
                                value="false"
                                <?= !$empleado['es_eventual'] ? 'selected' : ''; ?>
                            >
                                Permanente
                            </option>

                            <option
                                value="true"
                                <?= $empleado['es_eventual'] ? 'selected' : ''; ?>
                            >
                                Eventual
                            </option>

                        </select>

                    </div>

                </div>


                <!-- BOTONES -->

                <div class="mt-3">

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        Guardar cambios
                    </button>

                    <a
                        href="/Proyecto_majo/public/index.php?modulo=empleados"
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

require_once __DIR__ . "/../layouts/footer.php";

?>