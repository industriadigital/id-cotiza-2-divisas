<?php
    //me fijo si dieron enviaron una nueva cotización para guardar
    if (isset($_POST['actualizar_cotizaciones'])){
        $nonce_guardar_edicion = $_POST['cotiza_nonce_actualiza'];
        global $reg_errors;
        $reg_errors = new WP_Error;
        //reviso que los campos no estén vacíos
        if  (    empty( $_POST['cotiza1'])  ) {    $reg_errors -> add("empty-cotiza1","El campo denominación es obligatorio.");  }
        if  (    empty( $_POST['cotiza1Compra'])  ) {    $reg_errors -> add("empty-cotiza1Compra","El campo compra es obligatorio.");  }
        if  (    empty( $_POST['cotiza1Venta'])  ) {    $reg_errors -> add("empty-cotiza1Venta","El campo venta es obligatorio.");  }
        if  (    empty( $_POST['cotiza2'])  ) {    $reg_errors -> add("empty-cotiza2","El campo denominación es obligatorio.");  }
        if  (    empty( $_POST['cotiza2Compra'])  ) {    $reg_errors -> add("empty-cotiza2Compra","El campo compra es obligatorio.");  }
        if  (    empty( $_POST['cotiza2Venta'])  ) {    $reg_errors -> add("empty-cotiza2Venta","El campo venta es obligatorio.");  }
        //reviso que los valores tengan el formato correspondiente
        if (    !preg_match(    '/^([0-9]{1,7}(\.[0-9]{1,2})?)$/', $_POST['cotiza1Compra']) ) { $reg_errors->add( "invalid-cotiza1Compra", "El valor ingresado para la compra no tiene un formato válido" );   }
        if (    !preg_match(    '/^([0-9]{1,7}(\.[0-9]{1,2})?)$/', $_POST['cotiza1Venta'])  ) { $reg_errors->add( "invalid-cotiza1Venta", "El valor ingresado para la venta no tiene un formato válido" ); }
        if (    !preg_match(    '/^([0-9]{1,7}(\.[0-9]{1,2})?)$/', $_POST['cotiza2Compra']) ) { $reg_errors->add( "invalid-cotiza2Compra", "El valor ingresado para la compra no tiene un formato válido" );   }
        if (    !preg_match(    '/^([0-9]{1,7}(\.[0-9]{1,2})?)$/', $_POST['cotiza2Venta'])  ) { $reg_errors->add( "invalid-cotiza2Venta", "El valor ingresado para la venta no tiene un formato válido" ); }
        //si todas las revisiones fueron bien, entonces no registro errores y
        //puedo continuar con el guardado. De lo contrario, muestro los errores.
        if  (   is_wp_error(    $reg_errors )   ) {
            if  (   count(  $reg_errors->get_error_messages()   ) > 0  ) {
                foreach (   $reg_errors->get_error_messages() as $error ) {?>
                <p><?php echo $error;?></p>
                <?php }
            } else{
                //si todo fue bien continúo con el guardado.
                //pero antes reviso el nonce del form
                if(wp_verify_nonce($nonce_guardar_edicion,'actualiza_cotizacion') == false){
                    die('No tienes permisos para ejecutar esta acción.');
                 }   else{

                    $usuario = wp_get_current_user();
                    $valoresActualizados = [
                        'cotiza1'   => sanitize_textarea_field($_POST['cotiza1']),
                        'cotiza1Compra'   => $_POST['cotiza1Compra'],
                        'cotiza1Venta'    => $_POST['cotiza1Venta'],
                        'cotiza2'   => sanitize_textarea_field($_POST['cotiza2']),
                        'cotiza2Compra'   => $_POST['cotiza2Compra'],
                        'cotiza2Venta'    => $_POST['cotiza2Venta'],
                        'actualizado' => date_i18n( get_option( 'date_format' )),
                        'por' => $usuario -> user_login
                    ];

                    $actualizado = update_option( 'id-cotiza-2-divisas-valores', $valoresActualizados);
                    if ( false === $actualizado ) {

                        // Error al actualizar
                        echo '<div class="notice notice-error"><p>El registro no ha podido ser actualizado.</p></div>';
                        
                    } else {
    
                        // Actualización realizada
                        echo '<div class="notice notice-success"><p>El registro ha sido actualizado.</p></div>';
                        
                    }

                 
                }
            }
        }
    }

    if ( ! current_user_can( 'manage_options' ) ) {

        wp_send_json_error( 'No tienes permisos para estar aquí.' );

    }else{

?> 
<div class="wrap">

    <h1 class='wp-heading-inline'><?php echo get_admin_page_title(); ?></h1>

    <form method="post" novalidate="novalidate" action ="<?php get_the_permalink();?>">

        <?php wp_nonce_field('actualiza_cotizacion', 'cotiza_nonce_actualiza'); ?>

        <h3>Divisa 1</h3>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="cotiza1">Denominación</label>
                    </th>
                    <td>
                        <input name="cotiza1" type="text" id="cotiza1" value="<?php echo obtenerValorDivisa( 'cotiza1' ); ?>" class="regular-text" required aria-required="true" maxlength="20">
                        <p class="description" id="tagline-description">Tal como se va a mostrar en el sitio.</p>
                    </td>
                </tr>
                <tr>
                <th scope="row">
                    <label for="cotiza1Compra">Valor de Compra</label>
                </th>
                <td>
                    <input name="cotiza1Compra" type="text" id="cotiza1Compra" value="<?php echo obtenerValorDivisa( 'cotiza1Compra' ); ?>" class="regular-text" required aria-required="true" maxlength="9">
                    <p class="description" id="tagline-description">Utilizar un punto (.) para separar los decimales.</p>
                </td>
                </tr>
                <tr>
                <th scope="row">
                    <label for="cotiza1Venta">Valor de Venta</label>
                </th>
                <td>
                    <input name="cotiza1Venta" type="text" id="cotiza1Venta" value="<?php echo obtenerValorDivisa( 'cotiza1Venta' ); ?>" class="regular-text" required aria-required="true" maxlength="9">
                    <p class="description" id="tagline-description">Utilizar un punto (.) para separar los decimales.</p>
                </td>
                </tr>
        </table>
        <hr />
        <h3>Divisa 2</h3>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="cotiza2">Denominación</label>
                    </th>
                    <td>
                        <input name="cotiza2" type="text" id="cotiza2" value="<?php echo obtenerValorDivisa( 'cotiza2' ); ?>" class="regular-text" required aria-required="true" maxlength="20">
                        <p class="description" id="tagline-description">Tal como se va a mostrar en el sitio.</p>
                    </td>
                </tr>
                <tr>
                <th scope="row">
                    <label for="cotiza2Compra">Valor de Compra</label>
                </th>
                <td>
                    <input name="cotiza2Compra" type="text" id="cotiza2Compra" value="<?php echo obtenerValorDivisa( 'cotiza2Compra' ); ?>" class="regular-text" required aria-required="true" maxlength="9">
                    <p class="description" id="tagline-description">Utilizar un punto (.) para separar los decimales.</p>
                </td>
                </tr>
                <tr>
                <th scope="row">
                    <label for="cotiza2Venta">Valor de Venta</label>
                </th>
                <td>
                    <input name="cotiza2Venta" type="text" id="cotiza2Venta" value="<?php echo obtenerValorDivisa( 'cotiza2Venta' ); ?>" class="regular-text" required aria-required="true" maxlength="9">
                    <p class="description" id="tagline-description">Utilizar un punto (.) para separar los decimales.</p>
                </td>
                </tr>
        </table>
        <p class="submit">
            <input type="submit" name="actualizar_cotizaciones" id="actualizar_cotizaciones" class="button button-primary" value="Guardar cambios">
        </p>
    </form>
</div>
<?php
}
?>