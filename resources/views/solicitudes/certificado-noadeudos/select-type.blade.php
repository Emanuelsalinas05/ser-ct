<i>SELECCIONA EL TIPO DE CERTIFICADO DE NO ADEUDO QUE DESEAS GESTIONAR </i>
<br>
<br>

<x-adminlte-callout>
    <div class="container">
        <div class="row text-center">
            @foreach($tipocert as $key => $tipoc)
            <div class="col-sm">   

                <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('solicitud-certificado.store') }}" >
                        @method('POST')
                        @csrf

                        <input  type="hidden" 
                                name="acta" 
                                id="acta"
                                value="{{ $datosacta->id }}">

                        <input  type="hidden" 
                                name="action" 
                                id="action"
                                value="3">

                        <input  type="hidden" 
                                name="tipocert" 
                                id="tipocert"
                                value="{{ $tipoc->oorden }}">
                        
                        <button class="btn btn-outline-info btn-sm btn-block"
                                title="{{ $tipoc->id.'. '.$tipoc->otipo }}">
                            <b>{{ $tipoc->otipo }}</b>
                        </button>   
                </form>                 
                                     
            </div>
            @endforeach
        </div>
    </div>
</x-adminlte-callout>