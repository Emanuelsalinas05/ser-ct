<div class="row">
        <div class="col-sm">
            <x-adminlte-callout theme="info" 
                                icon="far fa-address-book"
                                class="text-info"
                                title="DATOS DEL SERVIDOR PÚBLICO SALIENTE">
                    <i class="text-info"><b>RFC:</b></i>
                    <i class="text-dark">{{ $datosacta->orfc_entrega_a }}</i>
                    <br>
                    <i class="text-info"><b>NOMBRE:</b></i>
                    <i class="text-dark">{{ $datosacta->onombre_entrega_a }}</i>
                    <br>
                    <i class="text-info"><b>CARGO:</b></i>
                    <i class="text-dark">{{ $datosacta->ocargo_entrega_a }}</i>
                    <br>
                    <i class="text-info"><b>CENTRO DE TRABAJO:</b></i>
                    <i class="text-dark">{{ $datosacta->oct_a.' - '.$datosacta->onombre_ct_a }} </i>
                    <br>
                    <i class="text-info"><b>UNIDAD ADMINISTRATIVA:</b></i>
                    <i class="text-dark">{{ $datosacta->nivel }}</i>
                    &nbsp;&nbsp;&nbsp;
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
                    <i class="text-info"><b>ENTREGA:</b></i>
                    <i class="text-dark">{{ $datosacta->onombre_entrega_a }}</i>
                    <br>
                    <i class="text-info"><b>RECIBE:</b></i>
                    <i class="text-dark">{{ $datosacta->onombre_recibe_a }}</i>
                    <br>
                    @if($datosacta->oconcluida==1)
                        <i class="text-info"><b>FECHA Y HORA:</b></i>
                        <i class="text-dark">{{ $datosacta->ofecha_inicio_a }}&nbsp;&nbsp;
                        {{ $datosacta->ohora_inicio_a }}hrs.</i>
                    @else
                        <i class="text-warning">
                            <b>ACTA EN PROCESO - NO SE HA CONCLUIDO </b>
                        </i>
                    @endif
            </x-adminlte-callout>
        </div>
</div>


