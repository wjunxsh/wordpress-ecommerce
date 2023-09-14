<?php

class IntegrityReportBackend {
    public static function init() {
        add_action('admin_post_nopriv_integrity_report_form', array('IntegrityReportBackend','integrity_report_handle_form_submit'));
        add_action('admin_post_integrity_report_form', array('IntegrityReportBackend','integrity_report_handle_form_submit'));
    }
    public static function integrity_report_handle_form_submit(){
        // reporter
    $reporter_name = sanitize_text_field($_POST['reporter_name']);
    $reporter_email = sanitize_email($_POST['reporter_email']);
    $reporter_phone = sanitize_text_field($_POST['reporter_phone']);
    $reporter_im = sanitize_text_field($_POST['reporter_im']);

    // reported stuff
    $stuff_names = array_map('sanitize_text_field', $_POST['stuff_name']);
    $stuff_numbers = array_map('sanitize_text_field', $_POST['stuff_number']);
    $stuff_emails = array_map('sanitize_email', $_POST['stuff_email']);
    $stuff_departments = array_map('sanitize_text_field', $_POST['stuff_department']);

    // report content
    $report_title = sanitize_text_field($_POST['report_title']);
    $report_description = sanitize_textarea_field($_POST['report_description']);

    // process attachment...
    $attachment = $_FILES['report_attachment'];

    // send email
    $to = '1053249119@qq.com';
    $subject = 'Integrity Reporting';
    $message = 'Form data: daf-----';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    //wp_mail($to, $subject, $message, $headers);
    check_admin_referer('integrity_report_form_nonce');

    $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);

    $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
        'body' => [
            'secret'   => '6LcoVRwoAAAAAEgoFUp9nrnvVzIK6WixzS1Ljs2t',
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ]
    ]);

    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body, true);
    if (true == $result['success']) {
        wp_mail($to, $subject, $message, $headers);
    } else {
        echo '<p>Google 验证失败</p><script type="text/javascript">setTimeout(function(){window.location.href="'.$_SERVER['HTTP_REFERER'].'"},5000)</script>';
        exit;
    }
    // back to original url
    wp_safe_redirect($_SERVER['HTTP_REFERER']);
    exit;
    }
}