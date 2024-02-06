<div class="modal fade" id="modalUsuarios" tabindex="-1" aria-labelledby="modalUsuariosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header-modal">
                <h5 id="tituloUsuario" class="modal-title" style="display: inline"><b>Crear nuevo usuario</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="row g-3" method="post" style="margin-bottom: 0" id="formUsuarios">
                        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" id="IdUsuario" name="IdUsuario" value="0">
                        <div class="col-md-6">
                            <label for="Nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="Nombres" name="Nombres"
                                   placeholder="Ingresa información" >
                        </div>
                        <div class="col-md-6">
                            <label for="Apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="Apellidos" name="Apellidos"
                                   placeholder="Ingresa información" >
                        </div>
                        <div class="col-md-6">
                            <label for="Telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="Telefono" name="Telefono"
                                   placeholder="Ingresa información" >
                        </div>
                        <div class="col-md-6" style="margin-bottom: 10px">
                            <label for="Correo" class="form-label">Correo</label>
                            <input type="email"  class="form-control" id="Correo" name="Correo"
                                   placeholder="Ingresa información" >
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background: #e3e3e3 !important">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    Cerrar <i class="fa fa-close"></i>
                </button>
                <button type="button" class="btn btn-success" onclick="GuardarUsuario(event)">
                    Guardar <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-header-modal {
        padding:9px 15px;
        border-bottom:1px solid #2ecc71;
        color: #fff;
        background: linear-gradient(#2ecc71, #069937);
        -webkit-border-top-left-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        -moz-border-radius-topleft: 5px;
        -moz-border-radius-topright: 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: space-between;
    }
</style>

<script>
    function GuardarUsuario(e) {
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
            let IdUsuario = $('#IdUsuario').val();
            let urlCreate = "{{ route('UsuariosCreate') }}";
            let urlUpdate = "{{ route('UsuariosUpdate', ['IdUsuario'=>':IdUsuario']) }}";
            urlUpdate = urlUpdate.replace(':IdUsuario', $('#IdUsuario').val());

            const araryData = formUsuarios.serializeArray()

            Swal.fire({
                title: "¿Desea guardar el usuario?",
                showDenyButton: true,
                icon: 'question',
                confirmButtonText: 'Guardar',
                denyButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: IdUsuario == 0? urlCreate : urlUpdate,
                        async: false,
                        data: araryData,
                        success: function (result) {
                            if (result.success) {
                                $('#modalUsuarios').modal('toggle');
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
    }

    $('#modalUsuarios').on('shown.bs.modal', function (e) {
        let IdUsuario  = $(e.relatedTarget).data('idusuario').toString();
        let Nombres = $(e.relatedTarget).data('nombres');
        let Apellidos = $(e.relatedTarget).data('apellidos');
        let Telefono = $(e.relatedTarget).data('telefono');
        let Correo = $(e.relatedTarget).data('correo');

        $(e.currentTarget).find('input[id="IdUsuario"]').val(IdUsuario);
        if (IdUsuario !== '0') {
            $(e.currentTarget).find('input[id="Nombres"]').val(Nombres);
            $(e.currentTarget).find('input[id="Apellidos"]').val(Apellidos);
            $(e.currentTarget).find('input[id="Telefono"]').val(Telefono);
            $(e.currentTarget).find('input[id="Correo"]').val(Correo);
            $(e.currentTarget).find('h5[id="tituloUsuario"]')[0].innerHTML = "<b>Actualizar información de usuario</b>";
        }
        else {
            $(e.currentTarget).find('h5[id="tituloUsuario"]')[0].innerHTML = "<b>Registrar usuario</b>";
        }
    })

    $('#modalUsuarios').on('hidden.bs.modal', function (e) {
        $(e.currentTarget).find('input[id="IdUsuario"]').val("0");
        $(e.currentTarget).find('input[id="Nombres"]').val("");
        $(e.currentTarget).find('input[id="Apellidos"]').val("");
        $(e.currentTarget).find('input[id="Telefono"]').val("");
        $(e.currentTarget).find('input[id="Correo"]').val("");
        $(e.currentTarget).find('h5[id="tituloUsuario"]')[0].innerHTML = "";
    })
</script>
