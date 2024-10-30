<?php
    
    /*******************************************************************************************************************
        
        Plugin Name: LiveNinja Messenger WP Plugin
        Plugin URI: ln.co
        Description: Embeds the LiveNinja Messenger widget code on your Wordpress website
        Version: 0.0.2
        Author: LiveNinja Dev Team + Pacific54
        Author URI: ln.co
        
    *******************************************************************************************************************/
    
    define( "PLUGIN_URL", plugins_url( "", __FILE__ ) );
    
    if ( !function_exists( "add_action" ) ) {
        echo "This page cannot be called directly.";
        exit;
    }
    
    wp_enqueue_style( "liveninja-messenger", PLUGIN_URL . "/css/liveninja.css" );
    
    add_action( "admin_menu", "lnm_add_settings_page" );
    function lnm_add_settings_page() {
        add_menu_page( "LiveNinja Messenger", "LiveNinja", "manage_options", "lnm_plugin", "lnm_settings_page", PLUGIN_URL . "/img/liveninja.png" );
    }
    function lnm_settings_page() { ?>
        <div class="wrap">
            <h1>LiveNinja Messenger</h1>
            <form action="options.php" method="POST">
                <?php settings_fields( "lnm_settings_group" ); ?>
                <?php lnm_settings_section_callback(); ?>
                <table class="form-table">
                    <?php lnm_account_callback(); ?>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
    <?php }
    
    add_action( "admin_init", "lnm_register_settings" );
    function lnm_register_settings() {
        register_setting( "lnm_settings_group", "lnm_settings", null );
        add_settings_section( "lnm_settings_section", "", "lnm_settings_section_callback", "" );
        add_settings_field( "lnm_account", __( "LiveNinja Brand Page ID" ), "lnm_account_callback", "lnm_plugin", "lnm_settings_section" );
    }
    function lnm_settings_section_callback() {
        echo <<<________STRING
            
            <p>Please enter the URL for your LiveNinja Brand Page below.</p>
            <ul class="lnm-list">
                <li>If you don't know what your Brand Page ID is, please log in to your dashboard at <a href="https://messenger.liveninja.com" target="_blank">mesenger.liveninja.com</a>, then click the settings icon at the bottom of your inbox.</li>
                <li>Once there, select your brand ( by name ) and choose "View My Brand Page".</li>
                <li>Copy/Paste the tail end of the URL from your browser's address bar in the field below.</li>
            </ul>
            
________STRING;
    }
    function lnm_account_callback() {
        $options = get_option( "lnm_settings" );
        echo <<<________STRING
            <tr>
                <th scope="row">
                    <label for="lnm_settings[lnm_account]">Brand Page ID</label>
                </th>
                <td>
                    <span style="margin-right: 5px;">ln.co/</span><input class="regular-text ltr" type="text" name="lnm_settings[lnm_account]" placeholder="Brand Page ID" value="{$options[ "lnm_account" ]}">
                </td>
            </tr>
________STRING;
    }
    
    /* Add code to website */
    
    add_action( "wp_enqueue_scripts", "lnm_script" );
    function lnm_script() {
        $options = get_option( "lnm_settings" );
        if ( !empty( $options[ "lnm_account" ] ) && preg_match( "/^[a-zA-Z0-9]+$/i", $options[ "lnm_account" ] ) ) {
            wp_enqueue_script( "liveninja-messenger", PLUGIN_URL . "/js/liveninja.js.php?id=" . $options[ "lnm_account" ], null, null, true );
        }
        return null;
    }
    