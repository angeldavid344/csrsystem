<?php


namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    /**
     * Mostrar la lista de salas disponibles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salas = Sala::where('horas_disponibles', '>', 0)->get();
        return view('sala.index', compact('salas'));
    }
}
