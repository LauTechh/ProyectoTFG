@extends('plantilla.invitado')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">

    <form action="{{ route('registro.finalizar') }}" method="POST">
        @csrf

        {{-- 🌟 LLAMAMOS AL COMPONENTE QUE ACABAS DE CREAR 🌟 --}}
        @include('componentes.form-avatar')

        {{-- Solo dejamos el botón, porque el botón de registro es diferente al de perfil --}}
        <button type="submit" class="btn-primario" style="width: 100%; padding: 15px; font-size: 1.2rem; margin-top: 20px;">
            ¡Finalizar y entrar! 🚀
        </button>
    </form>
</div>

@vite(['resources/js/avatar-preview.js'])
@endsection