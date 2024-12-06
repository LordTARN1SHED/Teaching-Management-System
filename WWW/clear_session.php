<?php
session_start();

// 清除session
unset($_SESSION['course_filter']);

// 可以添加其他清除session的逻辑

// 返回一个成功的响应
http_response_code(200);
?>
