<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/js/app.js'])
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
          integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <title>Ubicación de tesis</title>
</head>
    <body class="body">
        <form action="{{ route('Ingresar') }}" method="POST" class="formLogin"
              @if($error != null) style="height: 622px" @endif>

            @if($error != null)
                <div class="alert alert-danger" role="alert"><b>{{ $error }}</b></div>
            @endif

            <img src="{{ asset('img/Logo_SOPECIN.png') }}" width="336px" height="100px" alt="Img Logo">
            <h4 class="tituloLogin">Iniciar sesión</h4>

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <label for="Username" class="labelLogin"><b>Usuario</b></label>
            <input type="text" class="inputLogin" tabindex="1" id="Username" name="Username">

            <label for="Password" class="labelLogin"><b>Contraseña</b></label>
            <input type="password" class="inputLogin" tabindex="2" id="Password" name="Password">

            <button type="submit" class="buttonLogin" id="btnIngresar" tabindex="3">
                Ingresar <i class="fa-solid fa-right-to-bracket" data-toggle="tooltip" title="Ingresar"></i>
            </button>
            <hr>
            <button type="button" class="buttonRegistro" id="btnRegistro" tabindex="3" onclick="Registrar()">
                Registro <i class="fa-solid fa-book-user" data-toggle="tooltip" title="Ingresar"></i>
            </button>
        </form>
    </body>
</html>

<script>
    function Registrar(){
        window.location.href="{{ route('Register') }}"
    }
</script>
