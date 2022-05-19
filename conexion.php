<?php

$usuario= 'root';
$password='';
try {
$conexion= new PDO('mysql:host=127.0.0.1;dbname=crud_usuarios',$usuario, $password);
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
}
