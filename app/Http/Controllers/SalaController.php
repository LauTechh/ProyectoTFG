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

    public function registrarPulso(\Illuminate\Http\Request $request)
    {
        // Usamos DB directo para saltarnos cualquier problema de configuración del modelo
        $hoy = now()->toDateString();
        $userId = \Illuminate\Support\Facades\Auth::id();
        $sala = $request->input('sala');

        // 1. Buscamos si existe
        $registro = \Illuminate\Support\Facades\DB::table('sesiones_estudio')
            ->where('user_id', $userId)
            ->where('sala', $sala)
            ->where('fecha_inicio', $hoy)
            ->first();

        if ($registro) {
            // 2. Si existe, sumamos 30s
            \Illuminate\Support\Facades\DB::table('sesiones_estudio')
                ->where('id', $registro->id)
                ->update(['segundos' => $registro->segundos + 30]);
        } else {
            // 3. Si no existe, creamos el primero
            \Illuminate\Support\Facades\DB::table('sesiones_estudio')->insert([
                'user_id' => $userId,
                'sala' => $sala,
                'fecha_inicio' => $hoy,
                'segundos' => 30
            ]);
        }

        // 4. Respondemos éxito total
        return response()->json(['status' => 'ok'], 200);
    }
}
