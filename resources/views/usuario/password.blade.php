<div class="modal fade" id="modalPassword" tabindex="-2" aria-labelledby="modalPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header-modal">
                <h5 class="modal-title" id="exampleModalLabel"><b>Actualizar contraseña</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="row g-3" method="post" style="margin-bottom: 0" id="formContrasenia">
                        <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="col-md-12">
                            <label for="Actual" class="form-label">Contraseña actual</label>
                            <input type="password" class="form-control" id="Actual" name="Actual"
                                   placeholder="Ingresa información">
                        </div>
                        <div class="col-md-12">
                            <label for="Nueva" class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" id="Nueva" name="Nueva"
                                   placeholder="Ingresa información">
                        </div>
                        <div class="col-md-12">
                            <label for="Repetir" class="form-label">Confirme la nueva contraseña</label>
                            <input type="password" class="form-control" id="Repetir" name="Repetir"
                                   placeholder="Ingresa información">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background: #e3e3e3 !important">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    Cerrar <i class="fa fa-close"></i>
                </button>
                <button type="button" class="btn btn-success" onclick="GuardarContrtasenia(event)">
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
    function GuardarContrtasenia(e) {
        const formContrasenia = $("#formContrasenia");
        formContrasenia.validate({
            rules: {
                Actual : { required: true },
                Nueva : { required: true },
                Repetir : { required: true },
            },
            messages: {
                Actual:{
                    required: "El campo es obligatorio."
                },
                Nueva:{
                    required: "El campo es obligatorio."
                },
                Repetir:{
                    required: "El campo es obligatorio."
                }
            }
        });
        // POST
        if (formContrasenia.valid()) {
            e.preventDefault();
            let urlChangePassword = "{{ route('UsuariosChangePassword') }}";

            const araryData = formContrasenia.serializeArray()

            Swal.fire({
                title: "¿Desea cambiar la contraseña?",
                showDenyButton: true,
                icon: 'question',
                confirmButtonText: 'Guardar',
                denyButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: urlChangePassword,
                        async: false,
                        data: araryData,
                        success: function (result) {
                            if (result.success) {
                                $('#modalPassword').modal('toggle');
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: result.mensaje,
                                    showConfirmButton: true
                                });
                                setTimeout(function(){
                                    window.location.href = '{{ url('/logout') }}';
                                }, 1000);
                            }
                            else{
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: result.mensaje,
                                    showConfirmButton: true
                                });
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
