<?php 
if(getSession('username')){
    $username = getSession('username');
}
if(getSession('user_id')){
    $user_id = getSession('user_id');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- <link rel="stylesheet" href="assets/css/fontawesome.min.css"> -->
    <link rel="stylesheet" href="assets/css/style.css?version=<?php echo rand()?>">
    <title>Quản lý người dùng <?php echo !empty($title) ? '| ' .$title : '' ?></title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container d-flex justify-content-between">
                <a class="navbar-brand" href="?module=users&action=list">Manage Users</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse right-navsub" id="navbarSupportedContent">
                    <ul class="navbar-nav">               
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               Hi, <?php echo $username; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="?module=users&action=edit&id=<?php echo $user_id ?>">Đổi thông tin</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="?module=auth&action=logout">Đăng xuất</a>
                            </div>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>
    </header>