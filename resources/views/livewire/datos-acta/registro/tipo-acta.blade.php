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
                                wire:click="tipoActa({{ $acta->id }})">
                            <b>{{ $acta->otipoacta }}</b>
                        </button>
                    </div>
                    @endforeach
                </div>
        </div>
</x-adminlte-callout>