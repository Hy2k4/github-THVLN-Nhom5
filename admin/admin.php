<?php
echo "đây là trang admin phân quyền<br>";
echo "hiện tại trang chưa xây xong nên sẽ đưa bạn về trang đăng nhập<br>";
echo "sau 3 giây<br>";

?>

<script>
    setTimeout(function(){
        window.location.href = '../B1/move_back.php';
    }, 2500);

</script>
