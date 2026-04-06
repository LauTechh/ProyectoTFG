{{-- resources/views/componentes/form-avatar.blade.php --}}

<div class="caja-beige-selector">
    <h2 style="color: #7c2d12; margin-bottom: 10px;">¡Personaliza tu Patata! 🥔</h2>
    <p style="color: #8b5e3c; margin-bottom: 30px;">Elige una opción de cada fila para montar tu personaje.</p>

    {{-- 1. BASE --}}
    <h3 class="titulo-seccion-avatar">1. Color de la patata</h3>
    <div class="cuadricula-opciones-avatar">
        @foreach(['azulRelleno.png' => 'Azul', 'moradoRelleno.png' => 'Morado', 'naranjaRelleno.png' => 'Naranja', 'rosaRelleno.png' => 'Rosa', 'verdeRelleno.png' => 'Verde'] as $file => $name)
        <label class="opcion-avatar">
            <input type="radio" name="avatar_base" value="base/{{ $file }}"
                {{ (Auth::check() && Auth::user()->avatar_base == 'base/'.$file) ? 'checked' : '' }} required>
            <img src="{{ asset('img/avatar/base/'.$file) }}" alt="{{ $name }}">
        </label>
        @endforeach
    </div>

    {{-- 2. BOCA --}}
    <h3 class="titulo-seccion-avatar">2. Ponle boca</h3>
    <div class="cuadricula-opciones-avatar">
        @foreach(['boca1.png', 'boca2.png', 'boca3.png', 'boca4.png'] as $file)
        <label class="opcion-avatar">
            <input type="radio" name="avatar_boca" value="boca/{{ $file }}"
                {{ (Auth::check() && Auth::user()->avatar_boca == 'boca/'.$file) ? 'checked' : '' }} required>
            <img src="{{ asset('img/avatar/boca/'.$file) }}" alt="Boca">
        </label>
        @endforeach
    </div>

    {{-- 3. OJOS --}}
    <h3 class="titulo-seccion-avatar">3. Los ojos para leer</h3>
    <div class="cuadricula-opciones-avatar">
        @foreach(['ojos1.png', 'ojos2.png', 'ojos3.png'] as $file)
        <label class="opcion-avatar">
            <input type="radio" name="avatar_ojos" value="ojos/{{ $file }}"
                {{ (Auth::check() && Auth::user()->avatar_ojos == 'ojos/'.$file) ? 'checked' : '' }} required>
            <img src="{{ asset('img/avatar/ojos/'.$file) }}" alt="Ojos">
        </label>
        @endforeach
    </div>

    {{-- 4. COMPLEMENTOS --}}
    <h3 class="titulo-seccion-avatar">4. Algún complemento</h3>
    <div class="cuadricula-opciones-avatar">
        @foreach(['complemento1.png', 'complemento2.png', 'complemento3.png', 'complemento4.png', 'complemento5.png'] as $file)
        <label class="opcion-avatar">
            <input type="radio" name="avatar_complemento" value="complemento/{{ $file }}"
                {{ (Auth::check() && Auth::user()->avatar_complemento == 'complemento/'.$file) ? 'checked' : '' }} required>
            <img src="{{ asset('img/avatar/complemento/'.$file) }}" alt="Complemento">
        </label>
        @endforeach
    </div>
</div>

{{-- 2. VISTA PREVIA (Con seguros para evitar imágenes rotas) --}}
<div class="caja-vista-previa-avatar">

    {{--
        Añadimos display:none si no hay imagen. 
        El JS se encargará de ponerlo en 'block' cuando el usuario elija.
    --}}

    <img id="preview-base"
        class="capa-avatar"
        style="z-index: 10; {{ (Auth::check() && Auth::user()->avatar_base) ? '' : 'display:none;' }}"
        src="{{ (Auth::check() && Auth::user()->avatar_base) ? asset('img/avatar/' . Auth::user()->avatar_base) : '' }}">

    <img id="preview-boca"
        class="capa-avatar"
        style="z-index: 20; mix-blend-mode: multiply; {{ (Auth::check() && Auth::user()->avatar_boca) ? '' : 'display:none;' }}"
        src="{{ (Auth::check() && Auth::user()->avatar_boca) ? asset('img/avatar/' . Auth::user()->avatar_boca) : '' }}">

    <img id="preview-ojos"
        class="capa-avatar"
        style="z-index: 30; {{ (Auth::check() && Auth::user()->avatar_ojos) ? '' : 'display:none;' }}"
        src="{{ (Auth::check() && Auth::user()->avatar_ojos) ? asset('img/avatar/' . Auth::user()->avatar_ojos) : '' }}">

    <img id="preview-complemento"
        class="capa-avatar"
        style="z-index: 40; {{ (Auth::check() && Auth::user()->avatar_complemento) ? '' : 'display:none;' }}"
        src="{{ (Auth::check() && Auth::user()->avatar_complemento) ? asset('img/avatar/' . Auth::user()->avatar_complemento) : '' }}">

    {{-- El texto de ayuda: Se oculta si ya hay una base cargada (perfil) --}}
    <p id="preview-text" style="{{ (Auth::check() && Auth::user()->avatar_base) ? 'display:none;' : 'color: #8b5e3c; font-style: italic;' }}">
        ¡Elige un color para empezar! 🥔
    </p>
</div>