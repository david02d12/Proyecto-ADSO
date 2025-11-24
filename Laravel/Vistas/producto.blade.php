<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Producto</title>
    {{-- Incluye Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    {{-- Incluye Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <!--Barra de navegacion de arriba-->
<nav class="navbar navbar-expand-lg" style="background-color: #d20000ff;">
  <div class="container-fluid">
    <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="outline: none; box-shadow: none; border-color: transparent;background-color: #1c1c1cff">
      <i class="fa-solid fa-bars"></i>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <h1 style="color: white;">Celuaccel</h1>
      </div>
    </div>
  </div>
</nav>
    <div class="container-sm d-flex justify-content-center mt-5">
        <div class="card">
            <div class="card-body" style="width: 1200px;">
                <h3>Módulo Producto</h3>
                <hr>

                {{-- Mensaje de éxito --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Errores de validación --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fa-solid fa-circle-xmark"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Formulario de Búsqueda y Botón Nuevo --}}
                <form action="{{ route('producto.index') }}" method="GET">
                    <div class="text-end mb-3">
                        <button type="button" style="background-color:red;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AgregarModal"><i class="fa-solid fa-plus"></i> Nuevo</button>
                    </div>
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por Código, Nombre o Descripción">
                            </div>
                        </div>

                        <div class="col-md-6 text-end">
                            <button type="submit" class="btn btn-success edit-btn" style="background-color:red;"><i class="fas fa-search-plus"></i> Buscar</button>
                            <a href="{{ route('producto.index') }}">
                                <button type="button" class="btn btn-success edit-btn" style="background-color:#1c1c1cff"><i class="fas fa-list"></i> Reset</button>
                            </a>
                        </div>
                    </div>
                </form>

                @if($datos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered ">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Cant.</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Catálogo</th>
                                    <th scope="col">Categoría</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datos as $item)
                                    <tr>
                                        <td>{{$item->Codigo_Producto}}</td>
                                        <td>{{$item->Nombre}}</td>
                                        <td>{{$item->Cantidad}}</td>
                                        <td>${{ number_format($item->Precio, 2) }}</td>
                                        <td>{{ Str::limit($item->Descripcion, 30) }}</td>
                                        <td>{{ Str::limit($item->Imagen, 15) }}</td>
                                        <td>{{ $item->Activo_Catalogo }}</td>
                                        <td>{{$item->ID_Categoria}}</td>
                                        <td>
                                            {{-- Botón Editar (Modal) --}}
                                            <button
                                                type="button"
                                                class="btn btn-success edit-btn btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#EditarModal"
                                                data-id="{{ $item->Codigo_Producto }}"
                                                data-cantidad="{{ $item->Cantidad }}"
                                                data-nombre="{{ $item->Nombre }}"
                                                data-precio="{{ $item->Precio }}"
                                                data-descripcion="{{ $item->Descripcion }}"
                                                data-imagen="{{ $item->Imagen }}"
                                                data-activo="{{ $item->Activo_Catalogo }}"
                                                data-categoria="{{ $item->ID_Categoria }}"
                                                style="background-color:red;">
                                                <i class="fa-solid fa-pen-to-square"></i> Editar
                                            </button>

                                            {{-- Formulario Eliminar --}}
                                            <form action="{{ route('producto.destroy', $item->Codigo_Producto) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button style="background-color:#1c1c1cff;" type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar el producto {{ $item->Nombre }}?')">
                                                    <i class="fa-solid fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            {{-- Aquí puedes usar la función integrada links() de Laravel que es más simple --}}
                            {{ $datos->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                        </ul>
                    </nav>

                    <div class="text-muted mt-2">
                        Mostrando {{ $datos->firstItem() }} a {{ $datos->lastItem() }} de {{ $datos->total() }} registros
                    </div>

                @else
                    <div class="alert alert-info text-center mt-3">
                        <i class="fas fa-info-circle"></i>
                        @if(request('search'))
                            No se encontraron productos con el término "{{ request('search') }}"
                        @else
                            No hay productos registrados.
                        @endif
                    </div>
                @endif
            </div>

            <div class="modal fade" id="AgregarModal" tabindex="-1" aria-labelledby="AgregarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AgregarModalLabel"><i class="fa-solid fa-box"></i> Registrar Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('producto.store') }}" method="POST">
                            @csrf
                           
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Codigo_Producto" class="form-label">Código Producto</label>
                                    <input type="text" class="form-control" id="Codigo_Producto" name="Codigo_Producto" value="{{ old('Codigo_Producto') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="Nombre" name="Nombre" value="{{ old('Nombre') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Cantidad" class="form-label">Cantidad</label>
                                    <input type="number" class="form-control" id="Cantidad" name="Cantidad" value="{{ old('Cantidad') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Precio" class="form-label">Precio</label>
                                    <input type="number" step="0.01" class="form-control" id="Precio" name="Precio" value="{{ old('Precio') }}" required>
                                </div>
                            </div>
                           
                            <div class="mb-3">
                                <label for="Descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="Descripcion" name="Descripcion" rows="3" required>{{ old('Descripcion') }}</textarea>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="Imagen" class="form-label">Ruta de Imagen</label>
                                    <input type="text" class="form-control" id="Imagen" name="Imagen" value="{{ old('Imagen') }}" required>
                                </div>
                            <div class="mb-3">
                                <label for="Activo_Catalogo" class="form-label">Activo en Catálogo</label>
                                <select class="form-select" id="Activo_Catalogo" name="Activo_Catalogo" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ID_Categoria" class="form-label">ID Categoría</label>
                                    <input type="number" class="form-control" id="ID_Categoria" name="ID_Categoria" value="{{ old('ID_Categoria') }}" required>
                                </div>
                            </div>
                           


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:#1c1c1cff;"><i class="fa-solid fa-right-from-bracket"></i> Cerrar</button>
                                <button type="Submit" style="background-color:red;" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar Producto</button>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="EditarModal" tabindex="-1" aria-labelledby="EditarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="EditarModalLabel"><i class="fa-solid fa-box-open"></i> Editar Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST">
                                @csrf
                                @method('PUT') <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editCodigo_Producto" class="form-label">Código Producto</label>
                                        {{-- El Código_Producto es la clave primaria, lo hacemos de solo lectura --}}
                                        <input type="text" class="form-control" id="editCodigo_Producto" name="Codigo_Producto" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editNombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="editNombre" name="Nombre" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editCantidad" class="form-label">Cantidad</label>
                                        <input type="number" class="form-control" id="editCantidad" name="Cantidad" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editPrecio" class="form-label">Precio</label>
                                        <input type="number" step="0.01" class="form-control" id="editPrecio" name="Precio" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="editDescripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="editDescripcion" name="Descripcion" rows="3" required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editImagen" class="form-label">Ruta de Imagen</label>
                                        <input type="text" class="form-control" id="editImagen" name="Imagen" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editID_Categoria" class="form-label">ID Categoría</label>
                                        <input type="number" class="form-control" id="editID_Categoria" name="ID_Categoria" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="editActivo_Catalogo" class="form-label">Activo en Catálogo</label>
                                    <select class="form-select" id="editActivo_Catalogo" name="Activo_Catalogo" required>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:#1c1c1cff;"><i class="fa-solid fa-right-from-bracket"></i> Cerrar</button>
                                    <button type="submit" style="background-color:red;" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    {{-- Incluye Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
   
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editarModal = document.getElementById('EditarModal');
            editarModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
               
                // Obtener datos del producto
                var id = button.getAttribute('data-codigo');
                var cantidad = button.getAttribute('data-cantidad');
                var nombre = button.getAttribute('data-nombre');
                var precio = button.getAttribute('data-precio');
                var descripcion = button.getAttribute('data-descripcion');
                var imagen = button.getAttribute('data-imagen');
                var activo = button.getAttribute('data-activo');
                var categoria = button.getAttribute('data-categoria');

                // Llenar campos del modal de edición
                document.getElementById('editCodigo_Producto').value = id;
                document.getElementById('editCantidad').value = cantidad;
                document.getElementById('editNombre').value = nombre;
                document.getElementById('editPrecio').value = precio;
                document.getElementById('editDescripcion').value = descripcion;
                document.getElementById('editImagen').value = imagen;
                document.getElementById('editActivo_Catalogo').value = activo;
                   // Seleccionar opción
                document.getElementById('editID_Categoria').value = categoria;

                var form = document.getElementById('editForm');
                form.action = '{{ url('producto') }}/' + id;
            });
        });

    </script>
</body>
</html>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="background-color:#1c1c1cff">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" style="color:white;" id="offcanvasExampleLabel">Menú</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
        <div class="container mt-5">
            <h1 style="color:white;">Seleccione un Modulo</h1>
            <a href="{{ route('categoria.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-icons"></i> Ir a Categoria</a><br>
            <a href="{{ route('chat.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-comment"></i> Ir a Chat</a><br>
            <a href="{{ route('comentarios.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-comment-dots"></i> Ir a Comentarios</a><br>
            <a href="{{ route('historial.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-clock"></i> Ir a Historial de Servicios</a><br>
            <a href="{{ route('mensajes.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-comment"></i> Ir a Mensajes</a><br>
            <a href="{{ route('notificaciones.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-alarm-clock"></i> Ir a Notificaciones</a><br>
            <a href="{{ route('pregunta.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-magnifying-glass"></i> Ir a Pregunta</a><br>
            <a href="{{ route('producto.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-cart-shopping"></i> Ir a Producto</a><br>
            <a href="{{ route('roles.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-circle-user"></i> Ir a Roles</a><br>
            <a href="{{ route('servicio.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-briefcase"></i> Ir a Servicios</a><br>
            <a href="{{ route('tipo.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-address-book"></i> Ir a Tipos de Documento</a><br>
            <a href="{{ route('usuario.index') }}" class="btn" style="color:white;"><i class="fa-solid fa-users"></i> Ir a Usuarios</a><br>
        </div>
  </div>
</div> 