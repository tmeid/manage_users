<?php 
include_blade('assets/blade/sub_header.php', 'Quên mật khẩu');

if(isLogin('login_token')){
    redirect('?module=users&action=list');
}

echo '<main>';
echo '<div class="container">';
echo '<div class="row d-flex justify-content-center">';
echo '<div class="col-6">';

if(isset($_POST['submit'])){
    $formData = getFormData();
    $errors = [];

    $email = $formData['email'];
    $pattern = '/\.(?=[^\s]*@)/';

    $email = preg_replace($pattern, '', $email);

    if (empty($email)) {
        $errors['email']['required'] = 'Trường email bị bỏ trống';
    } else {
        if (!isEmail($email)) {
            $errors['email']['invalid'] = 'Định dạng email không hợp lệ';
        }
    }

    if(empty($errors)){
        $sql = "SELECT id, fullname FROM users WHERE email =:email";
        $userData = firstRaw($sql, ['email' => $email]);

        if($userData){
            $fullname = $userData['fullname'];
            $id = $userData['id'];
            // create a forgot_token
            $forgot_token = sha1(uniqid() .time());
            // insert to db
            $statusUpdate = update('users', ['forgot_token' => $forgot_token], $id);
            // send mail 
            // send an active email
            if($statusUpdate){
                $path = getUrl(__ENV) .'?module=auth&action=change_password&token=' .$forgot_token;
                $content = "<p>Xin chào $fullname,</p>";
                $content .= "<p>Vui lòng click vào link sau để đổi mật khẩu: $path</p>";
                $sendMailStatus = sendMail($email, 'Email thay đổi mật khẩu', $content);

                if($sendMailStatus){
                    setFlashSession('msg', 'Đã gửi mail thay đổi mật khẩu đến bạn, vui lòng kiểm tra email');
                    setFlashSession('type', 'success');
                }else{
                    setFlashSession('msg', 'Hệ thống đang gặp lỗi');
                    setFlashSession('type', 'danger');
                }
            }else{
                setFlashSession('msg', 'Hệ thống đang gặp lỗi');
                setFlashSession('type', 'danger');
            }
            

        }else{
            setFlashSession('msg', 'Tài khoản không tồn tại');
            setFlashSession('type', 'danger');
        }
        redirect('?module=auth&action=forgot_password');
    }else{
        setFlashSession('msg', 'Đã có lỗi xảy ra, vui lòng kiểm tra lại');
        setFlashSession('type', 'danger');
        setFlashSession('errors', $errors);
        setFlashSession('old', $userData);
        redirect('?module=auth&action=forgot_password');
    }
}
?>
<form action="" class="form border p-3" method="post">
    <h3>Tìm tài khoản</h3>
    <?php 
        
        $msg = getFlashSession('msg');
        $type = getFlashSession('type');
        $errors = getFlashSession('errors');
        $old = getFlashSession('old');
        if($msg){
            echo getMsg($msg, $type);
        }
    ?>
    <p>Vui lòng nhập email để tìm tài khoản</p>
    <label for="email">Email</label>
    <input id="email" type="text" name="email" placeholder="Email..." class="form-control mb-2" value="<?php echo $old['email'] ?? '' ?>">
    <?php echo (!empty($errors['email'])) ? '<span class="error">' . reset($errors['email']) . '</span>' : '' ?>

    <div class="d-flex justify-content-end">
        <a href="?module=auth&action=login" class="btn btn-secondary">Huỷ</a>
        <button type="submit" class="btn btn-primary ml-2" name="submit">Tìm</button>
    </div>
    
</form>

<?php 
echo '</div';
echo '</div';
echo '</div';
echo '</main>';
?>
