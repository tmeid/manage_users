<?php
include_blade('assets/blade/sub_header.php');
if (isLogin('login_token')) {
    redirect('?module=auth&action=list');
}

$urlData = getFormData();
if (!empty($urlData['token'])) {
    $forgot_token = $urlData['token'];

    $sql = "SELECT id FROM users WHERE forgot_token =:forgot_token";
    $userData = firstRaw($sql, ['forgot_token' => $forgot_token]);
    if ($userData) {
        $id = $userData['id'];
        // update('users', ['forgot_token' => null], $id);

        // hiển thị form ==> submit lên lại ==> validate thành công ==> update dữ liệu
        // validate pass: 
        if(isset($_POST['submit'])){       
            $errors = [];
            $pass = $urlData['password'];
            if(empty($pass)){
                $errors['password']['required'] = 'Chưa nhập password';
            }else{
                if(strlen($pass) <= 5){
                    $errors['password']['min'] = 'Mật khẩu phải có ít nhất 6 kí tự';
                }
            }

            // validate re-password: 
            $rePass = $urlData['rePassword'];
            if(empty($rePass)){
                $errors['rePassword']['required'] = 'Trống trường nhập lại password';
            }else{
                if($pass !== $rePass){
                    $errors['rePassword']['match'] = 'Mật khẩu không khớp nhau';
                }
            }
            if(empty($errors)){
                $hashPass = password_hash($pass, PASSWORD_DEFAULT);
                $statusUpdate = update('users', ['password' => $hashPass, 'forgot_token' => null], $id);

                // delete all login_token of users 
                $statusDelete = delete('login_tokens', 'user_id', $id);
                if($statusUpdate && $statusDelete){
                    setFlashSession('msg', 'Đổi mật khẩu thành công, vui lòng đăng nhập lại');
                    setFlashSession('type', 'success');
                    redirect('?module=auth&action=login');
                }else{
                    setFlashSession('msg', 'Lỗi hệ thống, vui lòng thử lại');
                    setFlashSession('type', 'danger');
                }
            }else{
                setFlashSession('msg', 'Đã có lỗi xảy ra, vui lòng thử lại');
                setFlashSession('type', 'danger');
                setFlashSession('errors', $errors);
                redirect('?module=auth&action=change_password&token=' .$forgot_token);
                    
            }
        }
?>
        <div class="container">
            <div class="row">
                <div class="col-6" style="margin: 10px auto;">
                    <h3 class="text-center text-uppercase">Đổi mật khẩu</h3>
                    <?php
                        $msg = getFlashSession('msg');
                        $type = getFlashSession('type');
                        $errors = getFlashSession('errors');
                        if($msg){
                            echo getMsg($msg, $type);
                        }
                    ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input name="password" id="password" type="password" class="form-control" placeholder="Nhập mật khẩu...">
                            <?php echo (!empty($errors['password'])) ? '<span class="error">' . reset($errors['password']) . '</span>' : '' ?>
                        </div>

                        <div class="form-group">
                            <label for="re-password">Nhập lại mật khẩu</label>
                            <input name="rePassword" id="re-password" type="password" class="form-control" placeholder="Nhập lại mật khẩu...">
                            <?php echo (!empty($errors['rePassword'])) ? '<span class="error">' . reset($errors['rePassword']) . '</span>' : '' ?>
                        </div>
                        <input type="hidden" name="token" value="<?php  echo $forgot_token ?>">
                        <button name="submit" type="submit" class="btn btn-primary btn-block">Đổi mật khẩu</button>
                        <hr>

                        <div class="text-center"><a href="?module=auth&action=login">Đăng nhập</a></div>
                    </form>
                </div>
            </div>
        </div>




<?php

    } else {
        setFlashSession('msg', 'Link hết hạn, vui lòng thử lại');
        setFlashSession('type', 'danger');
        redirect('?module=auth&action=forgot_password');
    }
} else {
    setFlashSession('msg', 'Link bị sai');
    setFlashSession('type', 'danger');
    redirect('?module=auth&action=forgot_password');
}

// if(isset($_GET['token'])){
//     $forgot_token = $_GET['token'];
//     if(!empty($forgot_token)){
//         $sql = "SELECT id FROM users WHERE forgot_token =:forgot_token";
//         $userData = firstRaw($sql, ['forgot_token' => $forgot_token]);
//         if($userData){
//             $id = $userData['id'];
//             update('users', ['forgot_token' => null], $id);
//         }else{
//             setFlashSession('msg', 'Link hết hạn, vui lòng thử lại');
//             setFlashSession('type', 'danger');
//             redirect('?module=auth&action=forgot_password');
//         }
//     }else{
//         setFlashSession('msg', 'Link hết hạn, vui lòng thử lại');
//         setFlashSession('type', 'danger');
//         redirect('?module=auth&action=forgot_password');
//     }
// }else{
//     setFlashSession('msg', 'Link bị sai');
//     setFlashSession('type', 'danger');
//     redirect('?module=auth&action=forgot_password');
// }
