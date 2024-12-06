<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收编号
    $timeIndex = $_POST["timeIndex"];

    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 检查该 timeindex 在 course 表中是否存在
    $check_sql = "SELECT * FROM course WHERE timeindex='$timeIndex'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        echo "该项在课程表中存在，不允许删除";
    } else {
        // 删除 timetable 表中对应的项
        $delete_sql = "DELETE FROM timetable WHERE timeindex='$timeIndex'";
        if ($conn->query($delete_sql) === TRUE) {
            echo "删除成功";
        } else {
            echo "Error: " . $delete_sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
