<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单提交的数据
    $weekId = $_POST["weekId"];
    $week = $_POST["week"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 查询是否存在重复的 weekId
    $sql = "SELECT * FROM weektable WHERE weekid='$weekId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // 如果存在重复的 weekId，返回 duplicate
        echo "duplicate";
    } else {
        // 如果不存在重复的 weekId，插入数据到 weektable 表
        $sql = "INSERT INTO weektable (weekid, week) VALUES ('$weekId', '$week')";
        if ($conn->query($sql) === TRUE) {
            echo "周数插入成功！";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
