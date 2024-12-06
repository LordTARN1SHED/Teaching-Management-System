<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程ID和新容量
    $courseId = $_POST["courseId"];
    $newcapacity = $_POST["newcapacity"];
    
    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "account";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败：" . $conn->connect_error);
    }

    // 查询课程对应的地点ID（locationid）
    $select_sql = "SELECT locationid FROM course WHERE courseid='$courseId'";
    $result = $conn->query($select_sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $locationId = $row["locationid"];

        // 根据地点ID查询地点表（location），获取地点的容量（capacity）
        $select_location_sql = "SELECT capacity FROM location WHERE locationid='$locationId'";
        $location_result = $conn->query($select_location_sql);
        if ($location_result->num_rows > 0) {
            $location_row = $location_result->fetch_assoc();
            $location_capacity = $location_row["capacity"];

            // 检查新容量是否小于等于地点容量
            if (floatval($newcapacity) <= floatval($location_capacity)) {
                // 更新course表中的容量
                $update_sql = "UPDATE course SET realcapacity='$newcapacity' WHERE courseid='$courseId'";
                if ($conn->query($update_sql) === TRUE) {
                    echo "课程容量更新成功";
                } else {
                    echo "Error: " . $update_sql . "<br>" . $conn->error;
                }
            } else {
                echo "新容量必须小于等于地点容量";
            }
        } else {
            echo "找不到地点信息";
        }
    } else {
        echo "找不到课程信息";
    }

    $conn->close();
}
?>
