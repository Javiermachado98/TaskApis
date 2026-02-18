<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * En este punto hacemos el llamado de todo lo que tenemos en nuestra base de datos, lo que nos permite
     * con el eloquent asignamos una variable $tasks la que sera igual a las tareas
     * y luego retornamos los datos del arreglo
     */
    public function index()
    {
        $tasks = Task::all();
        return TaskResource::collection($tasks); // IMPORTANTE esto es lo que me trae los arreglos
    }

    /**
     * Store a newly created resource in storage.
     * En este punto movimos la configuración de store a request por buenas practicas, aqui lo que hacemos es que en los parametros
     * de la funcion store llamamos taskRequest que es el que nos traera los mensajes, que estamos necesitando, luego de eso
     * confirmamos la creación y respondemos, si da error mostraremos el error en base a lo que falle.
     */
    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
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
     * En esta funcion hacemos la actualizacion es importante tener en cuenta que para esta actualizacion
     * tambien hacemos las validaciones las cuales deben cumplirse por que no se puede actualizar un dato de manera incorrecta
     * 
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
     * aqui eliminamos con exito el registro
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json([
            'message'=>'Tarea eliminada correctamente'
        ]);
    }
}
