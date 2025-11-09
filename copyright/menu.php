<?php

function cc_crear_menu()
{
    add_menu_page(
        'Copyright configuration',
        'Copyright configuration',
        'manage_options',
        'copyright-configuration',
        'cc_pagina_configuration'
    );
}

function cc_pagina_configuration()
{

    // Si el formulario fue enviado y el código generado con wp_nonce_field es correcto ...
    if (isset($_POST['cc_texto']) && isset($_POST['cc_color']) && isset($_POST['cc_align']) && check_admin_referer('cc_guardar_conf')) {

        $copyright = sanitize_text_field($_POST['cc_texto']);
        $color = sanitize_text_field($_POST['cc_color']);
        $align = sanitize_text_field($_POST['cc_align']);

        update_option('cc_texto', $copyright);
        update_option('cc_color', $color);
        update_option('cc_align', $align);

        echo '<div class="updated"><p>✅ Copyright guardado correctamente.</p></div>';
    }

    $copyright = get_option('cc_texto');
    $color = get_option('cc_color');
    $align = get_option('cc_align');

?>

    <div class="wrap">
        <h1>Configuración: Copyright</h1>

        <form method="post">
            <?php wp_nonce_field('cc_guardar_conf'); //sistema de seguridad
            ?>

            <p>Escribir el nombre o la marca que aparecerá junto al copyright:</p>
            <input type="text" name="cc_texto" value="<?php echo isset($copyright) ? esc_attr($copyright) : ''; ?>" ></input>
            <br><br>

            <p>Elegir si quiere que el texto se vea centrado, a la izquierda o a la derecha.</p>
            <input type="radio" name="cc_align" value="center" <?php echo $align == "center" ? "checked": "" ?> >Center</input>
            <input type="radio" name="cc_align" value="left" <?php echo $align == "left" ? "checked": "" ?> >Left</input>
            <input type="radio" name="cc_align" value="right" <?php echo $align == "right" ? "checked": "" ?> >Right</input>
            <br><br>

            <p>Cambiar el color del texto</p>
            <input type="color" name="cc_color" value=<?php echo $color ? $color : "" ?> required></input>
            <br><br>

            <input type="submit" class="button-primary" value="Guardar copyright">
        </form>
        
    </div>

<?php
}

add_action('admin_menu', 'cc_crear_menu');
