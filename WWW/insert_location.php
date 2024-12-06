<?php
// 获取表单提交的数据
$locationId = $_POST["locationId"];
$building = $_POST["building"];
$room = $_POST["room"];
$capacity = $_POST["capacity"];

// 连接数据库
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "account";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("连接失败：" . $conn->connect_error);
}

// 检查是否存在重复的 locationid
$check_sql = "SELECT * FROM location WHERE locationid='$locationId'";
$check_result = $conn->query($check_sql);
if ($check_result->num_rows > 0) {
    echo "此地点号已被占用，请输入不同的地点号!";
} else {
    // 插入数据到 location 表
    $insert_sql = "INSERT INTO location (locationid, building, room, capacity) VALUES ('$locationId', '$building', '$room', '$capacity')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "地点插入成功！";
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
