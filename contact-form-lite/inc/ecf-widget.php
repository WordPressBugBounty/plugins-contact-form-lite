<?php

class ecf_sc_widget extends WP_Widget {

	
    // Create Widget
    function __construct() {
		
		$widget_ops = array('classname' => 'widget_ecf_sc_widget', 'description' => __( "Use this widget to display your form in widget area.") );
        $control_ops = array( 'width' => 'auto' );

		parent::__construct('ecf-widget', esc_html( ECF_ITEM_NAME ), $widget_ops, $control_ops );
		
    }

    // Widget Content
    function widget( $args, $instance ) {
		
        extract( $args );
		
		if ( isset ( $instance['ecf_shortcode'] ) && $instance['ecf_shortcode'] != 'select' ) {
		
        	$ecf_shortcode = $instance['ecf_shortcode'];
			
			$ecf_do_widget = do_shortcode( '[easy-contactform id="'.$ecf_shortcode.'"]' );
			
		} else {
			
			$ecf_do_widget = '<p>No form selected</p>';
			
		}
		
		
		echo wp_kses( $before_widget, ecf_wp_kses_allowed_html() );
        echo wp_kses( $ecf_do_widget, ecf_wp_kses_allowed_html() );
        echo wp_kses( $after_widget, ecf_wp_kses_allowed_html() );
     }

    // Update and save the widget
    function update( $new_instance, $old_instance ) {
		
    	$instance = $old_instance;
		
    	$instance['ecf_shortcode'] = $new_instance['ecf_shortcode'];
		
    	return $new_instance;
		
    }

    // If widget content needs a form
    function form( $instance ) {
		
        ?>
        <p><label for="<?php echo esc_attr( $this->get_field_id('ecf_shortcode') ); ?>">Select the Form name and press save button.<br />
    <select id="<?php echo esc_attr( $this->get_field_id('ecf_shortcode') ); ?>" name="<?php echo esc_attr( $this->get_field_name('ecf_shortcode') ); ?>" >
    <option value="select">- Select -</option>
	<?php 

global $post;

$args = array(
  'post_type' => 'easycontactform',
  'order' => 'ASC',
  'posts_per_page' => -1,
  'post_status' => 'publish',
	
);

$iscurr = ( isset( $instance["ecf_shortcode"] ) ? $instance["ecf_shortcode"]: 'select' ) ;

$myposts = get_posts( $args );
if( !empty ( $myposts ) ) {
	foreach( $myposts as $post ) :	setup_postdata($post);
		echo '<option value=' . esc_attr( $post->ID ) . '' .  selected( $iscurr, $post->ID ) . '>' . esc_html( esc_js( the_title(NULL, NULL, FALSE) ) ) . '</option>';
	endforeach; 
}
?>
</select></label></p>
        <?php       
    }
}


function ecf_widget_init() {
	
	register_widget('ecf_sc_widget');
	
}
add_action( 'widgets_init', 'ecf_widget_init' );


?>