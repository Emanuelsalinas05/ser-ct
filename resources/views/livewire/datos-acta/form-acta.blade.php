<x-adminlte-callout>
<form wire:submit.prevent="saveDatos({{$datosacta->id}}, 1)" name="FormLaborales">
<table 	class="table table-sm" 
		style="font-size: 14px;">
	<tbody>
		<tr>
			<td colspan="4"><b>DATOS DEL SERVIDOR PÚBLICO QUE ENTREGA</b></td>
		</tr>
		<tr>
			<td align="right" width="20%">NOMBRE COMPLETO:</td>
			<td width="50%">
				<input 	type="text" name="onombre_entrega_a"
						wire:model="onombre_entrega_a"
						required 
						class="form-control form-control-sm">
			</td>
			<td align="right" width="10%">RFC:</td>
			<td width="20%">
				<input 	type="text" name="orfc_entrega_a"
						wire:model="orfc_entrega_a"
						required 
						maxlength="13" 
						class="form-control form-control-sm">
			</td>
		</tr>
		<tr>
			<td align="right" width="20%">CARGO OCUPADO:</td>
			<td width="50%">
				<input 	type="text" name="ocargo_entrega_a"
						wire:model="ocargo_entrega_a"
						required 
						class="form-control form-control-sm">
			</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="4"><b>DATOS DEL SERVIDOR PÚBLICO QUE RECIBE</b></td>
		</tr>
		<tr>
			<td align="right" width="20%">NOMBRE COMPLETO:</td>
			<td width="50%">
				<input 	type="text" name="onombre_recibe_a"
						wire:model="onombre_recibe_a"
						required 
						class="form-control form-control-sm">
			</td>
			<td align="right" width="10%">RFC:</td>
			<td width="20%">
				<input 	type="text" name="orfc_recibe_a"
						wire:model="orfc_recibe_a"
						required 
						maxlength="13" 
						class="form-control form-control-sm">
			</td>
		</tr>
		<tr>
			<td align="right" width="20%">CARGO A OCUPAR:</td>
			<td width="50%">
				<input 	type="text" name="ocargo_recibe_a"
						wire:model="ocargo_recibe_a"
						required 
						class="form-control form-control-sm">
			</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="4" align="right">
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