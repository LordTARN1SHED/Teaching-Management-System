<?php
session_start();

// 获取 POST 数据并存储到 session 中
$params = json_decode(file_get_contents('php://input'), true);
$_SESSION['course_filter'] = $params;

// 返回存储在session中的内容
echo json_encode($_SESSION['course_filter']);
?>
