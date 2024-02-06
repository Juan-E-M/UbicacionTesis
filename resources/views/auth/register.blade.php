<html lang="ES">
<head>
    @vite(['resources/js/app.js'])

    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
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
<body class="body">
<div class="formRegister">
    <div class="modal-content">
        <div style="display:flex;">
            <div class="col-md-6">
                <h3 class="modal-title" id="exampleModalLabel"><b>Registro</b></h3>
            </div>
            <div class="col-md-6" style="text-align: right">
                <a type="button" class="btn btn-light" href="{{ route('login') }}">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <hr style="margin-top: 0; margin-bottom: 10px !important;"/>
        <div class="modal-body">
            <div class="container-fluid">
                <form class="row g-3" method="post" style="margin-bottom: 0" id="formUsuarios">
                    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" id="IdUsuario" name="IdUsuario" value="0">
                    <div class="col-md-6">
                        <label for="Nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="Nombres" name="Nombres"
                               placeholder="Ingresa información">
                    </div>
                    <div class="col-md-6">
                        <label for="Apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="Apellidos" name="Apellidos"
                               placeholder="Ingresa información">
                    </div>
                    <div class="col-md-6" style="margin-bottom: 10px">
                        <label for="Telefono" class="form-label">Teléfono</label>
                        <input type="text"  class="form-control" id="Telefono" name="Telefono"
                               placeholder="Ingresa información">
                    </div>
                    <div class="col-md-6" style="margin-bottom: 10px">
                        <label for="Correo" class="form-label">Correo</label>
                        <input type="email"  class="form-control" id="Correo" name="Correo"
                               placeholder="Ingresa información">
                    </div>
                </form>
            </div>
        </div>
        <h5 class="modal-title" id="exampleModalLabel">Su contraseña se generará usando la primera letra de su nombre y su apellido completo.</h5>
        <hr style="margin-top: 0; margin-bottom: 10px !important;"/>
        <button type="button" class="btn btn-success" onclick="RegistrarUsuario(event)">
            Registar
        </button>
    </div>
</div>
</body>
</html>

<script>
    function RegistrarUsuario(e) {
        const formUsuarios = $("#formUsuarios");
        formUsuarios.validate({
            rules: {
                Nombres : { required: true },
                Apellidos : { required: true },
                Telefono : { required: true },
                Correo : { required: true, email: true },
            },
            messages: {
                Nombres:{
                    required: "El campo es obligatorio."
                },
                Apellidos:{
                    required: "El campo es obligatorio."
                },
                Telefono:{
                    required: "El campo es obligatorio."
                },
                Correo:{
                    required: "El campo es obligatorio.",
                    email: "El campo no tiene el formato correcto."
                }
            }
        });
        // POST
        if (formUsuarios.valid()) {
            e.preventDefault();
            let urlCreate = "{{ route('SaveRegister') }}";
            const araryData = formUsuarios.serializeArray()
            Swal.fire({
                title: "¿Desea continuar el registro de su usuario?",
                showDenyButton: true,
                icon: 'question',
                confirmButtonText: 'Guardar',
                denyButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: urlCreate,
                        async: false,
                        data: araryData,
                        success: function (result) {
                            if (result.success) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: result.message,
                                    showConfirmButton: true
                                });
                                setTimeout(function(){
                                    window.location.href = '{{ route('login') }}';
                                }, 1000);
                            }
                            else{
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: result.message,
                                    showConfirmButton: true
                                })
                            }
                        },
                        error: function(error)  {
                            let mensaje = "";
                            let response = $.parseJSON(error.responseText)
                            if (response.message !== undefined)
                                mensaje = response.message
                            else
                                mensaje = response.errorThrown
                            Swal.fire({icon: 'error', text: mensaje });
                        }
                    });
                }
            });
        }
    }
</script>
