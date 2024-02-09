
<?php include_once __DIR__ . '/header-dashboard.php' ?>

<?php setlocale(LC_TIME, "es_UY"); ?>
<?php if (count($proyectos) === 0) { ?>
    <p class="no-proyectos">No hay proyectos aún <a href="/crear-proyecto">Comienza creando uno</a></p>
<?php } else { ?>
    <ul class="listado-proyectos">
        <?php foreach ($proyectos as $proyecto) { ?>
            <li class="proyecto">
                <a href="/proyecto?id=<?php echo $proyecto->url; ?>" class="proyecto-contenedor">
                    <div>
                        <?php echo $proyecto->proyecto; ?>
                    </div>
                    <form action="/proyecto/eliminar" method="post">
                        <input type="hidden" name="id" value="<?php echo $proyecto->id ?>">
                        <input type="submit" class="btn btn-eliminar" value="x" />
                    </form>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>
<?php
    $script = "
        <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/proyectos.js'></script>
    ";
?>