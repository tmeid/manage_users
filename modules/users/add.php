<?php 
$checkLogin = isLogin('login_token', 'login_tokens', 'token');
if (!$checkLogin) {
    redirect('?module=auth&action=login');
}
include_blade('assets/blade/header.php', 'Thêm người dùng');

if(isset($_POST['submit'])){
    $formData = getFormData();
    
    $errors = [];
    // validate name
    $name = $formData['name'];
    if(empty($name)){
        $errors['name']['required'] = 'Trường tên bị trống';
    }else{
        if(mb_strlen($name, 'utf-8') < 4){
            $errors['name']['size'] = 'Tên phải ít nhất 4 kí tự';
        }

    }
    
    // validate email
    // remove a dot character before @ character because both of them are same email: 
    // d.thuy.3319@gmai.com ==> dthuy3319@gmail.com
    $email = $formData['email'];
    $pattern = '/\.(?=[^\s]*@)/';

    $email = preg_replace($pattern, '', $email);
    
    if(empty($email)){
        $errors['email']['required'] = 'Trường email bị bỏ trống';
    }else{
        if(!isEmail($email)){
            $errors['email']['invalid'] = 'Định dạng email không hợp lệ';
        }else{
            // kiểm tra email có unique không
            $sql = "SELECT id FROM users WHERE email = :email";
            if(getRows($sql, ['email' => $email]) == 1){
                $errors['email']['unique'] = 'Email đã tồn tại';
            }
        }
    }

    // print_r($errors['name']);
    // validate số đt vietnam: k dc để trống
    // các đầu số  03, 05, 07, 08, 09: 10 số
    // có thể bắt đầu bằng +84 hoặc 84
    $phone = $formData['phone'];
    if(empty($phone)){
        $errors['phone']['required'] = 'Trường điện thoại bị trống';
    }else{
        if(!isVietnamesePhone($phone)){
            $errors['phone']['invalid'] = 'Số điện thoại không hợp lệ';
        }
    }

    // validate pass: 
    $pass = $formData['password'];
    if(empty($pass)){
        $errors['password']['required'] = 'Chưa nhập password';
    }else{
        if(strlen($pass) <= 5){
            $errors['password']['min'] = 'Mật khẩu phải có ít nhất 6 kí tự';
        }
    }

    // validate re-password: 
    $rePass = $formData['rePassword'];
    if(empty($rePass)){
        $errors['rePassword']['required'] = 'Trống trường nhập lại password';
    }else{
        if($pass !== $rePass){
            $errors['rePassword']['match'] = 'Mật khẩu không khớp nhau';
        }
    }

    if(empty($errors)){
        $fullname = $formData['name'];
        $dataInsert = [
            'email'=> $email,
            'fullname' => $fullname,
            'phone' => $formData['phone'],
            'password' => password_hash($formData['password'], PASSWORD_DEFAULT),
            'status' => 1
        ];
        $insertStatus = insert('users', $dataInsert);
        if($insertStatus){
            setFlashSession('msg', 'Thêm người dùng thành công');
            setFlashSession('type', 'success');
            redirect('?module=users&action=list');
        }else{
            setFlashSession('msg', 'Hệ thống đang gặp lỗi');
            setFlashSession('type', 'danger');
            redirect('?module=users&action=add');
        }

        
    }else{
        setFlashSession('msg', 'Đã có lỗi xảy ra, vui lòng kiểm tra lại');
        setFlashSession('type', 'danger');
        setFlashSession('errors', $errors);
        setFlashSession('old', $formData);
        redirect('?module=users&action=add');
    }
}

?>
<div class="container">
    <div class="row">
        <div class="col-6" style="margin: 10px auto;">
        <h3>Thêm người dùng</h3>
        <form action="" method="post">
            <?php 
            
                $msg = getFlashSession('msg');
                $type = getFlashSession('type');
                $errors = getFlashSession('errors');
                $old = getFlashSession('old');
                if($msg){
                    echo getMsg($msg, $type);
                }
            ?>
                <div class="form-group">
                    <label for="name">Tên</label>
                    <input name="name" id="name" type="text" class="form-control" placeholder="Nhập tên..." value="<?php  echo $old['name'] ?? '' ?>">
                    <?php echo (!empty($errors['name'])) ? '<span class="error">'.reset($errors['name']).'</span>' : '' ?>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" id="email" type="text" class="form-control" placeholder="Nhập email..." value="<?php  echo $old['email'] ?? '' ?>">
                    <?php echo (!empty($errors['email'])) ? '<span class="error">'.reset($errors['email']).'</span>' : '' ?>
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input name="phone" id="phone" type="text" class="form-control" placeholder="Nhập số điện thoại..." value="<?php  echo $old['phone'] ?? '' ?>">
                    <?php echo (!empty($errors['phone'])) ? '<span class="error">'.reset($errors['phone']).'</span>' : '' ?>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input name="password" id="password" type="password" class="form-control" placeholder="Nhập mật khẩu...">
                    <?php echo (!empty($errors['password'])) ? '<span class="error">'.reset($errors['password']).'</span>' : '' ?>
                </div>

                <div class="form-group">
                    <label for="re-password">Nhập lại mật khẩu</label>
                    <input name="rePassword" id="re-password" type="password" class="form-control" placeholder="Nhập lại mật khẩu...">
                    <?php echo (!empty($errors['rePassword'])) ? '<span class="error">'.reset($errors['rePassword']).'</span>' : '' ?>
                </div>

                <button name="submit" type="submit" class="btn btn-primary">Thêm người dùng</button>
                <a href="?module=users&action=list" name="submit" type="submit" class="btn btn-success">Quay lại</a>
            </form>
        </div>
    </div>
</div>

<?php
include_blade('assets/blade/footer.php');