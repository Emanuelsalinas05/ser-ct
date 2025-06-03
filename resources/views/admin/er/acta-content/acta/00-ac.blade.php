<table  class="table table-sm table-hover"
        style="font-size:14px;">
<tbody>
    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>OTROS HECHOS</b>:</td>
    </tr>
    <tr>
        <td style="text-align: justify;" colspan="8">
            <b>LA RAZÓN POR LA CUAL SE LEVANTA EL ACTA Y LA DESCRIPCIÓN GENERAL DE CÓMO SE RECIBE EL CENTRO DE TRABAJO EN RELACIÓN A LOS DOCUMENTOS QUE SE MENCIONAN EN EL ACTA DE ENTREGA Y RECEPCIÓN.</b>
            <br>
            {{$datosacta->ohechos_ac}}

        </td>
    </tr>
    <tr>
        <td align="right" colspan="2">
            <b>* HORA DE INICIO</b>:
        </td>
        <td>
            {{$datosacta->ohora_inicio_ac}}
        </td>

        <td align="right" colspan="2">
            <b>* FECHA DE INICIO</b>:
        </td>
        <td>
            {{$datosacta->ofecha_inicio_ac}}
        </td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td align="right" colspan="2">
            <b>CIUDAD</b>
        </td>
        <td colspan="4" width="45%">
            {{$datosacta->olugar_ac}} 
        </td>
        <td colspan="2" width="30%">(LUGAR DONDE SE LLEVA A CABO)</td>
    </tr>
    <tr>
        <td align="right"><b>* DOMICILIO</b>:</td>
        <td colspan="5">
            {{$datosacta->odomicilio_ct_ac}} 
        </td>
        <td align="right"><b>* TEL.</b>:</td>
        <td>
            {{$datosacta->otelefono_ct_ac}} 
        </td>
    </tr>
    <tr>
        <td align="right"><b>C.T.</b></td>
        <td>
            {{$datosacta->datosacta}} 
        </td>
        <td align="right" colspan="2"><b>NOMBRE DEL C.T.</b></td>
        <td colspan="4">
            {{$datosacta->onombre_ct_ac}} 
        </td>
    </tr>
    <tr>
        <td align="right" colspan="3">
            <b>* DIRECCIÓN/SUBDIRECCIÓN/DEPARTAMENTO</b>
            <br>AL QUE PERTENECE
        </td>
        <td colspan="5">
            {{$datosacta->odepartamento_ac}} 
        </td>
    </tr>


    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>SERVIDOR PÚBLICO QUE RECIBE</b></td>
    </tr>
    <tr>
        <td  align="right"><b>NOBRE</b>:</td>
        <td colspan="2">
            {{$datosacta->onombre_recibe_ac}} 
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            {{$datosacta->orfc_recibe_ac}} 
        </td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
        <td>
            {{$datosacta->oidentificacion_recibe_ac}} : {{$datosacta->onumero_identificacion_recibe_ac}}
        </td>
        
        <td colspan="2" align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="3">
            <a  href="../../storage/{{$datosacta->oidentificacion_url_recibe_ac}}"
                class="btn btn-outline-secondary btn-xs"
                target="_blank"
                style="text-decoration:none;">
                VER {{$datosacta->oidentificacion_recibe_ac}} 
            </a>
        </td>
    </tr>
    <tr>
        <td style="text-align: justify; " colspan="8">
            <b>OBSERVACIONES QUE SEÑALE LA PERSONA SERVIDORA PÚBLICA DESIGNADA PARA RECIBIR.</b> 
            <br>
            {{$datosacta->omanifestacion_recibe_ac}} 
        </td>
    </tr>



    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>REPRESENTANTE DEL ÓRGANO INTERNO DE CONTROL</b></td>
    </tr>
    <tr>
        <td  align="right"><b>NOBRE</b>:</td>
        <td colspan="4">
            {{$datosacta->orepresentante_contraloria_ac}} 
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            {{$datosacta->orfc_orepresentante_contraloria_ac}} 
        </td>
        <td></td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
        <td>
            {{$datosacta->oidentificacion_representante_ac}} : {{$datosacta->onumero_identificacion_representante_ac}}
        </td>
        
        <td colspan="2" align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="3">
            <a  href="../../storage/{{$datosacta->oidentificacion_representante_url_ac}}"
                class="btn btn-outline-secondary btn-xs"
                target="_blank"
                style="text-decoration:none;">
                VER {{$datosacta->oidentificacion_representante_ac}} 
            </a>
        </td>
    </tr>
    <tr>
        <td style="text-align: justify;" colspan="8">
            <b>OBSERVACIONES QUE SEÑALEN LOS REPRESENTANTES DE LA AUTORIDAD INMEDIATA SUPERIOR, DEL ÓRGANO INTERNO DE CONTROL Y TESTIGO. </b>
            <br>
            {{$datosacta->omanifiestan_representante_organo_ac}} 
        </td>
    </tr>



    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>DATOS DEL PRIMER TESTIGO</b></td>
    </tr>
    <tr>
        <td  align="right"><b>NOBRE</b>:</td>
        <td colspan="4">
            {{$datosacta->onombre_testigo1_ac}} 
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            {{$datosacta->orfc_testigo1_ac}} 
        </td>
        <td></td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
        <td>
            {{$datosacta->oidentificacion_testigo1_ac}} : {{$datosacta->onumero_identificacion_testigo1_ac}}
        </td>
        
        <td colspan="2" align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="3">
            <a  href="../../storage/{{$datosacta->oidentificacion_testigo1_url_ac}}"
                class="btn btn-outline-secondary btn-xs"
                target="_blank"
                style="text-decoration:none;">
                VER {{$datosacta->oidentificacion_testigo1_ac}} 
            </a>
        </td>
    </tr>
    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>DATOS DEL SEGUNDO TESTIGO</b></td>
    </tr>
    <tr>
        <td  align="right"><b>NOBRE</b>:</td>
        <td colspan="4">
            {{$datosacta->onombre_testigo2_ac}} 
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            {{$datosacta->orfc_testigo2_ac}} 
        </td>
        <td></td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
        <td>
            {{$datosacta->oidentificacion_testigo2_ac}}  : {{$datosacta->onumero_identificacion_testigo2_ac}}
        </td>
        
        <td colspan="2" align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="3">
            <a  href="../../storage/{{$datosacta->oidentificacion_testigo2_url_ac}}"
                class="btn btn-outline-secondary btn-xs"
                target="_blank"
                style="text-decoration:none;">
                VER {{$datosacta->oidentificacion_testigo2_ac}} 
            </a>             
        </td>
    </tr>
    <tr>
        <td colspan="3"  align="right">
            <b>HORA Y FECHA DE FINALIZACIÓN DEL ACTA</b>
        </td>
        <td align="right">
            <b>* HORA </b>:
        </td>
        <td>
            {{$datosacta->ohora_fin_ac}} 
        </td>

        <td align="right">
            <b>* FECHA </b>:
        </td>
        <td>
            {{$datosacta->ofecha_fin_ac}} 
        </td>
        <td></td>
    </tr>
</tbody>
</table>
