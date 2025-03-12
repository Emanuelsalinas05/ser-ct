<?php 

use App\Models\DatosActa;

$datosacta  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*','idct_subdireccion','idct_departamento',
                    DB::raw('CASE 
                                WHEN idct_departamento=0 
                                THEN (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_subdireccion) 
                                ELSE (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_departamento) 
                            END AS unidad'))
                ->leftJoin('g1organigrama', 'g1organigrama.idct_sector',  'id_ct')  
                ->where('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                ->whereOconcluida(1)
                ->OrderBy('unidad', 'ASC')
                ->OrderBy('ofecha_fin_a', 'DESC')
                ->OrderBy('ofecha_fin_ac', 'DESC')
                ->get();

$datosacta2  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*','idct_subdireccion','idct_departamento',
                    DB::raw('CASE 
                                WHEN idct_departamento=0 
                                THEN (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_subdireccion) 
                                ELSE (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_departamento) 
                            END AS unidad'))
                ->leftJoin('g1organigrama', 'g1organigrama.idct_supervicion',  'id_ct')  
                ->where('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                ->whereOconcluida(1)
                ->OrderBy('unidad', 'ASC')
                ->OrderBy('ofecha_fin_a', 'DESC')
                ->OrderBy('ofecha_fin_ac', 'DESC')
                ->get();


$datosacta3  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*','idct_subdireccion','idct_departamento',
                    DB::raw('CASE 
                                WHEN idct_departamento=0 
                                THEN (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_subdireccion) 
                                ELSE (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=idct_departamento) 
                            END AS unidad'))
                ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                ->where('g1organigrama.idct_subdireccion', Auth::user()->id_ct)
                ->whereOconcluida(1)
                ->OrderBy('unidad', 'ASC')
                ->OrderBy('ofecha_fin_a', 'DESC')
                ->OrderBy('ofecha_fin_ac', 'DESC')
                ->get();


?>