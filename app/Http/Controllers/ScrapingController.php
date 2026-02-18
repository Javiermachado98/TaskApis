<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class ScrapingController extends Controller
{


    /**
     * Aqui vamos a hacer uso de la funcion invoke para que poder extraer los datos directamente desde la pagina de el pais
     * en el cual primero debemos es apuntar a la pagina, usamos un segmento en especifico para evitar posibles errores, por lo cual usaremos 
     * el de tecnologia
     * - IMPORTANTE debemos importar el facades\https
     * Al importarnos el facades https el sistema entiende las peticiones que esta realizando
     * leugo de eso que logramos apuntar a la pagina web que deseamos scrapear, vamos a poder capturar sus datos, como los capturamos
     * llamandolos desde los eventos del DOM, y los cargamos hacia nuestro lado, y le decimos que queremos ver todos los elementos que sea un h2
     * creamos un arreglo vacio de los titulares a los cuales iremos agregando cada uno de los titulares y hacemos el ciclo
     * el que recorrar cada uno de ellos 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        //aqui estoy apuntando la data que quiero traerme desde el pais
        $html = Http::get('https://elpais.com/tecnologia/')->body();

        //aqui me estoy trayendo los datos del DOM del document
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        //aqui extraigo la información de los titulaeres
        $h2s = $dom->getElementsByTagName('h2');
        $titulares = [];
        foreach ($h2s as $h2) {
            $texto = trim($h2->textContent);
            if ($texto !== '') {
                $titulares[] = $texto;
            }

        }
        //aqui estoy trayendome solo de 1 a 10
        $titulares = array_slice($titulares, 0, 10);

        //aqui respondo
        return response()->json([
            'fuente' => 'El País - Tecnologia',
            'titulares' => $titulares
        ]);
    }
}
