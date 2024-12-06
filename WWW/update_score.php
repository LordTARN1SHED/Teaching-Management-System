<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID、学生ID和成绩
    $courseId = $_POST["courseId"];
    $studentId = $_POST["studentId"];
    $score = $_POST["score"];
    
    // 更新studenttake表中的成绩
    // 这里假设已经连接数据库，并且已经进行了适当的防SQL注入处理
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    $sql = "UPDATE studenttake SET score='$score' WHERE courseid='$courseId' AND schoolnum='$studentId'";
    if ($conn->query($sql) === TRUE) {
        echo "成绩更新成功";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
