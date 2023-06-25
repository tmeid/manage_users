<?php 
$checkLogin = isLogin('login_token');
if(!$checkLogin){
    redirect('?module=auth&action=login');
}else{
    $token = getSession('login_token');
    // delete that token from login_tokens table 
  
    delete('login_tokens', 'token', $token);
    // remove token from session 
    destroySession('login_token');
    destroySession('username');
    destroySession('user_id');

    redirect('?module=auth&action=login');
}