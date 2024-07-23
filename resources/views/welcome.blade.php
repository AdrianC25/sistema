@extends('layouts.app')
@section('content')
    <div class="container">
        <i class="fas fa-plus btn add-categoria" data-bs-toggle="modal" data-bs-target="#agregarCategoria"
            style="color: green;">Agregar Nueva Categoria</i>
        <div class="row">
            @foreach ($categorias as $categoria)
                <div class="col-md-3">
                    <div class="card my-4">
                        <div class="card-title">
                            <h2 class="text-capitalize text-center">
                                {{ $loop->iteration }} </h2>
                        </div>
                        <div class="card-body">
                            <h4 class="text-capitalize">{{ $categoria->nombre }}</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="" data-id="{{ $categoria->id }}" class="btn edit-categoria">
                                        <i class="fas fa-edit" style="color: darkkhaki;"></i>
                                    </a>
                                    <a href="" data-id="{{ $categoria->id }}" class="btn delete-categoria">
                                        <i class="fas fa-trash-alt" style="color: red;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modals Section -->
    <!-- Modal add Categoria -->
    <div class="modal fade" id="agregarCategoria" tabindex="-1" aria-labelledby="agregarCategoriaLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="agregarCategoriaLabel">Agergar Categoria</h1>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombreCategoriaInput"><b>Nombre Categoria</b></label>
                        <input type="text" class=" form-control" id="nombreCategoriaInput" placeholder="Nombre" required>
                        <div id="nombreCategoriaError" style="color: red; display: none;">
                            <i class="fas fa-times-circle"></i> Campo vacío
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn_guardar_categoria" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal edit Producto -->
    <div class="modal fade" id="editarCategoria" tabindex="-1" aria-labelledby="editarCategoriaLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editarCategoriaLabel">Editar Categotia</h1>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombreCategoriaEditarInput"><b>Nombre Categoria</b></label>
                        <input type="text" class=" form-control" id="nombreCategoriaEditarInput" placeholder="Nombre"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btn_editar_categoria" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <script>
        // coneccion con ajax 
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log('Ready to Work');
            // crear categoria
            $('#btn_guardar_categoria').on('click', function(event) {
                event.preventDefault();

                var nombre = $('#nombreCategoriaInput').val().trim();

                var argumento = {
                    nombre: nombre,
                };
                console.log('Variables Obtenidas: ', argumento);

                if (nombre === ""){
                    $('#nombreCategoriaInput').css({
                        'border-color':'red',
                        'background-color': '#f8d7da'
                    });
                    $('#nombreCategoriaError').css('display', 'block');
                }
    
                $.ajax({
                        url: '{{ url('welcome/add_categoria') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: argumento,
                    })
                    .done(function(respuesta) {
                        console.log('Categoria Guardada');
                        console.log(respuesta);
                        $('#agregarCategoria').modal('hide');
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Se ha Guardado con Exito",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(()=>{
                            location.reload();
                        });
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.log('Error: ', errorThrown);
                        Swal.fire({
                            icon: "error",
                            title: "Error al Guardar",
                            text: "Ha ocurrido un error al Intentar Añadir. Intenta Nuevamente"
                        });
                    });
            });

            // Modulo editar categoria 
            $('.edit-categoria').on('click', function(event) {
                event.preventDefault();
                var idCategoria = $(this).data('id');
                console.log('editar categoria id ' + idCategoria);
                $.ajax({
                        url: '/welcome/editar_categoria/' + idCategoria,
                        type: 'GET',
                        dataType: 'json',
                    })
                    .done(function(respuesta) {
                        console.log(respuesta);
                        $('#editarCategoria').modal('show');
                        $('#btn_editar_categoria').data('id', idCategoria);
                        $('#nombreCategoriaEditarInput').val(respuesta.categoria.nombre);
                    });

            });

            $('#btn_editar_categoria').on('click', function(event) {
                event.preventDefault();
                var idCategoria = $(this).data('id');
                var nombre = $('#nombreCategoriaEditarInput').val();

                var argumentos = {
                    id: idCategoria,
                    nombre: nombre,
                }

                console.log('Variables Obtenidas: ', argumentos);



                $.ajax({
                        url: '{{ url('/welcome/add_edit_categoria/') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: argumentos,
                    })
                    .done(function(respuesta) {
                        console.log('Categoria Editada Correctamente');
                        console.log(respuesta);
                        $('#editarCategoria').modal('hide');
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Se ha Editado con Exito",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(()=>{
                            location.reload();
                        });
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.log('Error: ', errorThrown);
                        Swal.fire({
                            icon: "error",
                            title: "Error al Guardar",
                            text: "Ha ocurrido un error al Intentar Editar. Intenta Nuevamente"
                        });
                    });
            });

            // modulo eliminar
            $('.delete-categoria').on('click', function(event) {
                event.preventDefault();

                var idCategoria = $(this).data('id');
                console.log('id categoria: ' + idCategoria);

                Swal.fire({
                    title: "¿Estas Seguro de Eliminar esta Categoria?",
                    text: "¡Esto no se podrá revertir!",
                    icon: "warning",
                    showCancelButton: true,
                    color: "#716add",
                    background: "#000",
                    confirmButtonColor: "#32a852",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, Eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                                url: '/welcome/eliminar/' + idCategoria,
                                type: 'DELETE',
                                dataType: 'json',
                            })
                            .done(function(respuesta) {
                                Swal.fire({
                                    title: "¡Categoria Eliminada!",
                                    text: "Tu categoria ha sido eliminada.",
                                    icon: "success",
                                    color: "#716add",
                                    background: "#000"
                                }).then(() => {
                                    window.location.href = '/';
                                });
                            })
                            .fail(function(jqXHR, textStatus, errorThrown) {
                                console.log('Error: ', errorThrown);
                                Swal.fire({
                                    title: "Error",
                                    text: "Ha ocurrido un error al intentar eliminar. Intenta Nuevamente",
                                    icon: "error",
                                    color: "#716add",
                                    background: "#000"
                                });
                            });
                    }
                });
            });

        }); //fin funcion
    </script>
@endsection
