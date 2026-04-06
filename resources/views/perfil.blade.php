@extends('plantilla.app')

@section('content')
<div class="contenedor-perfil-layout">

    <div class="columna-perfil-izq">
        <div class="tarjeta-decorativa">
            <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1000&auto=format&fit=crop" alt="Decoración" class="img-espacio">
            <p class="txt-decorativo">"Un libro es un jardín que se lleva en el bolsillo."</p>
        </div>
    </div>

    <div class="columna-perfil-der">

        <div class="caja-avatar-perfil">
            <div class="circulo-avatar-grande">
                <img src="{{ asset('img/avatar/' . Auth::user()->avatar_base) }}" class="capa-v-avatar">
                <img src="{{ asset('img/avatar/' . Auth::user()->avatar_boca) }}" class="capa-v-avatar mix-blend">
                <img src="{{ asset('img/avatar/' . Auth::user()->avatar_ojos) }}" class="capa-v-avatar">
                <img src="{{ asset('img/avatar/' . Auth::user()->avatar_complemento) }}" class="capa-v-avatar">
            </div>

            <div class="acciones-perfil">
                <a href="{{ route('perfil.editar-avatar') }}" class="btn-perfil-accion">🎨 Cambiar Avatar</a>
                {{-- Cambiamos el enlace por un botón que activa el formulario --}}
                <button onclick="toggleFormNombre()" class="btn-perfil-accion">✏️ Cambiar Nombre</button>
            </div>

            {{-- FORMULARIO DE CAMBIO DE NOMBRE (Oculto por defecto) --}}
            <div id="form-nombre-container" style="display: none; margin-top: 20px; padding: 15px; background: rgba(255,255,255,0.5); border-radius: 15px; border: 1px solid #fed7aa;">
                <form action="{{ route('perfil.actualizarNombre') }}" method="POST" class="flex flex-col gap-2">
                    @csrf
                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                        class="input-buscador-ancho !py-2 !text-sm w-full" required>
                    <div class="flex gap-2 justify-end">
                        <button type="button" onclick="toggleFormNombre()" class="text-xs text-stone-500 uppercase font-bold">Cancelar</button>
                        <button type="submit" class="btn-compacto-add">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

        <details class="datos-usuario-desplegable">
            <summary>Mis datos de usuario</summary>
            <div class="contenido-datos">
                <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>ADN Patata:</strong> {{ Auth::user()->avatar_base }}, {{ Auth::user()->avatar_ojos }}</p>
            </div>
        </details>

        <div style="margin-top: 30px;">
            <a href="/" class="btn-primario" style="font-size: 0.8rem; padding: 10px 20px;">⬅ Volver al menú</a>
        </div>
    </div>

</div>

{{-- Script sencillo para mostrar/ocultar el formulario sin recargar --}}

@endsection