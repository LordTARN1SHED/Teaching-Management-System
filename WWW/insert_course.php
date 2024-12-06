<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收表单数据
    $courseId = $_POST["courseId"];
    $subject = $_POST["subject"];
    $timeIndex = $_POST["timeIndex"];
    $locationId = $_POST["locationId"];
    $credit = $_POST["credit"];
    $realCapacity = $_POST["realCapacity"];
    $cdep = $_POST["cdep"];
    $weekId = $_POST["weekId"];

    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 检查输入的 realCapacity 是否小于对应 locationid 的 capacity
    $check_capacity_sql = "SELECT capacity FROM location WHERE locationid='$locationId'";
    $check_capacity_result = $conn->query($check_capacity_sql);
    if ($check_capacity_result->num_rows > 0) {
        $row = $check_capacity_result->fetch_assoc();
        $capacity = $row["capacity"];
        if ($realCapacity > $capacity) {
            echo "实际容量大于地点容量！";
            exit; // 停止执行后续代码
        }
    } else {
        echo "地点不存在！";
        exit; // 停止执行后续代码
    }

    // 检查表中是否已存在相同的 courseid
    $check_sql = "SELECT * FROM course WHERE courseid='$courseId'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        echo "该课程号已被占用，请输入不同的课程号!";
    } else {
        // 插入新记录到数据库中
        $insert_sql = "INSERT INTO course (courseid, subject, timeindex, locationid, credit, realcapacity, cdep, weekid) 
                        VALUES ('$courseId', '$subject', '$timeIndex', '$locationId', '$credit', '$realCapacity', '$cdep', '$weekId')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "课程信息添加成功！";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
