<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo servicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<body style="background-color: #ffffffff;">
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
    <container class="container-sm d-flex justify-content-center mt-5">
        <div class="card">
            <div class="card-body" style="width: 1000px;">
                <h3>Modulo servicio</h3>
                <hr>
                {{-- Mensaje de éxito --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Mensaje de error general --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
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

                <form name="servicio" action="{{ url('/servicio') }}" method="GET">
                    <div class="text-end mb-3">
                        <button type="button" style="background-color:red;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AgregarModal"><i class="fa-solid fa-plus"></i> Nuevo</button>
                    </div>
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search" value="{{ request ('search') }}" placeholder="Buscar por codigo o usuario" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="col-md-6 text-end">
                            <button type="submit" class="btn btn-success edit-btn" style="background-color:red;"><i class="fas fa-search-plus"></i> Buscar</button>
                            <a href="{{ url('/servicio') }}">
                                <button type="button" class="btn btn-success edit-btn" style="background-color:#1c1c1cff"><i class="fas fa-list"></i> Reset</button>
                            </a>
                        </div>
                    </div>

                </form>
                <!--Cuenta los datos-->
                @if($datos->count() > 0)
                            <table class="table table-striped table-hover table-bordered ">
                                    <thead class="table-primary">
                                        <tr>
                                        <th scope="col">Codigo del Servicio</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col">Documento del Usuario</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Dispositivo</th>
                                        <th scope="col">Especificaciones</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Etapa</th>
                                        <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datos as $item)
                                        <tr>
                                            <td>{{$item->ID_Servicio}}</td>
                                            <td>{{$item->Descripcion}}</td>
                                            <td>{{$item->ID_Usuario}}</td>
                                            <td>{{$item->Precio}}</td>
                                            <td>{{$item->Movil_Nombre}}</td>
                                            <td>{{$item->Movil_Especificacion}}</td>
                                            <td>{{$item->Fecha}}</td>
                                            <td>{{$item->Etapa}}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-success edit-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#EditarModal"
                                                    data-id="{{ $item->ID_Servicio }}"
                                                    data-desc="{{ $item->Descripcion }}"
                                                    data-usu="{{ $item->ID_Usuario }}"
                                                    data-precio="{{ $item->Precio }}"
                                                    data-mnombre="{{ $item->Movil_Nombre }}"
                                                    data-mespec="{{ $item->Movil_Especificacion }}"
                                                    data-fecha="{{ $item->Fecha }}"
                                                    data-etapa="{{ $item->Etapa }}"
                                                    style="background-color:red;">
                                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                                </button>
                                                <form action="{{ route('servicio.destroy', $item->ID_Servicio) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button style="background-color:#1c1c1cff;" type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este servicio?')">
                                                        <i class="fa-solid fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                    </tr>
                                        @endforeach
                                    </tbody>
                            </table>

                             <!-- Paginación -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <!-- Botón Anterior -->
                        <li class="page-item {{ $datos->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link"
                               href="{{ $datos->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}">
                                Atras
                            </a>
                        </li>

                        <!-- Números de página -->
                        @for ($i = 1; $i <= $datos->lastPage(); $i++)
                            <li class="page-item {{ $datos->currentPage() == $i ? 'active' : '' }}">
                                <a style="background-color:red;" class="page-link"
                                   href="{{ $datos->url($i) }}{{ request('search') ? '&search=' . request('search') : '' }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor

                        <!-- Botón Siguiente -->
                        <li class="page-item {{ !$datos->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link"
                               href="{{ $datos->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}">
                                Siguiente
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Información de registros -->
                <div class="text-muted mt-2">
                    Mostrando {{ $datos->firstItem() }} a {{ $datos->lastItem() }} de {{ $datos->total() }} registros
                </div>

                @else
                <div class="alert alert-info text-center mt-3">
                    <i class="fas fa-info-circle"></i>
                    @if(request('search'))
                        No se encontraron Servicios con ese tipo de dato "{{ request('search') }}"
                    @else
                        No hay Servicios registrados.
                    @endif
                </div>
                @endif
            </div>
            <!--Modal Agregar -->

            <div class="modal fade" id="AgregarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-user"></i> Crear Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('servicio.store') }}" name="servicio" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="ID_Servicio" class="form-label">Codigo</label>
                        <input type="text" class="form-control" id="ID_Servicio" name="ID_Servicio" placeholder="Digite el Codigo del Servicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="Descripcion" class="form-label">Descripcion</label>
                        <input type="text" class="form-control" id="Descripcion" name="Descripcion" placeholder="Digite la Descripcion" required>
                    </div>
                    <div class="mb-3">
                        <label for="ID_Usuario" class="form-label">Documento del Usuario</label>
                        <input type="text" class="form-control" id="ID_Usuario" name="ID_Usuario" placeholder="Digite el documento" required>
                    </div>
                    <div class="mb-3">
                        <label for="Precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="Precio" name="Precio" placeholder="Digite el Precio" required>
                    </div>
                    <div class="mb-3">
                        <label for="Movil_Nombre" class="form-label">Nombre del Dispositivo</label>
                        <input type="text" class="form-control" id="Movil_Nombre" name="Movil_Nombre" placeholder="Digite el Nombre del Dispositivo" required>
                    </div>
                    <div class="mb-3">
                        <label for="Movil_Especificacion" class="form-label">Especificaciones</label>
                        <input type="text" class="form-control" id="Movil_Especificacion" name="Movil_Especificacion" placeholder="Digite las especificaciones del dispositivo (Color, fallos, etc)" required>
                    </div>
                    <div class="mb-3">
                        <label for="Fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="Fecha" name="Fecha" placeholder="Digite la Fecha" required>
                    </div>
                    <div class="mb-3">
                        <label for="Etapa" class="form-label">Etapa</label>
                        <input type="number" class="form-control" id="Etapa" name="Etapa" placeholder="Digite el porcentaje de la Etapa" required>
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

            <!--Modal Modificar-->
            <div class="modal fade" id="EditarModal" tabindex="-1" aria-labelledby="EditarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditarModalLabel"><i class="fa-solid fa-user-pen"></i> Editar servicio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT') <!-- Muy importante -->
                             <div class="mb-3">
                                <label for="ID_Servicio" class="form-label">Documento</label>
                               <input type="text" class="form-control" id="editID_Servicio" name="ID_Servicio"  readonly>
                    <div class="mb-3">
                        <label for="editDescripcion" class="form-label">Descripcion</label>
                        <input type="text" class="form-control" id="editDescripcion" name="Descripcion" placeholder="Digite la Descripcion" required>
                    </div>
                    <div class="mb-3">
                        <label for="editID_Usuario" class="form-label">Documento del Usuario</label>
                        <input type="text" class="form-control" id="editID_Usuario" name="ID_Usuario" placeholder="Digite el documento" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPrecio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="editPrecio" name="Precio" placeholder="Digite el Precio" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMovil_Nombre" class="form-label">Nombre del Dispositivo</label>
                        <input type="text" class="form-control" id="editMovil_Nombre" name="Movil_Nombre" placeholder="Digite el Nombre del Dispositivo" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMovil_Especificacion" class="form-label">Especificaciones</label>
                        <input type="text" class="form-control" id="editMovil_Especificacion" name="Movil_Especificacion" placeholder="Digite las especificaciones del dispositivo (Color, fallos, etc)" required>
                    </div>
                    <div class="mb-3">
                        <label for="editFecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="editFecha" name="Fecha" placeholder="Digite la Fecha" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEtapa" class="form-label">Etapa</label>
                        <input type="number" class="form-control" id="editEtapa" name="Etapa" placeholder="Digite el porcentaje de la Etapa" required>
                    </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:#1c1c1cff;"><i class="fa-solid fa-right-from-bracket"></i> Cerrar</button>
                                <button type="submit" style="background-color:red;" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>




        </div>
        
    </container>
</body>
</html>
<script>
   var editarModal = document.getElementById('EditarModal');
editarModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;

    var id = button.getAttribute('data-id'); // Documento del cliente
    var desc = button.getAttribute('data-desc');
    var usu = button.getAttribute('data-usu');
    var precio = button.getAttribute('data-precio');
    var mnombre = button.getAttribute('data-mnombre');
    var mespec = button.getAttribute('data-mespec');
    var fecha = button.getAttribute('data-fecha');
    var etapa = button.getAttribute('data-etapa');

    // Llenar modal
    document.getElementById('editID_Servicio').value = id;
    document.getElementById('editDescripcion').value = desc;
    document.getElementById('editID_Usuario').value = usu;
    document.getElementById('editPrecio').value = precio;
    document.getElementById('editMovil_Nombre').value = mnombre;
    document.getElementById('editMovil_Especificacion').value = mespec;
    document.getElementById('editFecha').value = fecha;
    document.getElementById('editEtapa').value = etapa;

    // Cambiar acción del formulario
    var form = document.getElementById('editForm');
    form.action = '/servicio/' + id;
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
            <a href="{{ route('usuario.index') }}" class="btn" style="color:white;">Ir a Usuarios</a><br>
            <a href="{{ route('producto.index') }}" class="btn" style="color:white;">Ir a Productos</a><br>
            <a href="{{ route('historial.index') }}" class="btn" style="color:white;">Ir a Historial de Servicios</a><br>
            <a href="{{ route('servicio.index') }}" class="btn" style="color:white;">Ir a Servicios</a><br>
            <a href="{{ route('categoria.index') }}" class="btn" style="color:white;">Ir a Categoria</a><br>
            <a href="{{ route('chat.index') }}" class="btn" style="color:white;">Ir a Salas de Chat</a>
        </div>
  </div>
</div>