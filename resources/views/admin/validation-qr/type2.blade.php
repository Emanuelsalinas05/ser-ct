<div class="row">
        <div class="col-sm">
            <x-adminlte-callout theme="info" 
                                icon="far fa-address-book"
                                class="text-info"
                                title="DATOS DEL SERVIDOR PÚBLICO">
                    <i class="text-info"><b>RFC:</b></i>
                    <i class="text-dark">{{ $datosacta->orfc_recibe_ac }}
                    <br>
                    <i class="text-info"><b>NOMBRE:</b></i>
                    <i class="text-dark">{{ $datosacta->onombre_recibe_ac }}</i>
                    <br>
                    <i class="text-info"><b>CENTRO DE TRABAJO:</b></i>
                    <i class="text-dark">{{ $datosacta->oct_ac.' - '.$datosacta->onombre_ct_ac }}</i>
                    <br>
                    <i class="text-info"><b>UNIDAD ADMINISTRATIVA:</b></i>
                    <i class="text-dark">{{ $datosacta->nivelx }}</i>
                    &nbsp;&nbsp;
            </x-adminlte-callout>
        </div>
  
        <div class="col-sm">
            <x-adminlte-callout theme="info" 
                                icon="far fa-file-alt"
                                class="text-info"
                                title="DATOS DE LA ENTREGA RECEPCIÓN">
                    <i class="text-info"><b>TIPO:</b></i>
                    <i class="text-dark">{{ $datosacta->tipoacta->otipoacta }}</i>
                    <br><br>
                    <i class="text-info"><b>RECIBE:</b></i>
                    <i class="text-dark">{{ $datosacta->onombre_recibe_ac }}</i>
                    <br>
                    @if($datosacta->oconcluida==1)
                        <i class="text-info"><b>FECHA Y HORA INICIO:</b></i>
                        <i class="text-dark">
                            {{ $datosacta->ofecha_inicio_ac }}&nbsp;&nbsp;
                            {{ $datosacta->ohora_inicio_ac }}hrs.
                        </i>
                        <br>
                        <i class="text-info"><b>FECHA Y HORA FIN:</b></i>
                        {{ $datosacta->ofecha_fin_ac }}&nbsp;&nbsp;
                        {{ $datosacta->ohora_fin_ac }}hrs.
                    @else
                        <i class="text-warning">
                            <b>ACTA EN PROCESO (NO SE HA CONCLUIDO) </b>
                        </i>
                    @endif
                    <br>
                    &nbsp;
            </x-adminlte-callout>
        </div>
</div>