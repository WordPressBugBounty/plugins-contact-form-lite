<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function ecf_stt_page()
{

    ?>

    <div class="wrap">

    <div class="metabox-holder">
			<div class="postbox">
            <h3 style="padding-bottom: 8px; border-bottom: 1px solid #CCC;"><?php esc_html_e( 'Pro Version Control Panel Screenshot', 'contact-form-lite' );?></h3>

<div id="ecf-screenshot" class="ecfnote red rounded">
<span class="dashicons dashicons-megaphone" style="margin-right:8px;"></span>Need more options and feature? Just upgrade to <strong>Pro Version</strong>. <a class="ecf_cp_demo" href="JavaScript:void(0);">See this screenshot</a>
<div style="display: none;" class="ecf_cp_demo_wrap">
<p><img style="margin-top:5px; padding:3px; border: 1px dashed rgb(222, 185, 173);" src="<?php echo esc_url( plugins_url( 'images/banners/sc/cp_tab_one.png', dirname( __FILE__ ) ) ); ?>" width="900" height="715" /></p>
<p><img style="margin-top:5px; padding:3px; border: 1px dashed rgb(222, 185, 173);" src="<?php echo esc_url( plugins_url( 'images/banners/sc/cp_tab_two.png', dirname( __FILE__ ) ) ); ?>" width="900" height="941" /></p>
<p><img style="margin-top:5px; padding:3px; border: 1px dashed rgb(222, 185, 173);" src="<?php echo esc_url( plugins_url( 'images/banners/sc/cp_tab_three.png', dirname( __FILE__ ) ) ); ?>" width="900" height="943" /></p>
<a class="ecf_cp_demo_close" href="JavaScript:void(0);" style="float:right;margin-top:5px;color:#FFF;">close</a></div>
    </div>

           </div>
		</div>


    <div class="metabox-holder">
			<div class="postbox">
            <h3 style="padding-bottom: 8px; border-bottom: 1px solid #CCC;"><?php esc_html_e( 'Check this out!', 'contact-form-lite' );?></h3>
           <a href="https://ghozylab.com/plugins/easy-media-gallery-pro/demo/best-gallery-and-photo-albums-demo/" target="_blank"><img style="margin: 10px 0px 10px 10px" src="<?php echo esc_url( plugins_url( 'images/banners/emg_red_728x90.png', dirname( __FILE__ ) ) ); ?>" width="728" height="90" /></a>
           </div>
		</div>


    </div>

<style>
	a:focus {box-shadow: none !important; }
	.setpre {
		display:none;
		margin-right:10px;
		float: left;
		width:16px;
		height:16px;
		background-repeat:no-repeat;
		}

/* NOTES */
	  .ecfnote a { color:#FFF !important;}
      .ecfnote {
          position:relative;
          width:auto;
          padding:1em 1.5em;
          color:#fff;
          background:#97C02F;
          overflow:hidden;
		  margin: 10px 0px 10px 10px;
		  display:table;
      }

      .ecfnote:before {
          content:"";
          position:absolute;
          top:0;
          right:0;
          border-width:0 16px 16px 0; /* This trick side-steps a webkit bug */
          border-style:solid;
          border-color:#fff #fff #658E15 #658E15; /* A bit more verbose to work with .rounded too */
          background:#658E15; /* For when also applying a border-radius */
          display:block; width:0; /* Only for Firefox 3.0 damage limitation */
          /* Optional: shadow */
      }

      .ecfnote.red {background:#C93213;}
      .ecfnote.red:before {border-color:#fff #fff #97010A #97010A; background:#97010A;}

      .ecfnote.rounded {
          -webkit-border-radius:5px 0 5px 5px;
          -moz-border-radius:5px 0 5px 5px;
          border-radius:5px 0 5px 5px;
      }

      .ecfnote.rounded:before {
          border-width:8px; /* Triggers a 1px 'step' along the diagonal in Safari 5 (and Chrome 10) */
          border-color:#fff #fff transparent transparent; /* Avoids the 1px 'step' in webkit. Background colour shows through */
          border-bottom-left-radius:5px;
          -webkit-border-bottom-left-radius:5px;
          -moz-border-radius:0 0 0 5px;
          border-radius:0 0 0 5px;
      }

</style>

<script type="text/javascript">
/*<![CDATA[*/

jQuery(document).ready(function($) {

	$('.ecf_cp_demo, .ecf_cp_demo_close').on('click', function() {
		$('.ecf_cp_demo_wrap').slideToggle();
		});

});


	var ecfloader;
	function ecf_ajax_autoupdt(cmd) {

		window.clearTimeout(ecfloader);

		jQuery('.setpre').show().css('background-image','url(<?php echo esc_url( ECF_URL ).'/inc/images/89.gif'; ?>)');
		var data = {
			action: 'ecf_ajax_autoupdt',
			security: '<?php echo esc_html( wp_create_nonce( 'ecf-lite-nonce' ) ); ?>',
			cmd: jQuery(cmd).val(),
			};

			jQuery.post(ajaxurl, data, function(response) {
				if (response == 1) {
					jQuery('.setpre').css('background-image','url(<?php echo esc_url( ECF_URL ).'/inc/images/valid.png'; ?>)');
					ecfloader = window.setTimeout(function() {
					jQuery('.setpre').fadeOut();
					}, 3000);
					}
					else {
						jQuery('.setpre').hide();
						alert('Ajax request failed, please refresh your browser window.');
						}
					});
	}
/*]]>*/
</script>

<?php

}

?>