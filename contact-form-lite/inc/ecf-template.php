<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Please do not load this file directly!' );
}

/*-------------------------------------------------------------------------------*/
/*   Form generator ( Wrap, Script & CSS
/*-------------------------------------------------------------------------------*/
function ecf_markup_generator( $fid, $rnd )
{

    ob_start();

    $avname  = 0;
    $avemail = 0;
    $avmsg   = 0;

    $opt = ecf_opt_generator( $fid, $rnd );

    $frmArray = json_decode( trim( $opt[ 'frmformat' ] ), true );

    // @since 1.0.17 ( Addons )
    if ( has_filter( 'ecf_form_header' ) ) {

        $isheader = apply_filters( 'ecf_form_header', $opt, null, $fid, $rnd );

    } else {

        if ( $opt[ 'fo_is_head_ttl' ] == 'on' ) {

            if ( $opt[ 'fo_head_txt' ] && $opt[ 'fo_head_txt' ] != 'none' ) {
                $isheader = '<header>'.$opt[ 'fo_head_txt' ].'</header>';
            } elseif ( $opt[ 'fo_head_txt' ] == '' && get_the_title( $fid ) ) {
                $isheader = '<header>'.esc_html( esc_js( get_the_title( $fid ) ) ).'</header>';
            } else {
                $isheader = '';
            }

        } else {
            $isheader = '';
        }

    }

    // @since 1.0.15
    if ( has_filter( 'ecf_addons_before_form_render' ) ) {

        echo esc_html( apply_filters( 'ecf_addons_before_form_render', $opt, $fid ) );

    }

    ?>

<!-- START JS for Form ID: <?php echo esc_html( $fid ); ?> -->
<script type="text/javascript">
jQuery(document).ready(function($) {

    jQuery("#preloader-<?php echo esc_html( $rnd ); ?>").fadeOut(500, function() {
        jQuery("#ecf-form-<?php echo esc_html( $rnd ); ?>").fadeIn(300);
    });

    Ladda.bind('.ladda-button');

    $(function() {

        <?php /* @since 1.0.15 */

    if ( has_filter( 'ecf_addons_before_form_validate' ) ) {

        echo wp_kses( apply_filters( 'ecf_addons_before_form_validate', $opt, $fid ), ecf_wp_kses_allowed_html() );

    }
    ?>

        /* Validation */
        $("#form-<?php echo esc_html( $rnd ); ?>").validate({
            /* Rules for form validation */
            rules: {
                <?php echo esc_html( $opt[ 'frmelval' ] ); ?>,

                <?php /* @since 1.0.15     */

    if ( has_filter( 'ecf_addons_when_form_validate' ) ) {
        echo wp_kses( apply_filters( 'ecf_addons_when_form_validate', $opt ), ecf_wp_kses_allowed_html() );
    }
    ?>
            },
            /* Messages for form validation */
            messages: {
                <?php
if ( $opt[ 'frmerrmsg' ] != 'none' ) {echo wp_kses( $opt[ 'frmelvalmsg' ], ecf_wp_kses_allowed_html() );}
    ?>
            },
            /* Do not change code below */
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent());
            },

            submitHandler: function(form) {
                <?php /* @since 1.0.15 */

    if ( has_filter( 'ecf_addons_form_onsubmit' ) ) {

        echo wp_kses( apply_filters( 'ecf_addons_form_onsubmit', $opt, $rnd ), ecf_wp_kses_allowed_html() ) ;

    } else {?>
                ecf_onsubmit(jQuery('.form-<?php echo esc_html( $rnd ); ?>'));

                <?php }
    ?>

            },

            invalidHandler: function(form) {
                Ladda.stopAll();
            },

            onkeyup: false,
            onfocusout: false,
            onclick: false

        });
    });


    /* Form Submit ( Ajax ) */
    function ecf_onsubmit(form) {

        if (form.attr('action') == '#') {

            data = {};
            eldat = [];
            data['action'] = 'ecf_deliver_mail';
            data['formid'] = '<?php echo esc_html( $fid ); ?>';
            data['security'] = '<?php echo esc_html( wp_create_nonce( trim( $fid ) ) ); ?>';


            <?php

    if ( has_filter( 'ecf_addons_form_element_parsing' ) ) {

        echo wp_kses_post( apply_filters( 'ecf_addons_form_element_parsing', '' ) );

    } else {
        ?>

            jQuery('input, textarea', form).each(function(key) {

                items = {};

                if (typeof $(this).data('type') === 'undefined') {
                    return true;
                }


                <?php
}
    ?>

                items['type'] = $(this).data('type');
                items['label'] = $(this).data('label');
                items['value'] = this.value;
                items['name'] = this.name;

                eldat.push(items);

            });


            <?php /* @since 1.0.13 */

    if ( has_filter( 'ecf_addons_element_helper' ) ) {
        $frm = null;

        if ( $frm ) {
            echo wp_kses( apply_filters( 'ecf_addons_element_helper', $fid, $opt[ 'frmformat' ] ), ecf_wp_kses_allowed_html() );
        } else {
            echo wp_kses( apply_filters( 'ecf_addons_element_helper', $fid, null ), ecf_wp_kses_allowed_html() );
        }

    }

    ?>
            data['allelmnt'] = JSON.stringify(eldat);

            submitForm();

            return false;

        }

    }

    /* Start submitForm	 */
    function submitForm() {

        jQuery.ajax({
            url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(data) {

                if (data.Ok == true) {

                    $("#form-<?php echo esc_html( $rnd ); ?>").get(0).reset();

                    if (data.msg == 'redirect') {
                        window.location = "<?php echo esc_html( $opt[ 'actafter' ][ 2 ] ); ?>";
                    } else {
                        notifyme('<?php echo esc_html( $opt[ 'actafter' ][ 1 ] ); ?>', 'n', 'success',
                            'left middle');
                    }

                } else {
                    $("#form-<?php echo esc_html( $rnd ); ?>").get(0).reset();
                    notifyme(data.msg, 'n', 'error', 'left middle');
                }

                Ladda.stopAll();

            }
        });

        <?php /* @since 1.0.15 */

    if ( has_filter( 'ecf_addons_after_form_submit' ) ) {

        echo wp_kses( apply_filters( 'ecf_addons_after_form_submit', $opt ), ecf_wp_kses_allowed_html() );

    }
    ?>

    }


    /* Notify */
    function notifyme(msg, b, typ, pos) {
        if (b == 'n') {
            b = 'cf-submitted<?php echo esc_html( $rnd ); ?>';
        } else {
            b = 'atc<?php echo esc_html( $rnd ); ?>';
        }

        $("#" + b).gnotify(msg, {
            style: "nbootstrap",
            elementPosition: pos,
            className: typ
        });

        msg = null;
        typ = null;

    }

});
</script>
<!-- END JS for Form ID: <?php echo esc_html( $fid ); ?> -->
<?php
if ( has_filter( 'ecf_addons_add_inline_styles' ) ) {
        echo wp_kses_post( apply_filters( 'ecf_addons_add_inline_styles', null ) );
    }
    ?>

<!-- START Form Markup for Form ID: <?php echo esc_html( $fid ); ?> -->
<div id="preloader-<?php echo esc_attr( $rnd );?>" class="ecfpreloader"></div>
<div id="ecf-form-<?php echo esc_attr( $rnd );?>" class="ecf-body" style="display:none;">
    <form method="post" enctype="multipart/form-data" action="#" id="form-<?php echo esc_attr( $rnd );?>"
        class="ecf-form form-<?php echo esc_attr( $rnd );?>">
        <?php echo wp_kses( $isheader, ecf_wp_kses_allowed_html() ); ?>
        <fieldset>
            <?php

    foreach ( $frmArray as $key => $value ) {

        foreach ( $value as $k => $v ) {

            if ( isset( $v[ 'placeholder' ] ) && trim( $v[ 'placeholder' ] ) != '' ) {
                $isplchldr = 'placeholder="'.$v[ 'placeholder' ].'"';
            } else {
                $isplchldr = null;
            }

            /* @since 1.0.13 */
            if ( has_filter( 'ecf_addons_form_element_logic' ) ) {

                if ( is_array( apply_filters( 'ecf_addons_form_element_logic', $v ) ) ) {

                    $frmdata = apply_filters( 'ecf_addons_form_element_logic', $v );

                    $isphonemask    = $frmdata[ 0 ];
                    $isphoneplchldr = $frmdata[ 1 ];
                    $lblclass       = $frmdata[ 2 ];

                }

            } else {

                if ( $v[ 'field_type' ] == 'paragraph' || $v[ 'field_type' ] == 'message' ) {
                    $lblclass = 'textarea';
                } else {
                    $lblclass = 'input';
                }

            }

            echo '<section>';

            /* @since 1.0.13 */
            if ( has_filter( 'ecf_addons_fields_rules' ) ) {

                if ( in_array( $v[ 'field_type' ], apply_filters( 'ecf_addons_fields_rules', '' ) ) ) {

                    $addflds = $v[ 'field_type' ];

                }

            } else {

                $addflds = 'noadd';

            }

            if ( ! isset( $addflds ) ) {
                $addflds = 'noadd';
            }

            if ( $v[ 'field_type' ] == 'paragraph' || $v[ 'field_type' ] == 'message' || $v[ 'field_type' ] == 'name' || $v[ 'field_type' ] == 'text' || $v[ 'field_type' ] == 'email' || $v[ 'field_type' ] == 'website' || $v[ 'field_type' ] == $addflds ) {
                echo '<label class="label">'.esc_html( $v[ 'label' ] ).'</label>';
            }

            echo '<label class="'.esc_attr( $lblclass ).'">';

            /* Start Generate Form Element */
            switch ( $v[ 'field_type' ] ) {

                case 'name':

                    $avname = $avname + 1;
                    echo '<input data-type="'.esc_attr( $v[ 'field_type' ] ).'" data-label="'.esc_attr( $v[ 'label' ] ).'" id="'.esc_attr( $v[ 'field_type' ].$k ).'" type="text" name="'.esc_attr( $v[ 'field_type' ].$k ).'" '.esc_attr( $isplchldr ).'/>';

                    break;

                case 'text':

                    echo '<input data-type="'.esc_attr( $v[ 'field_type' ] ).'" data-label="'.esc_attr( $v[ 'label' ] ).'" id="'.esc_attr( $v[ 'field_type' ].$k ).'" type="text" name="'.esc_attr( $v[ 'field_type' ].$k ).'" '.esc_attr( $isplchldr ).'/>';

                    break;

                case 'email':

                    $avemail = $avemail + 1;
                    echo '<input data-type="'.esc_attr( $v[ 'field_type' ] ).'" data-label="'.esc_attr( $v[ 'label' ] ).'" id="'.esc_attr( $v[ 'field_type' ].$k ).'" type="text" name="'.esc_attr( $v[ 'field_type' ].$k ).'" '.esc_attr( $isplchldr ).'/>';

                    break;

                case 'website':

                    echo '<input data-type="'.esc_attr( $v[ 'field_type' ] ).'" data-label="'.esc_attr( $v[ 'label' ] ).'" id="'.esc_attr( $v[ 'field_type' ].$k ).'" type="text" name="'.esc_attr( $v[ 'field_type' ].$k ).'" placeholder="http://"/>';

                    break;

                case 'paragraph':

                    echo '<textarea data-type="'.esc_attr( $v[ 'field_type' ] ).'" data-label="'.esc_attr( $v[ 'label' ] ).'" id="'.esc_attr( $v[ 'field_type' ].$k ).'" name="'.esc_attr( $v[ 'field_type' ].$k ).'" rows="7" '.esc_attr( $isplchldr ).'></textarea>';

                    break;

                case 'message':

                    $avmsg = $avmsg + 1;
                    echo '<textarea data-type="'.esc_attr( $v[ 'field_type' ] ).'" data-label="'.esc_attr( $v[ 'label' ] ).'" id="'.esc_attr( $v[ 'field_type' ].$k ).'" name="'.esc_attr( $v[ 'field_type' ].$k ).'" rows="7" '.esc_attr( $isplchldr ).'></textarea>';

                    break;

                default:
                    break;

            }

            if ( has_filter( 'ecf_addons_add_form_element' ) ) {

                apply_filters( 'ecf_addons_add_form_element', $v, $k, $rnd, $isplchldr, $isphonemask, $isphoneplchldr );

            }

            echo '</label>';
            echo '</section>';

        }

    }

    if ( has_filter( 'ecf_addons_after_form_render' ) ) {
        echo wp_kses_post( apply_filters( 'ecf_addons_after_form_render', $opt ) );
    }
    ?>
        </fieldset>
        <footer>
            <button data-style="slide-down" id="cf-submitted<?php echo esc_attr( $rnd );?>" class="ecfbutton ladda-button"
                type="submit" name="cf-submitted<?php echo esc_attr( $rnd );?>"><span
                    class="ladda-label">SEND</span></button>
        </footer>
    </form>

    <?php
if ( ecf_get_aff_option( 'ecf_affiliate_info', 'ecf_aff_id', '' ) ) {?>
    <span class="ecf-aff-link">Powered by <a
            href="https://secure.ghozylab.com/demo/?ref=<?php echo esc_html( ecf_get_aff_option( 'ecf_affiliate_info', 'ecf_aff_id', '' ) ); ?>&goto=ecf"
            target="_blank">Easy Contact Form Plugin</a></span>

    <?php }
    ?>

</div>
<!-- END Form Markup for Form ID: <?php echo esc_html( $fid ); ?> -->

<?php

    $theform = ob_get_clean();

    if ( $avemail < 0 || $avmsg < 0 || $avname < 0 ) {
        echo wp_kses( ecf_notify( 'formelement', $fid ), ecf_wp_kses_allowed_html() );
    } else {
        echo wp_kses( $theform, ecf_wp_kses_allowed_html() );
    }

}
