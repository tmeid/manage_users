<?php
include_blade('assets/blade/sub_header.php');
echo '<main>';
echo '<div class="container">';
echo '<div class="row d-flex justify-content-center">';
echo '<div class="col-6 text-center">';
$queryStringData = getFormData();
$token = $queryStringData['token'];

if(!empty($token)){
    $sql = 'SELECT id from users WHERE active_token = :active_token';
    $userData = firstRaw($sql, ['active_token' => $token]);
    if($userData){
        $userId = $userData['id'];
        // update status, active_token of user 
        $updateStatus = update(
            'users', 
            ['status' => 1, 'active_token' => null], 
            $userId
        );

        if($updateStatus){  
            // set flash session and redirect to login page 
            setFlashSession('msg', 'Kích hoạt tài khoản thành công, bạn có thể đăng nhập ngay bây giờ');
            setFlashSession('type', 'success');

            redirect('?module=auth&action=login');
        }else{
            echo getMsg('Đã có lỗi xảy ra, xin vui lòng thử lại', 'danger');
        }
    }else{
        echo getMsg('Liên kết không tồn tại hoặc tài khoản đã được active', 'danger');
    }
}else{
    echo getMsg('Bị trống token', 'danger');
}


echo '</div';
echo '</div';
echo '</div';
echo '</main>';

// if (!empty($token)) {
//     $sql = 'SELECT active_token, id from users WHERE active_token = :active_token';

//     $userData = firstRaw($sql, ['active_token' => $token]);

//     if ($userData) {
//         $activeToken = $userData['active_token'];
//         $userId = $userData['id'];

//         if (!empty($activeToken)) {
//             if ($token == $activeToken) {
//                 // update active = 1 for user
//                 $updateStatus = update('users', ['status' => 1], $userId);
//                 if ($updateStatus) {
//                     // active successfully
//                     echo 'active thành công';
//                 } else {
//                     echo 'đã có lỗi xảy ra';
//                 }
//             } else {
//                 echo 'token không tồn tại';
//             }
//         }
//     }else{
//         echo 'liên kết hết hạn hoặc token k đúng';
//     }
// }else{
//     echo 'Bị thiếu token';
// }
