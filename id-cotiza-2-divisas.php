<?php
/*
Plugin Name: ID Cotiza 2 Divisas
Plugin URI: https://www.industriadigital.ar
Description: Muestra los valores de 2 cotizaciones introducidas manualmente | Shortcode [id_cotiza]
Version: 0.0.2 VALORES MANUALES
 * Requires at least: 5.2
 * Requires PHP:      7.2
Author: Ricardo Medina
Author URI: https://www.industriadigital.ar
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       id-cotiza-2-divisas
*/

// si el archivo es llamado directamente, abortamos
if(! defined('ABSPATH')){
    die("No tienes nada para ver aquí.");
}

function activarCotiza2Divisas(){

    //agregamos opciones
    $opcionesPorDefecto = [
        'since'         => date_i18n( get_option( 'date_format' )),
        'pluginName'    => 'id-cotiza-2-divisas'
    ];
    
    update_option( 'id-cotiza-2-divisas-opciones', $opcionesPorDefecto);

    //agregamos los valores por defecto
    $valoresPorDefecto = [
        'oficialCompra'   => '333.33',
        'oficialVenta'    => '333.33',
        'blueCompra'   => '333.33',
        'blueVenta'    => '333.33'
    ];
    
    update_option( 'id-cotiza-2-divisas-valores', $valoresPorDefecto);
}

function borrarCotiza2Divisas(){

    delete_option( 'id-cotiza-2-divisas-opciones' );
    delete_option( 'id-cotiza-2-divisas-valores' );

}

register_activation_hook(__FILE__,'activarCotiza2Divisas');
register_uninstall_hook(__FILE__, 'borrarCotiza2Divisas');