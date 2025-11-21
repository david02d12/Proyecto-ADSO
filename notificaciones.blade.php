<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Notificaciones</title>
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
                <h3>Módulo Notificaciones 🔔</h3>
                <hr>

                {{-- Mensaje de éxito (session('success')) --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Errores de validación ($errors->any()) --}}
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
                <form action="{{ route('notificaciones.index') }}" method="GET">
                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AgregarModal"><i class="fa-solid fa-bell-circle-plus"></i> Nueva Notificación</button>
                    </div>
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por Código o Tipo de Notificación">
                            </div>
                        </div>

                        <div class="col-md-6 text-end">
                            <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                            <a href="{{ route('notificaciones.index') }}">
                                <button type="button" class="btn btn-warning"><i class="fas fa-list"></i> Reset</button>
                            </a>
                        </div>
                    </div>
                </form>

                {{-- Tabla de Datos --}}
                @if($datos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered ">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">Código Notificación</th>
                                    <th scope="col">Tipo de Notificación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datos as $item)
                                    <tr>
                                        <td>{{$item->Codigo_Notificaciones}}</td>
                                        <td>{{$item->Tipo_Notificacion}}</td>
                                        <td>
                                            {{-- Botón Editar (Modal) --}}
                                            <button
                                                type="button"
                                                class="btn btn-success edit-btn btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#EditarModal"
                                                data-codigo="{{ $item->Codigo_Notificaciones }}"
                                                data-tipo="{{ $item->Tipo_Notificacion }}"
                                                >
                                                <i class="fa-solid fa-pen-to-square"></i> Editar
                                            </button>

                                            {{-- Formulario Eliminar --}}
                                            <form action="{{ route('notificaciones.destroy', $item->Codigo_Notificaciones) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar el tipo de notificación: {{ $item->Tipo_Notificacion }}?')">
                                                    <i class="fa-solid fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación --}}
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            {{ $datos->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                        </ul>
                    </nav>

                    <div class="text-muted mt-2">
                        Mostrando {{ $datos->firstItem() }} a {{ $datos->lastItem() }} de {{ $datos->total() }} registros
                    </div>

                @else
                    {{-- Mensaje de No Resultados --}}
                    <div class="alert alert-info text-center mt-3">
                        <i class="fas fa-info-circle"></i>
                        @if(request('search'))
                            No se encontraron notificaciones con el término "{{ request('search') }}"
                        @else
                            No hay notificaciones registradas.
                        @endif
                    </div>
                @endif
            </div>
            
            {{-- MODAL PARA AGREGAR NOTIFICACIÓN --}}
            <div class="modal fade" id="AgregarModal" tabindex="-1" aria-labelledby="AgregarModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AgregarModalLabel"><i class="fa-solid fa-bell-circle-plus"></i> Registrar Notificación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('notificaciones.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="Codigo_Notificaciones" class="form-label">Código Notificación</label>
                                <input type="number" class="form-control" id="Codigo_Notificaciones" name="Codigo_Notificaciones" value="{{ old('Codigo_Notificaciones') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="Tipo_Notificacion" class="form-label">Tipo de Notificación</label>
                                <input type="text" class="form-control" id="Tipo_Notificacion" name="Tipo_Notificacion" value="{{ old('Tipo_Notificacion') }}" required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-right-from-bracket"></i> Cerrar</button>
                                <button type="Submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar Notificación</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MODAL PARA EDITAR NOTIFICACIÓN --}}
            <div class="modal fade" id="EditarModal" tabindex="-1" aria-labelledby="EditarModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="EditarModalLabel"><i class="fa-solid fa-bell-pen"></i> Editar Notificación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST">
                                @csrf
                                @method('PUT') 
                                
                                <div class="mb-3">
                                    <label for="editCodigo_Notificaciones" class="form-label">Código Notificación</label>
                                    {{-- El Código_Notificaciones es la clave primaria, lo hacemos de solo lectura --}}
                                    <input type="text" class="form-control" id="editCodigo_Notificaciones" name="Codigo_Notificaciones" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editTipo_Notificacion" class="form-label">Tipo de Notificación</label>
                                    <input type="text" class="form-control" id="editTipo_Notificacion" name="Tipo_Notificacion" required>
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
                
                // Obtener datos de la notificación usando data-*
                var codigo = button.getAttribute('data-codigo');
                var tipo = button.getAttribute('data-tipo');

                // Llenar campos del modal de edición
                document.getElementById('editCodigo_Notificaciones').value = codigo;
                document.getElementById('editTipo_Notificacion').value = tipo;

                // Establecer la acción del formulario de edición (Apuntando a la ruta de actualización)
                var form = document.getElementById('editForm');
                // Esto construye la URL: /notificaciones/{Codigo_Notificaciones}
                form.action = '{{ url('notificaciones') }}/' + codigo; 
            });

            // Lógica para reabrir modal en caso de error de validación
            // Si hay errores de validación, reabrir el modal de agregar automáticamente.
            // Para el modal de edición, el controlador debe redirigir con un parámetro de error para reabrirlo.
            @if ($errors->any() && !old('Codigo_Notificaciones') && !old('Tipo_Notificacion'))
                // Si hay errores, pero no hay datos old() (es decir, el error es del modal de edición)
                // Esto es una simplificación, lo ideal es pasar el ID del elemento que se intentó editar.
                // Como workaround, si hay errores y no viene de 'store', podríamos asumir que es 'update'
            @elseif ($errors->any())
                // Si hay errores (asumimos que provienen del formulario de 'store' si 'old()' existe)
                var agregarModal = new bootstrap.Modal(document.getElementById('AgregarModal'));
                agregarModal.show();
            @endif
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
            <a href="{{ route('comentarios.index') }}" class="btn" style="color:white;">Ir Comentarios</a><br>
            <a href="{{ route('servicio.index') }}" class="btn" style="color:white;">Ir Servicio</a><br>
            <a href="{{ route('notificaciones.index') }}" class="btn" style="color:white;">Ir Notificaciones</a><br>
            <a href="{{ route('historial.index') }}" class="btn" style="color:white;">Ir Historial</a><br>
            <a href="{{ route('chat.index') }}" class="btn" style="color:white;">Ir chat</a><br>
            <a href="{{ route('categoria.index') }}" class="btn" style="color:white;">Ir Categoria</a><br>
           
        </div>
  </div>
</div>


