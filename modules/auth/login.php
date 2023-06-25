<?php
// check whether user has logged in yet and token hasnt expired
$checkLogin = isLogin('login_token');
if($checkLogin){
    redirect('?module=users&action=list');
}
include_blade('assets/blade/sub_header.php', 'Đăng nhập');

// 
if (isset($_POST['submit'])) {
    $formData = getFormData();
    $errors = [];
    if (!empty($formData)) {
        $email = $formData['email'];
        $pass = $formData['password'];

        // validate pass
        if (empty($pass)) {
            $errors['password']['required'] = 'Chưa nhập password';
        } else {
            if (strlen($pass) <= 5) {
                $errors['password']['min'] = 'Mật khẩu phải có ít nhất 6 kí tự';
            }
        }

        // validate email
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
        if (empty($errors)) {
            // check login info
            $sql = "SELECT id, password, fullname FROM users WHERE email = :email AND status = :status";
            $userRawData = firstRaw($sql, ['email' => $email, 'status' => 1]);
            if ($userRawData) {
                $hashPass = $userRawData['password'];
                $user_id = $userRawData['id'];
                $token_login = sha1(uniqid() .time());

                if (password_verify($pass, $hashPass)) {
                    // insert info to login_tokens table
                    $data = [
                        'user_id' => $user_id,
                        'token' => $token_login,
                    ];
                    $insertStatus = insert('login_tokens', $data);

                    // insert login's time 
                    update('users', ['last_activity' => date('Y-m-d H:i:s')], $user_id);

                    //check the expiration of existing login_tokens 
                    $login_tokens = getRaw("SELECT * FROM login_tokens WHERE user_id = :user_id", ['user_id' => $user_id]);
            
                    if(!empty($login_tokens)){
                        foreach($login_tokens as $login_token){
                            $last_activity = $login_token['created_at'];
                            $id = $login_token['id'];

                            if(checkExpire($last_activity)){
                                delete('login_tokens', 'id', $id);
                            }
                        }
                    }

                    if($insertStatus){
                        // set login session
                        setSession('login_token', $token_login);
                        
                        $username = $userRawData['fullname'];
                        setSession('username', $username);
                        setSession('user_id', $user_id);
                        // redirec to list users
                        redirect('?module=users&action=list');
                    }else{
                        setFlashSession('error_msg', 'Lỗi hệ thống, vui lòng đăng nhập sau');
                        setFlashSession('error_type', 'danger');
                    }
                    
                } else {

                    setFlashSession('error_msg', 'Mật khẩu bị sai');
                    setFlashSession('error_type', 'danger');
                    // setFlashSession('old', $formData);
                    // reload page
                    // redirect('?module=auth&action=login');
                }
            } else {
                setFlashSession('error_msg', 'Email không tồn tại trên hệ thống hoặc tài khoản chưa được kích hoạt');
                setFlashSession('error_type', 'danger');
                // setFlashSession('old', $formData);
                // redirect('?module=auth&action=login');
            }

            
        }else{
            setFlashSession('error_msg', 'Đã có lỗi xảy ra');
            setFlashSession('error_type', 'danger');
            setFlashSession('errors', $errors);
        }
        setFlashSession('old', $formData);
        redirect('?module=auth&action=login');

    }
}


?>
<div class="container">
    <div class="row">
        <div class="col-6" style="margin: 10px auto;">
            <h3 class="text-center text-uppercase">Đăng nhập</h3>
            <?php
            // flass session: msg, type from register page
            // flass session: error_msg, error_type from login page
            $msg = getFlashSession('msg');
            $error_msg = getFlashSession('error_msg');

            $type = getFlashSession('type');
            $error_type = getFlashSession('error_type');

            $old = getFlashSession('old');
            $errors = getFlashSession('errors');
            if ($msg) {
                echo getMsg($msg, $type);
            }
            if ($error_msg) {
                echo getMsg($error_msg, $error_type);
            }
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" id="email" type="text" class="form-control" placeholder="Nhập email..." value="<?php echo $old['email'] ?? '' ?>">
                    <?php echo (!empty($errors['email'])) ? '<span class="error">' . reset($errors['email']) . '</span>' : '' ?>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input name="password" type="password" type="password" class="form-control" placeholder="Nhập mật khẩu...">
                    <?php echo (!empty($errors['password'])) ? '<span class="error">' . reset($errors['password']) . '</span>' : '' ?>
                </div>

                <button type="submit" class="btn btn-primary btn-block" name="submit">Đăng nhập</button>
                <hr>

                <div class="text-center"><a href="?module=auth&action=forgot_password">Quên mật khẩu?</a></div>
                <div class="text-center"><a href="?module=auth&action=register">Đăng kí tài khoản</a></div>
            </form>
            <hr>
            <p class="text-center">Example email: dthuyhuynh901@gmail.com</p>
            <p class="text-center">Pass: 1234567890</p>
        </div>
    </div>
</div>

<?php
include_blade('assets/blade/sub_footer.php');
