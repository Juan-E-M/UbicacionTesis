<form class="row g-3 @if($registro->IdUsuario != Auth::Id()) disabledDiv @endif"
    method="post" style="margin-bottom: 0" id="formTema">
    <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
    <input type="hidden" id="IdRegistro" name="IdRegistro" value="{{ $registro->IdRegistro }}">
    <input type="hidden" id="IdTema" name="IdTema" value="{{ $tema ? $tema->IdTema : "0" }}">

    <div class="col-md-6">
        <label for="CursoGustado" class="form-label">¿Qué curso le gusto más?</label>
        <textarea class="form-control" id="CursoGustado" name="CursoGustado" rows="2"
                placeholder="Ingresa información">{{ $tema ? $tema->CursoGustado : "" }}</textarea>
    </div>
    <div class="col-md-6">
        <label for="DondeTrabaja" class="form-label">¿Dónde trabaja?</label>
        <textarea class="form-control" id="DondeTrabaja" name="DondeTrabaja" rows="2"
                placeholder="Ingresa información">{{ $tema ? $tema->DondeTrabaja : "" }}</textarea>
    </div>
    <div class="col-md-6">
        <label for="DondeQuiereTrabaja" class="form-label">¿Dónde quisiera trabajar?</label>
        <textarea class="form-control" id="DondeQuiereTrabaja" name="DondeQuiereTrabaja" rows="2"
                  placeholder="Ingresa información">{{ $tema ? $tema->DondeQuiereTrabaja : "" }}</textarea>
    </div>
    <div class="col-md-6">
        <label for="PorqueDeseasGrado" class="form-label">¿Para qué deseas el grado o título?</label>
        <textarea class="form-control" id="PorqueDeseasGrado" name="PorqueDeseasGrado" rows="2"
                  placeholder="Ingresa información">{{ $tema ? $tema->PorqueDeseasGrado : "" }}</textarea>
    </div>
    <div class="col-md-12">
        <label for="PorqueDeseasGrado" class="form-label">Con los resultados anteriores, ingrese palabras que pueden vincularse, por ejemplo:</label>
    </div>
    <div class="col-md-6">
        <div class="alert alert-light" role="alert">
            <ul class="list-group">
                <li class="list-group-item list-group-item-secondary">OCDE 1</li>
                <li class="list-group-item">2.1 Biología Molecular: bioprocesos</li>
                <li class="list-group-item">2.2 Aun no trabajo</li>
                <li class="list-group-item">2.3 Laboratorio de investigación agrícola</li>
                <li class="list-group-item">2.4 Laborar</li>
                <li class="list-group-item">
                    Temas de bioprocesos en mejora genética de productos agrícolas
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert alert-light" role="alert">
            <ul class="list-group">
                <li class="list-group-item list-group-item-secondary">OCDE 2</li>
                <li class="list-group-item">2.1 Producción: análisis de producción</li>
                <li class="list-group-item">2.2 En una industria alimenticia</li>
                <li class="list-group-item">2.3 En la misma industria alimenticia, pero que sea más grande</li>
                <li class="list-group-item">2.4 Para mejorar mi industria alimenticia</li>
                <li class="list-group-item">Temas de aplicación en su industria, con sustento en análisis de producción: Ishikawa, SIPOC, DAP, DOP</li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert alert-light" role="alert">
            <ul class="list-group">
                <li class="list-group-item list-group-item-secondary">OCDE 3</li>
                <li class="list-group-item">2.1 Anatomía: fractura</li>
                <li class="list-group-item">2.2 IPRESS</li>
                <li class="list-group-item">2.3 Ejercer la labor</li>
                <li class="list-group-item">Temas sobre prevención, método de curación, recuperación, estado emocional</li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert alert-light" role="alert">
            <ul class="list-group">
                <li class="list-group-item list-group-item-secondary">OCDE 4</li>
                <li class="list-group-item">2.1 Riesgo: uso de Ozono</li>
                <li class="list-group-item">2.2 Aun no trabajo</li>
                <li class="list-group-item">2.3 Fundo agrícola</li>
                <li class="list-group-item">2.4 Conseguir trabajo</li>
                <li class="list-group-item">Temas sobre el ozono en la preparación, sembrío, producción y cosecha en un producto determinado</li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert alert-light" role="alert">
            <ul class="list-group">
                <li class="list-group-item list-group-item-secondary">OCDE 5</li>
                <li class="list-group-item">2.1 Economía: microeconomía</li>
                <li class="list-group-item">2.2 Aun no trabajo</li>
                <li class="list-group-item">2.3 Oficina pública</li>
                <li class="list-group-item">2.4 Continuar estudios</li>
                <li class="list-group-item">Temas de microeconomía vinculados a un tema público, como impuestos, tributos y que puedan dar la línea de posgrado</li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert alert-light" role="alert">
            <ul class="list-group">
                <li class="list-group-item list-group-item-secondary">OCDE 6</li>
                <li class="list-group-item">2.1 Arquitectura: urbanismo</li>
                <li class="list-group-item">2.2 Independiente</li>
                <li class="list-group-item">2.3 Poder ejercer la profesión</li>
                <li class="list-group-item">Temas optimización de espacios en tiny house</li>
            </ul>
        </div>
    </div>

    <div class="col-md-6">
        <label for="Tiempo" class="form-label">Califica el tiempo que consideras aplicar a tu tesis</label>
        <select class="form-select" id="Tiempo" name="Tiempo">
            <option value="" selected>-- Seleccione --</option>
            <option value="-3" @if($tema and $tema->Tiempo == -3) selected @endif>03 meses</option>
            <option value="-2" @if($tema and $tema->Tiempo == -2) selected @endif>06 meses</option>
            <option value="-1" @if($tema and $tema->Tiempo == -1) selected @endif>09 meses</option>
            <option value="0" @if($tema and $tema->Tiempo == 0) selected @endif>12 meses</option>
            <option value="1" @if($tema and $tema->Tiempo == 1) selected @endif>15 meses</option>
            <option value="2" @if($tema and $tema->Tiempo == 2) selected @endif>18 meses</option>
            <option value="3" @if($tema and $tema->Tiempo == 3) selected @endif>24 meses</option>
        </select>
    </div>

    <div class="col-md-6">
        <label for="Requerimientos" class="form-label">Califica el acceso a requerimientos materiales - presupuesto que consideras tendrá tu tesis</label>
        <select class="form-select" id="Requerimientos" name="Requerimientos">
            <option value="" selected>-- Seleccione --</option>
            <option value="-3" @if($tema and $tema->Requerimientos == -3) selected @endif>25% de lo mínimo que se necesita</option>
            <option value="-2" @if($tema and $tema->Requerimientos == -2) selected @endif>50% de lo mínimo que se necesita</option>
            <option value="-1" @if($tema and $tema->Requerimientos == -1) selected @endif>75% de lo mínimo que se necesita</option>
            <option value="0" @if($tema and $tema->Requerimientos == 0) selected @endif>100% de lo mínimo que se necesita</option>
            <option value="1" @if($tema and $tema->Requerimientos == 1) selected @endif>125% de lo mínimo que se necesita</option>
            <option value="2" @if($tema and $tema->Requerimientos == 2) selected @endif>150% de lo mínimo que se necesita</option>
            <option value="3" @if($tema and $tema->Requerimientos == 3) selected @endif>175% de lo mínimo que se necesita</option>
        </select>
    </div>
    <hr/>
    <div class="modal-footer" style="margin-top: 15px">
        <button type="button" id="guardarInformacion" class="btn btn-success" onclick="GuardarTema(event)">
            <i class="fa fa-save"></i> Guardar
        </button>
    </div>
</form>

<script>
    function GuardarTema(e) {
        const formTema = $("#formTema");
        formTema.validate({
            rules: {
                CursoGustado : { required: true },
                DondeTrabaja: { required: true },
                DondeQuiereTrabaja: { required: true },
                PorqueDeseasGrado: { required: true },
                Tiempo: { required: true },
                Requerimientos : { required: true }
            },
            messages: {
                CursoGustado:{
                    required: "El campo es obligatorio."
                },
                DondeTrabaja:{
                    required: "El campo es obligatorio."
                },
                DondeQuiereTrabaja:{
                    required: "El campo es obligatorio."
                },
                PorqueDeseasGrado:{
                    required: "El campo es obligatorio."
                },
                Tiempo:{
                    required: "El campo es obligatorio."
                },
                Requerimientos:{
                    required: "El campo es obligatorio."
                }
            }
        });
        // POST
        if (formTema.valid()) {
            e.preventDefault();
            let IdTema = $('#IdTema').val();
            let urlPost = '{{route("TemaUpdate", ':IdTema')}}';
            urlPost = urlPost.replace(':IdTema', IdTema);
            if (IdTema === '0') {
                urlPost = '{{ route('TemaCreate') }}';
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
                        data: formTema.serialize(),
                        success: function (result) {
                            if (result.success) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: result.message,
                                    showConfirmButton: true
                                });
                                let url = '{{ route("GetTema", ':IdRegistro') }}';
                                url = url.replace(':IdRegistro', result.registro.IdRegistro);
                                setTimeout(function(){
                                    $.get(url, function(response){
                                        $('#detalle').html(response);
                                    });
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
