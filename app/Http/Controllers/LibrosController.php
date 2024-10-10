<?php

namespace App\Http\Controllers;

use App\Models\ActaVolante;
use App\Models\Libro;
use App\Models\Mesa;
use App\Models\MesaAlumno;
use App\Services\Trianual\LibroDigitalService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LibrosController extends Controller
{

    private LibroDigitalService $libroDigitalService;

    /**
     * @param LibroDigitalService $libroDigitalService
     */
    public function __construct(LibroDigitalService $libroDigitalService)
    {
        $this->libroDigitalService = $libroDigitalService;
    }


    /**
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index()
    {
        $librosObjects = Libro::orderBy('numero')
            ->orderBy('folio')
            ->orderBy('orden')
            ->orderBy('llamado')
            ->paginate(20);

        return view('libros.index', compact('librosObjects'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'mesa_id' => ['required'],
            'llamado' => ['required'],
        ]);

        if (!$validation->fails()) {
            try {
                foreach ($request['folios'] as $folio) {
                    $numero_folio = explode('-', $folio);
                    $request['folio'] = $numero_folio[0];
                    $request['orden'] = $numero_folio[1];

                    $libro = Libro::where([
                        'mesa_id' => $request['mesa_id'],
                        'llamado' => $request['llamado'],
                        'orden' => $request['orden']
                    ])->first();

                    $mesa = Mesa::find($request['mesa_id']);
                    $libroExist = null;
                    $libroAnterior = null;
                    if ($libro) {
                        $libroAnterior = clone $libro;
                        $libroExist = $libro->update($request->all());
                    } else {
                        $libro = Libro::create($request->all());
                    }

                    $this->setLibroActasVolantes($libro);

                    if (!$libroExist) {
                        $this->libroDigitalService->cargaLibroDigitaByLibro($libro, Auth::user());
                    } else {
                        $this->libroDigitalService->actualizaLibroDigitaByLibro($libroAnterior, $libro, Auth::user(), $mesa);
                    }
                }
                $data = [
                    'status' => 'success',
                    'data' => 'Libros creados!'
                ];
            } catch (Exception $e) {
                $data = [
                    'status' => 'error',
                    'data' => $e->getMessage()
                ];
            }

        } else {
            $data = [
                'status' => 'error',
                'data' => $validation->errors()
            ];
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        //
    }

    /**
     * @param Libro $libro
     * @return void
     */
    private function setLibroActasVolantes(Libro $libro): void
    {
        /** @var Mesa $mesa */
        $mesa = $libro->mesa;
        $llamado = false;
        if ($libro->llamado === "2") {
            $llamado = true;
        }

        $inscripciones = $mesa->mesa_inscriptos_by_llamado($libro->orden, $llamado);

        /** @var MesaAlumno $inscripcion */
        foreach ($inscripciones as $inscripcion) {

            /** @var ActaVolante $acta_volante */

            $acta_volante = $inscripcion->acta_volante ?? null;

            if ($acta_volante) {
                $acta_volante->libro_id = $libro->id;
                $acta_volante->update();
            }
        }
    }
}
