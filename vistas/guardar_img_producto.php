<!DOCTYPE html>
<html lang="en">

<head>
    <title> Bootstrap Example </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php require_once('_css.php') ?>
    <?php require_once('_js.php') ?>

</head>

<body>
    <?php //require_once('_nav.php') 

    require_once($_SERVER['DOCUMENT_ROOT'] . '/Modelos/cnx.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_input.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/Modelos/Producto.php');

    try {
        $cnx = new Cnx();
    } catch (PDOException $e) {
        echo 'Error';
        exit;
    }

    $ide = test_input($_REQUEST['ide'] ?? null);

    $producto = Producto::find($cnx, $ide);
    ?>


    <div class="container">
        <h1 class="text-center"> <?php echo  $producto->nombre ?> </h1>

        <?php if ($producto->path_original) : ?>
            <div>
                <img class="rounded mx-auto d-block" style="max-width: 300px;" src="<?php echo BASE_URL . $producto->path_original ?>" alt="" />
                <a href="#" class="btn btn-danger mb-3 mx-auto" onclick="eliminarImagen('img_productos_eliminar.php?ide=<?php echo $producto->id ?>')"> Eliminar imagen </a>
            </div>
        <?php else : ?>
            <form action="../img_productos.php" method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="archivo"> Archivo </label>
                    <input type="file" class="form-control-file" name="archivo" id="archivo">
                </div>
                <input type="hidden" name="ide" value="<?php echo $producto->id ?>">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        <?php endif ?>

    </div>

    <?php require_once('_footer.php') ?>

    <script>
        var imagen_grande = document.getElementById("imagen_grande");

        function mostrarImagen(p_imagen) {
            imagen_grande.src = p_imagen;
            exampleModal.show();
        }

        function eliminarImagen(p_imagen) {

            Swal.fire({
                title: 'Está segura/o?',
                text: "Si elimina este archivo no se podrá recuperar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No, me arrepentí!',
                confirmButtonText: 'Sí, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //Lo que sucede cuando le da click al botón aceptar.
                    location.href = p_imagen;
                }
            });

        }
    </script>

</body>

</html>