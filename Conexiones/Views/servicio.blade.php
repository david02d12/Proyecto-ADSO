<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo Servicios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/fontawesome.min.css" integrity="sha512-M5Kq4YVQrjg5c2wsZSn27Dkfm/2ALfxmun0vUE3mPiJyK53hQBHYCVAtvMYEC7ZXmYLg8DVG4tF8gD27WmDbsg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <container class="container-sm d-flex justify-content-center mt-5">
        <div class="card">
            <div class="card-body" style="width: 1200px;">
                <h3>Modulo Servicios</h3>
                <hr>
                <form name="cliente" action="" method="post">
                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Nuevo</button>
                    </div>
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Buscar</span>
                                <input type="text" class="form-control" placeholder="Buscar por nombre o documento" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="col-md-6 text-end">
                            <button type="button" class="btn btn-info"><i class="fas fa-search-plus"></i> Buscar</button>
                            <button type="button" class="btn btn-warning"><i class="fas fa-list"></i> Reset</button>
                        </div>
                    </div>

                </form>

                <table class="table table-striped table-hover table-bordered ">
                        <thead class="table-primary">
                            <tr>
                            <th scope="col">Codigo Servicio</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Codigo Usuario</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Nombre del Movil</th>
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
                                <td>{{$item->Movil_Especificaciones}}</td>
                                <td>{{$item->Fecha}}</td>
                                <td>{{$item->Etapa}}</td>
                                
                                <td>
                                    <button type="button" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                                    <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Eliminar</button>
                                </td>
                           </tr>
                            @endforeach
                        </tbody>
                </table>
                <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
                </nav>
            </div>
        </div>
    </container>
</body>
</html>