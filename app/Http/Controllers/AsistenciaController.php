<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = DB::table('asistencias')
        ->join('user', 'asistencia.id_empleado', '=', 'user.id')
        ->select('user.*', 'asistencia.*')
        ->where('asistencias.estado',1)
        ->where('user.estado',1)
        ->get();
        
        return response()->json($user, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //


    }

    /**
     * Display the specified resource.
     */
    public function show(Asistencia $asistencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asistencia $asistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asistencia $asistencia)
    {
        //
    }

    public function guardarEntrada(Request $request){
        $validateData = $request->validate([
            'id_empleado'   => 'required',
            'entrada'   => 'required',
        ]);

        $entrada = Asistencia::create([
            'id_empleado'=>$validateData['id_empleado'],
            'entrada'=>$validateData['entrada'],
            'estado' => 0
        ]);

        return response()->json(['message' => 'Hora de entrada registrada con exito'], 200);
    }


    public function calcularHoras(Request $request)
    {
        //revisar esto
        $horaEntrada = Carbon::parse($request->input('hora_entrada'));
        $horaSalida = Carbon::parse($request->input('hora_salida'));

        $horasTranscurridas = $horaSalida->diffInHours($horaEntrada);

        $limiteHorasNormales = 8;

        if ($horasTranscurridas > $limiteHorasNormales) {
            $horasExtras = $horasTranscurridas - $limiteHorasNormales;
            $horasNormales = $limiteHorasNormales;
        } else {
            $horasExtras = 0;
            $horasNormales = $horasTranscurridas;
        }

        return response()->json([
            'horas_normales' => $horasNormales,
            'horas_extras' => $horasExtras,
        ]);
    }
}
