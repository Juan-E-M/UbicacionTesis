<form class="row g-3 @if($registro != null and $registro->IdUsuario != Auth::Id()) disabledDiv @endif"
      method="post" style="margin-bottom: 0" id="formRegistro">
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" id="IdRegistro" name="IdRegistro" value="{{  $registro ? $registro->IdRegistro : 0 }}">

    <div class="col-md-6">
        <label for="Nombres" class="form-label">Nombres</label>
        <input type="text" class="form-control" id="Nombres" name="Nombres"
                placeholder="Ingresa información" value="{{$registro ? $registro->Nombres : "" }}">
    </div>
    <div class="col-md-6">
        <label for="Apellidos" class="form-label">Apellidos</label>
        <input type="text" class="form-control" id="Apellidos" name="Apellidos"
                placeholder="Ingresa información" value="{{ $registro ? $registro->Apellidos : "" }}">
    </div>
    <div class="col-md-6">
        <label for="Correo" class="form-label">Correo electrónico</label>
        <input type="text" class="form-control" id="Correo" name="Correo"
                placeholder="Ingresa información" value="{{ $registro ? $registro->Correo : "" }}">
    </div>
    <div class="col-md-6">
        <label for="CarreraProfesional" class="form-label">Carrera Profesional</label>
        <input type="text" class="form-control" id="CarreraProfesional" name="CarreraProfesional"
                placeholder="Ingresa información" value="{{ $registro ? $registro->CarreraProfesional : "" }}">
    </div>
    <div class="col-md-6">
        <label for="Maestria" class="form-label">Maestria</label>
        <input type="text" class="form-control" id="Maestria" name="Maestria"
                placeholder="Ingresa información" value="{{ $registro ? $registro->Maestria : "" }}">
    </div>
    <div class="col-md-6">
        <label for="Doctorado" class="form-label">Doctorado</label>
        <input type="text" class="form-control" id="Doctorado" name="Doctorado"
                placeholder="Ingresa información" value="{{ $registro ? $registro->Doctorado : "" }}">
    </div>
    <div class="col-md-12">
        <label for="Otro" class="form-label">Otro</label>
        <textarea type="text" class="form-control" id="Otro" name="Otro" rows="3"
                  placeholder="Ingresa información">{{ $registro ? $registro->Otro : "" }}</textarea>
    </div>
    <div class="col-md-6">
        <label for="Pais" class="form-label">Pais</label>
        <input type="numeric" class="form-control" id="Pais" name="Pais"
                placeholder="Ingresa información" value="{{ $registro ? $registro->Pais : "" }}">
    </div>
    <div class="col-md-6">
        <label for="Departamento" class="form-label">Departamento</label>
        <input type="text" class="form-control" id="Departamento" name="Departamento"
                  placeholder="Ingresa información" value="{{$registro ? $registro->Departamento : "" }}">
    </div>
    <hr/>
    <div class="modal-footer" style="margin-top: 15px">
        <button type="button" id="guardarInformacion" class="btn btn-success" onclick="GuardarRegistro(event)">
            <i class="fa fa-save"></i> Guardar
        </button>
    </div>
</form>

<script>
    function GuardarRegistro(e) {
        const formRegistro = $("#formRegistro");
        formRegistro.validate({
            rules: {
                Nombres : { required: true },
                Apellidos: { required: true },
                Correo: { required: true, email: true },
                CarreraProfesional : { required: true },
                Pais : { required: true }
            },
            messages: {
                Nombres:{
                    required: "El campo es obligatorio."
                },
                Apellidos:{
                    required: "El campo es obligatorio."
                },
                Correo:{
                    required: "El campo es obligatorio.",
                    email: "El campo no tiene el formato correcto,"
                },
                CarreraProfesional:{
                    required: "El campo es obligatorio."
                },
                Pais:{
                    required: "El campo es obligatorio."
                }
            }
        });
        // POST
        if (formRegistro.valid()) {
            e.preventDefault();
            let IdRegistro = $('#IdRegistro').val();
            let urlPost = '{{route("RegistroUpdate", ':IdRegistro')}}';
            urlPost = urlPost.replace(':IdRegistro', IdRegistro);
            if (IdRegistro === '0') {
                urlPost = '{{ route('RegistroCreate') }}';
            }
            Swal.fire({
                title: "¿Desea guardar los cambios?",
                showDenyButton: true,
                icon: 'question',
                confirmButtonText: 'Guardar',
                denyButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: urlPost,
                        async: false,
                        data: formRegistro.serialize(),
                        success: function (result) {
                            if (result.success) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: result.message,
                                    showConfirmButton: true
                                });
                                let url = '{{ route("GetEvaluacion", ':IdRegistro') }}';
                                url = url.replace(':IdRegistro', result.registro.IdRegistro);
                                setTimeout(function(){
                                    window.location.href = url
                                }, 1000);
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
