@extends('layouts.guest')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <h2>Paso 2: ¡Crea tu Patata-Avatar! 🥔</h2>
    <p>Elige una opción de cada fila para montar tu personaje.</p>

    <form action="/registro/finalizar" method="POST">
        @csrf

        <h3 style="margin-top: 30px; border-bottom: 1px solid #eee;">1. Color de la patata</h3>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; padding: 15px;">
            @foreach(['azulRelleno.png' => 'Azul', 'marronRelleno.png' => 'Marrón', 'pielRelleno.png' => 'Piel', 'rosaRelleno.png' => 'Rosa', 'verdeRelleno.png' => 'Verde'] as $file => $name)
            <label style="cursor: pointer;">
                <input type="radio" name="avatar_base" value="base/{{ $file }}" required style="display: none;">
                <img src="{{ asset('img/avatar/base/'.$file) }}" alt="{{ $name }}" 
                     style="width: 80px; height: 80px; object-fit: contain; border: 3px solid #eee; border-radius: 12px; background: white;">
            </label>
            @endforeach
        </div>

        <h3 style="margin-top: 30px; border-bottom: 1px solid #eee;">2. Estilo de borde</h3>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; padding: 15px;">
            @foreach(['azulLinea.png', 'marronLinea.png', 'pielLinea.png', 'rosaLinea.png', 'verdeLinea.png'] as $file)
            <label style="cursor: pointer;">
                <input type="radio" name="avatar_linea" value="lineas/{{ $file }}" required style="display: none;">
                <img src="{{ asset('img/avatar/lineas/'.$file) }}" 
                     style="width: 80px; height: 80px; object-fit: contain; border: 3px solid #eee; border-radius: 12px; background: white;">
            </label>
            @endforeach
        </div>

        <h3 style="margin-top: 30px; border-bottom: 1px solid #eee;">3. Los ojos</h3>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; padding: 15px;">
            @foreach(['ojos1.png', 'ojos2.png', 'ojos3.png'] as $file)
            <label style="cursor: pointer;">
                <input type="radio" name="avatar_ojos" value="ojos/{{ $file }}" required style="display: none;">
                <img src="{{ asset('img/avatar/ojos/'.$file) }}" 
                     style="width: 80px; height: 80px; object-fit: contain; border: 3px solid #eee; border-radius: 12px; background: white;">
            </label>
            @endforeach
        </div>

        <div style="position: relative; width: 200px; height: 200px; margin: 30px auto; border: 2px dashed #ccc; border-radius: 20px; background: white; overflow: hidden;">
            <img id="preview-base" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 10; display: none;">
            <img id="preview-linea" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 20; display: none; mix-blend-mode: multiply;">
            <img id="preview-ojos" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 30; display: none;">
            <p id="preview-text" style="margin-top: 80px; color: #999;">Tu patata aparecerá aquí</p>
        </div>

        <button type="submit" class="btn" style="width: 100%; padding: 15px; background-color: #4CAF50; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: bold;">
            ¡Finalizar y entrar! 🚀
        </button>
    </form>
</div>

@vite(['resources/js/avatar-preview.js'])
@endsection