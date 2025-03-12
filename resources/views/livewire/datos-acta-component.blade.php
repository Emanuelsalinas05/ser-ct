<div>
@if($ban==0)

   <x-adminlte-callout theme="info" 
                    title="SELECCIONA EL TIPO DE ENTREGA - RECEPCIÓN A REALIZAR"
                    class="text-info"
                    icon="fa fa-file">
        <br>
        <div class="container">
                <div class="row text-center">
                    @foreach($tipoacta as $acta)
                    <div class="col-sm">
                        <button class="btn btn-outline-success btn-sm btn-block shadow"
                                wire:click="tipoActas({{ $acta->id }})">
                            <b>{{ $acta->otipoacta }}</b> {{ $acta->id }}
                        </button>
                    </div>
                    @endforeach
                </div>
        </div>
</x-adminlte-callout>

@elseif($ban==1)
    

    @if($datosacta->ock==0)
        <p class="text-info">
            INGRESA LOS SIGUIENTES DATOS PARA COMENZAR CON EL REGISTRO DEL {{ $datosacta->tipoacta->otipoacta }}
        </p>
        @if($datosacta->id_tipoacta==1)
            @include('livewire.datos-acta.form-acta')
        @elseif($datosacta->id_tipoacta==2)
            @include('livewire.datos-acta.form-actac')
        @endif
    @else

        @include('livewire.datos-acta.registro.avances')
        
    @endif

@endif        
</div>
