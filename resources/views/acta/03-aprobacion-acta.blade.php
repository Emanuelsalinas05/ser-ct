
@if($avance->oestado==0)

        <a  href="{{ route('datos-acta.edit', $datosacta->id) }}"
            class="text-warning btn btn-light btn-block"
            style="text-decoration: none;  text-align: left;">
            <i class="fa fa-edit" style="font-size:18px;"></i>
            <b>REGISTRA AQUÍ LOS DATOS PARA EL {{ $datosacta->tipoacta->otipoacta }} </b> &nbsp;
            <i class="fas fa-mouse-pointer"></i>
        </a>

@elseif($avance->oestado==1)

        @if($avance->ocheckacta==1)

                @if($avance->ocargaacta==0)

                        @include('acta.04-form-carga-acta')

                @elseif($avance->ocargaacta==1)

                        <li class=" d-flex align-items-center"
                            style="border:none;"><!--justify-content-between  -->

                                <span  class="text-info" >
                                    <i class="fa fa-file" style="font-size:18px;"></i>&nbsp;
                                    <b> {{ $datosacta->tipoacta->otipoacta }}</b>  (FIRMADA Y ESCANEADA)
                                </span>
                                &nbsp;&nbsp;&nbsp;
                                <a  href="storage/{{ $datosacta->ourl_acta }}"
                                    target="_blank" 
                                    class="btn btn-outline-success btn-sm "
                                    title="{{ $datosacta->tipoacta->otipoacta }} FIRMADA Y ESCANEADA" 
                                    style="text-decoration: none; font-size:14px;">
                                    <b>VER DOCUMENTO  &nbsp;&nbsp;</b>
                                    <i class="fa fa-file-alt" style="font-size:16px;"></i>
                                </a>

                        </li>

                        @include('acta.06-envio-acta')

                @endif

        @elseif($avance->ocheckacta==0)
                <div class="bg-warning" style="font-size:18px;">
                	<b><center>ESPERA LA APROBACIÓN PARA PODER SUBIR EL ACTA ESCANEADA Y FIRMADA</center></b>
                </div>
        @endif

@endif
