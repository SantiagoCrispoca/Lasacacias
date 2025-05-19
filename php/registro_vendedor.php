<?php

$getJSON = file_get_contents('php://input');

$dataJson = json_decode($getJSON);

$usuario = $_POST['nombre'];
$email = $_POST['correo'];
$password = $_POST['password'];



echo $email;

//$mysqli = new mysqli("localhost", "root", "", "lasacacias");
$mysqli = new mysqli("sql113.infinityfree.com", "if0_38911703", "2NSoDpGB1PNq4q", "if0_38911703_usuarios");


/* if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
else{
    echo "Conectado";
}

*/


$sql = "INSERT INTO `usuarios` (`ID`, `Nombre`, `Correo`, `Contrasena`, `Rol`) VALUES (NULL, '".$usuario."', '".$email."', '".$password."', 'user');";

if ($mysqli->query($sql) === TRUE ){

     echo "New record...";
}
else{
     echo "Error: " . $sql . "<br>" . $mysqli->error;
}



?>