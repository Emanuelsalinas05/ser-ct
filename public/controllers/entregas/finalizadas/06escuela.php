use Illuminate\Support\Facades\Auth;
use App\Models\DatosActa;

$datosacta3 = DatosActa::where(function ($q) {
$q->where('id_ct', Auth::user()->id_ct)
->orWhere('id_ctorigen', Auth::user()->id_ct);
})
->where('oconcluida', 1)
->with(['tipoacta', 'elct']) // evita errores en la vista
->orderByDesc('id')
->paginate(10);
