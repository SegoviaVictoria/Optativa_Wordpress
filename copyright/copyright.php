<?php
/*
Plugin Name: Copyrigth Automático
Description: Cambia de forma automática el año del Copyrigth en el pie de página
Version: 1.0
Author: Victoria
*/

require_once 'menu.php';

if (!defined('ABSPATH')) exit;

function cc_mensaje_pie()
{
    $cc_texto = get_option("cc_texto");
    $cc_color = get_option("cc_color");
    $cc_align = get_option("cc_align");
    $ca_anio = date("Y");

    echo "<p style='color: {$cc_color}; text-align: {$cc_align};'>{$cc_texto} © {$ca_anio}</p>";
}

add_action('wp_footer', 'cc_mensaje_pie');
