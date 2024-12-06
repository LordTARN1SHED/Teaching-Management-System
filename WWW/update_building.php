<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID和新楼信息
    $courseId = $_POST["courseId"];
    $newBuilding = $_POST["newBuilding"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 更新location表中的楼信息
    $update_sql = "UPDATE location SET building='$newBuilding' WHERE locationid='$courseId'";
    if ($conn->query($update_sql) === TRUE) {
        echo "楼信息更新成功";
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
