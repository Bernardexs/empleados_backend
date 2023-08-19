<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //
        $user = DB::table('user')
        ->join('roles', 'user.id_rol', '=', 'roles.id')
        ->join('puestos', 'user.id_puesto', '=', 'puestos.id')
        ->join('salarios', 'user.id_salario', '=', 'salarios.id')
        ->select('user.*', 'roles.rol', 'puestos.puesto', 'salarios.salario')
        ->where('user.estado',1)
        ->where('roles.estado',1)
        ->where('puestos.estado',1)
        ->where('salarios.estado',1)
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
        
        $validateData = $request->validate([
            'name'            => 'required|string|max:255',
            'last_name'          => 'required|string|max:255',
            'cedula'            => 'required|string|max:10',
            'email'             => 'required|string|max:255',
            'password'          => 'required|string|min:8',
            'fecha_contratacion'   => 'required',
            'direccion'   => 'required',
            'id_rol'   => 'required',
            'id_puesto'   => 'required',
            'id_salario'=>'required',
        ]);
        
        $user = User::create([
            'name'            =>$validateData['name'],
            'last_name'            =>$validateData['last_name'],
            'cedula'            =>$validateData['cedula'],
            'email'          =>$validateData['email'],
            'password'            =>Hash::make($validateData['password']),
            'fecha_contratacion'             =>$validateData['fecha_contratacion'],
            'direccion'          =>$validateData['direccion'],
            'id_rol'   =>$validateData['id_rol'],
            'id_puesto'=>$validateData['id_puesto'],
            'id_salario'=>$validateData['id_salario'],
            'estado'=>1,
        ]);

        return response()->json(['message' => 'Usuario registrado'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['message' => 'Usuario encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['message' => 'Usuario encontrado'], 404);
        }

        $validateData = $request->validate([
            'name'            => 'required|string|max:255',
            'last_name'          => 'required|string|max:255',
            'cedula'            => 'required|string|max:10',
            'email'             => 'required|string|max:255',
            'password'          => 'required|string|min:8',
            'fecha_contratacion'   => 'required',
            'direccion'   => 'required',
            'id_rol'   => 'required',
            'id_puesto'   => 'required',
            'id_salario'=>'required',
        ]);

        $user = User::update([
            'name'            =>$validateData['name'],
            'last_name'            =>$validateData['last_name'],
            'cedula'            =>$validateData['cedula'],
            'email'          =>$validateData['email'],
            'fecha_contratacion'             =>$validateData['fecha_contratacion'],
            'direccion'          =>$validateData['direccion'],
            'id_rol'   =>$validateData['id_rol'],
            'id_puesto'=>$validateData['id_puesto'],
            'id_salario'=>$validateData['id_salario'],
            'estado'=>1,
        ]);

        return response()->json(['message' => 'Usuario actualizado'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['message' => 'Usuario encontrado'], 404);
        }
        $user->estado = 0;
        return response()->json(['message' => 'Usuario ocultado'], 200);

    }
}
