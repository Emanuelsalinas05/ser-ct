<x-adminlte-modal id="modaldedit{{ $finId }}" title="QUITAR ESTE PERIODO Y VOLVER A REGISTROS"
                  size="lg" theme="info" icon="fa fa-file-alt" v-centered static-backdrop>
    <form id="FrmCartelCancel_{{ $finId }}" method="post"
          action="{{ route('reportes-intervencion.update', Auth::user()->id_ct) }}">
        @method('PATCH') @csrf
        <input type="hidden" name="action" value="99">
        <input type="hidden" name="fecfin" value="{{ $i->ofechafin }}">

        <h3>¿DESEAS QUITAR EL PERIODO CON FECHA <b>{{ $i->fechaentrega }}</b>?</h3>

        <button type="submit" class="btn btn-outline-success btn-sm">
            SI, CANCELAR ESTA FECHA
        </button>
    </form>

    <x-slot name="footerSlot">
        <x-adminlte-button type="button"
                           data-bs-dismiss="modal" data-dismiss="modal"
                           theme="secondary" label="CANCELAR ACCIÓN"
                           class="btn-sm"/>
    </x-slot>
</x-adminlte-modal>
