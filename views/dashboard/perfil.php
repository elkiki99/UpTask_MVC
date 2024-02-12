<?php include_once __DIR__ . "/header-dashboard.php"; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . "/../templates/alertas.php" ?>

    <a href="/cambiar-password" class="enlace">Cambiar password</a>

    <form method="post" class="formulario" action="/perfil">
        <div class="campo">
            <label for="nosotros">Nombre</label>
            <input type="text" value="<?php echo $usuario->nombre; ?>" name="nombre" placeholder="Tu Nombre">
        </div>
        <div class="campo">
            <label for="nosotros">E-mail</label>
            <input type="email" value="<?php echo $usuario->email; ?>" name="email" placeholder="Tu E-mail">
        </div>

        <input type="submit" value="Guardar cambios">
    </form>
</div>

<?php include_once __DIR__ . "/footer-dashboard.php"; ?>

