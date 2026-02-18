<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return TaskResource::collection($tasks); // IMPORTANTE esto es lo que me trae los arreglos
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated =$request->validate([ // esta funcion la creo para hacer las validaciones
            'titulo'=>'required|string|min:3|max:255', // aqui le digo que es requerido, es texto con minimo 3 y maximo 255
            'descripcion'=>'nullable|string|max:500', // le digo que puede ser nulo, pero con maximo 500 caract
            'estado'=>'boolean', // pues el true o false 
            'prioridad'=>'integer|between:1,5', //numero que sea de 1 a 5
        
        ], [ // aqui hago los valores que se deberan de cumplir
            'titulo.required'=>'El titulo no puede ir vacio',
            'titulo.string'=>'El titulo debe ser texto',
            'titulo.min'=>'El titulo debe tener al menos 3 caracteres',
            'titulo.max'=>'El titulo no puede superar los 255 caracteres',

            'descripcion.string'=>'La descripcion debe ser texto',
            'descripcion.max'=>'La descripcion no puede superaar los 500 caracteres',

            'estado.boolean'=>'El estado debe ser boolean',

            'prioridad.integer'=>'La prioridad debe ser un numero',
            'prioridad.between'=>'La prioridad debe estar entre 1 y 5',

        ]);

        $task = Task::create($validated); /// aqui confirmamos la creación

        return response()->json([
            'message'=>'Tarea creada correctamente',
            'data'=>new TaskResource($task)
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'titulo'=>'required|string|min:3|max:255',
            'descripcion'=>'nullable|string|max:500',
            'estado'=>'boolean',
            'prioridad'=>'integer|between:1,5',
        ]);
        $task->update($validated);
        return response()->json([
            'message'=>'Tarea actualizada correctamente',
            'data'=>new TaskResource($task)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json([
            'message'=>'Tarea eliminada correctamente'
        ]);
    }
}
