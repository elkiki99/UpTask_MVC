<div class="contenedor olvide">

    <?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">¿Olvidaste tu Password? Ingresa tu e-mail y sigue los pasos</p>

        <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

        <form class="formulario" method="POST" action="/olvide" novalidate>
            <div class="campo">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Tu E-mail">
            </div>

            <input type="submit" class="boton" value="Restablecer Password">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
            <a href="/crear">¿Aún no tienes cuenta? Crea una</a>
        </div>
    </div> <!-- .contenedor-sm -->
</div>
