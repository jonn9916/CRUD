<?php
include ("conexion.php");
include ("funciones.php");



if ($_POST["operacion"] == "Crear") {
    $imagen = '';
    if ($_FILES["imagen_usuario"]["name"] != '') {
        $imagen = subir_imagen();
    }
   
   
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, apellidos, imagen, telefono, email ) VALUES ( :nombre, :apellidos, 
    :imagen, :telefono, :email) ");
    //var_dump($_POST["nombre"],$_POST["apellidos"],$imagen,$_POST["telefono"],$_POST["email"]);
     
    $resultado = $stmt->execute(
        array(
            ':nombre' => $_POST["nombre"],
            ':apellidos'  => $_POST["apellidos"],
            ':imagen' => $imagen,
            ':telefono' => $_POST["telefono"],
            ':email' => $_POST["email"]
            
        ));

    if (!empty($resultado)) {
        echo 'registro creado';
    }


}


if ($_POST["operacion"] == "Editar") {
    $imagen = '';
    if ($_FILES["imagen_usuario"]["name"] != '') {
        $imagen = subir_imagen();
    }else{
        $imagen=$_POST["imagen_usuario_oculta"];
    }
   
   
    $stmt = $conexion->prepare("UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos, imagen=:imagen, telefono=:telefono, email=:email WHERE id=:id ");
    //var_dump($_POST["nombre"],$_POST["apellidos"],$imagen,$_POST["telefono"],$_POST["email"]);
     
    $resultado = $stmt->execute(
        array(
            ':nombre' => $_POST["nombre"],
            ':apellidos'  => $_POST["apellidos"],
            ':imagen' => $imagen,
            ':telefono' => $_POST["telefono"],
            ':email' => $_POST["email"],
            ':id' => $_POST["id_usuario"]
            
        ));

    if (!empty($resultado)) {
        echo 'Registro actualizado';
    }
}