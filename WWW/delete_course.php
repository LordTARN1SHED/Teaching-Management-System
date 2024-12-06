<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收课程编号
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

    // 查询该课程在studenttake表中的score项内的数据
    $check_sql = "SELECT score FROM studenttake WHERE courseid='$courseId'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        $score = $row["score"];
        if ($score != "暂无成绩") {
            echo "该课程已有成绩，不允许删除！";
        } else {
            // 删除course表中对应课程的项
            $delete_course_sql = "DELETE FROM course WHERE courseid='$courseId'";
            if ($conn->query($delete_course_sql) === TRUE) {
                // 删除studenttake表中所有该courseid的项
                $delete_studenttake_sql = "DELETE FROM studenttake WHERE courseid='$courseId'";
                $conn->query($delete_studenttake_sql);
                // 删除teach表中所有该courseid的项
                $delete_teach_sql = "DELETE FROM teach WHERE courseid='$courseId'";
                $conn->query($delete_teach_sql);
                echo "课程删除成功！";
            } else {
                echo "Error: " . $delete_course_sql . "<br>" . $conn->error;
            }
        }
    } else {
        // 不存在选课记录，直接删除课程信息
        $delete_course_sql = "DELETE FROM course WHERE courseid='$courseId'";
        if ($conn->query($delete_course_sql) === TRUE) {
            // 删除teach表中所有该courseid的项
            $delete_teach_sql = "DELETE FROM teach WHERE courseid='$courseId'";
            $conn->query($delete_teach_sql);
            echo "课程删除成功！";
        } else {
            echo "Error: " . $delete_course_sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
