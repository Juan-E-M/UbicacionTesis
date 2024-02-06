@extends('layouts.app')

@section('content')
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    <div class="content-grid">
        <div class="card" style="height: 100%">
            <div class="modal-content" style="height: 100%">
                <div class="modal-header-grid">
                    <h3 class="modal-title">Mis <b>Evaluaciones</b></h3>
                    <a type="button" class="btn btn-light" href="{{ route('GetEvaluacion', ['IdRegistro' => 0]) }}">
                        <i class="fa fa-plus-square"></i> Nueva evaluación
                    </a>
                </div>
                <div class="modal-body" style="height: 100%; padding: 15px; overflow-y: scroll">
                    <table class="table table-hover" id="tableEvaluaciones" style="margin-top: 5px">
                        <thead style="background: #525252; color: #fff">
                        <tr>
                            <th scope="col">Número</th>
                            <th scope="col">Nombres y Apellidos</th>
                            <th scope="col">Correo electrónico</th>
                            <th scope="col">Carrera Profesional</th>
                            <th scope="col">Maestria</th>
                            <th scope="col">Doctorado</th>
                            <th scope="col">Otro</th>
                            <th scope="col">Pais</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Opciones</th>
                        </tr>
                        </thead>
                        <tbody style="overflow-y: scroll !important;">
                            @foreach($evaluaciones as $evaluacion)
                                <tr>
                                    <td>{{ $evaluacion->IdRegistro }}</td>
                                    <td>{{ $evaluacion->Nombres }}, {{ $evaluacion->Apellidos }}</td>
                                    <td>{{ $evaluacion->Correo }}</td>
                                    <td>{{ $evaluacion->CarreraProfesional }}</td>
                                    <td>{{ $evaluacion->Maestria }}</td>
                                    <td>{{ $evaluacion->Doctorado }}</td>
                                    <td>{{ $evaluacion->Otro }}</td>
                                    <td>{{ $evaluacion->Pais }}</td>
                                    <td>{{ $evaluacion->Departamento }}</td>
                                    <td>
                                        <a href="{{ route('GetEvaluacion', ['IdRegistro' => $evaluacion->IdRegistro]) }}"
                                           class="btn btn-primary">
                                            <i class="fa fa-pencil" data-toggle="tooltip" title="Edit"></i> Editar
                                        </a>
                                        <button onclick="EliminarEvaluacion({{ $evaluacion->IdRegistro }})" id="btnEliminar"
                                                class="btn btn-danger">
                                            <i class="fa fa-trash" data-toggle="tooltip" title="Eliminar"></i> Eliminar
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

    <style>
        .modal-header-grid {
            padding: 9px 15px;
            border-bottom: 1px solid #273c75;
            color: #fff;
            background: linear-gradient(#273c75, #192a56);
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
            $('#tableEvaluaciones').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay evaluaciones para mostrar",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Evaluaciones",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total evaluaciones)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Evaluaciones",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar: ",
                    "zeroRecords": "Sin evaluaciones encontrados",
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
        function EliminarEvaluacion(IdRegistro){
            let url = '{{route("RegistroDelete", ':IdRegistro')}}';
            url = url.replace(':IdRegistro', IdRegistro);
            Swal.fire({
                icon: 'question',
                title: '¿Desea eliminar la evaluación?',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "POST",
                        async: false,
                        cache: false,
                        url: url,
                        data: {
                            _token: $("#_token").val()
                        },
                        success: function (data) {
                            if (data.success){
                                Swal.fire({icon: 'success', text: data.message});
                                setTimeout(function(){
                                    window.location.reload();
                                }, 1000);
                            }
                            else
                                Swal.fire({icon: 'error', text: data.message});

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
                    })
                }
            })
        }
    </script>
@endsection
