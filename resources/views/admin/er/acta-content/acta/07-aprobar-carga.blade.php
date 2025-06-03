@if($avance->ocheckacta==0)
    <li class=" d-flex justify-content-between align-items-center"
        style="border:none;">
        <span >
        <i class="fa fa-file" style="font-size:14px;"></i>&nbsp;
            <b  class="text-info" > {{ $datosacta->tipoacta->otipoacta }}</b>
        </span>
        
        <x-adminlte-button  label="PERMITIR MODIFICAR ACTA" 
                            data-toggle="modal" 
                            icon="fa fa-edit"
                            data-target="#modOpenActa" 
                            class="btn bg-warning btn-sm"/>


        <x-adminlte-modal   id="modOpenActa" 
                            title="PERMITIR MODIFICAR DATOS DEL ACTA" 
                            size="lg" 
                            theme="warning"
                            icon="fas fa-file" 
                            v-centered static-backdrop >
                <center style="font-size:16px;">
                        ¿DESEAS PERMITIR MODIFICAR ACTA</b>? <br>
                        <form   name="FrmCartel" id="FrmCartel" method="post" 
                                action="{{ route('entregas-recepcion.update', $datosacta->id ) }}" >
                                @method('PATCH')
                                @csrf
                            <input type="hidden" name="action" value="9">
                            <input type="hidden" name="idacta" value="{{ $datosacta->id }}">
                            <button type="submit" class="btn btn-outline-success btn-sm btn-block"
                                    title="APROBAR">
                                SÍ, PERMITIR&nbsp;<i class="fas fa-check"></i>
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




        <x-adminlte-button  label="APROBACIÓN PARA SUBIR ACTA ESCANEADA/FIRMADA" 
                            data-toggle="modal" 
                            icon="fa fa-check"
                            data-target="#modalAprobarcarga" 
                            class="btn bg-success btn-sm"/>

        <x-adminlte-modal   id="modalAprobarcarga" 
                            title="APROBAR PARA QUE SE PUEDA SUBIR EL ACTA ESCANEADA Y FIRMADA" 
                            size="lg" 
                            theme="teal"
                            icon="fas fa-unlock-alt" 
                            v-centered static-backdrop >
                <center style="font-size:16px;">
                        ¿DESEAS APROBAR PARA PROCEDER A SUBIR EL ACTA ESCANEADA Y FIRMADA</b>? <br>
                        <form   name="FrmCartel" id="FrmCartel" method="post" 
                                action="{{ route('entregas-recepcion.update', $datosacta->id ) }}" >
                                @method('PATCH')
                                @csrf
                            <input type="hidden" name="action" value="1">
                            <input type="hidden" name="idacta" value="{{ $datosacta->id }}">
                            <button type="submit" class="btn btn-outline-success btn-sm btn-block"
                                    title="APROBAR">
                                SI, APROBAR&nbsp;<i class="fas fa-check"></i>
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
    </li> 
@else
    @if($datosacta->ocargaacta==1)
            <li class=" d-flex justify-content-between align-items-center"
                style="border:none;">
                <span >
                <i class="fa fa-file" style="font-size:14px;"></i>&nbsp;
                    <b  class="text-info" > {{ $datosacta->tipoacta->otipoacta }}</b>
                </span>
        
                <a  href="../../storage/{{ $datosacta->ourl_acta }}"
                    target="_blank" 
                    class="btn btn-outline-success btn-sm "
                    title="{{ $datosacta->tipoacta->otipoacta }} FIRMADA Y ESCANEADA" 
                    style="text-decoration: none; font-size:12px;">
                    VER ACTA FIRMADA/ESCANEADA &nbsp;&nbsp;
                    <i class="fa fa-file-alt" style="font-size:16px;"></i>
                </a>
            </li>                                
    @elseif($datosacta->ocargaacta==0)
        <div class="bg-warning">
            <b><center style="font-size: 18px;">NO SE A REGISTRADO EL ACTA ESCANEADA Y FIRMADA </center></b>
        </div>
    @endif
@endif

