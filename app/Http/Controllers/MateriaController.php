<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $materias = Materia::with('carrera')->get();
            return response()->json($materias, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las materias',
                'error' => $e->getMessage()
            ], 500);
        }
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
        $materia = Materia::create($request->all());
        return response()->json($materia, 201);

        try {
            $request->validate([
                'nombre' => 'required|string|max:200|min:3',
                'carrera_id' => 'required|exists:carreras,id',
            ]);
            $myMateria = new Materia;
            $myMateria->nombre = $request->nombre;
            $myMateria->carrera_id = $request->carrera_id;
            $myMateria->save();

            return response()->json([
                'message' => 'Materia creada exitosamente',
                'data' => $myMateria
            ])->setStatusCode(201);
        } catch (ValidationException $e) {
            //manejar la excepción de validación
            return response()->json([
                'message' => 'Datos enviados no válidos',
                'errors' => $e->validator->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la materia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $myMateria = Materia::with('carrera')->find($id);
            return response()->json($myMateria, 200)([
                'message' => 'Materia no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener la materia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materia $materia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $myMateria = materia::find($id);
        $myMateria->nombre = $request->nombre;
        $myMateria->save();
        return response()->json($myMateria, 200);

        try {
            $request->validate([
                'nombre' => 'required|string|max:200|min:3',
                'carrera_id' => 'required|exists:carreras,id',
            ]);
            $myMateria = Materia::find($id);
            if (!$myMateria) {
                return response()->json([
                    'message' => 'Materia no encontrada'
                ], 404);
            }
            $myMateria->nombre = $request->nombre;
            $myMateria->carrera_id = $request->carrera_id;
            $myMateria->save();

            return response()->json([
                'message' => 'Materia actualizada exitosamente',
                'data' => $myMateria
            ])->setStatusCode(200);
        } catch (ValidationException $e) {
            //manejar la excepción de validación
            return response()->json([
                'message' => 'Datos enviados no válidos',
                'errors' => $e->validator->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la materia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $myMateria = Materia::destroy($id);
        return response()->json($myMateria, 200);

        try {
            $myMateria = Materia::destroy($id);
            if (!$myMateria) {
                return response()->json([
                    'message' => 'Materia no encontrada'
                ], 404);
            }
            return response()->json([
                'message' => 'Materia eliminada exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la materia',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
