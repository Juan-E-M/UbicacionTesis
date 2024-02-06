<html lang="ES">
<head>
    @vite(['resources/js/app.js'])

    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/extras.css') }}" rel="stylesheet">
    <script
        src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
            integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
          integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js">
    </script>
    <title>Ubicación de tesis</title>
</head>
<body>
<nav class="navbar ocNav">
    <div class="container-fluid">
        <a href="#menu-toggle" class="btnNav" id="menu-toggle">
            <i class="fa fa-bars btnNavIcon"></i>
        </a>
        <b class="text-light">Ubicación de tesis</b>
    </div>
</nav>

<div id="wrapper" class="toggled">
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <img src="{{ asset('img/Logo_SOPECIN.png') }}" width="249px" height="120px" alt="Img Logo"
                 style="padding: 20px 5px; background-color: #ffffff">

            <div style="text-align: center; font-size: 16px; margin: 10px">
                <span class="nav-text">
                    <b class="text-light">{{ Auth::user()->Nombres }}, {{ Auth::user()->Apellidos }}</b><br>
                </span>
                <span class="nav-text">
                    <b class="text-light">{{ Auth::user()->Username }}</b><br>
                </span>
                <span class="nav-text">
                    <b class="text-light">{{ Auth::user()->Correo }}</b><br>
                </span>
                <li class="nav-item dropdown" style="margin-top: 20px; margin-bottom: 20px">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Opciones de usuario
                    </a>
                    <ul class="dropdown-menu" style="background-color: #576574;" aria-labelledby="navbarDropdown">
                        <button type="button" id="editarPerfil" class="dropdown-item buttonDropDown"
                                data-bs-toggle="modal" data-bs-target="#modalUsuarios"
                                data-idusuario="{{ Auth::user()->IdUsuario }}"
                                data-nombres="{{ Auth::user()->Nombres }}"
                                data-apellidos="{{ Auth::user()->Apellidos }}"
                                data-telefono="{{ Auth::user()->Telefono }}"
                                data-correo="{{ Auth::user()->Correo }}"><i class="fa fa-user"></i> Editar perfil
                        </button>
                        <button type="button" id="editarContrasenia" class="dropdown-item buttonDropDown"
                                data-bs-toggle="modal" data-bs-target="#modalPassword"><i class="fa-solid fa-passport"></i> Cambiar contraseña
                        </button>
                    </ul>
                </li>
                <hr style="color: white"/>
                <button class="btnHoverColorWhite" style="width: 200px; margin-top: 20px" onclick="Salir()">
                    Cerrar Sesión <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </div>
            <hr style="color: white"/>
            <li>
                <a href="{{ route('home') }}"
                   class="{{ request()->is('home') ? 'active' : '' }} buttonSideBar">
                    <i class="fa fa-home"></i>
                    <span class="nav-text " style="margin-left: 20px">Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('GetEvaluaciones') }}"
                   class="{{ request()->is('Evaluaciones') || request()->is('Evaluacion/*') ? 'active' : '' }} buttonSideBar">
                    <i class="fa fa-bars"></i>
                    <span class="nav-text" style="margin-left: 20px">Evaluación</span>
                </a>
            </li>
            @if(Auth::user()->EsAdmin)
                <li>
                    <a href="{{ route('GetUsuarios') }}"
                       class="{{ request()->is('Usuarios') ? 'active' : '' }} buttonSideBar">
                        <i class="fa fa-users"></i>
                        <span class="nav-text" style="margin-left: 20px">Usuarios</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
    @include('usuario.password')
    @include('usuario.form')
    <div id="page-content-wrapper-oc">
        @yield('content')
    </div>
</div>
</body>
</html>

<script type="text/javascript">
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    function Salir(){
        window.location.href = '{{ url('/logout') }}';
    }
</script>
