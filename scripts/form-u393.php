<?php 
/* 	
If you see this text in your browser, PHP is not configured correctly on this hosting provider. 
Contact your hosting provider regarding PHP configuration for your site.

PHP file generated by Adobe Muse CC 2015.0.0.309
*/

require_once('form_process.php');

$form = array(
	'subject' => 'Register Form Submission',
	'heading' => 'New Form Submission',
	'success_redirect' => '',
	'resources' => array(
		'checkbox_checked' => 'Checked',
		'checkbox_unchecked' => 'Unchecked',
		'submitted_from' => 'Form submitted from website: %s',
		'submitted_by' => 'Visitor IP address: %s',
		'too_many_submissions' => 'Too many recent submissions from this IP',
		'failed_to_send_email' => 'Failed to send email',
		'invalid_reCAPTCHA_private_key' => 'Invalid reCAPTCHA private key.',
		'invalid_field_type' => 'Unknown field type \'%s\'.',
		'invalid_form_config' => 'Field \'%s\' has an invalid configuration.',
		'unknown_method' => 'Unknown server request method'
	),
	'email' => array(
		'from' => '',
		'to' => ''
	),
	'fields' => array(
		'custom_U406' => array(
			'order' => 1,
			'type' => 'string',
			'label' => 'Nama',
			'required' => true,
			'errors' => array(
				'required' => 'Field \'Nama\' is required.'
			)
		),
		'Email' => array(
			'order' => 3,
			'type' => 'email',
			'label' => 'Email',
			'required' => true,
			'errors' => array(
				'required' => 'Field \'Email\' is required.',
				'format' => 'Field \'Email\' has an invalid email.'
			)
		),
		'custom_U400' => array(
			'order' => 2,
			'type' => 'string',
			'label' => 'Alamat',
			'required' => false,
			'errors' => array(
			)
		),
		'custom_U410' => array(
			'order' => 4,
			'type' => 'string',
			'label' => 'Masukkan Password',
			'required' => true,
			'errors' => array(
				'required' => 'Field \'Masukkan Password\' is required.'
			)
		),
		'custom_U414' => array(
			'order' => 6,
			'type' => 'string',
			'label' => 'Konfirmasi Password',
			'required' => true,
			'errors' => array(
				'required' => 'Field \'Konfirmasi Password\' is required.'
			)
		),
		'custom_U446' => array(
			'order' => 5,
			'type' => 'string',
			'label' => 'Cell Phone',
			'required' => true,
			'errors' => array(
				'required' => 'Field \'Cell Phone\' is required.'
			)
		)
	)
);

process_form($form);
?>