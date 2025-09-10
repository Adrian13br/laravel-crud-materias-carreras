<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carrera = Carrera::all();
        return response()->json($carrera);
    }
    public function showConMaterias()
    {
        return Carrera::with('materias')->get();
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
        try {
            $request->validate([
                'nombre' => 'required|string|max:200|min:3',
            ]);
            $myCarrera = new Carrera;
            $myCarrera->nombre = $request->nombre;
            $myCarrera->save();

            return response()->json([
                'message' => 'Carrera creada exitosamente',
                'data' => $myCarrera
            ])->setStatusCode(201);
        } catch (ValidationException $e) {
            //manejar la excepción de validación
            return response()->json([
                'message' => 'Datos enviados no válidos',
                'errors' => $e->validator->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la carrera',
                'error' => $e->getMessage()
            ], 500);
        }


        // $carrera = Carrera::create($request->all());
        // return response()->json($carrera, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $myCarrera = Carrera::find($id);
            if (!$myCarrera) {
                return response()->json([
                    'message' => 'Carrera no encontrada'
                ], 404);
            }
            return response()->json($myCarrera, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener la carrera',
                'error' => $e->getMessage()
            ], 500);
        }

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrera $carrera) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:200|min:3',
            ]);
            $myCarrera = Carrera::find($id);
            $myCarrera->nombre = $request->nombre;
            $myCarrera->save();
            return response()->json($myCarrera, 200);
        } catch (ValidationException $e) {
            //manejar la excepción de validación
            return response()->json([
                'message' => 'Datos enviados no válidos',
                'errors' => $e->validator->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la carrera',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $myCarrera = Carrera::destroy($id);
        return response()->json($myCarrera, 200);

        try {
            $myCarrera = Carrera::find($id);
            if (!$myCarrera) {
                return response()->json([
                    'message' => 'Carrera no encontrada'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la carrera',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
