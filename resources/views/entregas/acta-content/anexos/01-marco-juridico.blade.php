<li class=" d-flex justify-content-between align-items-center"
    style="border:none;">
    &nbsp;
    <p style="color:gray; font-size: 13px;">
        <i><b>DA CLIC EN EL SÍMBOLO DE 
        <span class="btn btn-xs bg-light" disabled><i class="fas fa-plus"></i></span> 
        PARA VER LA INFORMACIÓN COMPLETA</b></i>
    </p>
</li>


<table  class="table table-striped table-hover table-sm"
        id="example13"
        style="font-size:12px;">
    <thead class="bg-lightblue disabled" align="center">
        <tr>
            <th>PROG.</th>
            <th>DENOMINACIÓN DEL ORDENAMIENTO JURÍDICO-ADMINISTRATIVO</th>
            <th>MEDIO OFICIAL DE PUBLICACIÓN</th>
            <th>FECHA DE PUBLICACIÓN </th>
            <th>LOCALIZADOR UNIFORME<br> DE RECURSOS (URL)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($juridicos as $key => $juridico)
        <tr>
            <td width="3%" align="right">
                    {{ $key+1 }} 
            </td>
            
            <td width="42%">
                    {{ $juridico->odenominacion_juridica }}
            </td>

            <td width="20%">
                    {{ $juridico->omedio_oficial_publicacion }}
            </td>
            
            <td width="10%" align="center">
                    {{ $juridico->ofecha_publicacion }}
            </td>
            
            <td width="20%" align="center">
                    <a  href="{{ $juridico->ourl_publicacion }}" 
                        target="_blank" 
                        class="btn btn-outline-info btn-sm" 
                        title="{{ $juridico->ourl_publicacion }}"
                        style="font-size:12px;">
                        CONSULTAR
                    </a>

                    <input  type="hidden" 
                            name="txCopy{{$juridico->onprogresivo}}" 
                            id="txCopy{{$juridico->onprogresivo}}"
                            value="{{ $juridico->ourl_publicacion }}">

                    <button id="btnCopy{{$juridico->onprogresivo}}" 
                            class="btn btn-outline-info btn-sm alertCopy{{$juridico->onprogresivo}}"
                            title="Copiar URL {{ $juridico->ourl_publicacion }}">
                            <i class="fa fa-copy"></i>
                    </button>
                <script type="text/javascript">
                    document.getElementById('btnCopy{{$juridico->onprogresivo}}').addEventListener('click', copiarAlPortapapeles);
                    function copiarAlPortapapeles(ev) {
                        // Obtener contenido del div oculto
                        let contenido = document.getElementById('txCopy{{$juridico->onprogresivo}}').value;
                        // Crear input
                        let input = document.createElement('input');
                        // Asignar contenido
                        input.value = contenido;
                        // Agregar input a documento
                        document.body.appendChild(input);
                        // Seleccionar contenido
                        input.select();
                        // Copiar
                        document.execCommand('copy');
                        // Eliminar input
                        input.remove();
                    }


                    $(function () {
                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            $('.alertCopy{{$juridico->onprogresivo}}').click(function() {
                                    Swal.fire({
                                    title: "{{ $juridico->onprogresivo.'.-  '.$juridico->odenominacion_juridica }}",
                                    text:  "Se copio la URL correctamente",
                                    icon: "info"
                                });
                            });
                    });

                </script>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>