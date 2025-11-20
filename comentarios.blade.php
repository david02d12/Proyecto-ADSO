<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Comentarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
                <h3>Módulo Comentarios 💬</h3>
                <hr>

                {{-- Mensaje de éxito --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Errores de validacion --}}
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
                <form action="{{ route('comentarios.index') }}" method="GET">
                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AgregarModal"><i class="fa-solid fa-comment-medical"></i> Nuevo Comentario</button>
                    </div>
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por Código o Comentario">
                            </div>
                        </div>

                        <div class="col-md-6 text-end">
                            <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                            <a href="{{ route('comentarios.index') }}">
                                <button type="button" class="btn btn-warning"><i class="fas fa-list"></i> Reset</button>
                            </a>
                        </div>
                    </div>
                </form>

                @if($datos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered ">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">Código Comentario</th>
                                    <th scope="col">Comentario</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">ID Usuario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datos as $item)
                                    <tr>
                                        <td>{{$item->Codigo_Comentario}}</td>
                                        <td>{{ Str::limit($item->Comentario, 50) }}</td>
                                        <td>{{$item->Fecha_Comentario}}</td>
                                        <td>{{$item->ID_Usuario}}</td>
                                        <td>
                                            {{-- Botón Editar (Modal) --}}
                                            <button
                                                type="button"
                                                class="btn btn-success edit-btn btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#EditarModal"
                                                data-Codigo="{{ $item->Codigo_Comentario }}"
                                                data-Comentario="{{ $item->Comentario }}"
                                                data-Fecha="{{ $item->Fecha_Comentario }}"
                                                data-ID_Usuario="{{ $item->ID_Usuario }}"
                                                >
                                                <i class="fa-solid fa-pen-to-square"></i> Editar
                                            </button>

                                            {{-- Formulario Eliminar --}}
                                            <form action="{{ route('comentarios.destroy', $item->Codigo_Comentario) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar el comentario #{{ $item->Codigo_Comentario }}?')">
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
                            No se encontraron comentarios con el término "{{ request('search') }}"
                        @else
                            No hay comentarios registrados.
                        @endif
                    </div>
                @endif
            </div>

            {{--- MODAL PARA AGREGAR COMENTARIO ---}}
            <div class="modal fade" id="AgregarModal" tabindex="-1" aria-labelledby="AgregarModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AgregarModalLabel"><i class="fa-solid fa-comment-medical"></i> Registrar Comentario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{-- Nota: El controlador espera ID_Comentario, ID_Usuario, Comentario y Fecha_Comentario --}}
                            <form action="{{ route('comentarios.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="ID_Comentario" class="form-label">Código/ID Comentario</label>
                                <input type="number" class="form-control" id="ID_Comentario" name="ID_Comentario" value="{{ old('ID_Comentario') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="ID_Usuario" class="form-label">ID Usuario</label>
                                {{-- Asumiendo que el ID de usuario es un número entero --}}
                                <input type="number" class="form-control" id="ID_Usuario" name="ID_Usuario" value="{{ old('ID_Usuario') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="Comentario" class="form-label">Comentario</label>
                                <textarea class="form-control" id="Comentario" name="Comentario" rows="3" required>{{ old('Comentario') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="Fecha_Comentario" class="form-label">Fecha Comentario</label>
                                {{-- Se usa tipo text para poder usar el formato YYYY-MM-DD y sea compatible --}}
                                <input type="date" class="form-control" id="Fecha_Comentario" name="Fecha_Comentario" value="{{ old('Fecha_Comentario', date('Y-m-d')) }}" required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-right-from-bracket"></i> Cerrar</button>
                                <button type="Submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar Comentario</button>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{--- MODAL PARA EDITAR COMENTARIO ---}}
            <div class="modal fade" id="EditarModal" tabindex="-1" aria-labelledby="EditarModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="EditarModalLabel"><i class="fa-solid fa-comment-dots"></i> Editar Comentario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST">
                                @csrf
                                @method('PUT') 
                                
                                <div class="mb-3">
                                    <label for="editID_Comentario" class="form-label">Código Comentario</label>
                                    {{-- El Código_Comentario es la clave primaria, lo hacemos de solo lectura --}}
                                    <input type="text" class="form-control" id="editID_Comentario" name="Codigo_Comentario" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editID_Usuario" class="form-label">ID Usuario</label>
                                    <input type="number" class="form-control" id="editID_Usuario" name="ID_Usuario" required>
                                </div>

                                <div class="mb-3">
                                    <label for="editComentario" class="form-label">Comentario</label>
                                    <textarea class="form-control" id="editComentario" name="Comentario" rows="3" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editFecha_Comentario" class="form-label">Fecha Comentario</label>
                                    {{-- Se usa tipo date --}}
                                    <input type="date" class="form-control" id="editFecha_Comentario" name="Fecha_Comentario" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-right-from-bracket"></i> Cerrar</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar Cambios</button>
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
                
                // Obtener datos del comentario
                var codigo = button.getAttribute('data-codigo');
                var comentario = button.getAttribute('data-comentario');
                var fecha = button.getAttribute('data-fecha');
                var idusuario = button.getAttribute('data-idusuario');

                // Llenar campos del modal de edición
                document.getElementById('editID_Comentario').value = codigo;
                document.getElementById('editComentario').value = comentario;
                document.getElementById('editID_Usuario').value = idusuario;
                
                // Formatear la fecha para el input type="date" (YYYY-MM-DD)
                // Tu controlador devuelve 'Fehca_Comentario', si el formato no es estándar, 
                // podría necesitar un tratamiento adicional, aquí asumo un formato compatible o que Laravel lo maneja.
                // Si el formato es 'YYYY-MM-DD' funcionará directamente.
                document.getElementById('editFecha_Comentario').value = fecha;

                // Establecer la acción del formulario de edición
                var form = document.getElementById('editForm');
                // Asegúrate de que tu ruta web tenga el nombre 'comentarios.update' y espere el parámetro {Codigo_Comentario}
                form.action = '{{ url('Comentario') }}/' + codigo; 
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
            <a href="{{ route('usuario.index') }}" class="btn" style="color:white;">Ir a Usuarios</a><br>
            <a href="{{ route('producto.index') }}" class="btn" style="color:white;">Ir a Productos</a><br>
            <a href="{{ route('comentarios.index') }}" class="btn" style="color:white;">Ir comentarios</a><br>
           
        </div>
  </div>
</div>

