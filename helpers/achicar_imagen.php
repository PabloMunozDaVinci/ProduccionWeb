<?php

function achicarImagen($nombre_archivo, $ancho, $alto, $nombre_archivo_nuevo)
{

    $info = pathinfo($nombre_archivo);
    $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));

    $extensiones_permitidas = array('jpg', 'png', 'gif');

    if (in_array($extension, $extensiones_permitidas)) {

        // Obtener las nuevas dimensiones
        list($ancho_orig, $alto_orig) = getimagesize($nombre_archivo);

        $ratio_orig = $ancho_orig / $alto_orig;

        if ($ancho / $alto > $ratio_orig) {
            $ancho = $alto * $ratio_orig;
        } else {
            $alto = $ancho / $ratio_orig;
        }

        // Redimensionar
        $image_p = imagecreatetruecolor($ancho, $alto);

        if($extension == 'jpg'){
            $image = imagecreatefromjpeg($nombre_archivo);
        }else if($extension == 'png'){
            $image = imagecreatefrompng($nombre_archivo);
        }else{
            $image = imagecreatefromgif($nombre_archivo);
        }
        
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $ancho, $alto, $ancho_orig, $alto_orig);

        if($extension == 'jpg'){
            imagejpeg($image_p, $nombre_archivo_nuevo, 100);
        }else if($extension == 'png'){
            imagepng($image_p, $nombre_archivo_nuevo, 100);
        }else{
            imagegif($image_p, $nombre_archivo_nuevo, 100);
        }

    } else {
        die('Extensión incorrecta');
    }
    
}