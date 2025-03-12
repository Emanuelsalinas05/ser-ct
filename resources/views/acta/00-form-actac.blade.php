<x-adminlte-callout>
<form   name="FrmCartel" id="FrmCartel" method="post" 
        action="{{ route('entrega-recepcion.update', 2 ) }}" >
    @method('PATCH')
    @csrf
    <input  type="hidden" 
            name="idacta" 
            id="idacta" 
            value="{{ $datosacta->id }}">

    <input  type="hidden" 
            name="action" 
            id="action" 
            value="1">

<table 	class="table table-sm" 
		style="font-size: 14px;">
	<thead>
		<tr>
			<th class="text-warning" colspan="4">
				<h5><b>VERIFICA QUE LOS DATOS ESTEN CORRECTOS, YA QUE ESTOS DATOS SERÁN PARA EL ACTA A REALIZAR</b></h5>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="2"><b>DATOS DEL SERVIDOR PÚBLICO DESIGNADO A RECIBIR</b></td>
		</tr>
		<tr>
			<td align="right" width="30%">NOMBRE COMPLETO:</td>
			<td>
				<input 	type="text" name="onombre_recibe_ac" id="onombre_recibe_ac"
						required 
						onblur="checaNombre()" 
						class="form-control form-control-sm" >
			</td>
		</tr>
		<tr>
			<td align="right" width="30%">RFC:</td>
			<td>
				<input 	type="text" name="orfc_recibe_ac" id="orfc_recibe_ac"
						required maxlength="14" 
						onblur="checaRfc()" 
						class="form-control form-control-sm">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<button class="btn btn-success btn-sm">
					GUARDAR Y CONTINUAR 
					<i class="fa fa-check"></i>
				</button>
			</td>
		</tr>

				<script type="text/javascript">

				function checaNombre(){
					 Swal.fire('Atención!', 'Verifica que tus datos estén correctos', 'info');
				}

				function checaRfc(){
					 Swal.fire('Atención!', 'Verifica que tus datos estén correctos', 'info');
				}
</script>

	</tbody>
</table>
</form>
</x-adminlte-callout>