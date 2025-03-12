<table  class="table table-sm table-hover"
        style="font-size:14px;">
<tbody>
    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>LUGAR Y FECHA</b></td>
    </tr>
    <tr>
        <td align="right"><b>C.T.</b></td>
        <td>
            {{$datosacta->oct_a}}
        </td>

        <td align="right"><b>NOMBRE DEL C.T.</b></td>
        <td colspan="5">
            {{$datosacta->onombre_ct_a}}
        </td>
    </tr>
    <tr>
        <td align="right"><b>* LUGAR</b></td>
        <td colspan="3" width="40%">
        	{{$datosacta->olugar_a}}
        </td>

        <td align="right"><b>* HORA</b></td>
        <td>
        	{{$datosacta->ohora_inicio_a}}
        </td>
        
        <td align="right"><b>* FECHA</b></td>
        <td>
        	{{$datosacta->ofecha_inicio_a}}
        </td>
    </tr>
    <tr>
        <td align="right"><b>* DOMICILIO</b></td>
        <td colspan="5">
        	{{$datosacta->odomicilio_ct_a}} 
        </td>

        <td colspan="2"></td>
    </tr>
    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>SERVIDOR PÚBLICO QUE ENTREGA</b></td>
    </tr>
    <tr>
        <td align="right"><b>NOBRE</b>:</td>
        <td colspan="2">
            {{$datosacta->onombre_entrega_a}}
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            {{$datosacta->orfc_entrega_a}}
        </td>
        
        <td align="right"><b>CARGO</b>:</td>
        <td colspan="2">
            {{$datosacta->ocargo_entrega_a}}
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
        	{{$datosacta->oidentificacion_entrega_a}} : {{$datosacta->onumero_identificacion_entrega_a}}
        </td>
        
        <td colspan="2" align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="3">
            <a  href="../../storage/{{$datosacta->oidentificacion_url_entrega_a}}"
                class="btn btn-outline-secondary btn-xs"
                target="_blank"
                style="text-decoration:none;">
                VER {{$datosacta->oidentificacion_entrega_a}} 
            </a>
        </td>
    </tr>
    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>SERVIDOR PÚBLICO QUE RECIBE</b></td>
    </tr>
    <tr>
        <td  align="right"><b>NOBRE</b>:</td>
        <td colspan="2">
            {{$datosacta->onombre_recibe_a}}
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            {{$datosacta->orfc_recibe_a}}
        </td>
        
        <td  align="right"><b>CARGO</b>:</td>
        <td colspan="2">
            {{$datosacta->ocargo_recibe_a}}
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
        	{{$datosacta->oidentificacion_recibe_a}} : {{ $datosacta->onumero_identificacion_recibe_a}}
        </td>
        
        <td colspan="2" align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="3">
            <a  href="../../storage/{{$datosacta->oidentificacion_url_recibe_a}}"
                class="btn btn-outline-secondary btn-xs"
                target="_blank"
                style="text-decoration:none;">
                VER {{$datosacta->oidentificacion_recibe_a}} 
            </a> 
        </td>
    </tr>
    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>TESTIGO 1</b></td>
    </tr>
    <tr>
        <td  align="right"><b>* NOBRE</b>:</td>
        <td colspan="2">
        	{{$datosacta->onombre_testigo_a}} 
        </td>
        <td  align="right"><b>* RFC TESTIGO 1</b>:</td>
        <td>
            {{$datosacta->orfc_testigo}} 
        </td>
        <td align="right"><b>* CARGO</b>:</td>
        <td colspan="2">
        	{{$datosacta->ocargo_testigo_a}} 
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
            {{$datosacta->oidentificacion_testigo}} : {{ $datosacta->onumero_identificacion_testigo_a}}
        </td>
        
        <td colspan="2" align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="3">
            <a  href="../../storage/{{$datosacta->oidentificacion_url_testigo}}"
                class="btn btn-outline-secondary btn-xs"
                target="_blank"
                style="text-decoration:none;">
                VER {{$datosacta->oidentificacion_testigo}} 
            </a> 
        </td>
    </tr>
    <tr>
        <td  align="right"><b>* C.T.</b>:</td>
        <td colspan="5">
        	{{$datosacta->oct_testigo_a}}  
        </td>
        <td colspan="2"></td>
        
    </tr>
    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>TESTIGO 2</b></td>
    </tr>
    <tr>
        <td  align="right"><b>* NOBRE</b>:</td>
        <td colspan="2">
        	{{$datosacta->onombre_testigo2_a}}   
        </td>
        <td align="right"><b>* RFC TESTIGO 2</b>:</td>
        <td>
            {{$datosacta->orfc_testigo2}} 
        </td>
        <td align="right"><b>* CARGO</b>:</td>
        <td colspan="2">
        	{{$datosacta->ocargo_testigo2_a}} 
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
            {{$datosacta->oidentificacion_testigo2}} : {{ $datosacta->onumero_identificacion_testigo2_a}}
        </td>
        
        <td colspan="2" align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="3">
            <a  href="../../storage/{{$datosacta->oidentificacion_url_testigo2}}"
                class="btn btn-outline-secondary btn-xs"
                target="_blank"
                style="text-decoration:none;">
                VER {{$datosacta->oidentificacion_testigo2}} 
            </a> 
        </td>
    </tr>
    <tr>
        <td  align="right"><b>* C.T.</b>:</td>
        <td colspan="5">
        	{{$datosacta->oct_testigo2_a}}  
        </td>
        <td colspan="2"></td>
    </tr>
    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>REPRESENTANTE DEL OIC Ó DE LA SECOGEM</b></td>
    </tr>
    <tr>
        <td colspan="3" align="right">
            <b>* ¿PARTICIPA ALGÚN REPRESENTANTE?</b>
        </td> 
        <td colspan="5">
            @if($datosacta->orepresentante_a==1)
            	SI
            @elseif($datosacta->orepresentante_a==2)
            	NO
            @endif
        </td>
    </tr>
    @if($datosacta->orepresentante_a==1)
    <tr id="reprecon">
        <td colspan="3" align="right"><b>NOMBRE DEL REPRESENTANTE:</b></td>
        <td colspan="3">
            {{$datosacta->onombre_representante_contraloria_a}} 
        </td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td colspan="2" align="right"><b>* OFICIO NÚM:</b></td>
        <td>
        	{{$datosacta->ooficio_designacion_er_a}}  
        </td>
        <td align="right"><b>* FECHA:</b></td>
        <td>
        	{{$datosacta->ofecha_ofocio_designacion_er_a}}   
        </td>
        <td colspan="3"></td>
    </tr>
    @elseif($datosacta->orepresentante_a==2)
    @endif    
    <tr>
        <td colspan="8" style="text-align:justify;">
            @if($datosacta->ohechos_a!=NULL)
            	<b> OTROS HECHOS</b><br>
            	{{$datosacta->ohechos_a}}
            @else
            @endif
        </td>
    </tr>
</tbody>
</table>

</form>
