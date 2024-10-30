<?php
    $account = $_GET[ "id" ];
    if ( !empty( $account ) && preg_match( "/^[a-zA-Z0-9]+$/i", $account ) ) :
        header( "Content-Type: application/javascript; Cache-Control: max-age=2592000" );
        echo <<<________STRING
            
            ( function( n, i, _n, j, a ) {
                n.addEventListener( "DOMContentLoaded", function() {
                    i[ 'liveninja' ] = [ "https://messenger.liveninja.com/w/{$account}?frame=true" ];
                    var _n = n.createElement( 'script' );
                    var j = n.getElementsByTagName( 'script' )[ 0 ];
                    _n.async = 1;
                    _n.src = 'https://messenger.liveninja.com/w/assets/widget.js';
                    j.parentNode.insertBefore( _n, j );
                })
            })( document, window );
            
________STRING;
    else :
        die;
    endif;
?>