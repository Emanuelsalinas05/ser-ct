<?php 
use App\Models\DatosActa;


$datosacta3  =   DatosActa::select(DB::raw('distinct(g1acta.id) as idd'), 'g1acta.*')
					->leftJoin('g1organigrama', 'g1organigrama.idct_escuela',  'id_ct')  
                    ->where('g1organigrama.idct_supervicion', Auth::user()->id_ct)
                    ->whereOconcluida(1)
                    ->get();

?>