@extends('plantilla.invitado')

@section('content')
<h2 style="margin-bottom: 20px;">¡Hola de nuevo!</h2>

<form action="/login" method="POST">
    @csrf
    <div style="margin-bottom: 15px;">
        <input type="email" name="email" placeholder="Email" required
            style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
    </div>

    <div style="margin-bottom: 20px;">
        <input type="password" name="password" placeholder="Contraseña" required
            style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
    </div>

    <button type="submit" class="btn" style="width: 100%; padding: 12px; font-weight: bold;">
        Entrar a mi cuenta
    </button>
</form>

<p style="margin-top: 20px; font-size: 0.9em;">
    ¿No tienes cuenta? <a href="/registro" style="color: #4CAF50; font-weight: bold;">Regístrate</a>
</p>
@endsection