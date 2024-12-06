<?php
$servername="localhost";
$username="root";
$password="root";
$dbname="account";

$name=$_POST['userName'];
$email=$_POST['emailnum'];
$pwd=$_POST['userPwd'];
$tname=$_POST['turename'];
$snum=$_POST['schoolnum'];
$tsnum=str_pad($snum,8,'0',STR_PAD_LEFT);
$gender=$_POST['sex'];
$phone=$_POST['phonenum'];
$cname=$_POST['copname'];
$cyear=$_POST['year'];
$idt=$_POST['identit'];
$mot=$_POST['motto'];
$conn= new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error){
    die("连接失败：".$conn->connect_error);
}

$sql_check = "SELECT * FROM account WHERE schoolnum = '$tsnum' AND identit = '$idt'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // 如果有相同的记录存在，则提示已经注册
    echo "<script>
            if(confirm('该学号和身份已经注册')) {
                window.location.href = 'sign.html'; // 将页面重定向到之前的页面
            }
          </script>";
} else {
    // 否则，执行插入操作
    $sql_insert = "INSERT INTO account (userName,emailnum,userPwd,turename,schoolnum,sex,phonenum,copname,identit,mottoword,year) 
                   VALUES ('$name','$email','$pwd','$tname','$tsnum','$gender','$phone','$cname','$idt','$mot','$cyear')";

    if($conn->query($sql_insert) === true) {
        echo "新记录插入成功";
        header("Location: signsuccess.html");
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
