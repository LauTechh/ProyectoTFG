@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; text-align: center;">
    <h1>📚 ¡Bienvenido a tu Red Social de Libros!</h1>
    
    {{-- BLOQUE 1: Saludo dinámico --}}
    @auth
        <p>Hola de nuevo, <strong>{{ Auth::user()->name }}</strong>. ¿Qué vamos a leer hoy?</p>
    @endauth

    @guest
        <p>Explora el mundo de la lectura. ¡Regístrate para guardar tus propios libros!</p>
    @endguest

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 40px;">
        
        {{-- BLOQUE 2: Mi Biblioteca (Solo visible si estás logueado) --}}
        @auth
        <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <h3>📖 Mi Biblioteca</h3>
            <p>Gestiona tus lecturas guardadas.</p>
            <a href="/mis-libros" class="btn" style="display: inline-block; margin-top: 10px;">Ver mis libros</a>
        </div>
        @endauth

        {{-- BLOQUE 3: Explorar (Visible para TODOS) --}}
        <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <h3>🔍 Explorar</h3>
            <p>Busca nuevos libros en Google Books.</p>
            <a href="/buscar" class="btn btn-dark" style="display: inline-block; margin-top: 10px;">Buscar libros</a>
        </div>

        {{-- BLOQUE 4: Registro (Solo para invitados) --}}
        @guest
        <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <h3>🥔 ¡Únete!</h3>
            <p>Crea tu cuenta y personaliza tu patata.</p>
            <a href="/registro" class="btn" style="display: inline-block; margin-top: 10px; background: #4CAF50; color: white;">Registrarme</a>
        </div>
        @endguest
    </div>

    {{-- BLOQUE 5: Datos del Avatar (Solo si estás logueado) --}}
    @auth
    <details style="margin-top: 50px; color: #888; font-size: 0.8em; cursor: pointer;">
        <summary>Ver datos técnicos de mi avatar</summary>
        <div style="background: #f9f9f9; padding: 10px; border: 1px solid #ddd; display: inline-block; margin-top: 10px; text-align: left;">
            <p><strong>Cuerpo:</strong> {{ Auth::user()->avatar_base }}</p>
            <p><strong>Línea:</strong> {{ Auth::user()->avatar_linea }}</p>
            <p><strong>Ojos:</strong> {{ Auth::user()->avatar_ojos }}</p>
        </div>
    </details>
    @endauth
</div>
@endsection