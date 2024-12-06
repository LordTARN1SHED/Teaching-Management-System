<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID和新教师编号
    $courseId = $_POST["courseId"];
    $teacher = $_POST["teacher"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 检查条件是否满足
    $check_sql = "SELECT * FROM account WHERE schoolnum = '$teacher' AND identit = 'teacher'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        $teacher_cdep = $row["copname"];
        $check_course_sql = "SELECT * FROM course WHERE courseid = '$courseId' AND cdep = '$teacher_cdep'";
        $check_course_result = $conn->query($check_course_sql);
        if ($check_course_result->num_rows > 0) {
            // 插入教师信息到teach表中
            $insert_sql = "INSERT INTO teach (schoolnum, courseid) VALUES ('$teacher', '$courseId')";
            if ($conn->query($insert_sql) === TRUE) {
                echo "教师添加成功！";
            } else {
                echo "Error: " . $insert_sql . "<br>" . $conn->error;
            }
        } else {
            echo "教师所属部门与课程所属部门不符，无法添加教师！";
        }
    } else {
        echo "该学号不是教师或者不存在！";
    }

    $conn->close();
}
?>
