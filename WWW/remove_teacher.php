<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID和老师编号
    $courseId = $_POST["courseId"];
    $teacherId = $_POST["teacherId"];
    $tsnum=str_pad($teacherId,8,'0',STR_PAD_LEFT);
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 判断该课程是否存在选课记录
    $check_sql = "SELECT * FROM studenttake WHERE courseid='$courseId'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows == 0) {
        // 删除teach表中的对应老师
        $delete_sql = "DELETE FROM teach WHERE courseid='$courseId' AND schoolnum='$tsnum'";
        if ($conn->query($delete_sql) === TRUE) {
            echo "成功删除老师！";
        } else {
            echo "Error: " . $delete_sql . "<br>" . $conn->error;
        }
    } else {
        echo "该课程存在选课记录，无法删除老师！";
    }

    $conn->close();
}
?>
