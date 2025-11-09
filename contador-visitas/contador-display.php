<?php
/*
Plugin Name: Contador de Visitas
Description: Contea las visitas de usuarios no registrados.
Version: 1.0
Author: Victoria Segovia
*/

require_once 'contador-menu.php';

if (!defined('ABSPATH')) exit;

function cv_mensaje_pie()
{
    $cv_totalVisitas = get_option("cv_total_visitas");
    $cv_color_texto = get_option("cv_color_texto");
    $cv_mostrar = get_option("cv_mostrar");

    $cv_totalVisitas += 1;

    if ($cv_mostrar) {
        echo "<p style='color:{$cv_color_texto}' >Total de visitas: {$cv_totalVisitas}</p>";
    }

    update_option("cv_total_visitas", $cv_totalVisitas);
}

add_action('wp_footer', 'cv_mensaje_pie');
