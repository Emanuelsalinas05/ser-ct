<x-adminlte-modal id="modaldedit{{ $finId }}" title="INFORMACIÓN SOBRE EL PERIODO"
                  size="lg" theme="info" icon="fa fa-info-circle" v-centered static-backdrop>
    <form id="FrmCartelCancel_{{ $finId }}" method="post"
          action="{{ route('reportes-intervencion.update', Auth::user()->id_ct) }}">
        @method('PATCH') @csrf
        <input type="hidden" name="action" value="99">
        <input type="hidden" name="fecfin" value="{{ $i->ofechafin }}">

        <h3>El período con fecha <b>{{ $i->fechaentrega }}</b> se mantiene finalizado.</h3>
        <p>Para iniciar un nuevo proceso de entrega-recepción, se debe solicitar una nueva intervención.</p>

        <button type="submit" class="btn btn-outline-info btn-sm">
            ENTENDIDO
        </button>
    </form>

    <x-slot name="footerSlot">
        <x-adminlte-button type="button"
                           data-bs-dismiss="modal" data-dismiss="modal"
                           theme="secondary" label="CERRAR"
                           class="btn-sm"/>
    </x-slot>
</x-adminlte-modal>
