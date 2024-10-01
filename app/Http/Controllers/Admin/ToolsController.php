<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\RedirectResponse;

class ToolsController extends Controller
{
    public function librosSinActasVolantes()
    {
        $libros = Libro::whereDoesntHave('actasVolantes')->orderBy('numero')->orderBy('folio')->paginate(25);

        return view('admin.tools.libros_sin_actas_volantes', compact('libros'));
    }

    public function librosSinMesas()
    {
        $libros = Libro::whereDoesntHave('mesa')->orderBy('numero')->orderBy('folio')->paginate(25);

        return view('admin.tools.libros_sin_mesas', compact('libros'));
    }

    public function librosDuplicados(): RedirectResponse
    {
        $libros = Libro::groupBy('mesa_id', 'llamado', 'numero', 'folio', 'orden')
            ->select('mesa_id', 'llamado', 'numero', 'folio', 'orden')
            ->selectRaw('COUNT(*) as count')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($libros as $libro) {


                $librosRepetidos = Libro::where([
                    'mesa_id' => $libro->mesa_id,
                    'llamado' => $libro->llamado,
                    'numero' => $libro->numero,
                    'folio' => $libro->folio,
                    'orden' => $libro->orden
                ])
                    ->orderBy('updated_at')
                    ->get();

                if (count($librosRepetidos) > 1 && $librosRepetidos[0]->actasVolantes()->count() === 0) {
                    $librosRepetidos[0]->delete();
                }

        }

        $message = "Libros eliminados correctamente de un total de {$libros->count()}";
        $libros = Libro::whereDoesntHave('actasVolantes')->orderBy('numero')->orderBy('folio')->paginate(25);

        return redirect()->route('admin.tools.libros_sin_actas_volantes', compact('libros'))
            ->with('success_message', $message);

    }

    public function deleteLibrosSinActasVolantes(Libro $libro): RedirectResponse
    {
        $librosRepetidos = Libro::where([
            'mesa_id' => $libro->mesa_id,
            'llamado' => $libro->llamado,
            'numero' => $libro->numero,
            'folio' => $libro->folio,
            'orden' => $libro->orden
        ])
            ->get();

        $message = "El libro tiene una mesa registrada";
        if (count($librosRepetidos) > 1 && $libro->actasVolantes()->count() === 0) {
            $libro->delete();
            $message = "Libro eliminado correctamente";
        }

        $libros = Libro::whereDoesntHave('actasVolantes')->orderBy('numero')->orderBy('folio')->paginate(25);

        return redirect()->route('admin.tools.libros_sin_actas_volantes', compact('libros'))
            ->with('success_message', $message);
    }
}
