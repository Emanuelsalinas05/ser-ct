<x-adminlte-modal   id="modalaprob{{ $solicitud->id }}" 
                    title="APROBAR SOLICITUD DE CERTIFICADO DE NO ADEUDO" 
                    size="lg" 
                    theme="lightblue"
                    icon="fa fa-file-alt" 
                    v-centered static-backdrop >

        <center style="font-size:16px;">
                <p style="text-align:justify;">
                        De conformidad con el Acuerdo por el que se establecen como sujetos obligados al proceso de entrega y recepción, a las personas servidoras públicas de SEIEM, de niveles diversos a los señalados en el párrafo primero, del artículo 6 del Reglamento para los Procesos de Entrega y Recepción y Rendición de Cuentas de la Administración Pública del Estado de México (Periódico Oficial "Gaceta del Gobierno", 22/07/2021).
                        <br>
                        <br>
                        Al aprobar la solicitud de <b>{{ $solicitud->acta->onombre_entrega_a }}</b>, con RFC <b>{{ $solicitud->acta->orfc_entrega_a }}</b>, expreso mi acuerdo aceptando los términos y condiciones que de esta acción se derivan, asumiendo la responsabilidad y teniendo el pleno conocimiento de dicha solicitud, para que se proceda conforme a lo establecido a gestionar la emisión del certificado de no adeudo solicitado.
                        <br>
                        <br>
                        Lo anterior, una vez que como <b>autoridad inmediata superior</b>, realicé la revisión correspondiente, sin encontrar evidencia de adeudos en los registros, y validé que se cuenta con el sustento documental correspondiente.
                        <br>
                </p>
                ¿DESEAS APROBAR LA SOLICITUD DE ESTE CERTIFICADO DE NO ADEUDO? 
                <br>
                <br>           
            
                <form   name="FrmCartel" 
                        id="FrmCartel" 
                        method="post" 
                        action="{{ route('ver-solicitudes-noadeudos.update', $solicitud->id ) }}" >
                        @method('PATCH')
                        @csrf
                        

                        <button type="submit" 
                                class="btn btn-success btn-sm btn-block"
                                title="APROBAR">
                            SÍ, APROBAR ESTA SOLICITUD&nbsp;
                            <i class="fas fa-check"></i>
                        </button>

                </form>

        </center>

        <x-slot name="footerSlot">
                <x-adminlte-button  theme="secondary" 
                                    label=" CANCELAR ACCIÓN " 
                                    data-dismiss="modal" 
                                    icon="fa fa-times"
                                    class="btn-sm"/>
        </x-slot>
</x-adminlte-modal>