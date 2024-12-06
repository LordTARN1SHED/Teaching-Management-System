<?php
$servername="localhost";
$username="root";
$password="root";
$dbname="account";


$pwd=$_POST['userPwd'];
$snum=$_POST['schoolnum'];
$oldpwd=$_POST['olduserPwd'];

$conn= new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error){
    die("连接失败：".$conn->connect_error);
}

$keyword = "$snum"; // 搜索关键字

// 构造 SQL 查询语句
$sql = "SELECT * FROM account WHERE schoolnum = '$keyword'";

// 执行查询
$result = $conn->query($sql);

// 处理查询结果
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // 获取其他数据
        $pwd2= $row["userPwd"];
    }
} else {
    echo "没有匹配的结果";
}

if($oldpwd!=$pwd2){
    echo "密码输入错误，请返回";
}
else{

$query1 = "UPDATE account SET userPwd='$pwd' WHERE schoolnum='$keyword'";
mysqli_query($conn, $query1);


mysqli_close($conn);

header("Location: jumpchange.html");
}
?>