<?php

class IntegrityReportAction {
    public static function init() {
        add_action('admin_post_nopriv_integrity_report_form', array('IntegrityReportAction','integrity_report_handle_form_submit'));
        add_action('admin_post_integrity_report_form', array('IntegrityReportAction','integrity_report_handle_form_submit'));
    }
    public static function integrity_report_handle_form_submit(){
		 check_admin_referer('integrity_report_form_nonce');
        //google verify
        
        self::google_recaptcha_verify();
        //处理post的值
        $body = self::sanitize_form_fields_to_email();
        // get mail attachments from files
        $attachments = self::attachments_from_upload();
        // send email config
		$to = 'colin.wu@anker-in.com';
		$subject = 'Integrity Reporting';
        //将数据组装起来
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($to, $subject, $body, $headers, $attachments);
        echo '<div style="width:100%;height:100vh;display:flex;align-items: center;justify-content: center; ">
            <p style="font-size:20px;text-align:center;background:#f5f5f5;width:50%;box-shadow:2px 2px 4px #dedede;border-radius:8px;padding:80px 40px;">
                The report has been sent, we will follow up as soon as possible!<span id="left-time">(left 3 s)</span></p>
        </div> <script type="text/javascript">
    window.leftTime = 3;
        setInterval(function(){ 
            window.leftTime -= 1;
            if(window.leftTime >= 0) {
                document.getElementById("left-time").innerText = "(left "+window.leftTime+") s";
            }else {
                window.location.href="'.$_SERVER['HTTP_REFERER'].'"
            }
        },1000)</script>';
        exit;
    }
    public static function google_recaptcha_verify() {
        $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
        //我的 6LfBRSAoAAAAAFoenTzFYE9KXJeDAwFg1DAAFZi_
        //线上 6LcoVRwoAAAAAEgoFUp9nrnvVzIK6WixzS1Ljs2t
        $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
            'body' => [
                'secret'   => '6LcoVRwoAAAAAEgoFUp9nrnvVzIK6WixzS1Ljs2t',
                'response' => $recaptcha_response,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ]
        ]);
        $response_body = wp_remote_retrieve_body($response);
        $result = json_decode($response_body, true);
        if (true != $result['success']) {
            echo '<p>Google 验证失败</p><script type="text/javascript">setTimeout(function(){window.location.href="'.$_SERVER['HTTP_REFERER'].'"},5000)</script>';
            exit;
        }
    }
    public static function sanitize_form_fields_to_email() {

        $reporter_name          = sanitize_text_field($_POST['reporter-name']);
        $reporter_email         = sanitize_email($_POST['reporter-email']);
        $reporter_phone         = sanitize_text_field($_POST['reporter-phone']);
        $reporter_im            = sanitize_text_field($_POST['reporter-im']);
        $anonymous              = sanitize_text_field($_POST['anonymous']);
        // reported stuff
        $stuff_names            = array_map('sanitize_text_field', $_POST['stuff-name']);
        $stuff_numbers          = array_map('sanitize_text_field', $_POST['stuff-number']);
        $stuff_emails           = array_map('sanitize_email', $_POST['stuff-email']);
        $stuff_departments      = array_map('sanitize_text_field', $_POST['stuff-department']);
		
        // report content
        $report_title           = sanitize_text_field($_POST['report-title']);
        $report_details     = sanitize_textarea_field($_POST['report-details']);
        $html = '
		<div><h3>Basic information of reporter</h3>
            <p><b>'.$anonymous .'</b></p>
			<p><b>Name:'.$reporter_name.'</b></p>
			<p><b>Email:'.$reporter_email.'</b></p>
			<p><b>Phone:'.$reporter_phone.'</b></p>
			<p><b>Other contact information:'.$reporter_im .'</b></p>
            <h3>Basic information about the reported Anker staff</h3>
            <table>
                <thead><tr><th>Staff name</th><th>Staff number</th><th>Staff email address</th><th>Staff department</th></tr></thead>
                <tbody>';
            for($i=0;$i<count($stuff_names);$i++) {
                $html .= '<tr><td>'.$stuff_names[$i].'</td><td>'.$stuff_numbers[$i].'</td><td>'.$stuff_emails[$i].'</td><td>'.$stuff_departments[$i].'</td></tr>';
            }       
            $html .='</tbody>
            </table>
            <h2>Reporting title:'.$report_title.'</h2>
            <p>Reporting content:'.$report_details.'</p>
		<div><style>
        table {
            border:1px solid #dedede;
            width:100%;
            border-collapse:collapse;
        }
        td,th{
            padding:8px;
            border:1px solid #dedede;
        }
    </style>';
	return $html;
	
    }
    public static function attachments_from_upload() {
        $attachments = array();
		if (isset($_FILES['report-attachment']) && count($_FILES['report-attachment'])>= 1){
            $upload_dir = wp_upload_dir();
			$count = count($_FILES['report-attachment']['tmp_name']);
			for ($i = 0; $i < $count; $i++) {
				 $file_name = $_FILES['report-attachment']['name'][$i];
            	$file_tmp = $_FILES['report-attachment']['tmp_name'][$i];
				if(!is_uploaded_file($file_tmp)){
                    continue;
                }
				$uploaded_file_path = $upload_dir['path'] . '/' . basename($file_name);
                if (move_uploaded_file($file_tmp, $uploaded_file_path)) {
                    array_push($attachments,$uploaded_file_path);
                }
			}
        }
        return $attachments;    
    }
}