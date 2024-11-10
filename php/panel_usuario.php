<?php 

require_once("conn.php");

session_start();

if(!isset($_SESSION['usuario'])) {
    header("location:index.php");
}

?>

<!DOCTYPE html>  
<html>  
      <head>  
           <title>Panel de usuarios</title>  
           <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> 
           <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>"> 
      </head>  
      <body>
        <div class="barra-navegacion-personalizada fixed-top d-flex justify-content-between align-items-center px-4">
            <h4 class="mb-0">Panel de Usuarios</h4>
            <a class="enlace-salir" href="salir.php">Salir</a>
        </div>
        <div class="contenedor-personalizado">
            <div class="row">
            
                <?php
                    $sql = "SELECT * FROM usuarios";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo 
                            ' 
                                <div class="col-md-4">
                                    <div class="card" style="width: 18rem;"> 
                                        <div class="card-body">
                                            <h5 class="card-title">' . $row["usuario"] . '</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">ID: ' . $row["id"] . '</h6> 
                                            <a href="https://www.google.es" target="_blank" class="btn btn-primary">Zona usuario</a>
                                        </div>  
                                    </div>
                                </div>
                            ';
                        }
                    }
                ?>
            </div>
        </div> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js?v=<?php echo time(); ?>" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="assets/js/main.js?v=<?php echo time(); ?>"></script>
    </body>  
</html> 