<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收地点ID和新最大容量信息
    $locationId = $_POST["locationId"];
    $newCapacity = $_POST["newCapacity"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 查询符合条件的课程记录
    $check_sql = "SELECT * FROM course WHERE locationid='$locationId' AND realcapacity > '$newCapacity'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        // 如果有课程的实际容量大于新容量，则不允许修改
        echo "存在实际容量大于新容量的课程，不允许修改最大容量。";
    } else {
        // 更新location表中的最大容量信息
        $update_sql = "UPDATE location SET capacity='$newCapacity' WHERE locationid='$locationId'";
        if ($conn->query($update_sql) === TRUE) {
            echo "最大容量更新成功";
        } else {
            echo "Error: " . $update_sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
