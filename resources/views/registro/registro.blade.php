@extends('plantilla.invitado')

@section('content')

{{-- Alerta de errores --}}
@if ($errors->any())
<div id="validation-alert" data-message="{{ $errors->first() }}" style="display:none;"></div>
@endif

<div class="seccion-auth">
    <div class="contenedor-auth-card">

        <h2 style="margin-bottom: 10px; color: #5d4037; text-align: center;">Crear cuenta 🥔📚</h2>
        <p style="color: #8b5e3c; margin-bottom: 25px; text-align: center;">Únete para empezar a crear tu avatar y guardar tus libros.</p>

        {{-- 1. ASEGÚRATE DE QUE LA RUTA SEA 'registro' (o la que maneje el POST del registro unificado) --}}
        <form action="{{ route('registro') }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; color: #7c2d12; margin-bottom: 5px; font-weight: bold;">Nombre</label>
                <input type="text" name="name" placeholder="Tu nombre completo" value="{{ old('name') }}" required
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; color: #7c2d12; margin-bottom: 5px; font-weight: bold;">Email</label>
                <input type="email" name="email" placeholder="Tu email" value="{{ old('email') }}" required
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #7c2d12; margin-bottom: 5px; font-weight: bold;">Contraseña</label>
                <input type="password" name="password" placeholder="Crea una contraseña" required
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            </div>

            {{-- 2. EL SELECTOR REUTILIZABLE --}}
            {{-- No tocamos nada aquí, el componente ya sabe si el usuario existe o no --}}
            <div style="margin-top: 30px; border-top: 1px dashed #fed7aa; padding-top: 20px;">
                @include('componentes.form-avatar')
            </div>

            <button type="submit" class="btn-primario" style="width: 100%; padding: 15px; font-size: 1.1rem; margin-top: 20px; cursor: pointer;">
                Registrarme ahora 🎨
            </button>
        </form>

        <p style="margin-top: 25px; font-size: 0.95em; color: #5d4037; text-align: center;">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}" style="color: #4CAF50; font-weight: bold; text-decoration: none;">Inicia sesión</a>
        </p>

    </div>
</div>

@vite(['resources/js/avatar-preview.js'])

@endsection