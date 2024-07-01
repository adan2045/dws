<?php


$nombre ='';
$dni='';
$email='';
$apellido='';
$password='';
$provincia='';

$apellido=
$error_nombre ='';
$error_dni='';
$error_email='';
$error_contrasenia='';
$error_provincia='';
$errorFlag='';


if (isset($_POST['registro'])){
    $errorFlag =false;

    function validacion ($campo, $min, $maximo, $name){
        $msg ='';
        $error = false;
        $campo2 ='';

        if(!isset($_POST[$campo])){
            $msg='no existe el campo '.$name;
            $error=true; 
        } else {
            $campo2=trim($_POST[$campo]);
            if(empty($campo2)){
                $msg='el campo no puede estar vacio';
                $error=true;
            } else {
                if(strlen($campo2) < $min || strlen($campo2) >$maximo){
                    $msg = 'por favor ingrese entre' . $min . ' y '. $maximo . ' caracteres ';
                    $error = true;
                }
            }

        }
        $resultado['msg']=$msg;
        $resultado['campo2']=$campo2;
        $resultado['error']=$error;
        return $resultado;
    }
    /*validacion nombre */
    $valNombre = validacion('nombre',3,100,'nombre');
    
    if ($valNombre ['error']){
        $error_nombre=$valNombre['msg'];
    }else{
        $nombre = $valNombre['campo2'];
    }
   /*validacion apellido */
   $valApellido = validacion('apellido',3,100,'apellido');
    
   if ($valApellido ['error']){
       $error_nombre=$valApellido['msg'];
   }else{
       $apellido = $valApellido['campo2'];
   }
/*validacion dni */
$valDni = validacion('dni',6,10,'dni');
    
    if ($valDni ['error']){
        $error_dni=$valDni['msg'];
    }else{
        $dni = $valDni['campo2'];
    }
/* validacion email */
$valemail = validacion('email',5,50,'email');
    
    if ($valemail ['error']){
        $error_email=$valemail['msg'];
    }else{
        if(!filter_var($valemail['campo2'], FILTER_VALIDATE_EMAIL)){
            $error_email = 'ingrese un formato valido';
            $errorFlag = true;
        }else{ 
        $email = $valemail['campo2'];
    } }
#validacion contraseña 
$valContrasenia = validacion('dni',6,10,'dni');
    
if ($valContrasenia ['error']){
    $error_contrasenia=$valContrasenia['msg'];
}else{
    $contrasenia = $valContrasenia['campo2'];
}

}
if ($errorFlag===false){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
    
        // Conexión a la base de datos
        $dsn = 'mysql:host=localhost;dbname=prueba;charset=utf8';
        $username = 'root';  // Cambia esto si tu usuario de MySQL es diferente
        $password = '';      // Cambia esto si tienes una contraseña para MySQL
    
        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Verificar si el correo ya está registrado
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $count = $stmt->fetchColumn();
    
            if ($count > 0) {
                echo "El email ya está registrado.";
            } else {
                // Insertar nuevo registro
                $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, apellido, email) VALUES (:nombre, :apellido, :email)');
                $stmt->execute(['nombre' => $nombre, 'apellido' => $apellido, 'email' => $email]);
                echo "Registro exitoso.";
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } }
    

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/estilo.ccs">
</head>

<body>
    <form method="post">
        <div class=>
            <h1> -----------Registro-----------</h1>
        </div>
        <div class="inputs" >
            <input type="text"name="nombre" placeholder="ingrese su nombre" value="<?=$nombre?>">
            <output class="msg_error"><?=$error_nombre?></output>
            
        </div>
        <div class="inputs" >
            <input type="text"name="apellido" placeholder="ingrese su apellido" value="<?=$apellido?>">
            <output class="msg_error"><?=$error_nombre?></output>
            
        </div>
        <div class="inputs">
            <input type="number"name="dni" placeholder="ingrese su dni" value="<?=$dni?>">
            <output class="msg_error"><?=$error_dni?></output>
        </div>
        <div class="inputs">
            <input type="text"name="email" placeholder="ingrese su email" value="<?=$email?>">
            <output class="msg_error"><?=$error_email?></output>
        </div>
        <div class="inputs">
            <input type="password"name="contrasenia" placeholder="ingrese su contraseña" value="<?=$contrasenia?>">
            <output class="msg_error"><?=$error_contrasenia?></output>
        </div>
        <div class="inputs">
            <select name="provincia">
                <option value=""selected disabled>seleccione su provincia </option>
                <option value="buenosaires"<? ($provincia=="buenosaires") ? 'selected': ' ' ?>>buenos aires</option>
                <option value="santafe"<? ($provincia=="santa fe") ? 'selected': ' ' ?>>santa fe</option>
                <option value="cordoba"<? ($provincia=="cordoba") ? 'selected': ' ' ?>>cordoba</option>
            </select>
            <output class="msg_error"><?=$error_provincia?> </output> 
        </div>
        <div>
            <button type="submit" name='registro'>registrarse</button>
        </div>
    </form>    
</body>
</html>