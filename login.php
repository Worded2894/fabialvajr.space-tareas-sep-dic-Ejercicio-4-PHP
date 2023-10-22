<?php
require_once 'usuarios.php';

// Comprobar si la sesión ya ha sido iniciada
if (session_status() == PHP_SESSION_NONE) {
    // Iniciar la sesión
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Autenticar al usuario
    $usuario_id = authenticate($_POST['nombre_usuario'], $_POST['clave']);

    if ($usuario_id !== false) {
        // Almacenar el ID del usuario en la sesión
        $_SESSION['usuario_id'] = $usuario_id;
        // Redirigir al usuario a la página de llenados
        header('Location: index.php');
        exit();
    } else {
        // Manejar el error de autenticación
        $error = "Nombre de usuario o clave incorrectos <br> Vuelva a intentar";
    }
}

header("X-Content-Type-Options: nosniff");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

         <!--Import Google Icon Font-->
         <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
    <nav>
        <div class="nav-wrapper #80cbc4 teal lighten-3">
            <a href="login.php" class="brand-logo center">Thomsom</a>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a href="sass.html">----</a></li>
            </ul>
        </div>
    </nav>
<br><br><br><br>
        <div class="container marginbottom #e0f2f1 teal lighten-5" style="border-radius: 15px;">
            <div> <p>‎ </p></div>
            <div class='row center-align'>
                <?php if (isset($error)): ?>
                    <p><?php echo $error; ?></p>
                <?php endif; ?>
            </div>

            <form method="post" action="login.php">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="nombre_usuario" type="text" name="nombre_usuario" class="validate">
                        <label for="nombre_usuario">Nombre de usuario</label><br>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <input id="clave" type="password" name="clave" class="validate">
                        <label for="clave">Clave</label><br>
                    </div>
                </div>

                <div class='row center-align'>
                    <button class="waves-effect waves-light btn-small" value="Iniciar sesión" type="submit">Iniciar Sesión</button>
                </div>
            </form>
            <div> <p>‎ </p></div>
        </div>
<br><br><br><br><br><br>
     <!--JavaScript at end of body for optimized loading-->
     <script type="text/javascript" src="js/materialize.min.js"></script>
	
</body>
<footer class="page-footer #4db6ac teal lighten-2">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">FABIAN ALVAREZ</h5>
                <p class="grey-text text-lighten-4">Programación Web N-1013.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="http://fabialvajr.space/tareas-sep-dic/Ejercicio%201/">Ejercicio 1</a></li>
                  <li><a class="grey-text text-lighten-3" href="http://fabialvajr.space/tareas-sep-dic/Ejercicio%202/">Ejercicio 2</a></li>
                  <li><a class="grey-text text-lighten-3" href="http://fabialvajr.space/tareas-sep-dic/Ejercicio%203/">Ejercicio 3</a></li>
                  <li><a class="grey-text text-lighten-3" href="http://fabialvajr.space/tareas-sep-dic/Ejercicio%204/">Ejercicio 4</a></li>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2023 Fabian Alvarez. All rights reserved.
            <a class="grey-text text-lighten-4 right" href="https://youtu.be/KTbynh5cRcQ?si=7uUJ0u55pMxph2QO">zzz</a>
            </div>
          </div>
</footer>
</html>