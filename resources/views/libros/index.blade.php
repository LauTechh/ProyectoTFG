@extends('plantilla.app')

@section('content')
<div class="seccion-auth">
    <div class="contenedor-menu-principal" style="padding-top: 20px; max-width: 900px; margin: 0 auto;">

        {{-- 1. TÍTULO Y BUSCADOR (Mantenemos tu buscador hero) --}}
        <div class="zona-busqueda-hero" style="display: flex; flex-direction: column; align-items: center; margin-bottom: 40px;">
            <form action="{{ route('libros.buscar') }}" method="GET" id="form-busqueda" style="width: 100%; max-width: 600px;">
                <div class="input-wrapper-busqueda" style="display: flex; align-items: center; background: #fffaf5; border: 2px solid #fed7aa; border-radius: 40px; padding: 5px 5px 5px 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);">
                    <input type="text" name="query"
                        placeholder="Buscar libros..."
                        value="{{ request('query') }}"
                        style="flex: 1; border: none; background: transparent; padding: 10px; outline: none; font-size: 1rem; color: #5d4037;"
                        required>
                    <button type="submit" id="btn-buscar" class="btn-menu" style="width: auto; margin: 0; padding: 10px 25px; border-radius: 30px; background: #fb923c; border: none; color: white; font-weight: bold; cursor: pointer;">
                        🔍
                    </button>
                </div>
            </form>
        </div>

        {{-- MENSAJE DE ÉXITO (El "Toast" verde de la foto) --}}
        @if(session('success'))
        <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
            <div style="background: #4ade80; color: white; padding: 12px 25px; border-radius: 15px; font-weight: bold; box-shadow: 0 4px 12px rgba(74, 222, 128, 0.3); display: flex; align-items: center; gap: 10px;">
                ✨ {{ session('success') }} 🥔
            </div>
        </div>
        @endif

        {{-- 2. LISTA DE RESULTADOS (Estética de la foto) --}}
        @if(isset($libros) && count($libros) > 0)
        <div class="lista-libros-estetica" style="display: flex; flex-direction: column; gap: 20px;">
            @foreach($libros as $libro)
            @php
            $info = $libro['volumeInfo'] ?? null;
            $titulo = $info['title'] ?? 'Título desconocido';
            $autor = isset($info['authors']) ? implode(', ', $info['authors']) : 'Autor desconocido';
            $categoria = $info['categories'][0] ?? 'Ficción';

            $portada = $info['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/150/f5f1e6/5d4037?text=Sin+Portada';
            $portada = str_replace('http://', 'https://', $portada);
            @endphp

            {{-- TARJETA HORIZONTAL --}}
            <div class="tarjeta-libro-lista" style="display: flex; align-items: center; background: white; padding: 25px; border-radius: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); border: 1px solid rgba(254, 215, 170, 0.3);">

                {{-- Portada --}}
                <div style="flex-shrink: 0; margin-right: 25px;">
                    <img src="{{ $portada }}" style="width: 100px; height: 140px; object-fit: cover; border-radius: 15px; box-shadow: 0 8px 15px rgba(0,0,0,0.1);">
                </div>

                {{-- Información --}}
                <div style="flex-grow: 1;">
                    <h3 style="color: #7c2d12; font-size: 1.3rem; margin: 0 0 5px 0; font-weight: 800; line-height: 1.2;">
                        {{ Str::limit($titulo, 70) }}
                    </h3>
                    <p style="color: #a8a29e; font-size: 1rem; margin: 0 0 12px 0;">{{ $autor }}</p>

                    {{-- Badge de Categoría --}}
                    <span style="background: #fef3c7; color: #92400e; padding: 6px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; display: inline-block;">
                        {{ $categoria }}
                    </span>
                </div>

                {{-- Botón de Acción --}}
                <div style="flex-shrink: 0; margin-left: 20px;">
                    @auth
                    <form action="{{ route('libros.guardar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="title" value="{{ $titulo }}">
                        <input type="hidden" name="author" value="{{ $autor }}">
                        <input type="hidden" name="cover_url" value="{{ $portada }}">
                        <button type="submit" class="btn-añadir" style="background: #fb923c; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: bold; cursor: pointer; transition: transform 0.2s;">
                            + Añadir
                        </button>
                    </form>
                    @else
                    <button type="button" class="js-invitado" style="background: #9ca3af; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: bold; cursor: pointer;">
                        + Añadir
                    </button>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>

        @elseif(request('query'))
        {{-- Mensaje si no hay resultados --}}
        <div style="text-align: center; background: white; padding: 40px; border-radius: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.03);">
            <p style="color: #8b5e3c; font-size: 1.2rem;">No hay patatas... digo, libros. 🥔</p>
            <a href="{{ route('libros.buscar') }}" style="color: #fb923c; text-decoration: none; font-weight: bold;">← Volver al inicio</a>
        </div>
        @endif

    </div>
</div>

<style>
    .btn-añadir:hover {
        transform: scale(1.05);
        background: #f97316;
    }

    .tarjeta-libro-lista {
        transition: transform 0.3s ease;
    }

    .tarjeta-libro-lista:hover {
        transform: translateY(-5px);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Alerta para invitados
        const botonesInvitado = document.querySelectorAll('.js-invitado');
        botonesInvitado.forEach(boton => {
            boton.addEventListener('click', function() {
                alert("¡Hola! 🥔 Para guardar libros necesitas entrar en tu cuenta.");
            });
        });

        // Feedback al buscar
        const form = document.getElementById('form-busqueda');
        const btn = document.getElementById('btn-buscar');
        if (form) {
            form.addEventListener('submit', function() {
                btn.innerHTML = '...';
            });
        }
    });
</script>
@endsection