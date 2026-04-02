@extends('layouts.app')

@section('content')
<div class="guest-body">
    <div class="guest-container">
        
        <h2 style="margin-bottom: 20px;">Crear cuenta 🥔📚</h2>
        <p style="color: #666; margin-bottom: 20px;">Únete para empezar a crear tu avatar y guardar tus libros.</p>

        <form action="/registro" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <input type="text" name="name" placeholder="Tu nombre completo" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 15px;">
                <input type="email" name="email" placeholder="Tu email" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <input type="password" name="password" placeholder="Crea una contraseña" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            </div>

            {{-- Usamos btn-primary que ya tienes definido en el CSS --}}
            <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-weight: bold; border: none; cursor: pointer;">
                Registrarme ahora
            </button>
        </form>

        <p style="margin-top: 20px; font-size: 0.9em;">
            ¿Ya tienes cuenta? <a href="/login" style="color: #4CAF50; font-weight: bold; text-decoration: none;">Inicia sesión</a>
        </p>
        
    </div>
</div>
@endsection