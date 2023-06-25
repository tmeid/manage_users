<?php 
$checkLogin = isLogin('login_token');
if(!$checkLogin){
    include_blade('assets/blade/sub_header.php');
}else{
    include_blade('assets/blade/header.php');
}
?> 
<div class="container">
    <div class="row">
        <div class="col">
            <?php if(!isLogin('login_token')): ?>
                <h2 class="text-center mt-5 mb-3">Vui lòng đăng nhập</h2>
                <div class="text-center">
                    <a class="btn btn-success" href="?module=auth&action=login">Đăng nhập</a>
                    <a class="btn btn-primary" href="?module=auth&action=register">Đăng ký</a>
                </div>
                <hr>
                <p class="text-center">Example email: dthuyhuynh901@gmail.com</p>
                <p class="text-center">Pass: 1234567890</p>
                
            <?php else: ?>
                <h2 class="text-center mt-3 mb-3">Chào mừng bạn đến với hệ thống</h2>
                <div class="text-center">
                    <a href="?module=users&action=list" class="btn btn-success">Quản lý users</a>
                </div>                
            <?php endif ?>
        </div>
    </div>
</div>

<?php 
include_blade('assets/blade/footer.php');