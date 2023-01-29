<?php
/*
Plugin Name: ID Cotiza 2 Divisas
Plugin URI: https://www.industriadigital.ar
Description: Muestra los valores de 2 cotizaciones introducidas manualmente | Shortcode [id_cotiza]
Version: 0.0.6 VALORES MANUALES
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
        'cotiza1'   => 'Dólar Oficial',
        'cotiza1Compra'   => '333.33',
        'cotiza1Venta'    => '333.33',
        'cotiza2'   => 'Dólar Blue',
        'cotiza2Compra'   => '333.33',
        'cotiza2Venta'    => '333.33'
    ];
    
    update_option( 'id-cotiza-2-divisas-valores', $valoresPorDefecto);
}

function borrarCotiza2Divisas(){

    delete_option( 'id-cotiza-2-divisas-opciones' );
    delete_option( 'id-cotiza-2-divisas-valores' );

}

register_activation_hook(__FILE__,'activarCotiza2Divisas');
register_uninstall_hook(__FILE__, 'borrarCotiza2Divisas');

add_action('admin_menu','mostrarMenuCotiza2Divisas');

function mostrarMenuCotiza2Divisas() {

    add_menu_page(
        
        '[Industria Digital] Edición de los Valores de Cotiza 2 Divisas', // Título de la página
        'Cotiza 2 Divisas', // Título del menú
        'manage_options', // Capability. Quién tiene acceso al menú (Administradores)
        'id-cotiza-2-divisas', // Slug
        'editarCotizaciones', // Función que muestra el contenido
        plugin_dir_url(__FILE__).'icon.svg', // Ubicación del ícono que se muestra en el menú
        '2' // Priority. Ubicación de esta opción en el menú de administración de wordpress

    );
}

function editarCotizaciones(){



}

function obtenerValorDivisa( $clave ) {

    $divisasValores = get_option( 'id-cotiza-2-divisas-valores' );
    return isset( $divisasValores[ $clave ] ) ? $divisasValores[ $clave] : false;

}


function actualizarValorDivisa( $clave, $valor ) {

    $divisasValores = get_option( 'id-cotiza-2-divisas-valores' );
    $divisasValores[ $clave ] = $valor;
    return update_option( 'id-cotiza-2-divisas-valores', $divisasValores);

}