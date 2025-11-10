<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<body>
    <container class="container-sm d-flex justify-content-center mt-5">
        <div class="card">
            <div class="card-body" style="width: 1200px;">
                <h3>Modulo Usuario</h3>
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

                <form name="usuario" action="{{ url('/usuario') }}" method="GET">
                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AgregarModal"><i class="fa-solid fa-plus"></i> Nuevo</button>
                    </div>
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" name="search" value="{{ request ('search') }}" placeholder="Buscar por nombre o documento" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="col-md-6 text-end">
                            <button type="submit" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                            <a href="{{ url('/usuario') }}">
                                <button type="button" class="btn btn-warning"><i class="fas fa-list"></i> Reset</button>
                            </a>
                        </div>
                    </div>

                </form>
                <!--Cuenta los datos-->
                @if($datos->count() > 0)
                            <table class="table table-striped table-hover table-bordered ">
                                    <thead class="table-primary">
                                        <tr>
                                        <th scope="col">Documento</th>
                                        <th scope="col">Tipo Documento</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Fecha de Nacimiento</th>
                                        <th scope="col">Dirección</th>
                                        <th scope="col">Teléfono</th>
                                        <th scope="col">Correo</th>
                                        <th scope="col">Contraseña</th>
                                        <th scope="col">Codigo de rol</th>
                                        <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datos as $item)
                                        <tr>
                                            <td>{{$item->ID_Usuario}}</td>
                                            <td>{{$item->Codigo_Documento}}</td>
                                            <td>{{$item->Nombre}}</td>
                                            <td>{{$item->Fecha_Nacimiento}}</td>
                                            <td>{{$item->Direccion}}</td>
                                            <td>{{$item->Telefono}}</td>
                                            <td>{{$item->Correo}}</td>
                                            <td>{{$item->Contraseña}}</td>
                                            <td>{{$item->Codigo_Rol}}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-success edit-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#EditarModal"
                                                    data-id="{{ $item->ID_Usuario }}"
                                                    data-tipo="{{ $item->Codigo_Documento }}"
                                                    data-nombre="{{ $item->Nombre }}"
                                                    data-fecha="{{ $item->Fecha_Nacimiento }}"
                                                    data-direccion="{{ $item->Direccion }}"
                                                    data-telefono="{{ $item->Telefono }}"
                                                    data-correo="{{ $item->Correo }}"
                                                    data-contraseña="{{ $item->Contraseña }}"
                                                    data-rol="{{ $item->Codigo_Rol }}">
                                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                                </button>
                                                <form action="{{ route('usuario.destroy', $item->ID_Usuario) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
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
                                <a class="page-link"
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
                        No se encontraron Proveedores con ese tipo de dato "{{ request('search') }}"
                    @else
                        No hay Proveedores registrados.
                    @endif
                </div>
                @endif
            </div>
            <!--Modal Agregar -->

            <div class="modal fade" id="AgregarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-user"></i> Crear Cuenta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('usuario.store') }}" name="usuario" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="ID_Usuario" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="ID_Usuario" name="ID_Usuario" placeholder="Digite el Documento" required>
                    </div>
                    <div class="mb-3">
                        <select class="form-select " id="Codigo_Documento" name="Codigo_Documento" aria-label="form-select-sm example">
                            <option selected>[ Seleccione el Tipo de Documento ]</option>
                            <option value=2>Cedula de Ciudadania</option>
                            <option value=1>Tarjeta de Identidad</option>
                            <option value=3>Pasaporte</option>
                            <option value=4>NIT</option>
                            <option value=5>PEP</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="Nombre" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Digite el Nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="Fecha_Nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="Fecha_Nacimiento" name="Fecha_Nacimiento" placeholder="Digite la Fecha de Nacimiento" required>
                    </div>
                    <div class="mb-3">
                        <label for="Direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="Direccion" name="Direccion" placeholder="Digite la Dirección" required>
                    </div>
                    <div class="mb-3">
                        <label for="Telefono" class="form-label">Telefóno</label>
                        <input type="number" class="form-control" id="Telefono" name="Telefono" placeholder="Digite el Telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="Correo" class="form-label">Correo Electronico</label>
                        <input type="email" class="form-control" id="Correo" name="Correo" placeholder="Digite el Correo Electronico" required>
                    </div>
                    <div class="mb-3">
                        <label for="Contraseña" class="form-label">Contraseña</label>
                        <input type="text" class="form-control" id="Contraseña" name="Contraseña" placeholder="Digite la Contraseña" required>
                    </div>
                    <div class="mb-3">
                        <select class="form-select " id="Codigo_Rol" name="Codigo_Rol" aria-label="form-select-sm example">
                            <option selected>[ Seleccione el Rol ]</option>
                            <option value=2>Cliente</option>
                            <option value=1>Administrador</option>
                            <option value=3>Tecnico</option>
                        </select>
                    </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-right-from-bracket"></i> Cerrar</button>
                        <button type="Submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
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
                        <h5 class="modal-title" id="EditarModalLabel"><i class="fa-solid fa-user-pen"></i> Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT') <!-- Muy importante -->
                             <div class="mb-3">
                                <label for="ID_Usuario" class="form-label">Documento</label>
                               <input type="text" class="form-control" id="editID_Usuario" name="ID_Usuario"  readonly>

                            </div>
                            <div class="mb-3">
                                <label for="editCodigo_Documento" class="form-label">Tipo Documento</label>
                                <select class="form-select" id="editCodigo_Documento" name="Codigo_Documento" required>
                                    <option value="2">Cedula de Ciudadania</option>
                                    <option value="1">Tarjeta de Identidad</option>
                                    <option value="3">Pasaporte</option>
                                    <option value="4">NIT</option>
                                    <option value="5">PEP</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editNombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editNombre" name="Nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="editFecha_Nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="editFecha_Nacimiento" name="Fecha_Nacimiento" required>
                            </div>
                            <div class="mb-3">
                                <label for="editDireccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="editDireccion" name="Direccion" required>
                            </div>
                            <div class="mb-3">
                                <label for="editTelefono" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" id="editTelefono" name="Telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="editCorreo" class="form-label">Correo Electronico</label>
                                <input type="email" class="form-control" id="editCorreo" name="Correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="editContraseña" class="form-label">Contraseña</label>
                                <input type="text" class="form-control" id="editContraseña" name="Contraseña" required>
                            </div>
                            <div class="mb-3">
                                <label for="editCodigo_Rol" class="form-label">Tipo Documento</label>
                                <select class="form-select" id="editCodigo_Rol" name="Codigo_Rol" required>
                                    <option value="1">Cedula de Ciudadania</option>
                                    <option value="2">Tarjeta de Identidad</option>
                                    <option value="3">Pasaporte</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-right-from-bracket"></i> Close</button>
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
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
    var tipo = button.getAttribute('data-tipo');
    var nombre = button.getAttribute('data-nombre');
    var fecha = button.getAttribute('data-fecha');
    var direccion = button.getAttribute('data-direccion');
    var telefono = button.getAttribute('data-telefono');
    var correo = button.getAttribute('data-correo');
    var contraseña = button.getAttribute('data-contraseña');
    var rol = button.getAttribute('data-rol');

    // Llenar modal
    document.getElementById('editID_Usuario').value = id;
    document.getElementById('editCodigo_Documento').value = tipo;
    document.getElementById('editNombre').value = nombre;
    document.getElementById('editFecha_Nacimiento').value = fecha;
    document.getElementById('editDireccion').value = direccion;
    document.getElementById('editTelefono').value = telefono;
    document.getElementById('editCorreo').value = correo;
    document.getElementById('editContraseña').value = contraseña;
    document.getElementById('editCodigo_Rol').value = rol;

    // Cambiar acción del formulario
    var form = document.getElementById('editForm');
    form.action = '/usuario/' + id;
});

</script>
