@extends('plantilla.app')

@section('content')
{{-- Cargamos los estilos específicos de perfil --}}
@vite(['resources/css/perfil.css'])

<div class="contenedor-perfil-layout">

    {{-- COLUMNA IZQUIERDA (1/3): NAVEGACIÓN --}}
    <div class="columna-perfil-izq">
        <div class="tarjeta-decorativa shadow-sm">
            <div class="cuerpo-tarjeta-navegacion">
                <h3 class="libro-titulo-compacto">Navegación</h3>

                <div class="grupo-botones-vertical">
                    <a href="{{ route('libros.estanteria') }}" class="btn-perfil-navegacion">
                        📚 Mi Estantería
                    </a>

                    <button class="btn-perfil-navegacion btn-deshabilitado" title="Próximamente...">
                        👥 Mis Amigos
                    </button>
                </div>

                <hr class="separador-perfil">

                <p class="txt-decorativo">
                    "Un libro es un jardín que se lleva en el bolsillo."
                </p>
            </div>
        </div>
    </div>

    {{-- COLUMNA DERECHA (2/3): GESTIÓN DE PERFIL --}}
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
                <button onclick="toggleFormNombre()" class="btn-perfil-accion">✏️ Cambiar Nombre</button>
            </div>

            {{-- FORMULARIO DE CAMBIO DE NOMBRE --}}
            <div id="form-nombre-container" style="display: none; margin-top: 20px; padding: 15px; background: rgba(255,255,255,0.5); border-radius: 15px; border: 1px solid #fed7aa; width: 100%; max-width: 400px;">
                <form action="{{ route('perfil.actualizarNombre') }}" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
                    @csrf
                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                        class="input-buscador-ancho" style="padding: 8px; font-size: 0.9rem; width: 100%; box-sizing: border-box;" required>

                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <button type="button" onclick="toggleFormNombre()" style="background: none; border: none; cursor: pointer; font-size: 0.7rem; color: #666; font-weight: bold; text-transform: uppercase;">Cancelar</button>
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
            <a href="/" class="btn-primario" style="font-size: 0.8rem; padding: 10px 20px; text-decoration: none;">⬅ Volver al menú</a>
        </div>
    </div>

</div>

{{-- Script para mostrar/ocultar el formulario de nombre --}}
<script>
    function toggleFormNombre() {
        const container = document.getElementById('form-nombre-container');
        if (container.style.display === 'none') {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    }
</script>

@endsection