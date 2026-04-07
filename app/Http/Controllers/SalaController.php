<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SesionEstudio;
use Illuminate\Support\Facades\Auth;

class SalaController extends Controller
{
    // Ver el menú de selección de salas
    public function index()
    {
        return view('salas.index');
    }

    // Entrar en una sala específica (Mundos personalizados)
    public function show($tipo)
    {
        $nombresSalas = [
            'despacho-rosa'   => 'Despacho Rosa 🌸',
            'biblioteca'      => 'Biblioteca Antigua 📚',
            'dormitorio'      => 'Dormitorio Relax 🛏️',
            'despacho-neutro' => 'Despacho Minimalista 🖥️'
        ];

        $nombreSala = $nombresSalas[$tipo] ?? 'Sala de Concentración';

        // Intentamos cargar la vista específica (ej: salas/despacho-rosa.blade.php)
        // Si no existe, cargamos una genérica o damos error
        if (view()->exists("salas.{$tipo}")) {
            return view("salas.{$tipo}", compact('tipo', 'nombreSala'));
        }

        // Si aún no has creado el archivo específico, puedes dejar que use 'estudio' por ahora:
        return view('salas.estudio', compact('tipo', 'nombreSala'));
    }

    // Guardar el tiempo de la patata en la base de datos
    public function guardar(Request $request)
    {
        $request->validate([
            'segundos' => 'required|integer',
            'sala'     => 'required|string'
        ]);

        SesionEstudio::create([
            'user_id'      => Auth::id(),
            'sala'         => $request->sala,
            'segundos'     => $request->segundos,
            'fecha_inicio' => now(),
        ]);

        return redirect()->route('salas.index')->with('success', '¡Sesión guardada! Tiempo registrado.');
    }
}
