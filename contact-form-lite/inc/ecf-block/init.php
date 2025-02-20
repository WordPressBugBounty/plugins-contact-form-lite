<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.

if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! class_exists( 'Ecf_Block' ) ) {

    class Ecf_Block
    {

        public function __construct()
        {

            add_action( 'init', [ $this, 'register_block_action' ] );

        }

        public function register_block_action()
        {

            if ( ! function_exists( 'register_block_type' ) ) {
                return;
            }

            $script_slug       = 'ecf-block-js';
            $style_slug        = 'ecf-block-style-css';
            $editor_style_slug = 'ecf-block-editor-css';

            wp_register_script(
                $script_slug,                                       // Handle.
                plugin_dir_url( __FILE__ ).'/dist/blocks.build.js', // Block.build.js: We register the block here. Built with Webpack.
                [ 'wp-blocks', 'wp-i18n', 'wp-element' ]         // Dependencies, defined above.
            );

            // Styles.
            wp_register_style(
                $style_slug,                                               // Handle.
                plugin_dir_url( __FILE__ ).'/dist/blocks.style.build.css', // Block style CSS.
                [ 'wp-blocks' ]                                         // Dependency to include the CSS after it.
            );

            wp_register_style(
                $editor_style_slug,                                         // Handle.
                plugin_dir_url( __FILE__ ).'/dist/blocks.editor.build.css', // Block editor CSS.
                [ 'wp-edit-blocks' ]                                     // Dependency to include the CSS after it.
            );

            register_block_type(
                'ecf-form/block', // Block name with namespace
                [
                    'style'           => $style_slug,        // General block style slug
                    'editor_style'    => $editor_style_slug, // Editor block style slug
                    'editor_script'   => $script_slug,       // The block script slug
                    'attributes'      => [
                        'data' => [
                            'type'    => 'string',
                            'default' => '',
                        ],
                    ],
                    'render_callback' => [ $this, 'render_callback' ],
                ]
            );

            wp_localize_script( 'ecf-block-js', 'ecf_tinymce_vars', [ 'forms' => ecf_get_forms() ] );

        }

        public function render_callback( $attributes, $content = null, $context = 'frontend' )
        {
            if ( ! is_admin() && isset( $attributes[ 'data' ] ) && $attributes[ 'data' ] ) {

                // Sanitize the input data before processing
                $data = sanitize_text_field( $attributes[ 'data' ] );

                // Decode the data
                $tempData  = html_entity_decode( $data );
                $cleanData = json_decode( $tempData );

                // Check if native_shortcode exists in the decoded data
                if ( isset( $cleanData->native_shortcode ) ) {
                    // Escape the output to prevent XSS
                    return esc_html( $cleanData->native_shortcode );
                }

            }

            return '';
        }

    }

    new Ecf_Block();

}
