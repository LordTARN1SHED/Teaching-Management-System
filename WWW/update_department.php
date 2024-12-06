<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID和新学院名称
    $courseId = $_POST["courseId"];
    $newDepartment = $_POST["newDepartment"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 更新course表中的学院
    $update_sql = "UPDATE course SET cdep='$newDepartment' WHERE courseid='$courseId'";
    if ($conn->query($update_sql) === TRUE) {
        echo "学院更新成功";
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
