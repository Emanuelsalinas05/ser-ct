<tr class="bg-lightblue">
	<td align="center"
		colspan="4">
		<b> </b>
	</td>
</tr>
<tr>
	<td align="right"
		class="text-info">
		<b>COLOCA LA FECHA DEL OFICIO:</i>
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
		<b>COLOCA EL NÚMERO DE TU OFICIO</b>
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
		class="text-info">
		LOCALIDAD
	</td>
	<td colspan="3">
		<input 	type="text"
				  name="olocalidad" id="olocalidad"
				  class="form-control form-control-sm"
				  value="{{ old('olocalidad') }}" >
		@error('olocalidad') <span style="color:red;">{{ $message }}</span> @enderror
	</td>
</tr>
<tr>
	<td align="right"
		class="text-info">
		MUNICIPIO
	</td>
	<td colspan="3">
		<input 	type="text"
				  name="omunicipio" id="omunicipio"
				  class="form-control form-control-sm"
				  value="{{ old('omunicipio') }}" >
		@error('omunicipio') <span style="color:red;">{{ $message }}</span> @enderror
	</td>
</tr>
<tr class="bg-lightblue">
	<td align="center"
		colspan="4">
		<b>DATOS DE LA AUTORIDAD INMEDIATA SUPERIOR </b>
	</td>
</tr>
<tr>
	<td align="right"
		class="text-info">
		NOMBRE COMPLETO DE TU AUTORIDAD INMEDIATA SUPERIOR
	</td>
	<td colspan="3">
		<input 	type="text"
				  name="onombre_autoridadinmediata" id="onombre_autoridadinmediata"
				  class="form-control form-control-sm"
				  value="{{ old('otitular_caf') }}">
		@error('onombre_autoridadinmediata') <span style="color:red;">{{ $message }}</span> @enderror
	</td>
</tr>
<tr>
	<td align="right"
		class="text-info">
		ESCRIBE EL <b>CARGO</b> DE TU AUTORIDAD INMEDIATA SUPERIOR
	</td>
	<td colspan="3">
		<input 	type="text"
				  name="ocargo_autoridadinmediata" id="ocargo_autoridadinmediata"
				  class="form-control form-control-sm"
				  value="{{ old('ocargo_autoridadinmediata') }}">
		@error('ocargo_autoridadinmediata') <span style="color:red;">{{ $message }}</span> @enderror
	</td>
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
		<b>COLOCAR LA FECHA Y HORA EN QUE SE REALIZARÁ LA ENTREGA RECEPCIÓN DEL CENTRO DE TRABAJO</b>
		<br>
		<b>MISMA FECHA Y HORA EXPRESADAS EN EL ACTA</b>
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

