@extends('plantilla.invitado')

@section('content')

{{-- Alerta de errores --}}
@if ($errors->any())
<div id="validation-alert" data-message="{{ $errors->first() }}" style="display:none;"></div>
@endif

<div class="seccion-auth">
    <div class="contenedor-auth-card">

        <h2 style="color: #5d4037; text-align: center; margin-bottom: 0;">¡Hola de nuevo! 🥔📚</h2>
        <p style="color: #8b5e3c; text-align: center; margin: 10px 0 20px 0;">Entra para ver cómo va tu estantería de libros.</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div>
                <label style="color: #7c2d12; font-weight: bold;">Email</label>
                <input type="email" name="email" placeholder="tu@email.com" value="{{ old('email') }}" required>
            </div>

            <div style="margin-top: 15px;">
                <label style="color: #7c2d12; font-weight: bold;">Contraseña</label>
                <input type="password" name="password" placeholder="Tu contraseña secreta" required>
            </div>

            <button type="submit" class="btn-primario" style="margin-top: 30px; width: 100%; cursor: pointer;">
                Entrar a mi cuenta 🚀
            </button>
        </form>

        <div style="margin-top: 25px; text-align: center; border-top: 1px dashed #fed7aa; padding-top: 20px;">
            <p style="color: #5d4037; font-size: 0.95em;">
                ¿No tienes cuenta?
                <a href="{{ route('registro') }}" style="color: #4CAF50; font-weight: bold; text-decoration: none;">Regístrate aquí</a>
            </p>
        </div>

    </div>
</div>

@endsection