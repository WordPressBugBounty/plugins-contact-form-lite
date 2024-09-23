<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*-------------------------------------------------------------------------------*/
/*   Backend Register JS & CSS
/*-------------------------------------------------------------------------------*/
function ecf_reg_script()
{

    $is_rtl = ( is_rtl() ? '-rtl' : '' );

    wp_register_style( 'ecf-pricing-css', plugins_url( 'css/pricing.css', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_style( 'ecf-sldr', plugins_url( 'css/slider.css', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_style( 'ecf-tabulous', plugins_url( 'css/tabulous.css', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_style( 'ecf-colorpicker', plugins_url( 'css/colorpicker.css', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_style( 'ecf-activate', plugins_url( 'css/activate.css', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_style( 'ecf-tinymcecss', plugins_url( 'css/tinymce.css', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_script( 'ecf-tinymcejs', plugins_url( 'js/tinymce.js', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_script( 'ecf-colorpickerjs', plugins_url( 'js/colorpicker/colorpicker.js', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_script( 'ecf-eye', plugins_url( 'js/colorpicker/eye.js', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_script( 'ecf-utils', plugins_url( 'js/colorpicker/utils.js', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_style( 'ecf-formbuilder-css', plugins_url( 'css/formbuilder/formbuilder'.$is_rtl.'.css', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_style( 'ecf-formbuilder-vendor-css', plugins_url( 'css/formbuilder/vendor/css/vendor.css', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_style( 'ecf-introcss', plugins_url( 'css/introjs.min.css', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_script( 'ecf-introjs', plugins_url( 'js/jquery/intro.min.js', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_script( 'ecf-formbuilder-core', plugins_url( 'js/formbuilder/formbuilder-core.js', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_script( 'ecf-formbuilder-js', plugins_url( 'js/formbuilder/formbuilder.js', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_style( 'ecf-bootstrap-css', plugins_url( 'css/bootstrap/css/bootstrap.min.css', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_script( 'ecf-bootstrap-js', plugins_url( 'js/bootstrap/bootstrap.min.js', dirname( __FILE__ ) ) );
    wp_register_script( 'ecf-wnew', plugins_url( 'js/wnew/ecf-wnew.js', dirname( __FILE__ ) ), false, ECF_VERSION );
    wp_register_script( 'ecf-lazyload', plugins_url( 'js/jquery/jquery.lazy.min.js', dirname( __FILE__ ) ), false, ECF_VERSION );

}

add_action( 'admin_init', 'ecf_reg_script' );

/*-------------------------------------------------------------------------------*/
/*   Frontend Register JS & CSS
/*-------------------------------------------------------------------------------*/
function ecf_frontend_js()
{

    wp_register_script( 'ecf-validate', ECF_URL.'/js/jquery/jquery.validate.min.js', false, ECF_VERSION );
    wp_register_style( 'ecf-frontend-css', ECF_URL.'/css/frontend.css', false, ECF_VERSION );
    wp_register_script( 'ecf-ladda', ECF_URL.'/js/jquery/ladda/ladda.jquery.js', false, ECF_VERSION );
    wp_register_script( 'ecf-ladda-js', ECF_URL.'/js/jquery/ladda/ladda.min.js', false, ECF_VERSION );
    wp_register_script( 'ecf-ladda-spin', ECF_URL.'/js/jquery/ladda/spin.js', false, ECF_VERSION );
    wp_register_script( 'ecf-notify', ECF_URL.'/js/jquery/notify.min.js', false, ECF_VERSION );
    wp_register_script( 'ecf-placeholder', ECF_URL.'/js/jquery/jquery.placeholder.min.js', false, ECF_VERSION );
}

add_action( 'wp_enqueue_scripts', 'ecf_frontend_js' );

/*-------------------------------------------------------------------------------*/
/*   AJAX Get Form List
/*-------------------------------------------------------------------------------*/
function ecf_grab_form_list_ajax()
{

    if ( ! isset( $_POST[ 'grabform' ] ) ) {
        die( '' );
    } else {

        $list = [  ];

        global $post;

        $args = [
            'post_type'      => 'easycontactform',
            'order'          => 'ASC',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
         ];

        $myposts = get_posts( $args );
        foreach ( $myposts as $post ): setup_postdata( $post );

            $list[ $post->ID ] = [ 'val' => $post->ID, 'title' => esc_html( esc_js( the_title( null, null, false ) ) ) ];

        endforeach;

    }

    echo json_encode( $list ); //Send to Option List ( Array )
    die();

}

add_action( 'wp_ajax_ecf_grab_form_list_ajax', 'ecf_grab_form_list_ajax' );

/*-------------------------------------------------------------------------------*/
/*   CHECK BROWSER VERSION ( IE ONLY )
/*-------------------------------------------------------------------------------*/
function ecf_check_browser_version_admin( $sid )
{

    if ( is_admin() && get_post_type( $sid ) == 'easycontactform' ) {

        preg_match( '/MSIE (.*?);/', $_SERVER[ 'HTTP_USER_AGENT' ], $matches );
        if ( count( $matches ) > 1 ) {
            $version = explode( '.', $matches[ 1 ] );
            switch ( true ) {
                case ( $version[ 0 ] <= '8' ):
                    $msg = 'ie8';

                    break;

                case ( $version[ 0 ] > '8' ):
                    $msg = 'gah';

                    break;

                default:
            }

            return $msg;
        } else {
            $msg = 'notie';

            return $msg;
        }
    }
}

/*-------------------------------------------------------------------------------*/
/*  Random String
/*-------------------------------------------------------------------------------*/
function ecfRandomString( $length )
{
    $original_string = array_merge( range( 'a', 'z' ), range( 'A', 'Z' ) );
    $original_string = implode( '', $original_string );

    return substr( str_shuffle( strtolower( $original_string ) ), 0, $length );
}

/*-------------------------------------------------------------------------------*/
/*   CSS Compressor
/*-------------------------------------------------------------------------------*/
function ecf_css_compress( $minify )
{
    /* remove comments */
    $minify = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $minify );

    /* remove tabs, spaces, newlines, etc. */
    $minify = str_replace( [ "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ], '', $minify );

    return $minify;
}

/*-------------------------------------------------------------------------------*/
/*   JS Compressor
/*-------------------------------------------------------------------------------*/
function ecf_js_compress( $minify )
{

    $replace = [
        '#\'([^\n\']*?)/\*([^\n\']*)\'#' => "'\1/'+\'\'+'*\2'", // remove comments from ' strings
        '#\"([^\n\"]*?)/\*([^\n\"]*)\"#' => '"\1/"+\'\'+"*\2"', // remove comments from " strings
        '#/\*.*?\*/#s'    => '',                                // strip C style comments
        '#[\r\n]+#'                   => "\n",                  // remove blank lines and \r's
        '#\n([ \t]*//.*?\n)*#s' => "\n",                        // strip line comments (whole line only)
        '#([^\\])//([^\'"\n]*)\n#s' => "\\1\n",
        '#\n\s+#'                        => "\n", // strip excess whitespace
        '#\s+\n#'                        => "\n", // strip excess whitespace
        '#(//[^\n]*\n)#s' => "\\1\n",             // extra line feed after any comments left
                                                  // (important given later replacements)
        '#/([\'"])\+\'\'\+([\'"])\*#' => '/*',    // restore comments in strings
     ];

    $search = array_keys( $replace );
    $script = preg_replace( $search, $replace, $minify );

    $replace = [
        "&&\n" => '&&',
        "||\n" => '||',
        "(\n"  => '(',
        ")\n"  => ')',
        "[\n"  => '[',
        "]\n"  => ']',
        "+\n"  => '+',
        ",\n"  => ',',
        "?\n"  => '?',
        ":\n"  => ':',
        ";\n"  => ';',
        "{\n"  => '{',
//  "}\n"  => "}", (because I forget to put semicolons after function assignments)
        "\n]"  => ']',
        "\n)"  => ')',
        "\n}"  => '}',
        "\n\n" => "\n",
     ];

    $search = array_keys( $replace );
    $script = str_replace( $search, $replace, $script );

    return trim( $script );

}

/*-------------------------------------------------------------------------------*/
/*  Frontend Notification
/*-------------------------------------------------------------------------------*/
function ecf_notify( $tp, $pid = null )
{

    switch ( $tp ) {

        case 'formelement':
            $ecffront = '<div class="ecf_center"><div class="ecf-infobox">You have to insert at least one Name field, one Email field and one Textarea ( message box ) field.<br />Click <a href="'.admin_url( 'post.php?post='.$pid.'&action=edit' ).'">'.__( 'here', 'contact-form-lite' ).'</a> to edit your Form.</div></div>';
            break;

        default:
            break;

    }

    echo wp_kses( $ecffront, ecf_wp_kses_allowed_html() );
}

/*-------------------------------------------------------------------------------*/
/*  Slipt Newline
/*-------------------------------------------------------------------------------*/
function ecf_splitNewLine( $text )
{
    $code = preg_replace( '/\n$/', '', preg_replace( '/^\n/', '', preg_replace( '/[\r\n]+/', "\n", $text ) ) );
    $is   = explode( "\n", $code );

    $results = [  ];

    foreach ( $is as $key ) {
        $exploded                  = explode( ':', $key );
        $results[ $exploded[ 0 ] ] = $exploded[ 1 ];
    }

    return $results;

}

/*-------------------------------------------------------------------------------*/
/*  Return to Bytes
/*-------------------------------------------------------------------------------*/
function ecf_return_bytes( $val )
{
    $val  = trim( $val );
    $last = strtolower( $val[ strlen( $val ) - 1 ] );
    switch ( $last ) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

/*-------------------------------------------------------------------------------*/
/* Input Clean Up
/*-------------------------------------------------------------------------------*/
function ecf_clean_input( $string, $preserve_space = 0 )
{
    if ( is_string( $string ) ) {
        if ( $preserve_space ) {
            return ecf_sanitize_string( wp_strip_all_tags( stripslashes( $string ) ), $preserve_space );
        }

        return trim( ecf_sanitize_string( wp_strip_all_tags( stripslashes( $string ) ) ) );
    } else if ( is_array( $string ) ) {
        reset( $string );
        while ( list( $key, $value ) = each( $string ) ) {
            $string[ $key ] = ecf_sanitize_string( $value, $preserve_space );
        }

        return $string;
    } else {
        return $string;
    }
}

function ecf_sanitize_string( $string, $preserve_space = 0 )
{
    if ( ! $preserve_space ) {
        $string = preg_replace( '/ +/', ' ', trim( $string ) );
    }

    return preg_replace( '/[<>]/', '_', $string );
}

/*-------------------------------------------------------------------------------*/
/*  HEX to RGB
/*-------------------------------------------------------------------------------*/
function ecf_hex2rgb( $hex )
{
    $hex = str_replace( '#', '', $hex );

    if ( strlen( $hex ) == 3 ) {
        $r = hexdec( substr( $hex, 0, 1 ).substr( $hex, 0, 1 ) );
        $g = hexdec( substr( $hex, 1, 1 ).substr( $hex, 1, 1 ) );
        $b = hexdec( substr( $hex, 2, 1 ).substr( $hex, 2, 1 ) );
    } else {
        $r = hexdec( substr( $hex, 0, 2 ) );
        $g = hexdec( substr( $hex, 2, 2 ) );
        $b = hexdec( substr( $hex, 4, 2 ) );
    }
    $rgb = [ $r, $g, $b ];
    //return implode(",", $rgb); // returns the rgb values separated by commas

    return implode( ',', $rgb ); // returns an array with the rgb values
}

/*-------------------------------------------------------------------------------*/
/*  Create Upgrade Metabox
/*-------------------------------------------------------------------------------*/
function ecf_upgrade_metabox()
{
    $ecfbuy = '<div style="text-align:center;">';
    $ecfbuy .= '<a id="ecfprcngtableclr" style="outline: none !important;" href="#"><img class="ecfhvrbutton" style="cursor:pointer; margin-top: 7px;" src="'.plugins_url( 'images/buy-now.png', dirname( __FILE__ ) ).'" width="241" height="95" alt="Buy Now!" ></a>';
    $ecfbuy .= '</div>';
    echo wp_kses( $ecfbuy, ecf_wp_kses_allowed_html() );
}

/*-------------------------------------------------------------------------------*/
/*  Create Pro Demo Metabox
/*-------------------------------------------------------------------------------*/
function ecf_prodemo_metabox()
{
    $enobuy = '<div style="text-align:center;">';
    $enobuy .= '<a id="ecfdemotableclr" style="outline: none !important;" target="_blank" href="http://demo.ghozylab.com/plugins/easy-contact-form-plugin/demo-form-registration/"><img class="ecfhvrbutton" style="cursor:pointer; margin-top: 7px;" src="'.plugins_url( 'images/view-demo-button.jpg', dirname( __FILE__ ) ).'" width="232" height="60" alt="Pro Version Demo" ></a>';
    $enobuy .= '</div>';
    echo wp_kses( $enobuy, ecf_wp_kses_allowed_html() );
}

/*-------------------------------------------------------------------------------*/
/*  RENAME POST BUTTON @since 1.0.1
/*-------------------------------------------------------------------------------*/
function easycform_change_publish_button( $translation, $text )
{
    if ( 'easycontactform' == get_post_type() ) {
        if ( $text == 'Publish' ) {
            return 'Save Form';
        } else if ( $text == 'Update' ) {
            return 'Update Form';
        }
    }

    return $translation;
}

add_filter( 'gettext', 'easycform_change_publish_button', 10, 2 );

/*-------------------------------------------------------------------------------*/
/*  WordPress Pointers 
/*-------------------------------------------------------------------------------*/
function easycform_pointer_header()
{
    $enqueue = false;

    $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    if ( ! in_array( 'easycform_pointer', $dismissed ) ) {
        $enqueue = true;
        add_action( 'admin_print_footer_scripts', 'easycform_pointer_footer' );
    }

    if ( $enqueue ) {
        // Enqueue pointers
        wp_enqueue_script( 'wp-pointer' );
        wp_enqueue_style( 'wp-pointer' );
    }
}

function easycform_pointer_footer()
{
    $pointer_content = '<h3>Thank You!</h3>';
    $pointer_content .= '<p>You&#39;ve just installed '.esc_html( ECF_ITEM_NAME ).'. Click here to get short tutorial and user guide plugin.</p><p>To close this notify permanently just click dismiss button below.</p>';
    ?>

<script type="text/javascript">// <![CDATA[
jQuery(document).ready(function($) {

if (typeof(jQuery().pointer) != 'undefined') {
    $('.ecf-intro-help').pointer({
        content: '<?php echo wp_kses( $pointer_content, ecf_wp_kses_allowed_html() ); ?>',
        position: {
            edge: 'left',
            align: 'center'
        },
        close: function() {
            $.post( ajaxurl, {
                pointer: 'easycform_pointer',
               action: 'dismiss-wp-pointer'
            });
        }
    }).pointer('open');

}

});
// ]]></script>
<?php
}

/*-------------------------------------------------------------------------------*/
/*   GENERATE SHARE BUTTONS
/*-------------------------------------------------------------------------------*/
function easycform_share()
{
    ?>
<div style="position:relative; margin-top:6px;">
<ul class='easycform-social' id='easycform-cssanime'>
<li class='easycform-facebook'>
<a onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=Check out the Best Contact Form Wordpress Plugin&amp;p[summary]=Best Contact Form Wordpress Plugin is powerful plugin to create Contact Form in minutes&amp;p[url]=http://demo.ghozylab.com/plugins/easy-contact-form-plugin/&amp;p[images][0]=<?php echo esc_url( ECF_URL.'/css/images/assets/best-cp-feed.png' ); ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)" title="Share"><strong>Facebook</strong></a>
</li>
<li class='easycform-twitter'>
<a onclick="window.open('https://twitter.com/share?text=Best Wordpress Contact Form Plugin &url=http://demo.ghozylab.com/plugins/easy-contact-form-plugin/', 'sharer', 'toolbar=0,status=0,width=548,height=325');" title="Twitter" class="circle"><strong>Twitter</strong></a>
</li>
<li class='easycform-googleplus'>
<a onclick="window.open('https://plus.google.com/share?url=http://demo.ghozylab.com/plugins/easy-contact-form-plugin/','','width=415,height=450');"><strong>Google+</strong></a>
</li>
<li class='easycform-pinterest'>
<a onclick="window.open('http://pinterest.com/pin/create/button/?url=http://demo.ghozylab.com/plugins/easy-contact-form-plugin/;media=<?php echo esc_url( ECF_URL.'/css/images/assets/best-cp-feed.png' ); ?>;description=Best Contact Form Wordpress Plugin','','width=600,height=300');"><strong>Pinterest</strong></a>
</li>
</ul>
</div>

    <?php
}

/*-------------------------------------------------------------------------------*/
/*  Addons Page WP Pointer
/*-------------------------------------------------------------------------------*/
function ecf_addons_pointer()
{
    $enqueue = false;

    $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    if ( ! in_array( 'ecf_add_pointer', $dismissed ) ) {
        $enqueue = true;
        add_action( 'admin_print_footer_scripts', 'ecf_add_pointer_footer' );
    }

    if ( $enqueue ) {
        // Enqueue pointers
        wp_enqueue_script( 'wp-pointer' );
        wp_enqueue_style( 'wp-pointer' );
    }
}

function ecf_add_pointer_footer()
{
    $add_pointer_content = '<h3>Good News !</h3>';
    $add_pointer_content .= '<p>In this version you can easily integrate several <strong>Pro Version</strong> features using Addons.<br />';
    ?>

<script type="text/javascript">// <![CDATA[
jQuery(document).ready(function($) {

if (typeof(jQuery().pointer) != 'undefined') {
    $('#ecf_meta_formbuilder').pointer({
        content: '<?php echo wp_kses( $add_pointer_content, ecf_wp_kses_allowed_html() ); ?>',
        position: {
			edge: 'bottom',
            align: 'center'
        },
        close: function() {
            $.post( ajaxurl, {
                pointer: 'ecf_add_pointer',
               action: 'dismiss-wp-pointer'
            });
        }
    }).pointer('open');

}

});
// ]]></script>
<?php
}

/*-------------------------------------------------------------------------------*/
/* Get latest info on What's New page
/*-------------------------------------------------------------------------------*/
function ecf_lite_get_news()
{

    if ( false === ( $cache = get_transient( 'ecf_lite_whats_new' ) ) ) {

        $url = [
            'c' => 'news',
            'p' => 'ecflite',
         ];

        $feed = wp_remote_get( 'http://content.ghozylab.com/feed.php?'.http_build_query( $url ).'', [ 'sslverify' => false ] );

        if ( ! is_wp_error( $feed ) ) {
            if ( isset( $feed[ 'body' ] ) && strlen( $feed[ 'body' ] ) > 0 ) {
                $cache = wp_remote_retrieve_body( $feed );
                set_transient( 'ecf_lite_whats_new', $cache, 60 );
            }
        } else {
            $cache = '<div class="error"><p>'.__( 'There was an error retrieving the list from the server. Please try again later.', 'contact-form-lite' ).'</div>';
        }
    }
    echo wp_kses( $cache, ecf_wp_kses_allowed_html() );
}

/*-------------------------------------------------------------------------------*/
/* Get Affiliate data
/*-------------------------------------------------------------------------------*/
function ecf_get_aff_option( $option_name, $key, $default = false )
{

    $options = get_option( $option_name );

    if ( $options ) {
        return ( array_key_exists( $key, $options ) ) ? $options[ $key ] : $default;
    }

    return $default;
}

/*-------------------------------------------------------------------------------*/
/* Update Affiliate data
/*-------------------------------------------------------------------------------*/
function ecf_update_aff_info( $aff_data, $email )
{
    $aff = [
        'ecf_aff_id'    => trim( $aff_data->aff_id ),
        'ecf_aff_name'  => trim( $aff_data->aff_name ),
        'ecf_aff_email' => trim( $email ),

     ];

    update_option( 'ecf_affiliate_info', $aff );

}

/*-------------------------------------------------------------------------------*/
/* Defined for using CURL or Not
/*-------------------------------------------------------------------------------*/
function _affiliateFetchmode( $api_params )
{

    if ( function_exists( 'curl_version' ) ) {

        $response = wp_remote_get( add_query_arg( $api_params, ECF_API_URLCURL ), [ 'timeout' => 15, 'sslverify' => false ] );

        if ( is_wp_error( $response ) ) {
            return false;
        }

        $dat = json_decode( wp_remote_retrieve_body( $response ) );

    } else {

        $json_url = add_query_arg( $api_params, ECF_API_URL );
        $response = wp_remote_get( $json_url );

        if ( is_wp_error( $response ) ) {
            return false;
        } else {
            $json = wp_remote_retrieve_body( $response );
            $dat  = json_decode( $json );

            return $dat;
        }

    }

    return $dat;

}

/*-------------------------------------------------------------------------------*/
/*  Create Preview Metabox @since 1.0.41
/*-------------------------------------------------------------------------------*/
function ecf_news_metabox()
{
    $ecfprev = '<div style="margin-left:5px;"><ul class="ecfcheckthisout">';
    $ecfprev .= '<li><a href="https://ghozy.link/hwi4g" target="_blank">Best Page Builder Plugin</a><span style="padding:2px 6px 2px 6px;background-color: #E74C3C; border-radius:9px;margin-left:7px;color:#fff;font-size:11px;">Best Seller</span></li>';
    $ecfprev .= '<li><a href="https://ghozylab.com/plugins/easy-media-gallery-pro/demo/best-gallery-and-photo-albums-demo/" target="_blank">Best Gallery Plugin</a></li>';
    $ecfprev .= '</ul></div>';
    echo wp_kses( $ecfprev, ecf_wp_kses_allowed_html() );
}

/*-------------------------------------------------------------------------------*/
/*  Duplicate Forms @since 1.0.70
/*-------------------------------------------------------------------------------*/
function ecf_duplicate_form()
{

    if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Security Issue!' );
    }

    if ( ! check_ajax_referer( 'ecf-duplicate-nonce', 'nonce' ) && ( isset( $_GET[ 'nonce' ] ) && ! wp_verify_nonce( $_GET[ 'nonce' ], 'ecf-duplicate-nonce' ) ) ) {
        wp_die( 'Security Issue!' );
    }

    if ( ! ( isset( $_GET[ 'post' ] ) || isset( $_POST[ 'post' ] ) || ( isset( $_REQUEST[ 'action' ] ) && 'ecf_duplicate_form' == $_REQUEST[ 'action' ] ) ) ) {
        wp_die( 'No post to duplicate has been supplied!' );
    }

    /*
     * get the original post id
     */
    $post_id = ( isset( $_GET[ 'post' ] ) ? $_GET[ 'post' ] : $_POST[ 'post' ] );
    $post_id = intval( $post_id );
    /*
     * and all the original post data then
     */
    $post = get_post( $post_id );

    /*
     * if you don't want current user to be the new post author,
     * then change next couple of lines to this: $new_post_author = $post->post_author;
     */
    $current_user    = wp_get_current_user();
    $new_post_author = $current_user->ID;

    /*
	* if post data exists, create the post duplicate
	*/
    if ( isset( $post ) && $post != null ) {

        /*
         * new post data array
         */
        $args = [
            'comment_status' => $post->comment_status,
            'ping_status'    => $post->ping_status,
            'post_author'    => $new_post_author,
            'post_content'   => $post->post_content,
            'post_excerpt'   => $post->post_excerpt,
            'post_name'      => $post->post_name,
            'post_parent'    => $post->post_parent,
            'post_password'  => $post->post_password,
            'post_status'    => 'draft',
            'post_title'     => 'COPY of '.$post->post_title,
            'post_type'      => $post->post_type,
            'to_ping'        => $post->to_ping,
            'menu_order'     => $post->menu_order,
         ];

        /*
         * insert the post by wp_insert_post() function
         */
        $new_post_id = wp_insert_post( $args );

        $data = get_post_custom( $post_id );

        foreach ( $data as $key => $values ) {

            foreach ( $values as $value ) {
                add_post_meta( $new_post_id, $key, maybe_unserialize( $value ) );
            }

        }

        /*
		* finally, redirect to the edit post screen for the new draft
		*/

        if ( wp_get_referer() ) {

            wp_safe_redirect( wp_get_referer() );

        } else {

            wp_redirect( admin_url( 'post.php?action=edit&post='.$new_post_id ) );

        }

        exit;
    } else {
        wp_die( 'Post creation failed, could not find original post: '.esc_html( $post_id ) );
    }

}

add_action( 'wp_ajax_ecf_duplicate_form', 'ecf_duplicate_form' );

/*-------------------------------------------------------------------------------*/
/*  Admin Bar @since 1.0.75
/*-------------------------------------------------------------------------------*/
function ecf_add_toolbar_items( $admin_bar )
{

    $admin_bar->add_menu( [
        'id'     => 'ecf-tb-item',
        'title'  => '<span style="padding:5px;margin-left: 5px;margin-right: 5px;color:#fff;background-color: #f44;background-image:-moz-linear-gradient(bottom,#0074A2, #009DD9);
	background-image: -webkit-gradient(linear, left bottom, left top, from(#0074A2), to(#009DD9));"><img src="'.plugins_url( 'images/ecf-cp-icon.png', dirname( __FILE__ ) ).'" style="vertical-align:middle;margin-right:5px" alt="Contact Form Plugin" title="Contact Form Plugin" />UPGRADE EASY FORM TO PRO VERSION</span>',
        'href'   => 'https://ghozylab.com/plugins/ordernow.php?order=ecfproplus&utm_source=adminbar&utm_medium=ecf_adminbar&utm_campaign=ecf_adminbar',
        'target' => '_blank',
        'meta'   => [
            'title'  => __( 'Upgrade to Pro Version' ),
            'target' => '_blank',
         ],
     ] );

}

add_action( 'admin_head', 'ecf_add_toolbar_items_handler' );

function ecf_add_toolbar_items_handler()
{

    global $current_screen;

    if ( isset( $current_screen ) && 'easycontactform' == $current_screen->post_type ) {

        add_action( 'admin_bar_menu', 'ecf_add_toolbar_items', 100 );

    }

}

function ecf_get_forms()
{

    $args = [
        'post_type'      => 'easycontactform',
        'order'          => 'ASC',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
     ];

    $gt = get_posts( $args );

    $forms = [  ];

    if ( $gt ) {
        foreach ( $gt as $ce ) {
            $forms[  ] = [ 'id' => ''.$ce->ID.'', 'name' => $ce->post_title ];
        }
    }

    return $forms;

}

function ecf_posts_notify( $hook )
{

    if ( get_option( 'ecf_block_notify' ) == '' ) {

        $current_user = wp_get_current_user();
        $cnt          = '<span class="cd_pp_content"><span class="ppp_user">'.__( 'Hello', 'contact-form-lite' ).' '.( $current_user->user_firstname ? $current_user->user_firstname : $current_user->user_login ).'</span>'.__( 'Now you can easily insert Contact Form Lite from Block > Common Blocks > Contact Form Lite', 'contact-form-lite' ).'</span><span class="cd_pp_img"><img src="'.ECF_URL.'/inc/images/ecf_block.gif'.'"></span>';

        wp_enqueue_style( 'ecf-post-css', plugins_url( 'css/post.css', dirname( __FILE__ ) ) );
        wp_enqueue_script( 'ecf-post', plugins_url( 'js/post/post.js', dirname( __FILE__ ) ) );
        wp_localize_script( 'ecf-post', 'ecf_popup', [ 'content' => $cnt ] );

    }

}

add_action( 'enqueue_block_editor_assets', 'ecf_posts_notify' );

function ecf_hide_notify()
{

    update_option( 'ecf_block_notify', 'done' );

    wp_die();

}

add_action( 'wp_ajax_ecf_hide_notify', 'ecf_hide_notify' );

function ecf_wp_kses_allowed_html( $mode = false )
{

    $custom_allowed_tags = [
        'a'        => [
            'itemprop' => true,
            'onclick'  => true,
            'href'     => true,
            'title'     => true,
            'class'    => true,
         ],
        'cite'     => [
            'class' => true,
         ],
        'strong'   => [
            'class' => true,
         ],
        'aside'    => [
            'data-section' => true,
         ],
        'canvas'   => [
            'class'  => true,
            'height' => true,
            'id'     => true,
            'width'  => true,
            'style'  => true,
         ],
        'div'      => [
            'itemscope' => true,
            'itemprop'  => true,
            'itemtype'  => true,
         ],
        'h1'       => [
            'itemprop' => true,
            'data-*'   => true,
         ],
        'svg'      => [
            'xmlns'               => true,
            'fill'                => true,
            'viewbox'             => true,
            'preserveaspectratio' => true,
            'shape-rendering'     => true,
            'role'                => true,
            'aria-hidden'         => true,
            'focusable'           => true,
            'height'              => true,
            'width'               => true,
            'class'               => true,
            'stroke-linejoin'     => true,
            'stroke-miterlimit'   => true,
            'data-*'              => true,
            'clip-rule'           => true,
            'fill-rule'           => true,
            'fill-opacity'        => true,
            'style'               => true,
            'transform'           => true,
         ],
        'path'     => [
            'style'        => true,
            'd'            => true,
            'fill'         => true,
            'fill-opacity' => true,
            'class'        => true,
            'opacity'      => true,
            'transform'    => true,
         ],
        'g'        => [
            'id'    => true,
            'fill'  => true,
            'style' => true,
         ],
        'circle'   => [
            'cx'        => true,
            'cy'        => true,
            'r'         => true,
            'fill'      => true,
            'class'     => true,
            'opacity'   => true,
            'transform' => true,
            'style'     => true,
         ],
        'line'     => [
            'x1'           => true,
            'y1'           => true,
            'x2'           => true,
            'y2'           => true,
            'stroke'       => true,
            'stroke-width' => true,
            'class'        => true,
            'opacity'      => true,
            'style'        => true,
         ],
        'form'     => [
            'method'  => true,
            'class'   => true,
            'action'  => true,
            'role'    => true,
            'data-*'  => true,
            'id'      => true,
            'style'   => true,
            'enctype' => true,
         ],
        'input'    => [
            'type'         => true,
            'class'        => true,
            'id'           => true,
            'value'        => true,
            'accept'       => true,
            'checked'      => true,
            'readonly'     => true,
            'name'         => true,
            'min'          => true,
            'max'          => true,
            'step'         => true,
            'placeholder'  => true,
            'autocomplete' => true,
            'data-*'       => true,
            'onblur'       => true,
            'onfocus'      => true,
            'style'        => true,
         ],
        'textarea' => [
            'type'         => true,
            'rows'         => true,
            'cols'         => true,
            'class'        => true,
            'id'           => true,
            'value'        => true,
            'name'         => true,
            'readonly'     => true,
            'maxlength'    => true,
            'spellcheck'   => true,
            'placeholder'  => true,
            'autocomplete' => true,
            'data-*'       => true,
            'style'        => true,
         ],
        'select'   => [
            'id'     => true,
            'class'  => true,
            'name'   => true,
            'data-*' => true,
            'style'  => true,
         ],
        'option'   => [
            'id'       => true,
            'class'    => true,
            'selected' => true,
            'disabled' => true,
            'value'    => true,
            'data-*'   => true,
            'style'    => true,
         ],
        'optgroup' => [
            'label' => true,
            'class' => true,
         ],
        'meta'     => [
            'itemscope' => true,
            'itemprop'  => true,
            'itemtype'  => true,
            'itemType'  => true,
            'content'   => true,
         ],
        'article'  => [
            'itemprop'  => true,
            'itemscope' => true,
            'itemtype'  => true,
         ],
        'iframe'   => [
            'id'              => true,
            'src'             => true,
            'class'           => true,
            'height'          => true,
            'width'           => true,
            'frameborder'     => true,
            'allowfullscreen' => true,
            'data-*'          => true,
            'style'           => true,
         ],
        'source'   => [
            'src'    => true,
            'type'   => true,
            'data-*' => true,
         ],
        'script'   => [
            'type' => true,
         ],
         'style'   => [
            'type' => true,
         ],
     ];

    // Get the default allowed tags for post content
    $default_allowed_tags = wp_kses_allowed_html( 'post' );

    // Merge arrays
    $merged_allowed_tags = ecf_array_merge_recursive_custom( $default_allowed_tags, $custom_allowed_tags );

    if ( $mode ) {
        if ( $mode === 'html' ) {
            $custom_html_tags = [
                'html' => [
                    'xmlns' => true,
                    'style' => true,
                 ],
                'head' => [  ],
                'meta' => [
                    'charset' => true,
                    'name'    => true,
                 ],
                'body' => [
                    'class' => true,
                    'style' => true,
                 ],
                'link' => [
                    'rel'   => true,
                    'id'    => true,
                    'href'  => true,
                    'media' => true,
                 ],
             ];

            $merged_allowed_tags = ecf_array_merge_recursive_custom( $merged_allowed_tags, $custom_html_tags );
        }
    }

    // Apply filters if needed
    $merged_allowed_tags = apply_filters( 'ecf_custom_allowed_tags', $merged_allowed_tags );

    return $merged_allowed_tags;

}

function ecf_array_merge_recursive_custom( $array1, $array2 )
{

    foreach ( $array2 as $key => $value ) {
        if ( is_array( $value ) && isset( $array1[ $key ] ) && is_array( $array1[ $key ] ) ) {
            $array1[ $key ] = ecf_array_merge_recursive_custom( $array1[ $key ], $value );
        } else {
            $array1[ $key ] = $value;
        }
    }

    return $array1;

}
