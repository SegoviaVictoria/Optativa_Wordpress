<?php

function r_crear_menu()
{
    add_menu_page(
        'Recordatorio',
        'Recordatorio',
        'manage_options',
        'recordatorio-configuration',
        'r_menu_configuration'
    );
}

function r_menu_configuration()
{

    if (isset($_POST['r_mensaje']) && isset($_POST['r_color_texto']) && check_admin_referer('wm_guardar_conf')) {

        $mensaje = sanitize_text_field($_POST['r_mensaje']);
        $color_texto = sanitize_text_field($_POST['r_color_texto']);
        $dia_semana = sanitize_text_field($_POST['r_dia']);

        update_option('r_mensaje', $mensaje);
        update_option('r_color_texto', $color_texto);
        update_option('r_dia', $dia_semana);

        echo '<div class="updated"><p>✅ Mensaje guardado correctamente.</p></div>';
    }

    $mensaje = get_option('r_mensaje');
    $color_texto = get_option('r_color_texto');
    $dia_semana = get_option('r_dia');

?>

    <div class="wrap">
        <h1>Configuración: Recordatorio</h1>

        <form method="post">
            <?php wp_nonce_field('wm_guardar_conf'); //sistema de seguridad
            ?>

            <p>Escribir el mensaje del recordatorio:</p>
            <textarea name="r_mensaje" rows="10" cols="60"><?php echo esc_textarea($mensaje); ?></textarea>
            <br><br>

            <p>Cambiar el color del texto:</p>
            <input type="color" name="r_color_texto" value=<?php echo $color_texto ? $color_texto : "" ?> required></input>
            <br><br>

            <p>Cambiar el dia de la semana:</p>
            <select name="r_dia">
                <option value="Monday" <?php selected($dia_semana, 'Monday'); ?> >Lunes</option>
                <option value="Tuesday" <?php selected($dia_semana, 'Tuesday'); ?> >Martes</option>
                <option value="Wednesday">Miercoles</option>
                <option value="Thursday">Jueves</option>
                <option value="Friday">Viernes</option>
                <option value="Saturday">Sabado</option>
                <option value="Sunday">Domingo</option>
            </select>
            <br><br>

            <input type="submit" class="button-primary" value="Guardar mensaje">
        </form>

    </div>

<?php
}

add_action('admin_menu', 'r_crear_menu');
