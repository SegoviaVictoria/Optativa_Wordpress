<?php

function wm_crear_menu()
{
    add_menu_page(
        'Welcome Message',
        'Welcome Message',
        'manage_options',
        'welcome-configuration',
        'wm_menu_configuration'
    );
}

function wm_menu_configuration()
{

    if (isset($_POST['wm_mensaje']) && isset($_POST['wm_color_texto']) && isset($_POST['wm_color_fondo']) && check_admin_referer('wm_guardar_conf')) {

        $mensaje = sanitize_text_field($_POST['wm_mensaje']);
        $color_texto = sanitize_text_field($_POST['wm_color_texto']);
        $color_fondo = sanitize_text_field($_POST['wm_color_fondo']);

        update_option('wm_mensaje', $mensaje);
        update_option('wm_color_texto', $color_texto);
        update_option('wm_color_fondo', $color_fondo);

        echo '<div class="updated"><p>✅ Mensaje guardado correctamente.</p></div>';
    }

    $mensaje = get_option('wm_mensaje');
    $color_texto = get_option('wm_color_texto');
    $color_fondo = get_option('wm_color_fondo');

?>

    <div class="wrap">
        <h1>Configuración: Mensaje bienvenida</h1>

        <form method="post">
            <?php wp_nonce_field('wm_guardar_conf'); //sistema de seguridad
            ?>

            <p>Escribir el mensaje de bienvenida:</p>
            <textarea name="wm_mensaje" rows="10" cols="60"><?php echo esc_textarea($mensaje); ?></textarea>
            <br><br>
            <p><?php echo $mensaje; ?></p>
            <p>Cambiar el color del texto:</p>
            <input type="color" name="wm_color_texto" value=<?php echo $color_texto ? $color_texto : "" ?> required></input>
            <br><br>

            <p>Cambiar el color del fondo:</p>
            <input type="color" name="wm_color_fondo" value=<?php echo $color_fondo ? $color_fondo : "" ?> required></input>
            <br><br>

            <input type="submit" class="button-primary" value="Guardar mensaje">
        </form>
        
    </div>

<?php
}

add_action('admin_menu', 'wm_crear_menu');
