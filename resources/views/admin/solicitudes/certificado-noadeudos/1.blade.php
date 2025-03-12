<tr class="bg-lightblue">
	<td align="center"
		colspan="4">
		<b> </b>
	</td>
</tr>
<tr>
	<td align="right"
		class="text-info">
		<b>COLOCAR LA FECHA DEL OFICIO:</i>
	</td>
	<td width="5%">
		<input 	type="date" 
				name="ofechax" id="ofechax"
				class="form-control form-control-sm"
				value="{{ old('ofechax') }}">
		@error('ofechax') <span style="color:red;">{{ $message }}</span> @enderror
	</td>
	<td width="5%">
	</td>
	<td></td>
</tr>

<tr class="bg-lightblue">
	<td align="center"
		colspan="4">
		<b> </b>
	</td>
</tr>
<tr>
	<td align="right"
		class="text-info">
		<b>COLOCA EL NÚMERO DE TÚ OFICIO</b>
	</td>
	<td colspan="2">
		<input 	type="text" 
				name="onumero_oficio" id="onumero_oficio"
				class="form-control form-control-sm"
				value="{{ old('onumero_oficio') }}">
		@error('onumero_oficio') <span style="color:red;">{{ $message }}</span> @enderror
	</td>
	<td></td>
</tr>


<tr class="bg-lightblue">
	<td align="center"
		colspan="4">
		<b> </b>
	</td>
</tr>
<tr>
	<td align="right"
		class="text-info" width="40%">
		<b>LOCALIDAD</b>
	</td>
	<td  width="60%" colspan="3">
		<input 	type="text" 
				name="olocalidad" id="olocalidad"
				class="form-control form-control-sm"
				value="{{ old('olocalidad') }}"
				onkeyup="javascript:this.value=this.value.toLowerCase();">
		@error('olocalidad') <span style="color:red;">{{ $message }}</span> @enderror
	</td>
</tr>
<tr>
	<td align="right"
		class="text-info">
		<b>MUNICIPIO</b>
	</td>
	<td colspan="3">
		<input 	type="text" 
				name="omunicipio" id="omunicipio"
				class="form-control form-control-sm"
				value="{{ old('omunicipio') }}"
				onkeyup="javascript:this.value=this.value.toLowerCase();">
		@error('omunicipio') <span style="color:red;">{{ $message }}</span> @enderror
	</td>
</tr>
<!--
<tr class="bg-lightblue">
	<td align="center"
		colspan="4">
		<b> TITULAR DE LA COORDINACIÓN DE ADMINISTRACIÓN Y FINANZAS</b>
	</td>
</tr>
<tr>
	<td align="right"
		class="text-info">
		<b>TÍTULO Y NOMBRE </b>
	</td>
	<td colspan="3">
		<input 	type="text" 
				name="otitular_caf" id="otitular_caf"
				class="form-control form-control-sm"
				value="{{ old('otitular_caf') }}"
				placeholder="Ejemplo:    Lic. Nombre(s)   Apellido   Apellido">
		@error('otitular_caf') <span style="color:red;">{{ $message }}</span> @enderror
	</td>
</tr>
-->
<tr class="bg-lightblue">
	<td align="center"
		colspan="4">
		<b> </b>
	</td>
</tr>
<tr>
	<td align="right"
		class="text-info">
		<b>COLOCAR LA FECHA Y HORA EN QUE SE REALIZARÁ LA ENTREGA RECEPCIÓN DEL CENTRO DE TRABAJO</b>
		<br>
		<i>**MISMA FECHA Y HORA EXPRESADAS EN LA ACTA</i>
	</td>
	<td width="5%">
		<input 	type="date" 
				name="ofecha" id="ofecha"
				class="form-control form-control-sm"
				value="{{ old('ofecha') }}">
		@error('ofecha') <span style="color:red;">{{ $message }}</span> @enderror
	</td>
	<td width="5%">
		<input 	type="time" 
				name="ohora" id="ohora"
				class="form-control form-control-sm"
				value="{{ old('ohora') }}">
		@error('ohora') <span style="color:red;">{{ $message }}</span> @enderror
	</td>
	<td></td>
</tr>
