<div class="modal fade" id="assistantListForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assistantListFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/taller/print/<?php echo $workshopId ?>" method="get">
                <div class="modal-header">
                    <h5 class="modal-title" id="assistantListFormLabel">Generar lista de asistencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Fecha de inicio de semestre</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Fecha de fin de semestre</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="day_of_week" class="form-label">Dia de la semana del taller</label>
                        <select class="form-select" id="day_of_week" name="day_of_week" required>
                            <option value="1">Lunes</option>
                            <option value="2">Martes</option>
                            <option value="3">Miercoles</option>
                            <option value="4">Jueves</option>
                            <option value="5">Viernes</option>
                            <option value="6">Sabado</option>
                            <option value="7">Domingo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Generar</button>
                </div>
            </form>
        </div>
    </div>
</div>