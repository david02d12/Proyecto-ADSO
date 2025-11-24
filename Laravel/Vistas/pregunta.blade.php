<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo de Preguntas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<body style="background-color: #ffffffff;">
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
        <h1 style="color: white;">Celuaccel - Módulo de Preguntas</h1>
      </div>
    </div>
  </div>
</nav>
    <div class="container-sm d-flex justify-content-center mt-5">
        <div class="card">
            <div class="card-body" style="width: 1200px;">
                <h3>Gestión de Preguntas</h3>
                <hr>
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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
                
                <form action="{{ url('/pregunta') }}" method="GET">
                    <div class="text-end mb-3">
                        <button type="button" style="background-color:red;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AgregarModal"><i class="fa-solid fa-plus"></i> Nueva Pregunta</button>
                    </div>
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search" value="{{ request ('search') }}" placeholder="Buscar por código, usuario, fecha o pregunta" aria-label="Buscar" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="submit" class="btn btn-success" style="background-color:red;"><i class="fas fa-search-plus"></i> Buscar</button>
                            <a href="{{ url('/pregunta') }}">
                                <button type="button" class="btn btn-success" style="background-color:#1c1c1cff"><i class="fas fa-list"></i> Resetear</button>
                            </a>
                        </div>
                    </div>
                </form>
                
                @if($datos->count() > 0)
                    <table class="table table-striped table-hover table-bordered ">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">ID Consulta</th>
                                <th scope="col">Cód. Producto</th>
                                <th scope="col">ID Usuario</th>
                                <th scope="col">Pregunta</th>
                                <th scope="col">Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $item)
                            <tr>
                                <td>{{ $item->ID_Consulta }}</td>
                                <td>{{ $item->Codigo_Producto }}</td>
                                <td>{{ $item->ID_Usuario }}</td>
                                <td>{{ Str::limit($item->Pregunta, 50) }}</td> {{-- Usamos Str::limit para preguntas largas --}}
                                <td>{{ $item->Fecha }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-success edit-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#EditarModal"
                                        data-id-consulta="{{ $item->ID_Consulta }}"
                                        data-codigo-producto="{{ $item->Codigo_Producto }}"
                                        data-id-usuario="{{ $item->ID_Usuario }}"
                                        data-fecha="{{ $item->Fecha }}"
                                        data-pregunta="{{ $item->Pregunta }}"
                                        style="background-color:red;">
                                        <i class="fa-solid fa-pen-to-square"></i> Editar
                                    </button>
                                    <form action="{{ route('pregunta.destroy', $item->ID_Consulta) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button style="background-color:#1c1c1cff;" type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta Pregunta?')">
                                            <i class="fa-solid fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item {{ $datos->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $datos->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}">
                                    Atrás
                                </a>
                            </li>

                            @for ($i = 1; $i <= $datos->lastPage(); $i++)
                                <li class="page-item {{ $datos->currentPage() == $i ? 'active' : '' }}">
                                    <a style="background-color:red;" class="page-link"
                                        href="{{ $datos->url($i) }}{{ request('search') ? '&search=' . request('search') : '' }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor

                            <li class="page-item {{ !$datos->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $datos->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}">
                                    Siguiente
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <div class="text-muted mt-2">
                        Mostrando {{ $datos->firstItem() }} a {{ $datos->lastItem() }} de {{ $datos->total() }} registros
                    </div>

                @else
                    <div class="alert alert-info text-center mt-3">
                        <i class="fas fa-info-circle"></i>
                        @if(request('search'))
                            No se encontraron preguntas con ese tipo de dato "{{ request('search') }}"
                        @else
                            No hay preguntas registradas.
                        @endif
                    </div>
                @endif
            </div>

            <div class="modal fade" id="AgregarModal" tabindex="-1" aria-labelledby="AgregarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AgregarModalLabel"><i class="fa-solid fa-plus-circle"></i> Crear Pregunta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('pregunta.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="ID_Consulta" class="form-label">ID Consulta</label>
                                    <input type="text" class="form-control" id="ID_Consulta" name="ID_Consulta" placeholder="Digite el ID de la Consulta (debe ser único)" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Codigo_Producto" class="form-label">Código del Producto</label>
                                    <input type="number" class="form-control" id="Codigo_Producto" name="Codigo_Producto" placeholder="Digite el Código del Producto" required>
                                </div>
                                <div class="mb-3">
                                    <label for="ID_Usuario" class="form-label">ID del Usuario</label>
                                    <input type="number" class="form-control" id="ID_Usuario" name="ID_Usuario" placeholder="Digite el ID del Usuario" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Fecha" class="form-label">Fecha (Formato numérico, por ejemplo timestamp)</label>
                                    <input type="number" class="form-control" id="Fecha" name="Fecha" placeholder="Digite la Fecha (numérico)" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Pregunta" class="form-label">Pregunta</label>
                                    <textarea class="form-control" id="Pregunta" name="Pregunta" rows="3" placeholder="Escriba la pregunta" required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:#1c1c1cff;"><i class="fa-solid fa-right-from-bracket"></i> Cerrar</button>
                                    <button type="Submit" style="background-color:red;" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
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
                            <h5 class="modal-title" id="EditarModalLabel"><i class="fa-solid fa-pen-to-square"></i> Editar Pregunta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST">
                                @csrf
                                @method('PUT') 
                                <div class="mb-3">
                                    <label for="editID_Consulta" class="form-label">ID Consulta</label>
                                    {{-- ID_Consulta es la llave primaria, se marca como readonly --}}
                                    <input type="text" class="form-control" id="editID_Consulta" name="ID_Consulta" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="editCodigo_Producto" class="form-label">Código del Producto</label>
                                    <input type="number" class="form-control" id="editCodigo_Producto" name="Codigo_Producto" placeholder="Digite el Código del Producto" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editID_Usuario" class="form-label">ID del Usuario</label>
                                    {{-- El campo ID_Usuario no está en la validación de update, pero lo incluimos para el formulario --}}
                                    <input type="number" class="form-control" id="editID_Usuario" name="ID_Usuario" placeholder="Digite el ID del Usuario" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editFecha" class="form-label">Fecha (Formato numérico, por ejemplo timestamp)</label>
                                    <input type="number" class="form-control" id="editFecha" name="Fecha" placeholder="Digite la Fecha (numérico)" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editPregunta" class="form-label">Pregunta</label>
                                    <textarea class="form-control" id="editPregunta" name="Pregunta" rows="3" placeholder="Escriba la pregunta" required></textarea>
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
</body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editarModal = document.getElementById('EditarModal');
        editarModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;

            // Obtener los datos del botón
            var idConsulta = button.getAttribute('data-id-consulta');
            var codigoProducto = button.getAttribute('data-codigo-producto');
            var idUsuario = button.getAttribute('data-id-usuario');
            var fecha = button.getAttribute('data-fecha');
            var pregunta = button.getAttribute('data-pregunta');

            // Llenar el formulario del modal de edición
            document.getElementById('editID_Consulta').value = idConsulta;
            document.getElementById('editCodigo_Producto').value = codigoProducto;
            document.getElementById('editID_Usuario').value = idUsuario;
            document.getElementById('editFecha').value = fecha;
            document.getElementById('editPregunta').value = pregunta;

            // Cambiar la acción del formulario al endpoint de update del recurso
            var form = document.getElementById('editForm');
            // La ruta es 'pregunta/{ID_Consulta}'
            form.action = '{{ url('pregunta') }}/' + idConsulta;
        });
    });
</script>


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

