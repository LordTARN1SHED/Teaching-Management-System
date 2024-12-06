<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收时间编号和新时间信息
    $timeIndex = $_POST["timeIndex"];
    $newTime = $_POST["newTime"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 检查是否存在其他 timeindex 对应的 time 字段与新时间信息相同
    $check_sql = "SELECT * FROM timetable WHERE time='$newTime' AND timeindex<>'$timeIndex'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        echo "已存在相同的时间信息，不允许修改";
    } else {
        // 更新timetable表中的时间信息
        $update_sql = "UPDATE timetable SET time='$newTime' WHERE timeindex='$timeIndex'";
        if ($conn->query($update_sql) === TRUE) {
            echo "时间信息更新成功";
        } else {
            echo "Error: " . $update_sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
