<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * Para este punto vamos a tener en cuenta que estamos haciendo las validaciones que hacemos en nuestro store de taskcontroller
     * lo que hacemos es 1ro en la funcion rules vamos a definir todas las reglas que queremos que se cumplan y su respectivos resultados
     * adicionalmente a eso le damos mayor seguridad y esteuctura a nuestro producto.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [ // esta funcion la creo para hacer las validaciones
            'titulo'=>'required|string|min:3|max:255', // aqui le digo que es requerido, es texto con minimo 3 y maximo 255
            'descripcion'=>'nullable|string|max:500', // le digo que puede ser nulo, pero con maximo 500 caract
            'estado'=>'boolean', // pues el true o false 
            'prioridad'=>'integer|between:1,5', //numero que sea de 1 a 5
        
        ];
    }


    /**
     * En esta funcion de messages es todo aquello que vamos a mostrar cuando la consulta al Api falle, es decir cuando la persona cometa un error o 
     * agregue un valor incorrecto en la creación de la tarea le vamos aresponder en base a lo que nos indica la validacion.
     * @return array{descripcion.max: string, descripcion.string: string, estado.boolean: string, prioridad.between: string, prioridad.integer: string, titulo.max: string, titulo.min: string, titulo.required: string, titulo.string: string}
     */
    public function messages(): array
    {
        return [ // aqui hago los valores que se deberan de cumplir
            'titulo.required'=>'El titulo no puede ir vacio',
            'titulo.string'=>'El titulo debe ser texto',
            'titulo.min'=>'El titulo debe tener al menos 3 caracteres',
            'titulo.max'=>'El titulo no puede superar los 255 caracteres',

            'descripcion.string'=>'La descripcion debe ser texto',
            'descripcion.max'=>'La descripcion no puede superaar los 500 caracteres',

            'estado.boolean'=>'El estado debe ser boolean',

            'prioridad.integer'=>'La prioridad debe ser un numero',
            'prioridad.between'=>'La prioridad debe estar entre 1 y 5',

        ];
    }
}
