
@if($datosacta->ocheckactaa==1&&$datosacta->oenviocorreooic==0)
<table class="table table-sm">
	@if($datosacta->oenviocorreooic==0)
	<tr class="bg-lightblue disabled">
		<td colspan="2" align="center">
			<b style="font-size:16px;">
				PARA FINALIZAR LA ENTREGA-RECEPCIÓN Y NOTIFICAR AL ÓRGANO INTERNO DE CONTROL, HAZ LO SIGUIENTE:
			</b>
		</td>
	</tr>
	@endif
@endif

@if($datosacta->carpetacorreo==0)

<form   name="FrmCartel" id="FrmCartel" method="post" 
        action="{{ route('entrega-recepcion.update', $datosacta->id ) }}" 
        enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input  type="hidden" 
            name="idacta" 
            id="idacta" 
            value="{{ $datosacta->id }}">

    <input  type="hidden" 
            name="action" 
            id="action" 
            value="50">
	<tr>
		<td colspan="2" class="text-secondary">
			GUARDAR LOS ARCHIVOS DE TODOS LOS ANEXOS Y ACTA ESCANEADA EN UNA CARPETA COMPRIMIDA DE ARCHIVOS DE ESTA: 
			<b> {{ $datosacta->tipoacta->otipoacta }}</b>.
		</td>
	</tr>
	<tr>
		<td width="50%"
			align="right">
			<b><i class="fas fa-file-archive" style="font-size:18px;"></i></b>&nbsp;
			ARCHIVO COMPRIMIDO (SOLO EXTENSIÓN .rar o .zip) :
		</td>
		<td>
			<input 	type="file" name="onombre_archivo" id="onombre_archivo"
					accept=".zip, .rar,"
					class="form-control form-control-sm">
		</td>
	</tr>
	<tr>
		<td colspan="2"
			align="right">
			<button class="btn btn-success btn-sm">
				CARGAR ARCHIVO
				&nbsp;
				<i class="fas fa-file-upload" style="font-size:18px;"></i>
			</button>
		</td>
	</tr>
</form> 
@elseif($datosacta->carpetacorreo==1) 
<form   name="FrmCartel" id="FrmCartel" method="post" 
        action="{{ route('entrega-recepcion.update', $datosacta->id ) }}"  >
    @method('PATCH')
    @csrf
    <input  type="hidden" 
            name="idacta" 
            id="idacta" 
            value="{{ $datosacta->id }}">

    <input  type="hidden" 
            name="action" 
            id="action" 
            value="60">
	<tr>
		<td colspan="2" class="text-secondary">
			A CONTINUACÍON SE ENVÍARÁ CORREO AL ÓRGANO INTERNO DE CONTROL QUIEN RECIBIRÁ EL CONTENIDO DE 
			LA <b> {{ $datosacta->tipoacta->otipoacta }}</b> REALIZADA	. <br>
			POR LO QUE DEBERÁS ESCRIBIR TÚ CORREO AL CUAL SE TE MARCARÁ COPIA. 
		</td>
	</tr>
	<tr>
		<td width="50%"
			align="right">
			ESCRIBE TU CORREO ELECTRÓNICO
		</td>
		<td>
			<input 	type="email" name="correocopia" id="correocopia"
					required 
					class="form-control form-control-sm">
		</td>
	</tr>
	<tr>
		<td width="50%"
			align="right">
			CONFIRMA TU CORREO ELECTRÓNICO
		</td>
		<td>
			<input 	type="email" name="correocopia2" id="correocopia2"
					required onblur="comprobarClave()"
					class="form-control form-control-sm">
		</td>
	</tr>
		<script type="text/javascript">
	            function comprobarClave() {
	                var clave1 = $('#correocopia').val();
	                var clave2 = $('#correocopia2').val();

	                
	                if (clave1 == '') {
	                    Swal.fire('aviso!', 'Ingresa un correo', 'warning');
	                }else if (clave1 != clave2) {
	                    Swal.fire('aviso!', 'Los correos no coinciden', 'warning');
	                }else if (clave1 == clave2 && clave1!='' && clave2!='' ){
	                    Swal.fire('Correcto!', 'Los correos coinciden', 'info')
	                }
	            }
        </script>

	
	<tr>
		<td colspan="2"
			align="right"
			style="font-size:16px;">
			<b class="text-danger">
				DA CLIC UNA SOLA VEZ EN EL BOTÓN "ENVIAR CORREO", ES NORMAL QUE TARDE UNOS SEGUNDOS.
			</b>
		</td>
	</tr>
	<tr>
		<td colspan="2"
			align="right">
			<button class="btn btn-success btn-sm">
				ENVIAR CORREO AL ÓRGANO INTERNO DE CONTROL
				&nbsp;
				<i class="fas fa-mail-bulk" style="font-size:18px;"></i>
			</button>
		</td>
	</tr>

</form>


@elseif($datosacta->carpetacorreo==2)

	<tr>
		<td colspan="2" 
			align="center">
			<b 	class="text-success"
				style="font-size:20px;">
				<i class="fas fa-mail-bulk" ></i>
				&nbsp;
				SE HA ENVIADO EL {{ $datosacta->tipoacta->otipoacta }} Y SUS ANEXOS AL OIC. 
				SE HA CONCLUIDO EXITOSAMENTE EL ACTO DE ENTREGA Y RECEPCIÓN 
<!--
				SE HA NOTIFICADO AL OIC. 
				, FAVOR DE ESPERA LA FINALIZACIÓN PARA CONCLUIR EL PROCESO DE ENTREGA - RECEPCIÓN
			-->
			</b>&nbsp;&nbsp;

		</td>
	</tr>

	@if(Auth::user()->onivel=='ELEMENTAL')

			@php( include 'send-mails/index.php' )

	@elseif(Auth::user()->onivel=='SECUNDARIA')

			@php( include 'send-mails/secundarias/index.php' )

	@endif

@endif

</table>


