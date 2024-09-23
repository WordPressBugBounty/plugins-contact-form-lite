<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Please do not load this file directly!' );
}

/* Gutenberg Compatibility */
add_filter( 'mce_external_plugins', 'ecf_tinymce_mceplugin' );
add_action( 'current_screen', 'ecf_gutenberg_shortcode_manager' );

function ecf_gutenberg_shortcode_manager()
{

    if ( function_exists( 'get_current_screen' ) ) {

        global $current_screen;

        if ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {

            add_filter( 'mce_buttons', 'ecf_register_mcebuttons', 0 );
            add_action( 'enqueue_block_editor_assets', 'ecf_block_editor_mcebtn_styles' );

        }

    }

}

function ecf_register_mcebuttons( $buttons )
{

    array_push( $buttons, 'ecficons' );

    return $buttons;

}

//include the tinymce javascript plugin
function ecf_tinymce_mceplugin( $plugin_array )
{

    $plugin_array['ecficons'] = ECF_URL.'/inc/tinymce_plugin/ecf_editor_plugin.js';

    return $plugin_array;

}

/**
 * Enqueue block editor style
 */
function ecf_block_editor_mcebtn_styles()
{

    wp_enqueue_style( 'ecf-icon-editor-styles', ECF_URL.'/inc/tinymce_plugin/ecf_mcebutton_style.css', false, '1.0', 'all' );

}