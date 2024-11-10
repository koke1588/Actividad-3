<?php 

require_once("conn.php");

session_start();

if(isset($_SESSION['usuario'])) {
    header("location:panel_usuario.php");
    exit();
}

if (isset($_SESSION["mensaje_alerta"])) {
    echo '<script>alert("' . $_SESSION["mensaje_alerta"] . '");</script>';
    unset($_SESSION["mensaje_alerta"]); 
}

if(isset($_POST["Login"])) {
    $usuario = mysqli_real_escape_string($conn, $_POST["usuario"]);
    $contra = mysqli_real_escape_string($conn, $_POST["contra"]); 
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {  
        $row = mysqli_fetch_array($result);
        if(password_verify($contra, $row["contra"])) {
            $_SESSION["usuario"] = $usuario;
            header("location:panel_usuario.php");
            exit();
        } else {
            echo '<script> alert("EPP. Wrong user details")</script>';
        }  
    } else {
        echo '<script> alert("¡No existe el usuario!")</script>';
    }
}

if(isset($_POST["registro"])) {
    if(empty($_POST["usuario"]) || empty($_POST["contra"]) || empty($_POST["repetir_contra"])) {
        echo '<script> alert("¡Se debe rellenar todos los campos!")</script>';
    } else if($_POST["contra"] != $_POST["repetir_contra"]) {
        echo '<script> alert("¡Las contraseñas no coinciden!")</script>';
    } else {
        $usuario = mysqli_real_escape_string($conn, $_POST["usuario"]); 
        $contra = mysqli_real_escape_string($conn, $_POST["contra"]);
        $contra = password_hash($contra, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios(usuario, contra) VALUES('$usuario', '$contra')";
        if(mysqli_query($conn, $sql)) {
            $_SESSION["mensaje_alerta"] = "¡Registro realizado con éxito! Ahora puedes iniciar sesión.";
            header("location:index.php");  
            exit();
        } else {
            echo '<script> alert("Error en el registro.")</script>';
        }
    }
}

?>

<!DOCTYPE html>  
<html>  
      <head>  
           <title>Iniciar sesión y Registro</title>   
           <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> 
           <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>"> 
      </head>  
      <body>
        <div class="container align-middle">
            <?php if (isset($_GET["action"]) && $_GET["action"] === "registro") { ?>
                <form method="post">
                    <h3 class="text-center">Registro</h3>
                    <div class="form-outline mb-4">
                        <input type="text" id="usuario" name="usuario" class="form-control" />
                        <label class="form-label" for="usuario">Usuario</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" id="contra" name="contra" class="form-control" />
                        <label class="form-label" for="contra">Contraseña</label>
                    </div> 
                    <div class="form-outline mb-4">
                        <input type="password" id="repetir_contra" name="repetir_contra" class="form-control" />
                        <label class="form-label" for="contra">Repetir contraseña</label>
                    </div>
                    <input type="submit" class="btn btn-primary btn-clock mb-4" value="Registro" name="registro" />
                    <div class="text-center">
                        <p>¿Ya estás registrado? <a href="index.php">Iniciar sesión</a></p>
                    </div>
                </form>
            <?php } else { ?>
                <form method="post">
                    <h3 class="text-center">Iniciar sesión</h3>
                    <div class="form-outline mb-4">
                        <input type="text" id="usuario" name="usuario" class="form-control" />
                        <label class="form-label" for="usuario">Usuario</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" id="contra" name="contra" class="form-control" />
                        <label class="form-label" for="contra">Contraseña</label>
                    </div>  
                    <input type="submit" class="btn btn-primary btn-clock mb-4" value="Iniciar sesión" name="Login" />
                    <div class="text-center">
                        <p>¿No estás registrado? <a href="index.php?action=registro">Regístrate</a></p>
                    </div>
                </form>
            <?php } ?>
        </div>  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js?v=<?php echo time(); ?>" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="assets/js/main.js?v=<?php echo time(); ?>"></script>
    </body>  
</html> 