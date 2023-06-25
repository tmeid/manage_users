<?php 
function setSession($key, $value){
    if(!empty(session_id())){
        $_SESSION[$key] = $value;
        return true;
    }
    return false;
    
}

function getSession($key = ''){
    if(empty($key)){
        return $_SESSION;
    }else if(isset($_SESSION[$key])){
        return $_SESSION[$key];
    }
    return false;
}

function destroySession($key = ''){
    if(empty($key)){
        session_destroy();
    }else if(isset($_SESSION[$key])){
        unset($_SESSION[$key]);
        return true;
    }
    return false;
}

// flash session
function setFlashSession($key, $value){
    $key = 'flash_' .$key;
    return setSession($key, $value);
}

function getFlashSession($key){
    $key = 'flash_' .$key;
    $data = getSession($key);
    destroySession($key);

    return $data;
}