<?php
/*
Plugin Name: Welcome Message
Description:
Version: 1.0
Author: Victoria Segovia
*/

require_once 'welcome-menu.php';

if (!defined('ABSPATH')) exit;

function wm_mensaje_pie()
{
    $wm_mensaje = get_option("wm_mensaje");
    $wm_color_texto = get_option("wm_color_texto");
    $wm_color_fondo = get_option("wm_color_fondo");

    echo "<div id='mensaje-bienvenida' style='
        position: fixed;
        top: 0;
        left: 0;
        width: 70vw;
        height: 70vh;
        background-color: {$wm_color_fondo};
        color: {$wm_color_texto};
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5em;
        text-align: center;
        z-index: 9999;
    '>
        <p>{$wm_mensaje}</p>
        <br></br>
        <p><button onclick='document.getElementById(\"mensaje-bienvenida\").style.display=\"none\"'>X</button></p>
    </div>";
}

add_action('wp_footer', 'wm_mensaje_pie');
