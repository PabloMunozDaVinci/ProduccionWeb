<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/_autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Modelos/cnx.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Modelos/Producto.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_input.php');

if (!Auth::isAdministrador()) {
    header('Location: login.php');
}

try {
    $cnx = new Cnx();
} catch (PDOException $e) {
    echo 'Error';
    exit;
}

$ide = test_input($_REQUEST['ide'] ?? null);

$producto = Producto::find($cnx, $ide);
echo var_dump($producto);

$error = null;

//Si el producto no existe, lo redireccionamos al panel.
if (!$producto) {
    header('Location: productos.php');
}

//Crea carpeta por año y mes si no existe.
$anio = date('Y');
$mes = date('m');
$directorio_original = "images/productos/{$anio}/{$mes}/originales";
$directorio_editado = "images/productos/{$anio}/{$mes}/editadas";

if (!is_dir("images/productos/{$anio}/{$mes}")) {
    mkdir($directorio_original, 077, true);
    mkdir($directorio_editado, 077, true);
}

if (isset($_FILES['archivo']) and $_FILES['archivo']['error'] == 0) {

    require_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/achicar_imagen.php');

    $info = pathinfo($_FILES['archivo']['name']);
    $extension = $info['extension']; //Extensión del archivo.
    $nombre_archivo = $info['filename']; //Nombre del archivo sin extensión.

    //Sólo permite caracteres alfanuméricos.
    $nombre_archivo = preg_replace("/[^A-Za-z0-9]/", '', $nombre_archivo);

    $time = time();

    //Extensiones permitidas.
    $extensiones_permitidas = array('jpg', 'png', 'gif');

    //Valida una extensión.
    if (in_array($extension, $extensiones_permitidas)) {

        $origen = $_FILES['archivo']['tmp_name'];

        $path_original = "{$directorio_original}/{$nombre_archivo}_{$time}.{$extension}";
        $path_editado = "{$directorio_editado}/{$nombre_archivo}_{$time}.{$extension}";

        if (move_uploaded_file($origen, $path_original)) {

            achicarImagen($path_original, 100, 100, $path_editado);

            //Modificamos el path del producto.
            $producto->path_original = $path_original;
            $producto->path_editado = $path_editado;
            $producto->save($cnx);

            header("Location: img_productos.php?ide={$producto->id}");
        } else {
            $error = 'Error al intentar subir el archivo';
        }
    } else {
        $error = 'El archivo tiene una extensión incorrecta';
    }
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/vistas/guardar_img_producto.php');
