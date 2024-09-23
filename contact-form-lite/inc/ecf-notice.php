<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/*-------------------------------------------------------------------------------*/
/*   Affiliate Notice @since 1.0.7
/*-------------------------------------------------------------------------------*/
//add_action('admin_notices', 'ecf_aff_admin_notice');

function ecf_aff_admin_notice() {
    global $current_user, $post;
		if ( !empty( $post ) && 'easycontactform' === $post->post_type && is_admin() ) {
        	$user_id = $current_user->ID;
        	/* Check that the user hasn't already clicked to ignore the message */
   	 		if ( ! get_user_meta($user_id, 'ecf_ignore_notice') ) {
       	 		echo '<div class="updated"><p>'; 
        		printf('Earn <span style="color: red;">EXTRA MONEY</span> and get 30&#37; affiliate share from every sale you make!&nbsp;&nbsp;<a href="https://ghozylab.com/plugins/affiliate-program/" target="_blank">JOIN GHOZYLAB AFFILIATE PROGRAM NOW!</a><span style="float: right;"><a href="%1$s">Hide Notice</a><span>', '?ecf_nag_ignore=0');
        		echo "</p></div>";
    			}
			}
}


add_action('admin_init', 'ecf_nag_ignore');

function ecf_nag_ignore() {

    global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['ecf_nag_ignore']) && '0' == $_GET['ecf_nag_ignore'] ) {
             add_user_meta($user_id, 'ecf_ignore_notice', 'true', true);
    }
}


/*-------------------------------------------------------------------------------*/
/*   Rating Notice @since 1.0.9
/*-------------------------------------------------------------------------------*/
//add_action('admin_notices', 'ecf_rating_admin_notice');

function ecf_rating_admin_notice() {
		
    global $post;
		if ( !empty( $post ) && 'easycontactform' === $post->post_type && is_admin() ) {
	
       	 		echo '<div class="updated"><p>'; 
        		echo'<span style="color:#0073AA;">If you use</span> <strong>'.esc_html(ECF_ITEM_NAME).'</strong><span style="color:#0073AA;"> and found it useful then please consider rating it and leaving your positive feedback</span> <a href="https://wordpress.org/support/view/plugin-reviews/contact-form-lite?filter=5#postform" target="_blank" style="color: red !important;">from here</a>';
        		echo "</p></div>";
				
		}
}


?>