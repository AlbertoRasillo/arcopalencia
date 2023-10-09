<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/login.css">
    <title></title>
</head>
<body>
<div id="contenedor">
    <header id="cabecera">
        <h2>Acceso plataforma ARCO Palencia</h2>
    </header>
    <nav id="menu">

    </nav>
<section>
    <form action="comprobar_credenciales.php" method="POST">
        Mi dirección email es:<input type="email" name="nombre" id="nombre" autocomplete="off"/>
        Contraseña:<input type="password" name="pass" id="pass" />
        Entrar como: <select name="rol" id="rol">
            <option value="socio">Socio</option>
            <option value="productor">Productor</option>
            <option value="administrador">Administrador</option>
        </select>
        <input type="submit" value="Identificarse">
        <br />
        <?php
            session_start();
            if (isset($_SESSION['conta']) and $_SESSION['conta']>=7) {
                  require_once('recaptcha-php/recaptchalib.php');
                  $publickey = "6Lcdx-ISAAAAAISRgBJwip72IQdVP6RqlCQkuFfY"; // you got this from the signup page
                  echo recaptcha_get_html($publickey);
            }
         ?>
    </form>
</section>
    <footer id="pie"><?php include('pie.php') ?></footer>
</div>
</body>
</html>
