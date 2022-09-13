<!DOCTYPE html>
<html lang="en">

<head>
    <title> Iniciar sesión </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



</head>

<body>



    <div class="container">

        <h1 class="text-center"> Iniciar sesión </h1>


        <div class="alert alert-danger"> </div>


        <form action="login.php" method="post">
            <div class="form-group mb-3">
                <label for="email"> Email </label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingrese su correo electrónico">
            </div>
            <div class="form-group mb-3">
                <label for="contrasena"> Contraseña </label>
                <input type="password" class="form-control" name="contrasena" id="contrasena">
            </div>
            <button type="submit" class="btn btn-success mb-3"> Enviar </button>
        </form>

    </div>


</body>

</html>