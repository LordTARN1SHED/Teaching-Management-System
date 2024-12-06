<?php
session_start();

$studentnum = $_SESSION["uschoolnum"];
$courseId = $_POST["courseId"];

// 连接数据库
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "account";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("连接失败：" . $conn->connect_error);
}

// 查询学生选课关系对应的成绩
$sql_score = "SELECT score FROM studenttake WHERE courseid = '$courseId' AND schoolnum = '$studentnum'";
$result_score = $conn->query($sql_score);
if ($result_score->num_rows > 0) {
    $row = $result_score->fetch_assoc();
    $score = $row["score"];
    if ($score === "暂无成绩") {
        // 如果成绩为暂无成绩，允许删除选课关系
        $sql_delete = "DELETE FROM studenttake WHERE courseid = '$courseId' AND schoolnum = '$studentnum'";
        if ($conn->query($sql_delete) === TRUE) {
            echo "删除成功";
        } else {
            echo "删除失败：" . $conn->error;
        }
    } else {
        echo "该课程已有成绩，不能删除选课关系";
    }
} else {
    echo "未找到学生选课关系";
}

$conn->close();
?>
