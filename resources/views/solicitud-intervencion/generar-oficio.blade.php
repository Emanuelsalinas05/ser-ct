<div class="modal fade" id="modalGenerarOficioIntervencion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">SOLICITUD PARA LA GESTIÓN DE INTERVENCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    RECUERDA QUE <strong>TODOS</strong> LOS REGISTROS VISUALIZADOS EN LA TABLA, SERÁN AGRUPADOS EN EL OFICIO QUE ESTAS A PUNTO DE REALIZAR.
                </div>

                <div class="form-group">
                    <label>Ingresa el consecutivo del oficio:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="consecutivo" value="{{ $consecutivo ?? '' }}">
                        <div class="input-group-append">
                            <span class="input-group-text">/{{ date('Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nombre del titular:</label>
                    <input type="text" class="form-control" id="titular" value="{{ Auth::user()->name }}" readonly>
                </div>

                <div class="form-group">
                    <label>Área/Oficina/etc solicitante:</label>
                    <input type="text" class="form-control" id="area">
                </div>

                <div class="form-group">
                    <label>Rúbrica:</label>
                    <input type="text" class="form-control" id="rubrica">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="generarFormatoOficio()">
                    GENERAR FORMATO PARA OFICIO
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    CANCELAR ACCIÓN
                </button>
            </div>
        </div>
    </div>
</div>