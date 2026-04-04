@extends('layouts.app')

@section('content')
<div class="guest-body">
    <div class="guest-container" style="max-width: 800px;">


        <form action="/registro/finalizar" method="POST">
            @csrf



            {{-- 🌟 AÑADIMOS EL CONTENEDOR BEIGE AQUÍ 🌟 --}}
            <div class="avatar-selector-beige-box">


                <h2 class="mb-2">Paso 2: ¡Crea tu Patata-Avatar! 🥔</h2>
                <p class="text-gray-600 mb-6">Elige una opción de cada fila para montar tu personaje.</p>


                {{-- 1. COLOR DE BASE --}}
                <h3 class="avatar-section-title">1. Color de la patata</h3>
                <div class="avatar-options-grid">
                    @foreach(['azulRelleno.png' => 'Azul', 'moradoRelleno.png' => 'Morado', 'naranjaRelleno.png' => 'Naranja', 'rosaRelleno.png' => 'Rosa', 'verdeRelleno.png' => 'Verde'] as $file => $name)
                    <label class="avatar-option">
                        <input type="radio" name="avatar_base" value="base/{{ $file }}" required>
                        <img src="{{ asset('img/avatar/base/'.$file) }}" alt="{{ $name }}">
                    </label>
                    @endforeach
                </div>

                {{-- 2. BOCA --}}
                <h3 class="avatar-section-title">2. Ponle boca a tu patata</h3>
                <div class="avatar-options-grid">
                    @foreach(['boca1.png', 'boca2.png', 'boca3.png', 'boca4.png'] as $file)
                    <label class="avatar-option">
                        <input type="radio" name="avatar_boca" value="boca/{{ $file }}" required>

                        <img src="{{ asset('img/avatar/boca/'.$file) }}" alt="Boca" class="avatar-img-large">
                    </label>
                    @endforeach
                </div>

                {{-- 3. OJOS --}}
                <h3 class="avatar-section-title">3. Los ojos para leer</h3>
                <div class="avatar-options-grid">
                    @foreach(['ojos1.png', 'ojos2.png', 'ojos3.png'] as $file)
                    <label class="avatar-option">
                        <input type="radio" name="avatar_ojos" value="ojos/{{ $file }}" required>

                        <img src="{{ asset('img/avatar/ojos/'.$file) }}" alt="Ojos" class="avatar-img-large"></label>
                    @endforeach
                </div>

                {{-- 4. COMPLEMENTOS --}}
                <h3 class="avatar-section-title">4. Algún complemento</h3>
                <div class="avatar-options-grid">
                    @foreach(['complemento1.png', 'complemento2.png', 'complemento3.png', 'complemento4.png', 'complemento5.png'] as $file)
                    <label class="avatar-option">
                        <input type="radio" name="avatar_complemento" value="complemento/{{ $file }}" required>
                        <img src="{{ asset('img/avatar/complemento/'.$file) }}" alt="Complemento">
                    </label>
                    @endforeach
                </div>
            </div> {{-- 🌟 FIN DEL CONTENEDOR BEIGE 🌟 --}}


            {{-- VISTA PREVIA --}}
            <div class="avatar-preview-box">
                <img id="preview-base" class="preview-layer z-10">
                <img id="preview-boca" class="preview-layer z-20">
                <img id="preview-ojos" class="preview-layer z-30">
                <img id="preview-complemento" class="preview-layer z-40">
                <p id="preview-text">Tu patata aparecerá aquí</p>
            </div>

            <button type="submit" class="btn-primary w-full py-4 text-lg">
                ¡Finalizar y entrar! 🚀
            </button>
        </form>
    </div>
</div>

@vite(['resources/js/avatar-preview.js'])
@endsection