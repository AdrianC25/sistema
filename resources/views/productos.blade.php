@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Detalle</th>
                            <th scope="col">Categoria</th>
                            {{-- <th scope="col">Acciones</th> --}}
                            {{-- Modal accion Buttom --}}
                            <th scope="col" class="text-center">
                                <i class="fas fa-plus btn add-producto" data-bs-toggle="modal"
                                    data-bs-target="#agregarProducto" style="color: green;">Agregar Producto</i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->pecio }}</td>
                                <td>{{ $producto->detalle }}</td>
                                <td>{{ $producto->categoria->nombre }}</td>
                                <td class="text-center">
                                    <a href="" data-id="{{ $producto->id }}" class="btn edit-producto">
                                        <i class="fas fa-edit" style="color: darkkhaki"></i>
                                    </a>
                                    <a href="" data-id="{{ $producto->id }}" class="btn delete-producto">
                                        <i class="fas fa-trash-alt" style="color: red"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modals Section -->
    <!-- Modal add Producto -->
    <div class="modal fade" id="agregarProducto" tabindex="-1" aria-labelledby="agregarProductoLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="agregarProductoLabel">Agergar Productos</h1>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombreProductoInput"><b>Nombre Producto</b></label>
                        <input type="text" class=" form-control" id="nombreProductoInput" placeholder="Nombre" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="precioProductoInput"><b>Precio Producto</b></label>
                        <input type="text" class=" form-control" id="precioProductoInput" placeholder="Precio" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="detalleProductoInput"><b>Detalle Producto</b></label>
                        <textarea class="form-control" id="detalleProductoInput" placeholder="Detalle" required></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="categoriaProductoInput"><b>Categoria Producto</b></label>
                        <select class="form-select form-select-sm" aria-label="Small select example"
                            id="categoriaProductoInput">
                            <option selected disabled value="">Seleccione una categoria</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}">
                                    {{ $cat->nombre }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="btn_guardar_producto" class="btn btn-success">Guardar Producto</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar Producto -->
    <div class="modal fade" id="editarProducto" tabindex="-1" aria-labelledby="editarProductoLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editarProductoLabel">Editar Productos</h1>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombreProductoEditarInput"><b>Nombre Producto</b></label>
                        <input type="text" class=" form-control" id="nombreProductoEditarInput" placeholder="Nombre"
                            required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="precioProductoEditarInput"><b>Precio Producto</b></label>
                        <input type="text" class=" form-control" id="precioProductoEditarInput" placeholder="Precio"
                            required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="detalleProductoEditarInput"><b>Detalle Producto</b></label>
                        <input type="text" class=" form-control" id="detalleProductoEditarInput" placeholder="Detalle"
                            required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="categoriaProductoEditarInput"><b>Categoria Producto</b></label>
                        <select class="form-select form-select-sm" aria-label="Small select example"
                            id="categoriaProductoEditarInput">
                            <option selected disabled value="">Seleccione una categoria</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}">
                                    {{ $cat->nombre }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="btn_editar_producto" class="btn btn-success">Guardar Cambios</button>
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

            // crear producto 
            $('#btn_guardar_producto').on('click', function(event) {
                event.preventDefault();

                var nombre = $('#nombreProductoInput').val();
                var precio = $('#precioProductoInput').val();
                var detalle = $('#detalleProductoInput').val();
                var categoria = $('#categoriaProductoInput').val();

                var argumentos = {
                    nombre: nombre,
                    precio: precio,
                    detalle: detalle,
                    categoria: categoria,
                };

                console.log('Variables Obtenidas: ', argumentos);

                $.ajax({
                        url: '{{ url('/productos/add_producto') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: argumentos,
                    })
                    .done(function(respuesta) {
                        console.log('Producto Guardado');
                        console.log(respuesta);
                        $('#agregarProducto').modal('hide');
                        location.reload();
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.log('Error: ', errorThrown);
                        alert('Ha ocurrido un error al intentar guardar. Intenta Nuevamente.');
                    });

            });

            // Modulo editar producto 
            $('.edit-producto').on('click', function(event) {
                event.preventDefault();
                var idProducto = $(this).data('id');
                console.log('editar producto id ' + idProducto);
                $.ajax({
                        url: '/productos/editar_producto/' + idProducto,
                        type: 'GET',
                        dataType: 'json',
                    })
                    .done(function(respuesta) {
                        console.log(respuesta);
                        $('#editarProducto').modal('show');
                        $('#btn_editar_producto').data('id', idProducto);
                        $('#nombreProductoEditarInput').val(respuesta.producto.nombre);
                        $('#precioProductoEditarInput').val(respuesta.producto.pecio);
                        $('#detalleProductoEditarInput').val(respuesta.producto.detalle);
                        $('#categoriaProductoEditarInput').val(respuesta.producto.id_categoria);
                    });

            });

            $('#btn_editar_producto').on('click', function(event) {
                event.preventDefault();
                var idProducto = $(this).data('id');
                var nombre = $('#nombreProductoEditarInput').val();
                var precio = $('#precioProductoEditarInput').val();
                var detalle = $('#detalleProductoEditarInput').val();
                var categoria = $('#categoriaProductoEditarInput').val();

                var argumentos = {
                    id: idProducto,
                    nombre: nombre,
                    precio: precio,
                    detalle: detalle,
                    categoria: categoria,
                }

                console.log('Variables Obtenidas: ', argumentos);

                $.ajax({
                        url: '{{ url('/productos/add_edit_producto/') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: argumentos,
                    })
                    .done(function(respuesta) {
                        console.log('Producto Editado Correctamente');
                        console.log(respuesta);
                        $('#editarProducto').modal('hide');
                        location.reload();
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.log('Error: ', errorThrown);
                        alert('Ha ocurrido un error al intentar editar. Intenta Nuevamente.');
                    });
            });

            // modulo eliminar
            $('.delete-producto').on('click', function(event) {
                event.preventDefault();

                var idProducto = $(this).data('id');
                console.log('id producto: ' + idProducto);
                if (confirm('¿Estas seguro de  eliminar este producto?')) {
                    $.ajax({
                            url: '/productos/eliminar/' + idProducto,
                            type: 'DELETE',
                            dataType: 'json',
                        })
                        .done(function(respuesta) {
                            alert(respuesta.producto);
                            window.location.href = '/productos';
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            console.log('Error: ', errorThrown);
                            alert('Ha ocurrido un error al intentar ELIMINAR. Intenta Nuevamente.');
                        });
                }
            });
        });
    </script>
@endsection
