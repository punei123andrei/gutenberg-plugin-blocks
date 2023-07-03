<?php 

function wr_send_email(){

    $token = $_GET['token'];
    if ( ! wp_verify_nonce( $token, 'wr_token' ) ) {
        echo __('Invalid security token.', 'wp-riders');
        wp_die();
    }

    $form_data = $_GET['formData'];

     // Parse the form data into individual variables
     parse_str($form_data, $form_fields);

     // Perform validation or processing on each field
     $job_title = isset($form_fields['jobTitle']) ? $form_fields['jobTitle'] : '';
     $first_name = isset($form_fields['firstName']) ? $form_fields['firstName'] : '';
     $last_name = isset($form_fields['lastName']) ? $form_fields['lastName'] : '';
     $entry_date = isset($form_fields['entryDate']) ? $form_fields['entryDate'] : '';

    $email_subject = 'Applied for position' . $job_title;
    $email_message = 'Name: ' . $first_name;
    $email_message .= 'Last Name: ' . $last_name;
    $email_message .= 'Entry Date: ' . $entry_date;

    $headers[] = 'From: Your Name <yourname@example.com>';
    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    $email_sent = wp_mail('recipient@example.com', $email_subject, $email_message, $headers);

    if ($email_sent) {
        wp_send_json('Email sent successfully.');
    } else {
        wp_send_json('Failed to send email.');
    }

  
    echo json_encode($entry_date);

    wp_die();

}