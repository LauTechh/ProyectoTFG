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

    public function registrarPulso(Request $request)
    {
        $hoy = now()->toDateString();
        $userId = Auth::id();
        $sala = $request->input('sala');

        // Buscamos si el usuario ya tiene una sesión en esa sala HOY
        // Usamos el Modelo SesionEstudio directamente
        $registro = SesionEstudio::where('user_id', $userId)
            ->where('sala', $sala)
            ->whereDate('fecha_inicio', $hoy)
            ->first();

        if ($registro) {
            // Si ya existe, sumamos los 30 segundos
            $registro->increment('segundos', 30);
        } else {
            // Si es la primera vez hoy, creamos el registro
            SesionEstudio::create([
                'user_id'      => $userId,
                'sala'         => $sala,
                'fecha_inicio' => now(), // Guardamos fecha y hora completa
                'segundos'     => 30
            ]);
        }

        return response()->json(['status' => 'ok'], 200);
    }
}
