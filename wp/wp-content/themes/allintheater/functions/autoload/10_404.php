<?php
/**
 * 404 Redirect
 */

if( !function_exists('redirect_404_to_homepage') ){

    add_action( 'template_redirect', 'redirect_404_to_homepage' );

    function redirect_404_to_homepage(){
       if(is_404()):
            wp_safe_redirect( home_url('/404') );
            exit;
        endif;
    }
}