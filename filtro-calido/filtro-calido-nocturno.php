<?php
/*
Plugin Name: Filtro cálido nocturno
Description: crea un filtro calido nocturno entre las 20:00 y las 07:00
Version: 1.0
Author: Victoria Segovia
*/

// Evitar acceso directo
if (!defined('ABSPATH')) exit;

function fcn_crearFiltroCalidoNocturno()
{
   $fcn_config = get_option("fcn_config", []);

   $FLA_HORA_INICIO = $fcn_config['fcn_hora_inicio'];
   $FLA_HORA_FIN = $fcn_config['fcn_hora_fin'];

   $fcn_intensidad = $fcn_config['fcn_intensidad'];
   $fcn_color = $fcn_config['fcn_color'];

   $fla_hora_actual = date("H");

   // Convertir el color hex a matiz (hue) aproximado para aplicar con hue-rotate
   // (no es exacto, pero sirve para dar un tono cálido al filtro)

   if ($fla_hora_actual >= $FLA_HORA_INICIO || $fla_hora_actual <= $FLA_HORA_FIN) {
      echo "<style>
         body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-color: {$fcn_color};
            pointer-events: none;
            opacity: {$fcn_intensidad};
            mix-blend-mode: multiply;
            transition: opacity 2s ease;
         }
      </style>";
   }
}

function fcn_crear_menu()
{
   add_menu_page(
      'Filtro cálido nocturno',
      'Filtro cálido nocturno',
      'manage_options',
      'filtro-calido-nocturno',
      'fcn_pagina_configuracion'
   );
}

function fcn_pagina_configuracion()
{

   // Si el formulario fue enviadoy el código generado con wp_nonce_field es correcto ...
   if (isset($_POST['fcn_guardar']) && check_admin_referer('fcn_guardar_config')) {

      $config = array(
         'fcn_hora_inicio' => intval($_POST['fcn_hora_inicio']),
         'fcn_hora_fin' => intval($_POST['fcn_hora_fin']),
         'fcn_intensidad' => intval($_POST['fcn_intensidad']),
         'fcn_color' => sanitize_text_field($_POST['fcn_color'])
      );

      update_option('fcn_config', $config);
      echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
   }

?>

   <div class="wrap">
      <h1>Configuración: Filtro Cálido Nocturno</h1>
      <p>La hora de inicio y hora de fin del modo nocturno.</p>
      <p>La intensidad del filtro cálido (por ejemplo: suave, medio o fuerte).</p>
      <p>El color exacto del filtro, usando un selector de color.</p>

      <form method="post">
         <?php wp_nonce_field('fcn_guardar_config'); //sistema de seguridad llamado nonce (número único temporal). que hay que validar luego para impedir envíos no autorizado del formulario 
         ?>
         <input type="hidden" name="fcn_guardar" value="1" />
         <label>Hora Inicio <input type="number" name='fcn_hora_inicio' min="00" max="23" value="<?php $config['fcn_hora_inicio']?>" required /></label>
         <label>Hora Fin <input type="number" name='fcn_hora_fin' min="15" max="24" value="<?php $config['fcn_hora_fin']?>" required /></label>
         <br><br>
         <label>Intensidad filtro (%) <input type="number" name='fcn_intensidad' min="1" max="100" value="<?php $config['fcn_intensidad']?>" required /></label>
         <br><br>
         <label>Color del Filtro <input type="color" name='fcn_color' value="<?php $config['fcn_color']?>" required /></label>
         <br><br>
         <input type="submit" class="button-primary" value="Guardar cofiguración">
      </form>
   </div>

<?php
}

add_filter('the_content', 'fcn_crearFiltroCalidoNocturno');
add_action('admin_menu', 'fcn_crear_menu');
