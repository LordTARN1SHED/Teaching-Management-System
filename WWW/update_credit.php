<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID和新学分
    $courseId = $_POST["courseId"];
    $newCredit = $_POST["newCredit"];
    
    // 检查新学分是否小于等于10
    if (floatval($newCredit) <= 10) {
        // 连接数据库
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "account";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("连接失败：" . $conn->connect_error);
        }

        // 更新course表中的学分
        $update_sql = "UPDATE course SET credit='$newCredit' WHERE courseid='$courseId'";
        if ($conn->query($update_sql) === TRUE) {
            echo "学分更新成功";
        } else {
            echo "Error: " . $update_sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "学分必须小于等于10";
    }
}
?>
