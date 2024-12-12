<?php
echo "thành công";
echo "<br>quay lại trang chính sau 10 giây";
echo "<br>đây chỉ là file test chương trình để chạy"
?>

<script>
    setTimeout(function(){
        window.location.href = './test.php';
    }, 10000);

</script>
