<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function easycform_put_compare_style()
{
    if ( is_admin() && isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'easycform_comparison' ) {
        wp_enqueue_style( 'ecf-pricing-css' );
    }
}

add_action( 'admin_enqueue_scripts', 'easycform_put_compare_style' );

function easycform_pricing_table()
{

    ?>
<!-- DC Pricing Tables:3 Start -->

<script>
jQuery(document).ready(function($) {
    $(".column_1, .column_3, .column_2, .column_4").click(function() {
        $('html, body').animate({
            scrollTop: $(".ecfscrollto").offset().top
        }, 1500);
    });
});
</script>

<div class="wrap">
    <div id="icon-edit" class="icon32 icon32-posts-easymedia"><br /></div>
    <h2><?php esc_html_e( 'Comparison', 'contact-form-lite' );?></h2>
    <div class="tsc_pricingtable03 tsc_pt3_style1" style="margin-bottom:110px; height:1100px;">
        <div class="caption_column">
            <ul>
                <li class="header_row_1 align_center radius5_topleft"><?php easycform_share();?></li>
                <li class="header_row_2">
                    <h2 class="caption"><?php echo esc_html( ECF_ITEM_NAME ); ?></h2>
                </li>
                <li class="row_style_2"><span>License</span></li>
                <li class="row_style_4"><span>Unlimited Form</span></li>
                <li class="row_style_2"><span>100% Responsive</span></li>
                <li class="row_style_4"><span>Unlimited colors and layout</span></li>
                <li class="row_style_2"><span>HTML/Plain Text Email Format</span></li>
                <li class="row_style_2"><span>SMTP email Authentication</span></li>
                <li class="row_style_4"><span>Redirect / Custom Message after Sent</span></li>
                <li class="row_style_2"><span>350+ Icons</span></li>
                <li class="row_style_4"><span>+700 Fonts from Google Fonts</span></li>
                <li class="row_style_2"><span>Show Form from Link / Image</span></li>
                <li class="row_style_4"><span>Custom CSS</span></li>
                <li class="row_style_2"><span>Custom JS</span></li>
                <li class="row_style_4"><span>Auto Responder</span></li>
                <li class="row_style_2"><span>Department Field</span></li>
                <li class="row_style_4"><span>Email Attachment</span></li>
                <li class="row_style_2"><span>Attachment File Type Control</span></li>
                <li class="row_style_4"><span>Attachment File Size Control</span></li>
                <li class="row_style_2"><span>Form CaptCHA</span></li>
                <li class="row_style_4"><span>Fields Validation</span></li>
                <li class="row_style_2"><span>Form Report ( Form Content, Geolocation )</span></li>
                <li class="row_style_4"><span>Form Analytics</span></li>
                <li class="row_style_2"><span>WP Multisite</span></li>
                <li class="row_style_4"><span>Support</span></li>
                <li class="row_style_2"><span>Update</span></li>
                <li class="row_style_4"><span>License</span></li>
                <li class="footer_row ecfscrollto"></li>
            </ul>
        </div>
        <div class="column_1">
            <ul>
                <li class="header_row_1 align_center">
                    <h2 class="col1">Lite</h2>
                </li>
                <li class="header_row_2 align_center">
                    <h1 class="col1">Free</h1>
                </li>
                <li class="row_style_1 align_center">Free</li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span>none</span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center">Free</li>

                <li class="footer_row"></li>
            </ul>
        </div>

        <div class="column_2">
            <ul>
                <li class="header_row_1 align_center">
                    <h2 class="col2">Pro</h2>
                </li>
                <li class="header_row_2 align_center">
                    <h1 class="col2">$<span><?php echo esc_html( ECF_PRO ); ?></span></h1>
                </li>
                <li class="row_style_2 align_center"><span style="font-weight: bold; color:#F77448; font-size:14px;">1
                        Site</span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span>1 Month</span></li>
                <li class="row_style_4 align_center"><span>1 Year</span></li>
                <li class="row_style_2 align_center"><span style="font-weight: bold; color:#F77448; font-size:14px;">1
                        Site</span></li>
                <li class="footer_row"><a target="_blank"
                        href="https://ghozylab.com/plugins/ordernow.php?order=ecfpro&utm_source=contactform&utm_medium=pricingpage&utm_campaign=pricingpage"
                        class="tsc_buttons2 blue">Upgrade Now</a></li>
            </ul>
        </div>

        <div class="column_2 featured">
            <span class="bestbuy"></span>
            <ul>
                <li class="header_row_1 align_center">
                    <h2 class="col2">Pro+</h2>
                </li>
                <li class="header_row_2 align_center">
                    <h1 class="col2">$<span><?php echo esc_html( ECF_PROPLUS ); ?></span></h1>
                </li>
                <li class="row_style_2 align_center"><span style="font-weight: bold; color:#F77448; font-size:14px;">3
                        Sites</span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span>1 Month</span></li>
                <li class="row_style_4 align_center"><span>1 Year</span></li>
                <li class="row_style_2 align_center"><span style="font-weight: bold; color:#F77448; font-size:14px;">3
                        Sites</span></li>
                <li class="footer_row"><a target="_blank"
                        href="https://ghozylab.com/plugins/ordernow.php?order=ecfproplus&utm_source=contactform&utm_medium=pricingpage&utm_campaign=pricingpage"
                        class="tsc_buttons2 orange">Upgrade Now</a></li>
            </ul>
        </div>
        <div class="column_2">
            <ul>
                <li class="header_row_1 align_center">
                    <h2 class="col2">Pro++</h2>
                </li>
                <li class="header_row_2 align_center">
                    <h1 class="col2">$<span><?php echo esc_html( ECF_PROPLUSPLUS ); ?></span></h1>
                </li>
                <li class="row_style_2 align_center"><span style="font-weight: bold; color:#F77448; font-size:14px;">5
                        Sites</span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_2 align_center"><span>6 Month</span></li>
                <li class="row_style_4 align_center"><span>1 Year</span></li>
                <li class="row_style_2 align_center"><span style="font-weight: bold; color:#F77448; font-size:14px;">5
                        Sites</span></li>
                <li class="footer_row"><a target="_blank"
                        href="https://ghozylab.com/plugins/ordernow.php?order=ecfproplusplus&utm_source=contactform&utm_medium=pricingpage&utm_campaign=pricingpage"
                        class="tsc_buttons2 green">Upgrade Now</a></li>
            </ul>
        </div>
        <div class="column_4">
            <ul>
                <li class="header_row_1 align_center">
                    <h2 class="col2">Developer</h2>
                </li>
                <li class="header_row_2 align_center">
                    <h1 class="col2">$<span><?php echo esc_html( ECF_DEV ); ?></span></h1>
                </li>
                <li class="row_style_1 align_center"><span style="font-weight: bold; color: #F77448; font-size:14px;">15
                        Sites</span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_3 align_center"><span class="pricing_yes"></span></li>
                <li class="row_style_1 align_center"><span>1 year</span></li>
                <li class="row_style_3 align_center"><span>1 year</span></li>
                <li class="row_style_1 align_center"><span style="font-weight: bold; color: #F77448; font-size:14px;">15
                        Sites</span></li>
                <li class="footer_row"><a target="_blank"
                        href="https://ghozylab.com/plugins/ordernow.php?order=ecfdev&utm_source=contactform&utm_medium=pricingpage&utm_campaign=pricingpage"
                        class="tsc_buttons2 red">Upgrade Now</a></li>
            </ul>
        </div>


    </div>
</div>
<!-- DC Pricing Tables:3 End -->
<div class="tsc_clear"></div> <!-- line break/clear line -->
<?php

}