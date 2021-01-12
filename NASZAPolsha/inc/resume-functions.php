<?php

// Removing a field submit_resume_form_fields
add_filter( 'submit_resume_form_fields', 'remove_submit_resume_form_fields' );

function remove_submit_resume_form_fields( $fields ) {

	// Unset any of the fields you'd like to remove - copy and repeat as needed
	unset( $fields['resume_fields']['candidate_video'] );
	unset( $fields['resume_fields']['links'] );

	// And return the modified fields
	return $fields;
	
}

//Adding a field wp job manager rezume
// Add field to admin
add_filter( 'resume_manager_resume_fields', 'wpjms_admin_resume_form_fields' );
function wpjms_admin_resume_form_fields( $fields ) {
	
	$fields['_candidate_phone'] = array(
	    'label' 		=> __( 'Ваш номер телефону', 'job_manager' ),
	    'type' 			=> 'text',
	    'placeholder' 	=> __( '+48 123 456 789', 'job_manager' ),
	    'description'	=> '',
	    'priority' => 1
	);

	return $fields;
	
}

// Add field to frontend
add_filter( 'submit_resume_form_fields', 'wpjms_frontend_resume_form_fields' );
function wpjms_frontend_resume_form_fields( $fields ) {
	
	$fields['resume_fields']['candidate_phone'] = array(
	    'label' => __( 'Ваш номер телефону', 'job_manager' ),
	    'type' => 'text',
	    'required' => true,
	    'placeholder' => __( '+48 123 456 789', 'job_manager' ),
	    'priority' => 1
	);
	return $fields;
	
}

// Add a line to the notifcation email with custom field
add_filter( 'apply_with_resume_email_message', 'wpjms_color_field_email_message', 10, 2 );
function wpjms_color_field_email_message( $message, $resume_id ) {
  $message[] = "\n" . "Номер телефону: " . get_post_meta( $resume_id, '_candidate_phone', true );  
  return $message;
}
