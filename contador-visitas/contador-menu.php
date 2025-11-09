<?php

function cv_crear_menu()
{
    add_menu_page(
        'Contador Visitas',
        'Contador Visitas',
        'manage_options',
        'contador-configuration',
        'cv_menu_configuration'
    );
}

function cv_menu_configuration()
{

    if (isset($_POST['cv_color_texto']) && check_admin_referer('cv_guardar_conf')) {

        $mostrar = isset($_POST['cv_mostrar']);
        $color_texto = sanitize_hex_color($_POST['cv_color_texto']);

        $total_visitas = get_option('cv_total_visitas') ? get_option('cv_total_visitas') : 0;

        update_option('cv_total_visitas', $total_visitas);
        update_option('cv_mostrar', $mostrar);
        update_option('cv_color_texto', $color_texto);

        echo '<div class="updated"><p>✅ Mensaje guardado correctamente.</p></div>';
    }

    $mostrar = get_option('cv_mostrar');
    $color_texto = get_option(('cv_color_texto'));

?>

    <div class="wrap">
        <h1>Configuración: Contador de Visitas</h1>

        <form method="post">
            <?php wp_nonce_field('cv_guardar_conf'); //sistema de seguridad
            ?>

            <p>Mostrar contador:</p>
            <label>
            <input type="checkbox" name="cv_mostrar" <?php echo $mostrar ? "checked": "" ?> /> Activar contador</label>
            <br></br>

            <p>Cambiar el color del texto:</p>
            <input type="color" name="cv_color_texto" value="<?php echo esc_attr($color_texto); ?>" required/>
            <br></br>

            <input type="submit" class="button-primary" value="Guardar mensaje">
        </form>
        
    </div>

<?php
}

add_action('admin_menu', 'cv_crear_menu');
