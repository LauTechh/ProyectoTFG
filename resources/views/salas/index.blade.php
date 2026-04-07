@extends('plantilla.app')

@section('content')
<div class="contenedor-mapa-casa" style="text-align: center;">
    <div class="caja-bienvenida">
        <h1 class="titulo-patata">🏠 Mi Hogar de Concentración</h1>
        <p>Haz clic en una estancia para empezar tu sesión.</p>
    </div>

    <div class="mapa-interactivo-wrapper" style="display: inline-block; margin-top: 20px; background: white; padding: 15px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">

        <img src="{{ asset('img/fondo/casa.png') }}" usemap="#image-map" class="img-casa-mapeada">

        <map name="image-map">
            <area alt="Despacho Rosa" title="Ir al Despacho Rosa 🌸" href="{{ route('salas.show', 'despacho-rosa') }}" coords="369,378,351,511,371,700,919,698,919,688,903,672,891,467,926,402,923,384" shape="poly">

            <area alt="Botica" title="Ir a la Botica 🧹" href="{{ route('salas.show', 'botica') }}" coords="948,402,907,465,919,665,938,685,940,697,1322,697,1336,404" shape="poly">

            <area alt="Biblioteca" title="Ir a la Biblioteca 📚" href="{{ route('salas.show', 'biblioteca') }}" coords="905,46,525,44,506,360,921,366" shape="poly">

            <area alt="Dormitorio" title="Ir al Dormitorio 🛏️" href="{{ route('salas.show', 'dormitorio') }}" coords="919,46,1274,46,1336,385,940,385" shape="poly">

            <area alt="Jardín" title="Ir al Jardín 🌿" href="{{ route('salas.show', 'jardin') }}" coords="504,141,488,361,349,361,329,510,339,603,100,597,130,444,158,282,184,139" shape="poly">
        </map>
    </div>

    <div style="margin-top: 30px;">
        <a href="/" class="enlace-volver">⬅ Volver al inicio</a>
    </div>
</div>

{{-- Script para que el mapa funcione en cualquier tamaño de pantalla --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        imageMapResize();
    });
</script>

@endsection