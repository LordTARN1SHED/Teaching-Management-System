<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单提交的数据
    $timeIndex = $_POST["timeIndex"];
    $time = $_POST["time"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 查询是否存在重复的 timeindex
    $duplicate_sql = "SELECT * FROM timetable WHERE timeindex='$timeIndex'";
    $duplicate_result = $conn->query($duplicate_sql);
    if ($duplicate_result->num_rows > 0) {
        // 如果存在重复的 timeindex，返回 duplicate
        echo "duplicate";
    } else {
        // 如果不存在重复的 timeindex，插入数据到 timetable 表
        $insert_sql = "INSERT INTO timetable (timeindex, time) VALUES ('$timeIndex', '$time')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "时间插入成功！";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
