<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID、原教师编号和新教师编号
    $courseId = $_POST["courseId"];
    $oldTeacherId = $_POST["oldTeacherId"];
    $newTeacherId = $_POST["newTeacherId"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 检查新教师编号是否存在于account表中，并且对应的identit为teacher
    $check_sql = "SELECT * FROM account WHERE schoolnum='$newTeacherId' AND identit='teacher'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        // 更新teach表中的教师编号
        $update_sql = "UPDATE teach SET schoolnum='$newTeacherId' WHERE courseid='$courseId' AND schoolnum='$oldTeacherId'";
        if ($conn->query($update_sql) === TRUE) {
            echo "教师编号更新成功";
        } else {
            echo "Error: " . $update_sql . "<br>" . $conn->error;
        }
    } else {
        echo "新教师编号不存在或不是教师";
    }

    $conn->close();
}
?>
