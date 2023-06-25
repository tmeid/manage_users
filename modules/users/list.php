<?php
$checkLogin = isLogin('login_token', 'login_tokens', 'token');
if (!$checkLogin) {
    redirect('?module=auth&action=login');
}
include_blade('assets/blade/header.php', 'Danh sách');




$sql = "SELECT * FROM users";
$bindData = [];
// search and filter 
if(isset($_GET['search'])){
    
    $filterData = getFormData();

    $status = $filterData['status'];
    $keyword = $filterData['keyword'];

    if(!empty($status) && in_array($status, [1, 2])){
        $status = $status - 1;
        $sql .= " WHERE status =:status";
        $bindData['status'] = $status;

        if(!empty($keyword)){
            $sql .= " AND (email LIKE :email OR fullname LIKE :fullname)";
            $bindData[':email'] = "%$keyword%";
            $bindData[':fullname'] = "%$keyword%";
        }
    }else{
        if(!empty($keyword)){
            $sql .= " WHERE email LIKE :email OR fullname LIKE :fullname";
            $bindData[':email'] = "%$keyword%";
            $bindData[':fullname'] = "%$keyword%";
        } 
    }
    
}
// paginate
$total_users = getRows($sql, $bindData);
$per_page = __PER_PAGE;
$max_page = ceil($total_users / __PER_PAGE);

if (!empty($_GET['page'])) {
    $page = $_GET['page'];
    if ($page < 1 || $page > $max_page) {
        $page = 1;
    }
} else {
    $page = 1;
}

$offset = ($page - 1) * $per_page;

$sql .= " ORDER BY created_at DESC LIMIT $offset, $per_page";
// $bindData[':offset'] = (int)$offset;
// $bindData[':limit'] = (int)$per_page;
$users = getRaw($sql, $bindData, true);


if(!empty($_SERVER['QUERY_STRING'])){
    $query_string = '?'.$_SERVER['QUERY_STRING'];
    $query_string = str_replace('&page='. $page, '', $query_string);
}else{
    $query_string = '?module=users&action=list';
}


?>
<main>
    <div class="container">
        <h3 class="mt-2 mb-2">Danh sách người dùng</h3>
        <a href="?module=users&action=add" class="btn btn-success mb-4">Thêm người dùng</a>

        <form action="" method="GET" class="row mb-4">
            
            <input type="hidden" name="module" value="users">
            <div class="col-4">
                <select name="status" class="form-control">
                    <option value="0">Chọn trạng thái</option>
                    <option value="1" <?php echo (isset($status) && $status === 0) ? 'selected' : '' ?>>Chưa kích hoạt</option>
                    <option value="2" <?php echo (isset($status) && $status == 1) ? 'selected' : '' ?>>Đã kích hoạt</option>
                </select>
            </div>
            <div class="col-6">
                <input class="form-control" type="search" name="keyword" placeholder="Tìm kiếm..." value="<?php echo (!empty($keyword)) ? $keyword : '' ?>">
            </div>
            <div class="col-2">
                <button class="btn btn-block btn-success" type="submit" name="search">Tìm</button>
            </div>
            
        </form>

        <?php    
            $msg = getFlashSession('msg');
            $type = getFlashSession('type');
            if($msg){
                echo getMsg($msg, $type);
            }
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Trạng thái</th>
                    <th colspan="2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $num => $user) : ?>
                        <tr>
                            <td><?php echo ++$num ?></td>
                            <td><?php echo $user['fullname'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $user['phone'] ?></td>
                            <td>
                                <?php echo $user['status'] ? 'Đã kích hoạt' : 'Chưa kích hoạt' ?>
                            </td>
                            <td><a href="?module=users&action=edit&id=<?php echo $user['id']?>"  class="btn btn-primary">Sửa</a></td>
                            <td><a href="?module=users&action=delete&id=<?php echo $user['id']?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn xoá?')">Xoá</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">Không có dữ liệu</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation" class="d-flex justify-content-around">
            <ul class="pagination">
                <?php 
                    if($page > 1){
                        $prePage = $page - 1;
                        echo "<li class='page-item'><a class='page-link' href='$query_string&page=$prePage'>Trước</a></li>";
                    }
                ?>
                    
                <?php 
                    $begin = $page - 2;
                    if($begin < 1){
                        $begin = 1;
                    }
                    $end = $page + 2;
                    if($end > $max_page){
                        $end = $max_page;
                    }
                    for($index = $begin; $index <= $end; $index++): 
                ?>
                    <li class='page-item <?php echo ($page == $index) ? 'active' : '' ?>'><a class='page-link' 
                        href='<?php echo $query_string ?>&page=<?php echo $index ?>'><?php echo $index?></a></li>
                <?php endfor ?>

                <?php
                    if($page < $max_page){
                        $nextPage = $page + 1;
                        echo "<li class='page-item'><a class='page-link' href='$query_string&page=$nextPage'>Sau</a></li>";
                    }
       
                ?>
            </ul>
        </nav>
    </div>
</main>


<?php

include_blade('assets/blade/footer.php');
