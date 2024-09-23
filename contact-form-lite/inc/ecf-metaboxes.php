<?php
/**
 * Add a custom Meta Box
 *
 * @param array $meta_box Meta box input data
 */

/*-----------------------------------------------------------------------------------*/
/*  Right Upgrade Metabox
/*-----------------------------------------------------------------------------------*/
function ecf_custom_metabox()
{
    add_meta_box( 'ecfdemodiv', __( 'AMAZING Pro Version DEMO' ), 'ecf_prodemo_metabox', 'easycontactform', 'side', 'default' );
    add_meta_box( 'ecfbuydiv', __( 'Upgrade to Pro Version' ), 'ecf_upgrade_metabox', 'easycontactform', 'side', 'default' );
    add_meta_box( 'ecfnewsvdiv', __( 'Check This Out!' ), 'ecf_news_metabox', 'easycontactform', 'side', 'default' );
}

add_action( 'do_meta_boxes', 'ecf_custom_metabox' );
add_action( 'admin_head', 'ecf_admin_head_script' );
add_action( 'admin_enqueue_scripts', 'ecf_load_script', 10, 1 );
//add_action( 'admin_enqueue_scripts', 'ecf_addons_pointer' );

function ecf_load_script()
{

    if ( strstr( $_SERVER[ 'REQUEST_URI' ], 'wp-admin/post-new.php' ) || strstr( $_SERVER[ 'REQUEST_URI' ], 'wp-admin/post.php' ) ) {
        if ( get_post_type( get_the_ID() ) == 'easycontactform' ) {

            $is_rtl = ( is_rtl() ? '-rtl' : '' );

            wp_enqueue_style( 'ecf-formbuilder-css' );
            wp_enqueue_style( 'ecf-formbuilder-vendor-css' );
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-widget' );
            wp_enqueue_script( 'jquery-ui-tabs' );
            wp_enqueue_script( 'jquery-ui-mouse' );
            wp_enqueue_script( 'jquery-ui-draggable' );
            wp_enqueue_script( 'jquery-ui-droppable' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( 'ecf-formbuilder-core' );
            wp_enqueue_script( 'ecf-formbuilder-js' );
            wp_enqueue_script( 'ecf-metascript', plugins_url( 'js/metabox/metabox.js', __FILE__ ), false, ECF_VERSION );
            wp_enqueue_script( 'ecf-ibutton-js', plugins_url( 'js/jquery/jquery.ibutton.js', __FILE__ ) );
            wp_enqueue_style( 'ecf-ibutton-css', plugins_url( 'css/ibutton.css', __FILE__ ), false, ECF_VERSION );
            wp_enqueue_style( 'ecf-metacss', plugins_url( 'css/metabox'.$is_rtl.'.css', __FILE__ ), false, '' );
            wp_enqueue_style( 'ecf-sldr' );
            wp_enqueue_style( 'ecf-tabulous' );
            wp_enqueue_style( 'ecf-colorpicker' );
            wp_enqueue_style( 'ecf-bootstrap-css' );
            wp_enqueue_style( 'ecf-introcss' );
            wp_enqueue_script( 'ecf-introjs' );
            wp_enqueue_script( 'ecf-bootstrap-js' );
            wp_enqueue_script( 'ecf-colorpickerjs' );
            wp_enqueue_script( 'jquery-ui-slider' );
            wp_enqueue_script( 'jquery-effects-highlight' );
            //wp_enqueue_script( 'ecf-no-toggle', plugins_url( 'js/metabox/no-toggle.js' , __FILE__ ), array('jquery'), 1, true ); // @since 1.0.25

            //add_action('admin_footer', 'ecf_scroll' );
            add_action( 'admin_footer', 'ecf_upgrade_popup' );
            //easycform_pointer_header();

            // @since 1.0.13
            if ( has_filter( 'ecf_addons_enqueue' ) ) {
                apply_filters( 'ecf_addons_enqueue', '' );
            }

        }
    }
}

function ecf_admin_head_script()
{
    if ( strstr( $_SERVER[ 'REQUEST_URI' ], 'wp-admin/post-new.php' ) || strstr( $_SERVER[ 'REQUEST_URI' ], 'wp-admin/post.php' ) ) {
        if ( get_post_type( get_the_ID() ) == 'easycontactform' ) {

            ?>
<style type="text/css" media="screen">
a:focus {
    box-shadow: none !important;
}

#minor-publishing {
    display: none !important;
}

#ecf_email_auto_response_ifr {
    height: 270px !important;
}

#ecfdemodiv .inside {
    max-height: 80px !important;
}

#ecfnewsvdiv .inside {
    max-height: 55px !important;
}

#ecfbuydiv .inside {
    max-height: 105px !important;
}
</style>


<script type="text/javascript">
/* Javascript/jQuery Code Here */

var servMax = '<?php echo esc_html( substr( ini_get( 'upload_max_filesize' ), 0, -1 ) ); ?>';

jQuery(document).ready(function($) {

    jQuery('#wp-ecf_email_auto_response-media-buttons a').not('#insert-media-button').hide();

    // Scroll to Top
    /*	jQuery(document).on( 'scroll', function(){
				if (jQuery(window).scrollTop() > 700) {
					jQuery('.ecf-scroll-top-wrapper').addClass('show');
					} else {
						jQuery('.ecf-scroll-top-wrapper').removeClass('show');
					}

				});

    		jQuery('.ecf-scroll-top-wrapper').on('click', ecfPosition); 	*/

    var ecfpos = $('#side-sortables').offset();

    $(window).scroll(function() {
        if ($(window).scrollTop() > ecfpos.top) {
            $('#side-sortables').addClass('fixed');
        } else {
            $('#side-sortables').removeClass('fixed');
        }
    });

    $('#ecf_meta_admin_email_maxup').keyup(function() {
        if (parseInt($(this).val()) > parseInt(servMax)) {
            alert('You can\'t use value greater than ' + servMax + '');
            $(this).val('');
            return false;
        }
    });

    $("#ecf_meta_fileex").keypress(function(e) {
        if (e.which === 32)
            return false;
    });

    $(function() {
        $('#ecf_meta_fileex').on('paste', function(e) {
            var e = $(this);
            setTimeout(function() {
                e.val($.trim(e.val()).replace(/ /g, "\r\n"));
            }, 0);
        });
    });

    $('#tahandle').click(function() {
        $('#ecf_meta_fileex').attr('readonly', !this.checked)
    });

    var links = jQuery('.ecftabcon li a');
    var tabcont = jQuery("#tabs_container");

    jQuery(".ecfdefaulttab").trigger("click");

    jQuery('.ecftabcon li a').on('click', function() {
        jQuery(tabcont).hide();
        jQuery(".tabloader").css("height", "300").addClass("tbloader");
        jQuery(tabcont).find("tr").hide();
        jQuery(tabcont).find("." + jQuery(this).attr("id") + "").fadeIn(500, function() {
            jQuery(tabcont).fadeIn("slow");
            jQuery(".tabloader").css("height", "auto").removeClass("tbloader");
        });

        links.removeClass('tabulous_active');
        jQuery(this).addClass('tabulous_active');


    });


    jQuery(function() {
        fb = new Formbuilder({
            selector: '.fb-main',
            bootstrapData: [
                <?php if ( trim( get_post_meta( get_the_ID(), 'ecf_formbuilder_format', true ) ) ) {

                $phpArray = json_decode( trim( get_post_meta( get_the_ID(), 'ecf_formbuilder_format', true ) ), true );

                foreach ( $phpArray as $key => $value ) {
                    foreach ( $value as $k => $v ) {

                        if ( $v[ 'field_type' ] == 'attachment' ) {
                            $attchHandle = '$( "#ecf-field-attachment" ).prop( "disabled", true ).attr("disabled","disabled");';
                        }

                        echo json_encode( $v ).',';
                    }
                }
            } else {
                echo '
          {
            "label": "Name",
            "field_type": "name",
			"icons": "fa-user",
			"iconpos": "prepend",
            "required": true,
            "field_options": {"size":"medium"},
            "cid": "c1"
          },
          {
            "label": "Email",
            "field_type": "email",
			"icons": "fa-envelope-o",
			"iconpos": "prepend",
            "required": true,
            "field_options": {"size":"medium"},
            "cid": "c2"
          },
          {
            "label": "Subject",
            "field_type": "text",
			"icons": "fa-asterisk",
			"iconpos": "prepend",
            "required": true,
            "field_options": {"size":"medium"},
            "cid": "c3"
          },
          {
            "label": "Message",
            "field_type": "message",
			"icons": "fa-comment",
			"iconpos": "prepend",
            "required": true,
            "field_options": {"size":"large"},
            "cid": "c4"
          },';
            }?>
            ]
        });

        fb.on('save', function(payload) {
            jQuery("#ecf_formbuilder_format").text('');
            jQuery("#ecf_formbuilder_format").text(payload);

        });
        <?php if ( isset( $attchHandle ) ) {echo wp_kses_post( $attchHandle );}?>
    });
});
</script>

<?php
}
    }
}

function ecf_add_meta_box( $meta_box )
{
    if ( ! is_array( $meta_box ) ) {
        return false;
    }

    // Create a callback function
    $callback = function ( $post, $meta_box ) {
        return ecf_create_meta_box( $post, $meta_box[ 'args' ] );
    };

    add_meta_box( $meta_box[ 'id' ], $meta_box[ 'title' ], $callback, $meta_box[ 'page' ], $meta_box[ 'context' ], $meta_box[ 'priority' ], $meta_box );
}

/**
 * Create content for a custom Meta Box
 *
 * @param array $meta_box Meta box input data
 */
function ecf_create_meta_box( $post, $meta_box )
{

    $allowed_html = [
        'a'    => [
            'href'    => true,
            'onclick' => true,
            'class'   => true,
         ],
        'span' => [
            'class' => true,
         ],
     ];

    $allowed_protocols = [
        'http',
        'https',
        'ftp',
        'ftps',
        'mailto',
        'tel',
        'javascript',
     ];

    if ( ! is_array( $meta_box ) ) {
        return false;
    }

    if ( isset( $meta_box[ 'description' ] ) && $meta_box[ 'description' ] != '' ) {
        echo '<p>'.wp_kses( $meta_box[ 'description' ], ecf_wp_kses_allowed_html() ).'</p>';
    }

    if ( isset( $meta_box[ 'istabbed' ] ) && $meta_box[ 'istabbed' ] != '' ) {

        // @since 1.0.13
        $paneltab = '<li><a class="tabulous_active ecfdefaulttab" id="email" href="#tabs-1" title="">Email</a></li><li><a id="layout" href="#tabs-2" title="">Layout & Styles</a></li><li><a id="misc" href="#tabs-3" title="">Miscellaneous</a></li><li><a id="adv" href="#tabs-4" title="">Advanced</a></li>';

        echo '<div id="ecftabs"><ul class="ecftabcon">';

        if ( has_filter( 'ecf_panel_tab' ) ) {
            echo wp_kses_post( apply_filters( 'ecf_panel_tab', $paneltab ) );
        } else {
            echo wp_kses_post( $paneltab );
        }
        echo '</ul><div class="tabloader"><div id="tabs_container">';

    }

    wp_nonce_field( basename( __FILE__ ), 'ecf_meta_box_nonce' );
    echo '<table class="form-table ecf-metabox-table">';

    foreach ( $meta_box[ 'fields' ] as $field ) {
        // Get current post meta data
        $meta = get_post_meta( $post->ID, $field[ 'id' ], true );

        //sanitize output
        if ( is_array( $meta ) ) {

            foreach ( $meta as $k => $v ) {
                $meta[ $k ] = esc_attr( $meta[ $k ] );
            }
        } else {
            $meta = wp_kses_post( $meta );
        }

        if ( isset( $field[ 'isfull' ] ) && $field[ 'isfull' ] == 'yes' ) {
            $isfull = '';
        } else {
            $isfull = '<th><label for="'.esc_attr( $field[ 'id' ] ).'"><strong>'.wp_kses_post( $field[ 'name' ] ).'<br></strong><span>'.wp_kses_post( $field[ 'desc' ] ).'</span></label>'.( isset( $field[ 'needmargin' ] ) && $field[ 'needmargin' ] ? wp_kses_post( $field[ 'needmargin' ] ) : '' ).'</th>';
        }
        echo '<tr '.( $field[ 'type' ] != 'formbuilder' ? 'style="display: block;"' : '' ).' class="'.esc_attr( $field[ 'id' ] ).' '.( isset( $field[ 'group' ] ) && $field[ 'group' ] ? esc_attr( $field[ 'group' ] ) : '' ).' '.( isset( $field[ 'isselector' ] ) && $field[ 'isselector' ] ? esc_attr( $field[ 'isselector' ] ) : '' ).' '.( isset( $field[ 'extragrp' ] ) && $field[ 'extragrp' ] ? esc_attr( $field[ 'extragrp' ].'-fields' ) : '' ).'">'.wp_kses_post( $isfull ).''; // @since 1.0.13

        switch ( $field[ 'type' ] ) {

            case 'text':

                if ( isset( $field[ 'needlefttext' ] ) && $field[ 'needlefttext' ] ) {
                    $max  = '<span style="font-size:12px; font-style:italic;">( Default server Max Limit is : '.ini_get( 'upload_max_filesize' ).' )</span>';
                    $txtw = 'style="text-align: center !important; width: 40px !important; margin-right: 3px !important;"';
                    $in   = substr( ini_get( 'upload_max_filesize' ), -1 ).'&nbsp;&nbsp;';
                } else {
                    $max  = null;
                    $txtw = null;
                    $in   = null;
                }

                echo '<td><input '.esc_attr( $txtw ).' type="text" name="ecf_meta['.esc_attr( $field[ 'id' ] ).']" id="'.esc_attr( $field[ 'id' ] ).'" value="'.( $meta ? esc_attr( $meta ) : esc_attr( $field[ 'std' ] ) ).'" size="30" />'.wp_kses_post( $in.$max ).'</td>';
                break;

            case 'textarea':

                echo '<td>';
                if ( isset( $field[ 'nthick' ] ) && $field[ 'nthick' ] ) {
                    $isd = 'readonly';
                    $tb  = '<input id="tahandle" type="checkbox" />';
                } else {
                    $tb  = null;
                    $isd = null;
                }
                echo '<textarea style="width: 100% !important; vertical-align:top !important;" name="ecf_meta['.esc_attr( $field[ 'id' ] ).']" id="'.esc_attr( $field[ 'id' ] ).'" type="'.esc_attr( $field[ 'type' ] ).'" cols="45" rows="7" '.esc_html( $isd ).'>'.( $meta != '' ? esc_textarea( $meta ) : esc_attr( $field[ 'std' ] ) ).'</textarea>';
                echo wp_kses( $tb, ecf_wp_kses_allowed_html() );
                echo '</div></td>';

                break;

            case 'customsize':

                echo '<td>';
                echo '<div id="cscontw"><strong>Width</strong> <input style="margin-right:5px !important; margin-left:3px; width:43px !important; float:none !important;" name="ecf_meta['.esc_attr( $field[ 'id' ] ).'_'.esc_attr( field[ 'width' ] ).']" id="'.esc_attr( $field[ 'id' ] ).'_w" type="text" value="'.( esc_attr(get_post_meta( $post->ID, 'ecf_cp_thumbsize_'.esc_attr( $field[ 'width' ] ).'', true )) ? esc_attr(get_post_meta( $post->ID, 'ecf_cp_thumbsize_'.esc_attr( $field[ 'width' ] ).'', true )) : esc_attr( $field[ 'stdw' ] ) ).'" />  '.esc_html( $field[ 'pixopr' ] ).'</div>

<span id="cssep" style="border-right:solid 1px #CCC;margin-left:9px; margin-right:10px !important; "></span>
 	<div id="csconth"><strong>Height</strong> <input style="margin-left:3px; margin-right:5px !important; width:43px !important; float:none !important;" name="ecf_meta['.esc_attr( $field[ 'id' ] ).'_'.esc_attr( $field[ 'height' ] ).']" id="'.esc_attr( $field[ 'id' ] ).'_h" type="text" value="'.( esc_attr(get_post_meta( $post->ID, 'ecf_cp_thumbsize_'.esc_attr( $field[ 'height' ] ).'', true )) ? esc_attr(get_post_meta( $post->ID, 'ecf_cp_thumbsize_'.esc_attr( $field[ 'height' ] )).'', true ) : esc_attr( $field[ 'stdh' ] ) ).'" /> '.esc_html( $field[ 'pixopr' ] ).'';
                echo '</div></td>';
                break;

            case 'select':
                echo '<td><select class="ecfmetaselect" name="ecf_meta['.esc_attr( $field[ 'id' ] ).']" id="'.esc_attr( $field[ 'id' ] ).'">';
                foreach ( $field[ 'options' ] as $key => $option ) {

                    if ( $field[ 'needkey' ] ) {
                        $tval = $key;
                    } else {
                        $tval = $option;
                    }

                    echo '<option value="'.esc_attr( $tval ).'"';
                    if ( $meta ) {
                        if ( $meta == $tval ) {
                            echo ' selected="selected"';
                        }

                    } else {
                        if ( $field[ 'std' ] == $tval ) {
                            echo ' selected="selected"';
                        }

                    }
                    echo '>'.esc_html( $option ).'</option>';
                }
                echo '</select></td>';

                break;

            case 'slider':
                echo '<td>';
                ?>

<script type="text/javascript">
/*<![CDATA[*/

jQuery(document).ready(function($) {
    /* Slider init */
    jQuery('#<?php echo esc_html( $field[ 'id' ] ); ?>_slider').slider({
        range: 'min',
        min: <?php echo esc_html( $field[ 'min' ] ); ?>,
        max: <?php echo esc_html( $field[ 'max' ] ); ?>,
        <?php if ( $field[ 'usestep' ] == '1' ) {?>
        step: <?php echo esc_html( $field[ 'step' ] ); ?>,
        <?php }?>
        value: '<?php if ( $meta != '' ) {echo esc_html( $meta );} else {echo esc_html( $field[ 'std' ] );}?>',
        slide: function(event, ui) {
            jQuery("#<?php echo esc_html( $field[ 'id' ] ); ?>").val(ui.value);
        }
    });


});

/*]]>*/
</script>

<?php echo '<span class="ecf_metaslider"><span id="'.esc_attr( $field[ 'id' ] ).'_slider" ></span><input class="pixoprval" name="ecf_meta['.esc_attr( $field[ 'id' ] ).']" id="'.esc_attr( $field[ 'id' ] ).'" type="text" value="'.( $meta != '' ? esc_attr( $meta ) : esc_attr( $field[ 'std' ] ) ).'" /><span id="pixopr">'.esc_attr( $field[ 'pixopr' ] ).'</span></span>';

                echo '</td>';
                break;

            case 'radio':
                echo '<td>';

                if ( ecf_check_browser_version_admin( get_the_ID() ) != 'ie8' ) {
                    foreach ( $field[ 'options' ] as $key => $option ) {
                        echo '<input id="'.esc_attr( $key ).'" type="radio" name="ecf_meta['.esc_attr( $field[ 'id' ] ).']" value="'.esc_attr( $key ).'" class="css-checkbox"';
                        if ( $meta ) {
                            if ( $meta == $key ) {
                                echo ' checked="checked"';
                            }

                        } else {
                            if ( $field[ 'std' ] == $key ) {
                                echo ' checked="checked"';
                            }

                        }
                        echo ' /><label for="'.esc_attr( $key ).'" class="css-label">'.esc_html( $option ).'</label> ';
                    }
                } else {
                    foreach ( $field[ 'options' ] as $key => $option ) {
                        echo '<label class="radio-label"><input type="radio" name="ecf_meta['.esc_attr( $field[ 'id' ] ).']" value="'.esc_attr( $key ).'" class="radio"';
                        if ( $meta ) {
                            if ( $meta == $key ) {
                                echo ' checked="checked"';
                            }

                        } else {
                            if ( $field[ 'std' ] == $key ) {
                                echo ' checked="checked"';
                            }

                        }
                        echo ' /> '.esc_html( $option ).'</label> ';
                    }
                }

                echo '</td>';

                break;

            case 'radioredirect':
                echo '<td>';
                if ( ecf_check_browser_version_admin( get_the_ID() ) != 'ie8' ) {
                    foreach ( $field[ 'options' ] as $key => $option ) {
                        echo '<input id="'.esc_attr( $key ).'" type="radio" name="ecf_meta['.esc_attr( $field[ 'id' ] ).'][]" value="'.esc_attr( $key ).'" class="css-checkbox"';
                        if ( $meta ) {
                            if ( $meta[ 0 ] == $key ) {
                                echo ' checked="checked"';
                            }

                        } else {
                            if ( $field[ 'std' ] == $key ) {
                                echo ' checked="checked"';
                            }

                        }
                        echo ' /><label for="'.esc_attr( $key ).'" class="css-label">'.esc_html( $option ).'</label> ';
                    }
                } else {
                    foreach ( $field[ 'options' ] as $key => $option ) {
                        echo '<label class="radio-label"><input type="radio" name="ecf_meta['.esc_attr( $field[ 'id' ] ).'][]" value="'.esc_attr( $key ).'" class="radio"';
                        if ( $meta ) {
                            if ( $meta[ 0 ] == $key ) {
                                echo ' checked="checked"';
                            }

                        } else {
                            if ( $field[ 'std' ] == $key ) {
                                echo ' checked="checked"';
                            }

                        }
                        echo ' /> '.esc_html( $option ).'</label> ';
                    }
                }

                echo '<div class="ecf_redirect_opt_cont istop"><span>Text</span><input class="redirectinpt" type="text" name="ecf_meta['.esc_attr( $field[ 'id' ] ).'][]" id="'.esc_attr( $field[ 'id' ] ).'_text" value="'.( $meta ? esc_attr( $meta[ 1 ] ) : esc_attr( $field[ 'txt' ] ) ).'" size="45" /></div><div class="ecf_redirect_opt_cont"><span>URL</span><input type="text" class="redirectinpt" name="ecf_meta['.esc_attr( $field[ 'id' ] ).'][]" id="'.esc_attr( $field[ 'id' ] ).'_url" value="'.( $meta ? esc_attr( $meta[ 2 ] ) : esc_attr( $field[ 'url' ] ) ).'" size="45" /></div></td>';

                break;

            case 'checkbox':
                echo '<td>';
                $val = '';
                if ( $meta ) {
                    if ( $meta == 'on' ) {
                        $val = ' checked="checked"';
                    }

                } else {
                    if ( $field[ 'std' ] == 'on' ) {
                        $val = ' checked="checked"';
                    }

                }

                echo '<input type="hidden" name="ecf_meta['.esc_attr( $field[ 'id' ] ).']" value="off" />
                <input class="ecfswitch" type="checkbox" id="'.esc_attr( $field[ 'id' ] ).'" name="ecf_meta['.esc_attr( $field[ 'id' ] ).']" value="on"'.esc_attr( $val ).' />';
                echo '</td>';
                break;

            case 'color':

                ?>
<script type="text/javascript">
/*<![CDATA[*/

jQuery(document).ready(function($) {

    jQuery('#<?php echo esc_html( $field[ 'id' ] ); ?>_picker').children('div').css('backgroundColor',
        '<?php echo ( $meta ? esc_html( $meta ) : esc_html($field[ 'std' ]) ); ?>');
    jQuery('#<?php echo esc_html( $field[ 'id' ] ); ?>_picker').ColorPicker({
        color: '<?php echo ( $meta ? esc_html($meta) : esc_html($field[ 'std' ]) ); ?>',
        onShow: function(colpkr) {
            jQuery(colpkr).fadeIn(500);
            return false;
        },
        onHide: function(colpkr) {
            jQuery(colpkr).fadeOut(500);
            return false;
        },
        onChange: function(hsb, hex, rgb) {
            //jQuery(this).css('border','1px solid red');
            jQuery('#<?php echo esc_html( $field[ 'id' ] ); ?>_picker').children('div').css(
                'backgroundColor', '#' + hex);
            jQuery('#<?php echo esc_html( $field[ 'id' ] ); ?>_picker').next('input').attr('value',
                '#' + hex);
        }
    });

});

/*]]>*/
</script>

<?php

                echo '<td>';
                echo '<div id="'.esc_attr( $field[ 'id' ] ).'_picker" class="colorSelector"><div></div></div>
				<input style="margin-left:10px; width:75px !important;" name="ecf_meta['.esc_attr( $field[ 'id' ] ).']" id="'.esc_attr( $field[ 'id' ] ).'" type="text" value="'.( $meta ? esc_attr( $meta ) : esc_attr( $field[ 'std' ] ) ).'" />';
                echo '</td>';
                break;

            case 'tinymce':

                echo '<td>';
                wp_editor(  ( $meta ? esc_html( $meta ) : esc_html( $field[ 'std' ] ) ), 'ecf_email_auto_response', [
                    'textarea_name' => 'ecf_meta['.esc_html( $field[ 'id' ] ).']',
                    'media_buttons' => true,
                    'textarea_rows' => 15,
                    'wpautop'       => true,
                 ] );
                echo '</td>';

                break;

            case 'formbuilder':

                echo '<td>';

                echo '<div style="height:130px;" id="fbloader" class="tbloader"></div>'; // @since 1.0.25
                echo '<div style="display:none;" class="fb-main"></div>';
                echo '<textarea style="width: 100% !important; vertical-align:top !important; display: none;" name="ecf_meta['.esc_attr( $field[ 'id' ] ).']" id="'.esc_attr( $field[ 'id' ] ).'" type="'.esc_attr( $field[ 'type' ] ).'" cols="45" rows="7">'.( $meta != '' ? esc_textarea( $meta ) : esc_attr( $field[ 'std' ] ) ).'</textarea>';

                echo '</div></td>';
                ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    jQuery(".ecfdefaulttab").trigger("click");
});
</script>
<?php

                break;

            case 'separator':
                echo '<td class="menuseparator">';
                echo '</td>';
                break;

/*-----------------------------------------------------------------------------------*/
        }

        // @since 1.0.13
        if ( has_filter( 'ecf_addons_fields_control' ) ) {
            echo wp_kses( $meta_box[ 'description' ], apply_filters( 'ecf_addons_fields_control', $meta, $field, $post->ID ), ecf_wp_kses_allowed_html() );
        }

        echo '</tr>';
    }

    echo '</table>';

    if ( isset( $meta_box[ 'istabbed' ] ) && $meta_box[ 'istabbed' ] != '' ) {
        echo '</div></div><!--END CON--></div><!--END TAB-->';
    }

}

/*-----------------------------------------------------------------------------------*/
/*	Register related Scripts and Styles
/*-----------------------------------------------------------------------------------*/

// SELECT MEDIA METABOX
add_action( 'add_meta_boxes', 'ecf_metabox_work' );
function ecf_metabox_work()
{

// Form Builder

// Config

    $meta_box = [
        'id'          => 'ecf_meta_formbuilder',
        'title'       => __( 'Form Builder', 'contact-form-lite' ),
        'description' => __( '<span class="ecf-introjs"><a href="#" onclick="startIntro();"><span class="ecf-intro-help"></span>Click Here to learn How to create your first Form</a></span><br /><div class="ecfinfobox">Try Pro Version Directly from Your Site 100% free!<br><a href="https://trial.ghozylab.com/?product=contact-form-pro" target="_blank">Download Now</a></div>', 'contact-form-lite' ),
        'page'        => 'easycontactform',
        'context'     => 'normal',
        'istabbed'    => '',
        'priority'    => 'default',
        'fields'      => [

            [
                'name'   => '',
                'desc'   => '',
                'id'     => 'ecf_formbuilder_format',
                'type'   => 'formbuilder',
                'isfull' => 'yes',
                'std'    => '{"fields":[{"label":"Name","field_type":"name","icons":"fa-user","iconpos":"prepend","required":true,"field_options":{"size":"medium"},"cid":"c1"},{"label":"Email","field_type":"email","icons":"fa-envelope-o","iconpos":"prepend","required":true,"field_options":{"size":"medium"},"cid":"c2"},{"label":"Subject","field_type":"text","icons":"fa-asterisk","iconpos":"prepend","required":true,"field_options":{"size":"medium"},"cid":"c3"},{"label":"Message","field_type":"message","icons":"fa-comment","iconpos":"prepend","required":true,"field_options":{"size":"large"},"cid":"c4"}]}',
             ],

         ],
     ];
    ecf_add_meta_box( $meta_box );

// Config

    $meta_box = [
        'id'          => 'ecf_meta_settings',
        'title'       => __( 'Settings', 'contact-form-lite' ),
        'description' => '',
        'page'        => 'easycontactform',
        'context'     => 'normal',
        'istabbed'    => 'yes',
        'priority'    => 'default',
        'fields'      => [

            // Email Settings

            [
                'name'  => __( 'Email Options', 'contact-form-lite' ),
                'desc'  => '',
                'id'    => 'ecf_meta_separator_email',
                'type'  => 'separator',
                'group' => 'email',
             ],

            [
                'name'  => __( 'Email Recipient', 'contact-form-lite' ),
                'desc'  => __( 'You can change this email with other email that you want. When use Department field, email recipients will use the email that you set in the email field for each department.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_admin_email',
                'type'  => 'text',
                'group' => 'email',
                'std'   => get_bloginfo( 'admin_email' ),
             ],

            [
                'name'    => __( 'Email Format<span class="ecf_pro_only"></span>', 'contact-form-lite' ),
                'desc'    => __( 'You can set email format to suit your needs.', 'contact-form-lite' ),
                'id'      => 'ecf_meta_email_format',
                'type'    => 'radio',
                'group'   => 'email',
                'options' => [
                    'html'  => 'HTML',
                    'plain' => 'Plain Text' ],
                'std'     => 'html',
             ],

            [
                'name'  => __( 'Email Header', 'contact-form-lite' ),
                'desc'  => __( 'This text used as the title for your incoming email. This should probably be your site name.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_admin_email_header',
                'type'  => 'text',
                'group' => 'email',
                'std'   => 'Email from '.get_bloginfo( 'name' ),
             ],

            [
                'name'  => __( 'Display Date/Time, User agent & sender IP Address<span class="ecf_pro_only"></span>', 'contact-form-lite' ),
                'desc'  => __( 'If ON, all information above will show in your incoming email footer.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_admin_email_addinfo',
                'type'  => 'checkbox',
                'group' => 'email',
                'std'   => 'on',
             ],

            [
                'name'  => __( 'Save an Email Attachment?<span class="ecf_pro_only"></span>', 'contact-form-lite' ),
                'desc'  => __( 'If ON, an email attachment will be stored on the server. You can locate the files in /wp-content/uploads/ directory.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_saveattch',
                'type'  => 'checkbox',
                'group' => 'email',
                'std'   => 'off',
             ],

            [
                'name'  => __( 'Allow Multiple Upload Attachment?<span class="ecf_pro_only"></span>', 'contact-form-lite' ),
                'desc'  => __( 'If ON, sender can upload multiple files at once.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_multiattach',
                'type'  => 'checkbox',
                'group' => 'email',
                'std'   => 'on',
             ],

            [
                'name'       => __( 'Action After email is Sent', 'contact-form-lite' ),
                'desc'       => __( 'You can set what action to sender when email is sent.', 'contact-form-lite' ),
                'id'         => 'ecf_email_action_on_sent',
                'type'       => 'radioredirect',
                'group'      => 'email',
                'needkey'    => 'yes',
                'options'    => [
                    'text'     => ' Display text',
                    'redirect' => 'Redirect to the Page' ],
                'std'        => 'text',
                'txt'        => 'Your Message Submitted Successfully',
                'url'        => 'http://',
                'trgt'       => 'off',
                'needmargin' => '<br><br><br><br><br>',
             ],

            [
                'name'  => __( 'Email Auto Responder', 'contact-form-lite' ),
                'desc'  => '<span style="font-style: italic; font-size:12px; color: #F40043;">All features below only available in PRO VERSION</span>',
                'id'    => 'ecf_meta_separator_autores',
                'type'  => 'separator',
                'group' => 'email',
             ],

            [
                'name'  => __( 'Enable Auto Responder?', 'contact-form-lite' ),
                'desc'  => __( 'If ON, sender will receive an email response from you. Use field below to create your own response content.', 'contact-form-lite' ),
                'id'    => 'ecf_email_isauto_response',
                'type'  => 'checkbox',
                'group' => 'email',
                'std'   => 'on',
             ],

            [
                'name'  => __( 'Auto Response From Email', 'contact-form-lite' ),
                'desc'  => __( 'Email to send Auto Response from. For example no-reply@ghozylab.com', 'contact-form-lite' ),
                'id'    => 'ecf_email_auto_response_from',
                'type'  => 'text',
                'group' => 'email',
                'std'   => '',
             ],

            [
                'name'  => __( 'Auto Response From Name', 'contact-form-lite' ),
                'desc'  => __( 'This should probably be your site name.', 'contact-form-lite' ),
                'id'    => 'ecf_email_auto_response_name',
                'type'  => 'text',
                'group' => 'email',
                'std'   => get_bloginfo( 'name' ),
             ],

            [
                'name'  => __( 'Auto Response Content', 'contact-form-lite' ),
                'desc'  => __( 'Sends an automated reply to incoming messages.<br>Available template tags:<br><ul class="ecf-tipslist">
    <li>{name} - The sender name</li>
    <li>{email} - The sender email address</li>
	<li>{message} - The sender message</li>
    <li>{date_time} - The date/time when an email sent</li>
</ul>', 'contact-form-lite' ),
                'id'    => 'ecf_email_auto_response',
                'type'  => 'tinymce',
                'group' => 'email',
                'std'   => 'Dear {name},

Thank you for contacting us, we will reply via ( {email} ) as soon as possible starting from {date_time}

&nbsp;

Best Regard,
<em>'.get_bloginfo( 'name' ).'</em>',
             ],

            [
                'name'  => __( 'Captcha Settings', 'contact-form-lite' ),
                'desc'  => '<span style="font-style: italic; font-size:12px; color: #F40043;">All features below only available in PRO VERSION</span>',
                'id'    => 'ecf_meta_separator_form_cap',
                'type'  => 'separator',
                'group' => 'misc',
             ],

            [
                'name'  => __( 'Use Captcha', 'contact-form-lite' ),
                'desc'  => __( 'We recommend you to enable this option to to stop spam email. Register for free <a href="https://www.google.com/recaptcha/admin" target="_blank">here</a>.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_use_captcha',
                'type'  => 'checkbox',
                'group' => 'misc',
                'std'   => 'off',
             ],

            [
                'name'    => __( 'Captcha Style', 'contact-form-lite' ),
                'desc'    => __( 'There are available three style that you can choose.', 'contact-form-lite' ),
                'id'      => 'ecf_meta_captcha_style',
                'type'    => 'radio',
                'group'   => 'misc',
                'needkey' => 'yes',
                'options' => [
                    'v3'     => 'reCAPTCHA v3',
                    'v2'     => 'reCAPTCHA v2',
                    'v1'     => 'Old reCAPTCHA',
                    'simple' => 'Simple' ],
                'std'     => 'v2',
             ],

            [
                'name'    => __( 'Captcha Themes', 'contact-form-lite' ),
                'desc'    => __( 'Select theme to customizing the Look and Feel of reCAPTCHA.', 'contact-form-lite' ),
                'id'      => 'ecf_meta_captcha_themes',
                'type'    => 'select',
                'group'   => 'misc',
                'needkey' => 'yes',
                'options' => [
                    'light'      => 'Light ( New reCAPTCHA Only )',
                    'dark'       => 'Dark ( New reCAPTCHA Only ) ',
                    'clean'      => 'Clean ( Old reCAPTCHA Only )',
                    'white'      => 'White ( Old reCAPTCHA Only )',
                    'red'        => 'Red ( Old reCAPTCHA Only )',
                    'blackglass' => 'Black Glass ( Old reCAPTCHA Only )' ],
                'std'     => 'light',
             ],

            [
                'name'  => __( 'Captcha Site key', 'contact-form-lite' ),
                'desc'  => __( 'Make sure to enter Captcha Site key correctly to avoid email delivery failure.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_captcha_pub',
                'type'  => 'text',
                'group' => 'misc',
                'std'   => '',
             ],

            [
                'name'  => __( 'Captcha Secret key', 'contact-form-lite' ),
                'desc'  => __( 'It\'s very important to enter Captcha Secret key correctly to avoid email delivery failure.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_captcha_skey',
                'type'  => 'text',
                'group' => 'misc',
                'std'   => '',
             ],

            [
                'name'  => __( 'Captcha Label', 'contact-form-lite' ),
                'desc'  => __( 'Label on top of Captcha. For example : Enter characters below:<br />type none for no text.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_captcha_label',
                'type'  => 'text',
                'group' => 'misc',
                'std'   => 'Enter characters below:',
             ],

            // Form Layout

            [
                'name'  => __( 'Form Layout', 'contact-form-lite' ),
                'desc'  => '<span style="font-style: italic; font-size:12px; color: #F40043;">All features below only available in PRO VERSION</span>',
                'id'    => 'ecf_meta_separator_form_layout',
                'type'  => 'separator',
                'group' => 'layout',
             ],

            [
                'name'    => __( 'Form Width', 'contact-form-lite' ),
                'desc'    => __( 'You can easily set the form width with this option. Default : 550px', 'contact-form-lite' ),
                'id'      => 'ecf_meta_form_width',
                'type'    => 'slider',
                'std'     => '550',
                'max'     => '1024',
                'min'     => '300',
                'step'    => '10',
                'usestep' => '1',
                'pixopr'  => 'px',
                'group'   => 'layout',
             ],

            [
                'name'  => __( 'Background Color', 'contact-form-lite' ),
                'desc'  => __( 'Set the background color for your form here. Default: #ffffff', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_back_col',
                'type'  => 'color',
                'std'   => '#ffffff',
                'group' => 'layout',
             ],

            [
                'name'    => __( 'Form Border', 'contact-form-lite' ),
                'desc'    => __( 'Set the form border size here. Default : 1px', 'contact-form-lite' ),
                'id'      => 'ecf_meta_form_border',
                'type'    => 'slider',
                'std'     => '1',
                'max'     => '10',
                'min'     => '0',
                'step'    => '1',
                'usestep' => '1',
                'pixopr'  => 'px',
                'group'   => 'layout',
             ],

            [
                'name'  => __( 'Border Color', 'contact-form-lite' ),
                'desc'  => __( 'Set the color of border here. Default: #d6d6d6', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_border_col',
                'type'  => 'color',
                'std'   => '#d6d6d6',
                'group' => 'layout',
             ],

            [
                'name'  => __( 'Use Shadow?', 'contact-form-lite' ),
                'desc'  => __( 'If ON, the shadow will show around the form.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_isshadow',
                'type'  => 'checkbox',
                'group' => 'layout',
                'std'   => 'on',
             ],

            [
                'name'  => __( 'Shadow Color', 'contact-form-lite' ),
                'desc'  => __( 'Set the color of shadow here. Default: #383838', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_shadow_col',
                'type'  => 'color',
                'std'   => '#383838',
                'group' => 'layout',
             ],

            [
                'name'       => __( 'Label /Title Color', 'contact-form-lite' ),
                'desc'       => __( 'Set the color of form label / title here. Default: #666666', 'contact-form-lite' ),
                'id'         => 'ecf_meta_form_text_col',
                'type'       => 'color',
                'std'        => '#666666',
                'group'      => 'layout',
                'needmargin' => '<br><br>',
             ],

            [
                'name'  => __( 'Header Area', 'contact-form-lite' ),
                'desc'  => '',
                'id'    => 'ecf_meta_separator_form_header',
                'type'  => 'separator',
                'group' => 'layout',
             ],

            [
                'name'  => __( 'Header Color', 'contact-form-lite' ),
                'desc'  => __( 'You can set header color here. Default: #F8F8F8', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_header_col',
                'type'  => 'color',
                'std'   => '#F8F8F8',
                'group' => 'layout',
             ],

            [
                'name'  => __( 'Show Form Title', 'contact-form-lite' ),
                'desc'  => __( 'If ON, the title will appear on the form header.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_istitle',
                'type'  => 'checkbox',
                'group' => 'layout',
                'std'   => 'on',
             ],

            [
                'name'  => __( 'Form Title', 'contact-form-lite' ),
                'desc'  => __( 'With this option the sender will easily determine the form type. For example ; Contact Us or Feedback. You can type none if you want to hide the form header.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_header_txt',
                'type'  => 'text',
                'group' => 'layout',
                'std'   => '',
             ],

            [
                'name'       => __( 'Header Title Color', 'contact-form-lite' ),
                'desc'       => __( 'You can set title color here. Default: #232323', 'contact-form-lite' ),
                'id'         => 'ecf_meta_form_title_col',
                'type'       => 'color',
                'std'        => '#232323',
                'group'      => 'layout',
                'needmargin' => '<br><br>',
             ],

            [
                'name'  => __( 'Form Elements', 'contact-form-lite' ),
                'desc'  => '',
                'id'    => 'ecf_meta_separator_form_content_el',
                'type'  => 'separator',
                'group' => 'layout',
             ],

            [
                'name'  => __( 'Fields Border Color on Hover & Focus', 'contact-form-lite' ),
                'desc'  => __( 'Set the border color for each field on hover & focus. Default: #2da5da', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_fields_br_col',
                'type'  => 'color',
                'std'   => '#2da5da',
                'group' => 'layout',
             ],

            [
                'name'  => __( 'Fields Background Color', 'contact-form-lite' ),
                'desc'  => __( 'Set the background color for each field. Default: #ffffff', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_fields_bk_col',
                'type'  => 'color',
                'std'   => '#ffffff',
                'group' => 'layout',
             ],

            [
                'name'  => __( 'Button Color', 'contact-form-lite' ),
                'desc'  => __( 'Set the button color to fit your need. Default: #2DA5DA', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_fields_btn_col',
                'type'  => 'color',
                'std'   => '#2DA5DA',
                'group' => 'layout',
             ],

            [
                'name'  => __( 'Button Text', 'contact-form-lite' ),
                'desc'  => __( 'You can change default SEND for submit button text.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_fields_btn_txt',
                'type'  => 'text',
                'group' => 'layout',
                'std'   => 'SEND',
             ],

            [
                'name'    => __( 'Button Loading Style', 'contact-form-lite' ),
                'desc'    => __( 'Select the loading animation for your submit button. Default: slide-down', 'contact-form-lite' ),
                'id'      => 'ecf_meta_form_fields_btn_anim',
                'type'    => 'select',
                'group'   => 'layout',
                'needkey' => 'yes',
                'options' => [
                    'expand-left'  => 'Expand Left',
                    'expand-right' => 'Expand Right',
                    'expand-up'    => 'Expand Up',
                    'zoom-in'      => 'Zoom In',
                    'zoom-out'     => 'Zoom Out',
                    'slide-left'   => 'Slide Left',
                    'slide-right'  => 'Slide Right',
                    'slide-up'     => 'Slide Up',
                    'slide-down'   => 'Slide Down',
                 ],
                'std'     => 'slide-down',
             ],

            [
                'name'  => __( 'Required Error Message', 'contact-form-lite' ),
                'desc'  => __( 'You can customize required error message here or<br />type none for no message.', 'contact-form-lite' ),
                'id'    => 'ecf_meta_form_err_msg',
                'type'  => 'text',
                'group' => 'layout',
                'std'   => 'This field is required',
             ],

            [
                'name'  => __( 'Advanced Settings', 'contact-form-lite' ),
                'desc'  => '<span style="font-style: italic; font-size:12px; color: #F40043;">All features below only available in PRO VERSION</span>',
                'id'    => 'ecf_meta_separator_form_adv',
                'type'  => 'separator',
                'group' => 'adv',
             ],

            [
                'name'         => __( 'Attachment Size Limit', 'contact-form-lite' ),
                'desc'         => 'For best performance we recommend you to set less than 2M even though your server provides a limit of '.ini_get( 'upload_max_filesize' ).'. Set to 0 if you want to use default server Max Limit.',
                'id'           => 'ecf_meta_admin_email_maxup',
                'type'         => 'text',
                'needlefttext' => 'y',
                'group'        => 'adv',
                'std'          => '0',
             ],

            [
                'name'   => __( 'Accepted Filetypes', 'contact-form-lite' ),
                'desc'   => __( 'Currently, sender permitted to upload the following file types from your contact form. You can add another Filetypes and make sure the format should like this : NAME:MIME Type ( for example html:text/html ) and don\'t forget to add on newline.<br><br> - Complete list <a href="https://en.wikipedia.org/wiki/Internet_media_type" target="_blank">here</a>', 'contact-form-lite' ),
                'id'     => 'ecf_meta_fileex',
                'type'   => 'textarea',
                'nthick' => '1',
                'std'    => 'txt:text/plain
css:text/css
gif:image/gif
png:image/x-png
jpeg:image/jpeg
jpg:image/jpeg
JPG:image/jpeg
jpe:image/jpeg
TIFF:image/tiff
tiff:image/tiff
tif:image/tiff
TIF:image/tiff
bmp:image/x-ms-bmp
BMP:image/x-ms-bmp
ai:application/postscript
eps:application/postscript
ps:application/postscript
rtf:application/rtf
pdf:application/pdf
doc:application/msword
docx:application/msword
xls:application/vnd.ms-excel
xlsx:application/vnd.ms-excel
zip:application/zip
rar:application/rar
wav:audio/wav
mp3:audio/mp3
ppt:application/vnd.ms-powerpoint
aar:application/sb-replay
sce:application/sb-scenario',
                'group'  => 'adv',
             ],

            [
                'name'  => __( 'Custom CSS', 'contact-form-lite' ),
                'desc'  => __( 'Want to add any custom CSS code? Put in here, and the rest is taken care of. This overrides the default stylesheets.<br>For example: body {
    background-color: #E6E6E6;
}', 'contact-form-lite' ),
                'id'    => 'ecf_meta_customcss',
                'type'  => 'textarea',
                'std'   => '',
                'group' => 'adv',
             ],

            [
                'name'  => __( 'Custom JS', 'contact-form-lite' ),
                'desc'  => __( 'Want to add any custom JS code? Put in here, and the rest is taken care of.<br>For example: alert(\'Hello World!\');', 'contact-form-lite' ),
                'id'    => 'ecf_meta_customjs',
                'type'  => 'textarea',
                'std'   => '',
                'group' => 'adv',
             ],

         ],
     ];

    // @since 1.0.13
    if ( has_filter( 'ecf_addons_metabox' ) ) {
        $meta_box = apply_filters( 'ecf_addons_metabox', $meta_box );
    } else {
        $meta_box = $meta_box;
    }

    ecf_add_meta_box( $meta_box );

}

//-----------------------------------------------------------------------------------------------------------------

/**
 * Save custom Meta Box
 *
 * @param int $post_id The post ID
 */
function ecf_save_meta_box( $post_id )
{

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! isset( $_POST[ 'ecf_meta' ] ) || ! isset( $_POST[ 'ecf_meta_box_nonce' ] ) || ! wp_verify_nonce( $_POST[ 'ecf_meta_box_nonce' ], basename( __FILE__ ) ) ) {
        return;
    }

    if ( 'page' == $_POST[ 'post_type' ] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

    }

    $dataTemp = $_POST[ 'ecf_meta' ];

    // save data
    foreach ( $dataTemp as $key => $val ) {

        delete_post_meta( $post_id, $key );

        // Sanitize input
        if ( is_array( $dataTemp[ $key ] ) ) {

            foreach ( $dataTemp[ $key ] as $k => $v ) {
                $dataTemp[ $key ][ $k ] = esc_html( $dataTemp[ $key ][ $k ] );
            }

        } else {

            if ( $key === 'ecf_formbuilder_format' ) {
                $dataTemp[ $key ] = $dataTemp[ $key ];
            } else {
                $dataTemp[ $key ] = esc_html( $dataTemp[ $key ] );
            }

        }

        add_post_meta( $post_id, $key, $dataTemp[ $key ], true );

    }

}

add_action( 'save_post', 'ecf_save_meta_box' );

function ecf_scroll()
{

    echo '<div class="ecf-scroll-top-wrapper">
    		<span class="ecf-scroll-top-inner">
        		<i class="ecfa"></i>
    			</span>
			</div>';
}

function ecf_upgrade_popup()
{

    echo '<!-- Modal -->
<div class="modal fade" id="myModalupgrade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Pricing Table</h4>
            </div>
            <div class="modal-body" style="background-color: #f5f5f5;">


            <div class="row flat"> <!-- Content Start -->


              <div class="col-lg-3 col-md-3 col-xs-6">
                <ul class="plan plan1">
                    <li class="plan-name">
                        Pro
                    </li>
                    <li class="plan-price">
                        <strong>$'.esc_html(ECF_PRO).'</strong>
                    </li>
                    <li>
                        <strong>1 site</strong>
                    </li>
                    <li class="plan-action">
                        <a href="https://ghozylab.com/plugins/ordernow.php?order=ecfpro&utm_source=contactform&utm_medium=orderfromeditor&utm_campaign=orderfromeditor" target="_blank" class="btn btn-danger btn-lg">BUY NOW</a>
                    </li>
                </ul>
            </div>

              <div class="col-lg-3 col-md-3 col-xs-6"><span class="featured"></span>
                <ul class="plan plan1">
                    <li class="plan-name">
                        Pro+
                    </li>
                    <li class="plan-price">
                        <strong>$'.esc_html(ECF_PROPLUS).'</strong>
                    </li>
                    <li>
                        <strong>3 sites</strong>
                    </li>
                    <li class="plan-action">
                        <a href="https://ghozylab.com/plugins/ordernow.php?order=ecfproplus&utm_source=contactform&utm_medium=orderfromeditor&utm_campaign=orderfromeditor" target="_blank" class="btn btn-danger btn-lg">BUY NOW</a>
                    </li>
                </ul>
            </div>

              <div class="col-lg-3 col-md-3 col-xs-6">
                <ul class="plan plan1">
                    <li class="plan-name">
                        Pro++
                    </li>
                    <li class="plan-price">
                        <strong>$'.esc_html(ECF_PROPLUSPLUS).'</strong>
                    </li>
                    <li>
                        <strong>5 sites</strong>
                    </li>
                    <li class="plan-action">
                        <a href="https://ghozylab.com/plugins/ordernow.php?order=ecfproplusplus&utm_source=contactform&utm_medium=orderfromeditor&utm_campaign=orderfromeditor" target="_blank" class="btn btn-danger btn-lg">BUY NOW</a>
                    </li>
                </ul>
            </div>

              <div class="col-lg-3 col-md-3 col-xs-6">
                <ul class="plan plan1">
                    <li class="plan-name">
                        Developer
                    </li>
                    <li class="plan-price">
                        <strong>$'.esc_html(ECF_DEV).'</strong>
                    </li>
                    <li>
                        <strong>15 sites</strong>
                    </li>
                    <li class="plan-action">
                        <a href="https://ghozylab.com/plugins/ordernow.php?order=ecfdev&utm_source=contactform&utm_medium=orderfromeditor&utm_campaign=orderfromeditor" target="_blank" class="btn btn-danger btn-lg">BUY NOW</a>
                    </li>
                </ul>
            </div>


            </div><!-- Content End  -->

            </div>
        </div>
    </div>
</div>

<!--  END HTML (to Trigger Modal) -->';

}

?>