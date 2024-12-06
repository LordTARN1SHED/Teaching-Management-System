<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID、原时间编号和新时间编号
    $courseId = $_POST["courseId"];
    $oldTimeIndex = $_POST["oldTimeIndex"];
    $newTimeIndex = $_POST["newTimeIndex"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }
    
    // 检查新时间编号是否存在于timetable表中
    $check_sql = "SELECT * FROM timetable WHERE timeindex='$newTimeIndex'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        // 更新course表中的时间编号
        $update_sql = "UPDATE course SET timeindex='$newTimeIndex' WHERE courseid='$courseId' AND timeindex='$oldTimeIndex'";
        if ($conn->query($update_sql) === TRUE) {
            echo "时间编号更新成功";
        } else {
            echo "Error: " . $update_sql . "<br>" . $conn->error;
        }
    } else {
        echo "新时间编号不存在于timetable表中";
    }

    $conn->close();
}
?>
