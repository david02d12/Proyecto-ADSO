<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo Inicio</title>
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
        <a href="{{ route('index') }}" style="text-decoration: none;font-size:35px;color: white;">Celuaccel</a>
      </div>
    </div>
  </div>
</nav>
<center>
  <h1>Catalogo de Productos</h1>
  <h6>Conoce los últimos accesorios que ofrecemos.</h6>
<div  class="card"  style="width:200px">
  <img>[Archivo]</img>
</div>
</center>
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