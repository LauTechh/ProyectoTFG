@extends('layouts.app') {{-- Cambiado de guest a app --}}

@section('content')
<div class="guest-body"> {{-- Centra el contenido --}}
    <div class="guest-container" style="max-width: 800px;"> {{-- Efecto cristal --}}
        
        <h2 style="margin-bottom: 10px;">Paso 2: ¡Crea tu Patata-Avatar! 🥔</h2>
        <p style="color: #666; margin-bottom: 20px;">Elige una opción de cada fila para montar tu personaje.</p>

        <form action="/registro/finalizar" method="POST">
            @csrf

            <h3 style="margin-top: 20px; border-bottom: 1px solid rgba(0,0,0,0.1); font-size: 1.1rem; padding-bottom: 5px;">1. Color de la patata</h3>
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; padding: 15px;">
                @foreach(['azulRelleno.png' => 'Azul', 'marronRelleno.png' => 'Marrón', 'pielRelleno.png' => 'Piel', 'rosaRelleno.png' => 'Rosa', 'verdeRelleno.png' => 'Verde'] as $file => $name)
                <label style="cursor: pointer;" class="avatar-option">
                    <input type="radio" name="avatar_base" value="base/{{ $file }}" required style="display: none;">
                    <img src="{{ asset('img/avatar/base/'.$file) }}" alt="{{ $name }}" 
                         style="width: 70px; height: 70px; object-fit: contain; border: 3px solid #eee; border-radius: 12px; background: white; transition: 0.2s;">
                </label>
                @endforeach
            </div>

            <h3 style="margin-top: 20px; border-bottom: 1px solid rgba(0,0,0,0.1); font-size: 1.1rem; padding-bottom: 5px;">2. Estilo de borde</h3>
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; padding: 15px;">
                @foreach(['azulLinea.png', 'marronLinea.png', 'pielLinea.png', 'rosaLinea.png', 'verdeLinea.png'] as $file)
                <label style="cursor: pointer;" class="avatar-option">
                    <input type="radio" name="avatar_linea" value="lineas/{{ $file }}" required style="display: none;">
                    <img src="{{ asset('img/avatar/lineas/'.$file) }}" 
                         style="width: 70px; height: 70px; object-fit: contain; border: 3px solid #eee; border-radius: 12px; background: white; transition: 0.2s;">
                </label>
                @endforeach
            </div>

            <h3 style="margin-top: 20px; border-bottom: 1px solid rgba(0,0,0,0.1); font-size: 1.1rem; padding-bottom: 5px;">3. Los ojos</h3>
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; padding: 15px;">
                @foreach(['ojos1.png', 'ojos2.png', 'ojos3.png'] as $file)
                <label style="cursor: pointer;" class="avatar-option">
                    <input type="radio" name="avatar_ojos" value="ojos/{{ $file }}" required style="display: none;">
                    <img src="{{ asset('img/avatar/ojos/'.$file) }}" 
                         style="width: 70px; height: 70px; object-fit: contain; border: 3px solid #eee; border-radius: 12px; background: white; transition: 0.2s;">
                </label>
                @endforeach
            </div>

            {{-- Vista previa de la patata --}}
            <div style="position: relative; width: 180px; height: 180px; margin: 25px auto; border: 2px dashed rgba(0,0,0,0.2); border-radius: 20px; background: rgba(255,255,255,0.5); overflow: hidden;">
                <img id="preview-base" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 10; display: none;">
                <img id="preview-linea" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 20; display: none; mix-blend-mode: multiply;">
                <img id="preview-ojos" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 30; display: none;">
                <p id="preview-text" style="margin-top: 75px; color: #666; font-weight: bold;">Tu patata aparecerá aquí</p>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 15px; font-weight: bold; border: none; cursor: pointer; font-size: 1.1rem;">
                ¡Finalizar y entrar! 🚀
            </button>
        </form>
    </div>
</div>

@vite(['resources/js/avatar-preview.js'])

{{-- Pequeño estilo extra para que al seleccionar una opción brille --}}
<style>
    .avatar-option input[type="radio"]:checked + img {
        border-color: #4CAF50 !important;
        box-shadow: 0 0 10px rgba(76, 175, 80, 0.5);
        transform: scale(1.05);
    }
</style>
@endsection