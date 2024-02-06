@extends('layouts.app')

@section('content')
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    <div class="content-grid">
        <div class="card" style="height: 100%">
            <div class="modal-content" style="height: 100%">
                <div class="modal-header-grid">
                    <h3 class="modal-title">Lista de <b>Usuarios</b></h3>
                    <button type="button" id="agregarUsuario" class="btn btn-light"
                            data-bs-toggle="modal" data-bs-target="#modalUsuarios" data-idusuario="0">
                        <i class="fa fa-plus-square"></i> Agregar
                    </button>
                </div>
                <div class="modal-body" style="height: 100%; padding: 15px; overflow-y: scroll">
                    <table class="table table-hover" id="tableUsuarios" style="margin-top: 5px">
                        <thead style="background: #525252; color: #fff">
                            <tr>
                                <th scope="col">Nombres y Apellidos</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody style="overflow-y: scroll !important;">
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->Nombres }} {{ $usuario->Apellidos }}</td>
                                    <td>{{ $usuario->Username }}</td>
                                    <td>{{ $usuario->Telefono }}</td>
                                    <td>{{ $usuario->Correo }}</td>
                                    <td>{{ $usuario->EsAdmin? 'Administrador':'Usuario' }}</td>
                                    <td>{{ $usuario->EsVerificado? 'Activo':'Inactivo' }}</td>
                                    <td>
                                        <button type="button" id="editarUsuario" class="btn btn-primary" style="margin-top: 10px"
                                                data-bs-toggle="modal" data-bs-target="#modalUsuarios"
                                                data-idusuario="{{ $usuario->IdUsuario }}"
                                                data-nombres="{{ $usuario->Nombres }}"
                                                data-apellidos="{{ $usuario->Apellidos }}"
                                                data-telefono="{{ $usuario->Telefono }}"
                                                data-correo="{{ $usuario->Correo }}">
                                            <i class="fa fa-pencil"></i> Editar
                                        </button>
                                        <button onclick="EliminarUsuario(event, {{ $usuario->IdUsuario }})"
                                                class="btn btn-danger" data-toggle="modal" style="margin-top: 10px">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </button>
                                        <button onclick="VerificarUsuario(event, {{ $usuario->IdUsuario }})"
                                                class="btn btn-warning" data-toggle="modal" style="margin-top: 10px">
                                            <i class="fa fa-check"></i> Validar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('usuario.form')

    <style>
        .modal-header-grid {
            padding: 9px 15px;
            border-bottom:1px solid #2ecc71;
            color: #fff;
            background: linear-gradient(#2ecc71, #069937);
            -webkit-border-top-left-radius: 3px;
            -webkit-border-top-right-radius: 3px;
            -moz-border-radius-topleft: 3px;
            -moz-border-radius-topright: 3px;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: space-between;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#tableUsuarios').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay usuarios para mostrar",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total usuarios)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Usuarios",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar: ",
                    "zeroRecords": "Sin usuarios encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                scrollY: '625px',
                scrollCollapse: true,
            });
        } );

        function EliminarUsuario(e, IdUsuario) {
            e.preventDefault();
            let urlDelete = "{{ route('UsuariosDelete', ':IdUsuario') }}";
            urlDelete = urlDelete.replace(':IdUsuario', IdUsuario);

            Swal.fire({
                title: "¿Desea eliminar el usuario?",
                showDenyButton: true,
                icon: 'question',
                confirmButtonText: 'Aceptar',
                denyButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: urlDelete,
                        data: {_token: $('#_token').val()},
                        async: false,
                        success: function (result) {
                            if (result.success) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: result.mensaje,
                                    showConfirmButton: true
                                });
                                setTimeout(function(){
                                    window.location.href = '{{ route('GetUsuarios') }}';
                                }, 1000);
                            }
                            else{
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: result.mensaje,
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

        function VerificarUsuario(e, IdUsuario) {
            e.preventDefault();
            let urlDelete = "{{ route('UsuariosVerificate', ':IdUsuario') }}";
            urlDelete = urlDelete.replace(':IdUsuario', IdUsuario);

            Swal.fire({
                title: "¿Desea realizar la validación el usuario?",
                showDenyButton: true,
                icon: 'question',
                confirmButtonText: 'Aceptar',
                denyButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: urlDelete,
                        data: { _token: $('#_token').val() },
                        async: false,
                        success: function (result) {
                            if (result.success) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: result.mensaje,
                                    showConfirmButton: true
                                });
                                setTimeout(function(){
                                    window.location.href = '{{ route('GetUsuarios') }}';
                                }, 1000);
                            }
                            else{
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: result.mensaje,
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
    </script>
@endsection
