<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID
    $courseId = $_POST["courseId"];
    
    // 将课程ID存储在session中
    $_SESSION["selected_course"] = $courseId;
    
    // 返回响应
    echo "选中的课程ID：" . $courseId . " 已保存在Session中";
}
?>
