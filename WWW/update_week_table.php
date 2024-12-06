<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收周数编号和新周数信息
    $weekId = $_POST["weekId"];
    $newWeek = $_POST["newWeek"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 检查是否存在其他 weekid 对应的 week 字段与新周数信息相同
    $check_sql = "SELECT * FROM weektable WHERE week='$newWeek' AND weekid<>'$weekId'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        echo "已存在相同的周数信息，不允许修改";
    } else {
        // 更新weektable表中的周数信息
        $update_sql = "UPDATE weektable SET week='$newWeek' WHERE weekid='$weekId'";
        if ($conn->query($update_sql) === TRUE) {
            echo "周数信息更新成功";
        } else {
            echo "Error: " . $update_sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
