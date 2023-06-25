<div style="max-width: 600px; margin: 50px auto;">
    <h3>Lỗi kết nối cơ sở dữ liệu</h3>
    <hr>
    <p><?php echo $e->getMessage(); ?></p>
    <p>Lỗi tại file: <?php echo $e->getFile() ?></p>
    <p>Lỗi tại dòng: <?php echo $e->getLine() ?></p>
</div>