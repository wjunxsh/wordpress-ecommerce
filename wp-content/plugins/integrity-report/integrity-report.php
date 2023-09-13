<?php
/*
Plugin Name: Integrity Report
Description: This is a plugin that show a integrity report form and sends data to pr via SMTP.
Version: 1.0
Author: Anker DTC IT
*/

// Integrity Report Agree Bar
function integrity_report_bar() {
  ob_start();
  ?>
  <div class="integrity_report_bar">
    <span id="statement_span">
      <input type="checkbox" id="statement_checkbox" />
      I have confirmed the above information and am sure to submit.
    </span>
    <p id="statement_link">
      <a href="/jubao_submit">Initiating integrity reporting</a>
    </p>
  </div>
    <script>
    document.getElementById('statement_span').addEventListener('click', function(e) {
      if (document.getElementById('statement_checkbox').checked) {
        document.getElementById('statement_checkbox').checked = false;
        document.getElementById('statement_link').style.display = 'none';
      } else {
        document.getElementById('statement_checkbox').checked = true;
        document.getElementById('statement_link').style.display = 'block';
      }
    })
    </script>
  <style>
  .integrity_report_bar span { display: inline; vertical-align: middle; font-size: 20px; cursor: pointer; }
  .integrity_report_bar input { font-size: 20px; width:20px; height:20px; margin: 5px; cursor: none; cursor: none; }
  .integrity_report_bar p { display: none; text-align: center; padding: 20px; }
  .integrity_report_bar a { display: inline-block; padding: 10px 20px; min-width: 400px; border: 1px solid #999; text-align: center; background: #eee; }
  </style>
    <?php
    return ob_get_clean(); // 清理缓冲区并返回内容
}
add_shortcode('integrity_report_bar', 'integrity_report_bar');

// Integrity Report Form
function integrity_report_form() {
    ob_start(); // start print
    
    ?>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="integrity_report_form">
    <?php
     wp_nonce_field('integrity_report_form_nonce');
     if (isset($_GET['error'])) {
        if ($_GET['error'] === 'nonce_failed') {
            echo '<p>Error: Nonce check failed.</p>';
        } elseif ($_GET['error'] === 'invalid_data') {
            echo '<p>Error: Invalid data.</p>';
        }
    }
       echo '<p>Error:===========sdfasdfafafafafd</p>';
    ?>
    <h3 style="margin-top: 30px;">Basic information of reportor</h3>
    <div class="form-check form-check-inline" id="reporter-realname">
      <input class="form-check-input" type="radio" name="anonymous" id="realname" checked>
      <label class="form-check-label" for="realname">Real-name reporting</label>
    </div>
    <div class="form-check form-check-inline" id="reporter-anonymous">
      <input class="form-check-input" type="radio" name="anonymous" id="anonymous">
      <label class="form-check-label" for="anonymous">Anonymous reporting</label>
    </div>
    <div class="card" id="reporter-fields">
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-4 required">
            <label for="reporter_name" class="required">Name</label>
            <input type="text" class="form-control" id="reporter_name" required>
            <div class="invalid-feedback">Please input your name.</div>
          </div>
        </div>
        <div>Contacting information（Fill in at least one type）</div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="reporter_email">Email</label>
            <input type="email" class="form-control" id="reporter_email">
          </div>
          <div class="form-group col-md-4">
            <label for="reporter_phone">TEL</label>
            <input type="phone" class="form-control" id="reporter_phone">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <lable for="reporter_im">Other contacts information</label>
            <input type="other" class="form-control" id="reporter_im" placeholder="(whatapp etc)">
          </div>
        </div>
      </div>
    </div>
        
    <h3 style="margin-top: 30px;">Basic information about the reported Anker staff</h3>
    <div class="card">
      <div class="card-body">
        <div id="reported_person">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="stuff_name[]">Staff name</label>
              <input type="text" class="form-control" id="stuff_name[]">
            </div>
            <div class="form-group col-md-4">
              <label for="stuff_number[]">Staff number</label>
              <input type="text" class="form-control" id="stuff_number[]">
            </div>
            <div class="form-group col-md-4">
              <label for="stuff_email[]">Staff email address</label>
              <input type="text" class="form-control" id="stuff_email[]">
            </div>
            <div class="form-group col-md-4">
              <label for="stuff_department[]">Staff department</label>
              <input type="text" class="form-control" id="stuff_department[]">
            </div>
            <div class="form-group col-md-4">
              <button type="button" class="btn btn-light" id="addmore">Add more</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h3 style="margin-top: 30px;">Report content</h3>
    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label for="report_title" class="required">Reporting title</label>
          <input type="text" class="form-control" id="report_title" required>
          <div class="invalid-feedback">Please input the report title.</div>
        </div>
        <div class="form-group">
          <label for="report_content" class="required">Reporting details</label>
          <textarea type="text" class="form-control" id="report_content" rows="3" required></textarea>
          <div class="invalid-feedback">Please input the report details.</div>
        </div>
        <div class="form-group">
          <label for="report_attachment">Supporting documents</label>
          <input type="file" class="form-control" id="report_attachment" aria-describedby="attachmentHelp">
          <small id="attachmentHelp" class="form-text text-muted">（The maximum attachment size is <red>50M</red>, and the acceptable formats are gif, jpg, png, jpeg, bmp, doc, ppt, xls, xlsx, docx, pptx, zip, rar, pdf.
If the format or size of the uploaded attachment does not meet the requirements, you can send the attachment to <a href="mailto: jubao@anker.com">jubao@anker.com</a>.）</small>
        </div>
      </div>
    </div>
    <div style="margin-top: 30px; text-align: center;">
      <button
		class="g-recaptcha btn btn-primary"
		data-sitekey="6LfBRSAoAAAAAHaaD8l0UJkepX90x4Fi5pKMpcD3"
		data-callback="onSubmit"
		data-action="submit"
		style="min-width: 180px;">Submit</button>
    </div>
    </form>
    
    <script>
    document.getElementById('reporter-realname').addEventListener('click', function(e) {
      document.getElementById('reporter-fields').style.display = 'block';
    });
    document.getElementById('reporter-anonymous').addEventListener('click', function(e) {
      document.getElementById('reporter-fields').style.display = 'none';
    });
    document.getElementById('reported_person').addEventListener('click', function(e) {
      if (e.target.id === 'addmore') {
        var div = document.createElement('div');
        div.className = 'form-row';
        div.innerHTML = '<div class="form-group col-md-4"><label for="stuff_name[]">Stuff name</label><input type="text" class="form-control" id="stuff_name[]"></div>' +
            '<div class="form-group col-md-4"><label for="stuff_number[]">Staff number</label><input type="text" class="form-control" id="stuff_number[]"></div>' +
            '<div class="form-group col-md-4"><label for="stuff_email[]">Staff email address</label><input type="text" class="form-control" id="stuff_email[]"></div>' +
            '<div class="form-group col-md-4"><label for="stuff_department[]">Staff department</label><input type="text" class="form-control" id="stuff_department[]"></div>' +
          '<div class="form-group col-md-4"><button type="button" class="btn btn-dark" id="remove">Remove</button></div>';
        document.getElementById('reported_person').appendChild(div);
      }
      if (e.target.id === 'remove') {
        e.target.parentNode.parentNode.remove();
      }
    });
    (function() {
      'use strict';
      window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
        }, false);
      });
      }, false);
    })();
    function onSubmit(token) {
        event.preventDefault();
        document.getElementsByClassName('needs-validation')[0].submit();
    }
    </script>
  <style>
    #addmore, #remove { margin-top: 39px; }
    label.required:after { content: " *"; color: red; font-weight: 100; }
  </style>
    <?php
    return ob_get_clean(); // 清理缓冲区并返回内容
}
add_shortcode('integrity_report_form', 'integrity_report_form');

// process submit form
function integrity_report_handle_form_submit() {
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
            'secret'   => '6LfBRSAoAAAAAFoenTzFYE9KXJeDAwFg1DAAFZi_',
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ]
    ]);

    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body, true);

    if (true == $result['success']) {
        wp_mail($to, $subject, $message, $headers);
        wp_safe_redirect(add_query_arg('error', 'invalid_data', $_SERVER['HTTP_REFERER']));
        exit;
    } else {
        wp_safe_redirect(add_query_arg('error', 'invalid_data', $_SERVER['HTTP_REFERER']));
        exit;
    }
    
    // back to original url
    wp_safe_redirect($_SERVER['HTTP_REFERER']);
    exit;
    
}
function start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'start_session', 1);
add_action('admin_post_nopriv_integrity_report_form', 'integrity_report_handle_form_submit');
add_action('admin_post_integrity_report_form', 'integrity_report_handle_form_submit');
add_action('wp_enqueue_scripts', 'my_recaptcha_script');

function my_recaptcha_script() {
    wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js?render=6LfBRSAoAAAAAHaaD8l0UJkepX90x4Fi5pKMpcD3', [], null, true);
}