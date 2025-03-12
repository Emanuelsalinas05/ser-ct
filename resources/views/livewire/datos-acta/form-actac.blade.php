<x-adminlte-callout>
<form wire:submit.prevent="saveDatos({{$datosacta->id}}, 2)" name="FormLaborales">
<table 	class="table table-sm" 
		style="font-size: 14px;">
	<tbody>
		<tr>
			<td colspan="2"><b>DATOS DEL SERVIDOR PÚBLICO DESIGNADO A RECIBIR</b></td>
		</tr>
		<tr>
			<td align="right" width="30%">NOMBRE COMPLETO:</td>
			<td>
				<input 	type="text" name="onombre_recibe_ac"
						wire:model="onombre_recibe_ac"
						required 
						class="form-control form-control-sm">
			</td>
		</tr>
		<tr>
			<td align="right" width="30%">RFC:</td>
			<td>
				<input 	type="text" name="orfc_recibe_ac"
						wire:model="orfc_recibe_ac"
						required maxlength="14" 
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
	</tbody>
</table>
</form>
</x-adminlte-callout>