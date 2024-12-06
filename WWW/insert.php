<?php
session_start();

$studentnum = $_SESSION["uschoolnum"];
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

// 查询当前学生已选课程的时间索引
$sql_check_timeindex = "SELECT course.timeindex FROM studenttake 
                       JOIN course ON studenttake.courseid = course.courseid 
                       WHERE studenttake.schoolnum = '$studentnum'";
$result_check_timeindex = $conn->query($sql_check_timeindex);
$selected_timeindexes = [];
if ($result_check_timeindex->num_rows > 0) {
    while ($row = $result_check_timeindex->fetch_assoc()) {
        $selected_timeindexes[] = $row["timeindex"];
    }
}

// 查询要选课程的时间索引
$sql_course_timeindex = "SELECT timeindex FROM course WHERE courseid = '$courseId'";
$result_course_timeindex = $conn->query($sql_course_timeindex);
if ($result_course_timeindex->num_rows > 0) {
    $row = $result_course_timeindex->fetch_assoc();
    $course_timeindex = $row["timeindex"];

    // 检查是否存在时间重复的情况
    if (in_array($course_timeindex, $selected_timeindexes)) {
        echo "选课失败：时间冲突，已经选择了与该课程时间重叠的其他课程！";
    } else {
        // 检查是否已经选过相同的课程
        $sql_check = "SELECT * FROM studenttake WHERE courseid = '$courseId' AND schoolnum = '$studentnum'";
        $result_check = $conn->query($sql_check);
        if ($result_check->num_rows > 0) {
            echo "选课失败：你已经选过这门课程了！";
        } else {
            // 执行插入操作
            $sql_insert = "INSERT INTO studenttake (courseid, schoolnum) VALUES ('$courseId', '$studentnum')";
            if ($conn->query($sql_insert) === TRUE) {
                echo "选课成功！";
            } else {
                echo "选课失败：" . $conn->error;
            }
        }
    }
} else {
    echo "选课失败：未找到课程信息！";
}

$conn->close();
?>
