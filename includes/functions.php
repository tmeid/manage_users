<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function include_blade($blade_path, $title = null)
{
    if (file_exists($blade_path)) {
        require_once $blade_path;
    }
}

function sendMail($sendTo, $subject, $content)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'thytamphan@gmail.com';                     //SMTP username
        $mail->Password   = 'unmwzaaxdzfrghzw';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->CharSet = 'UTF-8';

        //Recipients
        $mail->setFrom('thytamphan@gmail.com', 'Manage Users');
        $mail->addAddress($sendTo);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $status = $mail->send();
        return $status;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function filterInput($data, $method)
{
    if ($method == 'GET') {
        $type = INPUT_GET;
    } elseif ($method == 'POST') {
        $type = INPUT_POST;
    }
    $formData = [];
   
    foreach ($data as $key => $value) {
        $key = strip_tags($key);

        if (is_array($value)) {
            $formData[$key] = filter_input($type, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        } else {
            $formData[$key] = trim(filter_input($type, $key, FILTER_SANITIZE_SPECIAL_CHARS));
        }
    }
    return $formData;
}

function getFormData()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (!empty($_GET)) {
            $data = $_GET;
            $formData = filterInput($data, 'GET');
        }
    }elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (!empty($_POST)) {
            $data = $_POST;
            $formData = filterInput($data, 'POST');
        }
    }
    return $formData;
}

function isVietnamesePhone($phone){
    // + hoặc k có +, tiếp theo là 84 hoặc là số 0
    // số tiếp theo thuộc [3, 5, 7, 9] và chỉ 1 số
    // các số còn lại phải là số và có len = 8
    $reg = '/(\+|)(84|0)[35789]([0-9]{8})$/';
    return preg_match($reg, $phone);
}

function isEmail($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;   
}

function getMsg($msg, $type){
    return '<p class="alert alert-'.$type.'">'.$msg .'</p>';
}

function redirect($path='index.php'){
    echo ("<script>location.href = '$path';</script>");
    exit();
}

function getUrl($env){
    if(isset($_SERVER['https']) && $_SERVER['https'] == 'on'){
        $path = 'https';
    }else{
        $path = 'http';
    }
    $path .= '://' .$_SERVER['HTTP_HOST'];
    if($env == 'local'){
        $path .= '/php-basic/manage-users';
    }
    return $path;
}

function isLogin($session_token){
    $checkLogin = false;
    if(getSession($session_token)){
        $login_token = getSession($session_token);
    
        $sql = "SELECT * FROM login_tokens WHERE token = :token";
        $login_token_info = firstRaw($sql, ['token' => $login_token]);

        if($login_token_info){
            $checkLogin = true;
            // redirect('?module=users&action=list');
        }else{
            destroySession('login_token');
        }
    }
    return $checkLogin;
}

function checkExpire($last_activity){
    $now = date('Y-m-d H:i:s');
    $diff = strtotime($now) - strtotime($last_activity);

    $expire = __EXPIRE_TIME * 86400;
    if($diff > $expire){
        return true;
    }
    return false;
}

function save_to_distinct_file($content, $id){
    $queue_path = __DIR__ .'/queue/';
    $file = $queue_path .$id;
    if(!file_exists($queue_path .$id)){
        $data = serialize($content);
        return file_put_contents($file, $data);
    }
}
function get_next_mail(){
    $queue_path = __DIR__ .'/queue/';
    $filenames = scandir($queue_path);
    $filenames = array_diff($filenames, ['.', '..']);  // remove the dots from Linux environments
    // remove the 1st ele and return the value of the removed ele
    $filename = array_shift($filenames);
    if ($filename !== null) {
        $file = $queue_path . $filename;
        $content = file_get_contents($file);
        if ($content !== false) {
            $object = unserialize($content);
            if ($object !== false) {
                unlink($file);
                return [
                    'content' => $object, 
                    'id' => (int)$filename
                ];
            }
            return false;
        }
    }
}