<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID、原周编号和新周编号
    $courseId = $_POST["courseId"];
    $oldWeekId = $_POST["oldWeekId"];
    $newWeekId = $_POST["newWeekId"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 检查新周编号是否存在于weektable表中
    $check_sql = "SELECT * FROM weektable WHERE weekid='$newWeekId'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        // 更新course表中的周编号
        $update_sql = "UPDATE course SET weekid='$newWeekId' WHERE courseid='$courseId' AND weekid='$oldWeekId'";
        if ($conn->query($update_sql) === TRUE) {
            echo "周编号更新成功";
        } else {
            echo "Error: " . $update_sql . "<br>" . $conn->error;
        }
    } else {
        echo "新周编号不存在于weektable表中";
    }

    $conn->close();
}
?>
