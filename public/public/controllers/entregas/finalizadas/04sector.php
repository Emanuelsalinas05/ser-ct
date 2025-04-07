<?php 
use App\Models\DatosActa;

$datosacta2  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                ->leftJoin('g1organigrama', 'g1organigrama.idct_supervicion',  'id_ct')  
                ->where('g1organigrama.idct_sector', Auth::user()->id_ct)
                ->whereOconcluida(1)
                ->get();


$datosacta3  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
                ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                ->where('g1organigrama.idct_sector', Auth::user()->id_ct)
                ->whereOconcluida(1)
                ->get();
?>