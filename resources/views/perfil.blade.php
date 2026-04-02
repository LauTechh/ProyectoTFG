@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; text-align: center; padding: 20px;">
    <h1>Tu Perfil, {{ Auth::user()->name }} 🥔✨</h1>
    <p style="color: #666;">Aquí es donde nacerá tu comunidad de lectores.</p>

    <div style="position: relative; width: 250px; height: 250px; border-radius: 50%; background: #fff; overflow: hidden; border: 8px solid #4CAF50; margin: 30px auto; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
        <img src="{{ asset('img/avatar/' . Auth::user()->avatar_base) }}" style="position: absolute; top: 0; left: 0; width: 100%; transform: scale(2.0) translateY(2%);">
        <img src="{{ asset('img/avatar/' . Auth::user()->avatar_boca) }}" style="position: absolute; top: 0; left: 0; width: 100%; mix-blend-mode: multiply; transform: scale(2.0) translateY(2%);">
        <img src="{{ asset('img/avatar/' . Auth::user()->avatar_ojos) }}" style="position: absolute; top: 0; left: 0; width: 100%; transform: scale(2.0) translateY(2%);">
        <img src="{{ asset('img/avatar/' . Auth::user()->avatar_complemento) }}" style="position: absolute; top: 0; left: 0; width: 100%; transform: scale(2.0) translateY(2%);">

    </div>

    <div style="background: white; padding: 20px; border-radius: 15px; border: 1px solid #eee; margin-top: 20px;">
        <h3>📖 Próximamente: Tu Biblioteca Personal</h3>
        <p>Estamos conectando con Google Books para que puedas mostrar tus lecturas favoritas aquí.</p>
    </div>

    <div style="margin-top: 30px;">
        <a href="/" class="btn">⬅ Volver al menú</a>
    </div>
</div>
@endsection