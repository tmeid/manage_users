<?php 
$checkLogin = isLogin('login_token', 'login_tokens', 'token');
if (!$checkLogin) {
    redirect('?module=auth&action=login');
}
$userData = getFormData();
$id = $userData['id'];
if(!empty($id)){
    $user = getRaw("SELECT id FROM users WHERE id = :id", ['id' => $id]);
    if($user){
        // delete record from table containing foreign key 
        $deleteRelevant = delete('login_tokens', 'user_id', $id);
        if($deleteRelevant){
            $deleteStatus = delete('users', 'id', $id);
            if($deleteRelevant){
                setFlashSession('msg', 'Xoá user thành công');
                setFlashSession('type', 'success');
                redirect('?module=users&action=list');
            }else{
                setFlashSession('msg', 'Đã có lỗi xảy ra');
                setFlashSession('type', 'danger');
                redirect('?module=users&action=list');
            }
        }
    }else{
        setFlashSession('msg', 'User không tồn tại');
        setFlashSession('type', 'danger');
        redirect('?module=users&action=list');
    }
}else{
    setFlashSession('msg', 'Link bị lỗi');
    setFlashSession('type', 'danger');
    redirect('?module=users&action=list');
}