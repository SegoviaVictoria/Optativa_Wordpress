<?php
/*
Plugin Name: Recordatorio
Description: Recuerda una actividad
Version: 1.0
Author: Victoria Segovia
*/

require_once 'menu.php';

if (!defined('ABSPATH')) exit;

function r_mensaje_div()
{
    $r_mensaje = get_option("r_mensaje");
    $r_color_texto = get_option("r_color_texto");
    $r_dia = get_option("r_dia");

    $r_dia_actual = date("l");

    if ($r_dia_actual == $r_dia) {
        echo "<div id='mensaje-recordatorio' style='
        position: fixed;
        top: 15%;
        left: 15%;
        width: 70vw;
        height: 70vh;
        background-color: white;
        color: {$r_color_texto};
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 1.5em;
        text-align: center;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
        border-radius: 10px;
        z-index: 9999;
        '>
        <p>{$r_mensaje}</p>
        <br></br>
        <p><button onclick='document.getElementById(\"mensaje-recordatorio\").style.display=\"none\"'>X</button></p>
        </div>";
    }
}

add_action('wp_footer', 'r_mensaje_div');
