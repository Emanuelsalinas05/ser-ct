<div>
@if($ban==0)



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
