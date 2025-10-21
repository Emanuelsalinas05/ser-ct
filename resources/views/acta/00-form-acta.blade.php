<x-adminlte-callout>
<form   name="FrmCartel" id="FrmCartel" method="post" 
        action="{{ route('entrega-recepcion.update', 1 ) }}" >
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
				<h5><b>VERIFICAR QUE LA INFORMACIÓN ESTÉ CORRECTA, YA QUE ÉSTA SERÁ PARA EL ACTA A REALIZAR. (DEBERÁ REGISTRAR CON MAYÚSCULAS Y ACENTOS).</b></h5>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="4">
				<b>DATOS DEL SERVIDOR PÚBLICO QUE ENTREGA</b>
			</td>
		</tr>
		<tr>
			<td align="right" width="20%">NOMBRE COMPLETO:</td>
			<td width="50%">
				<input 	type="text" name="onombre_entrega_a"
						required 
						onblur="checaNombre()" 

						class="form-control form-control-sm" >
			</td>
			<td align="right" width="10%">RFC:</td>
			<td width="20%">
				<input 	type="text" name="orfc_entrega_a"
						required 
						maxlength="13" 
						onblur="checaRfc()" 
						class="form-control form-control-sm">
			</td>
		</tr>
		<tr>
			<td align="right" width="20%">CARGO OCUPADO:</td>
			<td width="50%">
				<input 	type="text" name="ocargo_entrega_a"
						required 
						class="form-control form-control-sm" >
			</td>
			<td colspan="2"></td>
		</tr>

		<script type="text/javascript">

				function checaNombre(){
					 Swal.fire('Atención!', 'Verifica que tus datos estén correctos', 'info');
				}

				function checaRfc(){
					 Swal.fire('Atención!', 'Verifica que tus datos estén correctos', 'info');
				}

        </script>

		<tr>
			<td colspan="4">
				<b>DATOS DEL SERVIDOR PÚBLICO QUE RECIBE</b>
			</td>
		</tr>
		<tr>
			<td align="right" width="20%">NOMBRE COMPLETO:</td>
			<td width="50%">
				<input 	type="text" name="onombre_recibe_a"
						required 
						class="form-control form-control-sm" >
			</td>
			<td align="right" width="10%">RFC:</td>
			<td width="20%">
				<input 	type="text" name="orfc_recibe_a"
						required 
						maxlength="13" 
						class="form-control form-control-sm">
			</td>
		</tr>
		<tr>
			<td align="right" width="20%">CARGO A OCUPAR:</td>
			<td width="50%">
				<input 	type="text" name="ocargo_recibe_a"
						required 
						class="form-control form-control-sm" >
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