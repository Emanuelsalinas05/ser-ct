<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Solicitudnoadeudo;
use App\Models\Tiposnoadeudo;
use App\Models\DatosActa;
use App\Models\CentrosTrabajo;
use App\Models\Organitation;

class ProductsExportx implements FromCollection, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $result2 = DB::select("select ac.onombre_entrega_a, ac.orfc_entrega_a, CONCAT(ac.oct_a,' - ',ac.onombre_ct_a), 
                                        case
                                            when ct.omodalidad='DPB'
                                            then  concat(org.cct_departamento,' - ',g1centros_trabajo.onombre_ct)
                                            when ct.omodalidad!='DPB'
                                            then concat(org.cct_subdireccion,' -',g1centros_trabajo.onombre_ct)
                                        END AS aaa ,
                                        tp.otipo, sl.onumero_oficio, date_format(sl.ofecha, '%d-%m-%Y') as fecha
                                        FROM 
                                        g1solicitudes_noadeudos sl, g1tipocertificado_noadeudo tp, g1acta ac , 
                                        g1centros_trabajo ct 
                                        , g1organigrama org
                                        LEFT JOIN g1centros_trabajo
                                        ON g1centros_trabajo.oclave = org.cct_subdireccion
                                        LEFT JOIN g1centros_trabajo  ctt2
                                        ON ctt2.oclave=org.cct_departamento
                                        WHERE   sl.id_tipocert = tp.id
                                        AND sl.ofinalizado=1
                                        AND sl.id_acta = ac.id
                                        AND ct.kcvect = ac.id_ct  
                                        AND org.idct_escuela = ac.id_ct   ");

        
        return collect($result2);
    }


    public function headings() : array
    {   
        return [
y
                'DIRECCIÓN DE ÁREA', 
                'SUBDIRECCIÓN Y/O DEPARTAMENTO',    
                'NOMBRE DEL CENTRO DE TRABAJO',     
                'CCT DOMILICIO DEL CCT',    
                'NOMBRE DEL SERVIDOR PÚBLICO QUE ENTREGA',  
                'NOMBRE DEL SERVIDOR PÚBLICO QUE  RECIBE',  
                'MOTIVO',   
                'FECHA DE LA E-R',  
                'ENTREGÓ CARPETA DE E-R (SI o NO)', 
                'DOCUMENTO COMPROBATORIO DE ENTREGA (No. de oficio)', 
                'CONSULTA DE CARPETA DIGITAL', 
                'OBSERVACIONES', 
            ];
    }


}
