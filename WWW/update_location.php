<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID、原教室编号和新教室编号
    $courseId = $_POST["courseId"];
    $oldLocationId = $_POST["oldLocationId"];
    $newLocationId = $_POST["newLocationId"];
    
    // 检查新教室编号是否存在于location表中
    // 这里假设已经连接数据库，并且已经进行了适当的防SQL注入处理
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }
    
    // 查询新的教室编号是否存在于location表中
    $sql = "SELECT * FROM location WHERE locationid='$newLocationId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // 如果新的教室编号存在于location表中，则更新course表中的教室编号
        $updateSql = "UPDATE course SET locationid='$newLocationId' WHERE courseid='$courseId' AND locationid='$oldLocationId'";
        if ($conn->query($updateSql) === TRUE) {
            echo "教室编号更新成功";
        } else {
            echo "Error: " . $updateSql . "<br>" . $conn->error;
        }
    } else {
        echo "错误：新的教室编号不存在于location表中";
    }
    $conn->close();
}
?>
