<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "account";

$name = $_POST['userName'];
$email = $_POST['emailnum'];
$phone = $_POST['phonenum'];
$cname = $_POST['copname'];
$mot = $_POST['motto'];


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("连接失败：" . $conn->connect_error);
}

session_start();
$keyword = $_SESSION["uschoolnum"]; // 搜索关键字

// 构造 SQL 查询语句
$sql = "SELECT * FROM account WHERE schoolnum = '$keyword'";

// 执行查询
$result = $conn->query($sql);

// 处理查询结果
if ($result->num_rows > 0) {

    $query1 = "UPDATE account SET emailnum='$email' WHERE schoolnum='$keyword'";
    mysqli_query($conn, $query1);

    $query2 = "UPDATE account SET userName='$name' WHERE schoolnum='$keyword'";
    mysqli_query($conn, $query2);

    $query3 = "UPDATE account SET phonenum='$phone' WHERE schoolnum='$keyword'";
    mysqli_query($conn, $query3);

    $query4 = "UPDATE account SET copname='$cname' WHERE schoolnum='$keyword'";
    mysqli_query($conn, $query4);

    $query5 = "UPDATE account SET mottoword='$mot' WHERE schoolnum='$keyword'";
    mysqli_query($conn, $query5);

    mysqli_close($conn);

    header("Location: jumpchange.html");

} else {
    echo "没有匹配的结果";
    mysqli_close($conn);
}



