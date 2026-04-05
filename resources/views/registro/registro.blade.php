@extends('plantilla.invitado') {{-- 1. Solo UN extends y a la nueva carpeta --}}

@section('content')

{{-- Alerta de errores --}}
@if ($errors->any())
<div id="validation-alert" data-message="{{ $errors->first() }}" style="display:none;"></div>
@endif

{{-- 2. Eliminamos el div 'guest-body' porque ya lo pusimos en el layout 'invitado' --}}
<h2 style="margin-bottom: 10px; color: #5d4037;">Crear cuenta 🥔📚</h2>
<p style="color: #8b5e3c; margin-bottom: 25px;">Únete para empezar a crear tu avatar y guardar tus libros.</p>

<form action="{{ route('registro') }}" method="POST"> {{-- Usamos el nombre de la ruta --}}
    @csrf
    <div style="margin-bottom: 15px;">
        <input type="text" name="name" placeholder="Tu nombre completo" value="{{ old('name') }}" required
            style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
    </div>

    <div style="margin-bottom: 15px;">
        <input type="email" name="email" placeholder="Tu email" value="{{ old('email') }}" required
            style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
    </div>

    <div style="margin-bottom: 20px;">
        <input type="password" name="password" placeholder="Crea una contraseña" required
            style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
    </div>

    {{-- Usamos btn-primario (españolizado) que definimos en app.css --}}
    <button type="submit" class="btn-primario" style="width: 100%; padding: 12px; font-size: 1rem;">
        Registrarme ahora
    </button>
</form>

<p style="margin-top: 25px; font-size: 0.95em; color: #5d4037;">
    ¿Ya tienes cuenta? <a href="{{ route('login') }}" style="color: #4CAF50; font-weight: bold; text-decoration: none;">Inicia sesión</a>
</p>

@endsection