<?php
/*
Plugin Name: Mi Primer Plugin
Description: Nuestro primer plugin del taller.
Version: 1.0
Author: [Tu nombre]
*/

// Evitar acceso directo
if ( !defined('ABSPATH') ) exit;

// Acción: agregar texto al pie del sitio
function mensaje_pie() {
    echo '<p style="text-align:center; color: gray;">🌟 Hecho con mi primer plugin 🌟</p>';
}

// Enganchar la función al evento del pie
add_action('wp_footer', 'mensaje_pie');

function mensaje_en_contenido($contenido) {
    return $contenido . '<p style="color:gray;">- Hecho con mi primer plugin</p>';
}

add_filter('the_content', 'mensaje_en_contenido');
