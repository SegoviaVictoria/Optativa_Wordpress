<?php
/*
Plugin Name: Mensaje del Día
Description: Muestra un mensaje aleatorio en el pie de página
Version: 1.0
Author: Isaac
*/

if ( !defined('ABSPATH') ) exit;

function mdd_mostrar_mensaje() {

    $mdd_frases = get_option("mdd_frases", []); // ponemos [] para que lea el array y no el string almacenado
    $mmd_emoji = get_option('mmd_emoji');
    $mdd_indice_aleatorio = array_rand($mdd_frases);
    $mdd_mensaje = $mdd_frases[$mdd_indice_aleatorio];

    echo "<p>$mdd_mensaje</p>";
    echo "<p>" . $mmd_emoji? "👮‍♀️👮‍♀️" : "" . "</p>";
}

// Enganchar la función al evento del pie
add_action('wp_footer', 'mdd_mostrar_mensaje');

// ======================= MENU DEL PLUGIN ======================= //

function mdd_crear_menu() {
    add_menu_page(
        // 🅰️ 1️⃣ - TÍTULO DE LA PÁGINA (parte superior)
        // Este texto aparecerá en la barra de título del navegador
        // y también como encabezado dentro de la página de configuración.
        'Mensaje del Día',

        // 🅱️ 2️⃣ - TEXTO DEL MENÚ
        // Es el texto que se mostrará en el menú lateral de WordPress.
        // Ejemplo: En el panel verás un botón que dice "Mensaje del Día".
        'Mensaje del Día',

        // 🆎 3️⃣ - PERMISO NECESARIO
        // Define qué tipo de usuario puede ver este menú.
        // 'manage_options' significa que solo los administradores pueden verlo.
        // Si quisieras que los editores también lo vean, podrías usar 'edit_posts'.
        'manage_options',

        // 🔠 4️⃣ - SLUG (identificador interno)
        // Es una palabra única que identifica la página dentro de WordPress.
        // Aparecerá en la URL como ?page=mensaje-del-dia
        // y se usa también como "nombre interno" para este menú.
        'mensaje-del-dia',

        // 🧩 5️⃣ - FUNCIÓN QUE MOSTRARÁ EL CONTENIDO
        // Cuando el usuario haga clic en este menú,
        // WordPress llamará a esta función para generar el contenido HTML de la página.
        // Esa función la definiremos más abajo (por ejemplo, mdd_pagina_configuracion()).
        'mdd_pagina_configuracion'
    );
}

function mdd_pagina_configuracion() {

    // Si el formulario fue enviadoy el código generado con wp_nonce_field es correcto ...
    if ( isset($_POST['mdd_frases']) && check_admin_referer('mdd_guardar_frases') ) {

        // Limpia el texto
        $texto = sanitize_textarea_field($_POST['mdd_frases']);
        $emoji = isset(($_POST['mmd_emoji']));
        // Divide el texto en líneas (una frase por línea)
        $frases = explode("\n", $texto);

        // Guarda las frases en la base de datos
        update_option('mdd_frases', $frases);
        update_option('mmd_emoji', $emoji);

        echo '<div class="updated"><p>✅ Frases guardadas correctamente.</p></div>';
    }

    // Leer las frases actuales (si hay)
    $frases = get_option('mdd_frases', []);
    $contenido = implode("\n", $frases);
    $mmd_emoji = get_option('mmd_emoji');

    ?>

    <div class="wrap">
        <h1>Configuración: Mensaje del Día</h1>
        <p>Escribe una frase por línea. Se mostrará una diferente cada vez que se cargue la página.</p>

        <form method="post">
            <?php wp_nonce_field('mdd_guardar_frases'); //sistema de seguridad llamado nonce (número único temporal). que hay que validar luego para impedir envíos no autorizado del formulario ?>
            <textarea name="mdd_frases" rows="10" cols="60"><?php echo esc_textarea($contenido); ?></textarea>
            <br><br>
            <input type="checkbox" name="mmd_emoji"<?php echo $mmd_emoji ? "checked": "" ?>> Activar super emoji</checkbox>
            <br><br>
            <input type="submit" class="button-primary" value="Guardar frases">
        </form>
    </div>

    <?php
}

add_action('admin_menu', 'mdd_crear_menu');