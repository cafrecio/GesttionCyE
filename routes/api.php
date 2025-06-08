use Illuminate\Support\Facades\Route;

// Devuelve todas las localidades de una provincia
Route::get('localidades', function (\Illuminate\Http\Request $req) {
    return \App\Models\Localidade::where('provincia_id', $req->provincia_id)->get();
});

// Devuelve una localidad, incluyendo su zona (para autocompletar zona_id)
Route::get('localidades/{id}', function ($id) {
    return \App\Models\Localidade::find($id);
});
