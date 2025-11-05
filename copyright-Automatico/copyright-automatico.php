<?php
/*
Plugin Name: Copyright Automático
Description: Muestra © y el año actual en el footer
Version: 1.0
Author: Victoria Segovia
*/

function anadirCopyright() {
    $year = date("Y");
    echo "<p style='text-align:center; color: gray;'>" . $year . " © </p>";
}

add_action('wp_footer', 'anadirCopyright');

