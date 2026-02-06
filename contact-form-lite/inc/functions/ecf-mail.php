<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
-------------------------------------------------------------------------------*/
/*
	Email Sender
/*-------------------------------------------------------------------------------*/
function ecf_deliver_mail() {

	check_ajax_referer( trim( $_POST['formid'] ), 'security' );

	$result      = array();
	$frmid       = trim( wp_unslash( $_POST['formid'] ) );
	$attachments = array();
	$aftersent   = get_post_meta( $frmid, 'ecf_email_action_on_sent', true );

	$singelmnt = ecf_form_element_parsing(
		$frmid,
		null,
		wp_unslash( $_POST['allelmnt'] ),
		null
	);

	// To
	if ( isset( $singelmnt['to'] ) && trim( $singelmnt['to'] ) ) {
		$to = sanitize_email( $singelmnt['to'] );
	} else {
		$to = sanitize_email( get_post_meta( $frmid, 'ecf_meta_admin_email', true ) );
	}

	// sanitize form values
	$name    = sanitize_text_field( $singelmnt['name'] );
	$email   = sanitize_email( $singelmnt['email'] );
	$message = $singelmnt['emailbody'];

	$headers   = array();
	$headers[] = 'Content-Type: text/html; charset=utf-8';
	$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';

	$args = array(
		'to'          => $to,
		'name'        => $name,
		'email'       => $email,
		'message'     => $message,
		'headers'     => $headers,
		'attachments' => $attachments,
	);

	$sent = wp_mail(
		$to,
		'From ' . $name,
		$message,
		$headers,
		$attachments
	);

	if ( apply_filters( 'ecf_email_configs', $sent, $args ) ) {

		if ( has_action( 'ecf_before_email_sent' ) ) {
			do_action( 'ecf_before_email_sent', $frmid, $name, $email, $singelmnt );
		}

		$result['Ok']  = true;
		$result['msg'] = $aftersent[0];

		if ( has_action( 'ecf_after_email_sent' ) ) {
			do_action( 'ecf_after_email_sent', $email, $name, $frmid );
		}

		if ( has_action( 'ecf_analytics_after_email_sent' ) ) {
			do_action( 'ecf_analytics_after_email_sent', $frmid );
		}
	} else {

		$result['Ok'] = false;

		global $phpmailer;
		$result['msg'] = isset( $phpmailer ) ? $phpmailer->ErrorInfo : 'Error!';
	}

	echo wp_json_encode( $result );
	wp_die();
}

add_action( 'wp_ajax_ecf_deliver_mail', 'ecf_deliver_mail' );
add_action( 'wp_ajax_nopriv_ecf_deliver_mail', 'ecf_deliver_mail' );

/**
 * Parse form elements and prepare sanitized email body (HTML)
 *
 * @param int    $fid   Form ID
 * @param string $type  (unused, reserved for future)
 * @param string $jsnel JSON string of submitted elements
 * @param array  $atch  Attachments (unused here)
 *
 * @return array $singelmnt Contains sanitized form values including 'emailbody'
 */
function ecf_form_element_parsing( $fid, $type, $jsnel, $atch ) {

	$emailhtml = '';
	$singelmnt = array();

	if ( ! is_array( $jsnel ) ) {
		return $singelmnt; // return empty if invalid
	}

	foreach ( $jsnel as $val ) {

		if ( ! isset( $val['type'] ) || ! isset( $val['label'] ) ) {
			continue; // skip invalid elements
		}

		$value = $val['value'] ?? '';

		// ---------------------------
		// Sanitize element value
		// ---------------------------
		if ( is_array( $value ) ) {
			array_walk_recursive( $value, 'ecf_sanitize_array' );
		} else {
			switch ( $val['type'] ) {
				case 'paragraph':
				case 'message':
					$value = sanitize_textarea_field( $value );
					break;
				case 'text':
				case 'website':
				case 'date':
				case 'name':
					$value = sanitize_text_field( $value );
					break;
				case 'email':
					$value = sanitize_email( $value );
					break;
				default:
					$value = sanitize_text_field( $value ); // fallback
			}
		}

		// ---------------------------
		// Store special fields
		// ---------------------------
		if ( $val['type'] === 'email' ) {
			$singelmnt['email'] = $value;
		} elseif ( $val['type'] === 'name' ) {
			$singelmnt['name'] = $value;
		} elseif ( $val['type'] === 'message' ) {
			$singelmnt['message'] = $value;
		}

		// ---------------------------
		// Handle checkbox group
		// ---------------------------
		if ( isset( $val['cbxgroup'] ) && is_array( $val['cbxgroup'] ) ) {
			$cbx   = array_map( 'sanitize_text_field', $val['cbxgroup'] );
			$value = $cbx;
		}

		// ---------------------------
		// Build HTML email line
		// ---------------------------
		$emailhtml .= '<strong>' . esc_html( $val['label'] ) . ':</strong><br>';

		if ( is_array( $value ) ) {
			$emailhtml .= implode( '<br>', array_map( 'esc_html', $value ) );
		} elseif ( $val['type'] === 'message' || $val['type'] === 'paragraph' ) {
				$emailhtml .= nl2br( esc_html( $value ) );
		} else {
			$emailhtml .= esc_html( $value );
		}

		$emailhtml .= '<br><br>'; // line break in HTML
	}

	// ---------------------------
	// Store complete HTML email body
	// ---------------------------
	$singelmnt['emailbody'] = $emailhtml;

	return $singelmnt;
}

/*
-------------------------------------------------------------------------------*/
/*
	Sanitize Array
/*-------------------------------------------------------------------------------*/
function ecf_sanitize_array( &$value ) {

	$value = esc_html( $value );
	$value = esc_js( $value );
	$value = htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' );
}
