<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>教学管理系统</title>
	<link rel="stylesheet" type="text/css" href="fzx.css">
</head>
<style>
	body {
		background-image: url('bg.jpg');
		background-repeat: no-repeat;
		background-size: cover;
	}
</style>

<body align="center" style="color: rgb(255, 255, 255);font-family:微软雅黑">
	<h1 class="H">管理员系统</h1>

	<div class="nav" height="50px" style=font-family:华文新魏>
		<a href="admin2.php" class="navbox" align="center">时间管理</a>
		<a href="admin.php" class="navbox" align="center">课程管理</a>
	</div>


	<nav class="nnaa2" id="sidebar" style="z-index: 999;">
		<button class="sidebut" onclick="toggleNav()"></button> <!-- 点击按钮切换导航栏状态 -->
		<ul class="uull">
			<li style="padding: 30px;">
				<h3 align="center" style="color: rgb(104, 104, 104)">目录</h3>
			</li>
			<li class="llii"><a class="aa" href="#1">周数列表</a></li>
			<li class="llii"><a class="aa" href="#2">节数列表</a></li>
		</ul>
	</nav>


	<table align="center" width="80%" id="dynamicHeightComponent" style="position: absolute; top: 132.5px; background-color: rgba(200, 200, 200, 0.8);font-family:宋体;margin-left: 10%">


		<table class="studentcourse1" width="70%">
			<br /><br />
			<h2 class="title1" align="center" id="1" class="smooth-scroll">周数列表</h2>
			<tr>
				<th> 周数号 </th>
				<th> 周数 </th>
			<tr>

				<?php
				// 连接数据库
				$servername = "localhost";
				$username = "root";
				$password = "root";
				$dbname = "account";
				$conn = new mysqli($servername, $username, $password, $dbname);
				// 检查连接是否成功
				if ($conn->connect_error) {
					die("连接失败：" . $conn->connect_error);
				}

				// 查询数据库中的course表
				$sql = "SELECT * FROM weektable";
				// WHERE your_condition

				// 执行查询
				$result = $conn->query($sql);

				//$sql = "SELECT * FROM course";
				//$result = $conn->query($sql);

				// 输出数据到HTML页面的<div>中
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {

						echo '<tr onclick="confirmInsert(this)">';


						echo "<th onclick='weekDelete(this)'>" . $row["weekid"] . "</th>";
						echo "<th onclick='updateWeekTable(this)'>" . $row["week"] . "</th>";

						echo "</tr>";
					}
				} else {
					echo "<tr>";
					echo "<th>没有数据可供显示</th>";
					echo "</tr>";
				}

				// 关闭数据库连接
				$conn->close();
				?>
			<tr>
				<th>
					<button class="button" onclick="togglePopuplocation()">添加周数</button>

					<div id="locationPopup" class="popup">
						<form id="weekTableForm">
							<label>新增周数</label><br><br>
							<label for="weekId">周数号： </label>
							<input type="text" id="weekId" name="weekId" required><br>

							<label for="week">周数：</label>
							<input type="text" id="week" name="week" required><br>

							<button class="button small" type="button" id="insertWeekTableBtn">新增周数</button>
							<button class="button small" type="button" onclick="cancelAddlocation()">取消添加</button>
						</form>

					</div>
				</th>
			<tr>



		</table>

		<table class="studentcourse2" width="70%">
			<br /><br />
			<h2 class="title2" align="center" id="2" class="smooth-scroll">节数列表</h2>


			<tr>
				<th> 时间号 </th>
				<th> 时间 </th>
			<tr>

				<?php
				// 连接数据库
				$servername = "localhost";
				$username = "root";
				$password = "root";
				$dbname = "account";
				$conn = new mysqli($servername, $username, $password, $dbname);
				// 检查连接是否成功
				if ($conn->connect_error) {
					die("连接失败：" . $conn->connect_error);
				}

				session_start();
				$courseId = $_SESSION["selected_course"];

				// 查询数据库中的course表
				$sql = "SELECT * FROM timetable";

				// 执行查询
				$result = $conn->query($sql);

				//$sql = "SELECT * FROM course";
				//$result = $conn->query($sql);

				// 输出数据到HTML页面的<div>中
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {

						echo '<tr onclick="updateScore(this)">';


						echo "<th onclick='timeDelete(this)'>" . $row["timeindex"] . "</th>";
						echo "<th onclick='updateTimetable(this)'>" . $row["time"] . "</th>";


						echo "</tr>";
					}
				} else {
					echo "<tr>";
					echo "<th>没有数据可供显示</th>";
					echo "</tr>";
				}

				// 关闭数据库连接
				$conn->close();
				?>

			<tr>
				<th>
					<button class="button" onclick="togglePopup()">添加时段</button>

					<div id="coursePopup" class="popup">
						<form id="timetableForm">
							<label>新增时间表</label><br><br>
							<label for="timeIndex">时间索引： </label>
							<input type="text" id="timeIndex" name="timeIndex" required><br>

							<label for="time">时间：</label>
							<input type="text" id="time" name="time" required><br>

							<button class="button small" type="button" id="insertTimetableBtn">新增时间</button>
							<button class="button small" type="button" onclick="cancelAdd()">取消添加</button>
						</form>
					</div>
				</th>
			<tr>


		</table>




	</table>


	<br><br>

	<p id="bottomComponent" style="position: absolute; left: calc(50% - 135px)">
		<a href="sign.html">点此进入注册页面</a>&nbsp&nbsp
		<a href="login.html">点此进入登录页面</a><br /><br />
		<h10 style="color: grey;font-family:Times New Roman">copyright--1798224146@qq.com</h10>
	</p>

</body>

</html>

<script>
	// 动态高度组件
	var dynamicHeightComponent = document.getElementById('dynamicHeightComponent');

	function setDynamicHeight() {
		dynamicHeightComponent.style.height = (document.documentElement.scrollHeight + 100) + 'px';
	}
	setDynamicHeight();

	window.addEventListener('resize', setDynamicHeight);

	// 底部组件
	var bottomComponent = document.getElementById('bottomComponent');
	var distanceFromBottom = 100; // 往上的距离，单位为像素
	function setBottomPosition() {
		bottomComponent.style.top = (document.documentElement.scrollHeight - distanceFromBottom) + 'px';
	}
	setBottomPosition();

	window.addEventListener('resize', setBottomPosition);
</script>

<script>
	//添加课程弹窗
	function togglePopup() {
		var popup = document.getElementById("coursePopup");
		if (popup.style.display === "none") {
			popup.style.display = "block";
		} else {
			popup.style.display = "none";
		}
	}
	//关闭弹窗
	function cancelAdd() {
		var popup = document.getElementById("coursePopup");
		popup.style.display = "none";
	}

	function togglePopuplocation() {
		var popup = document.getElementById("locationPopup");
		if (popup.style.display === "none") {
			popup.style.display = "block";
		} else {
			popup.style.display = "none";
		}
	}
	//关闭弹窗
	function cancelAddlocation() {
		var popup = document.getElementById("locationPopup");
		popup.style.display = "none";
	}
</script>

<script>
	function toggleNav() {
		var sidebar = document.getElementById("sidebar");
		if (sidebar.style.left === "0px") { // 如果导航栏已经展开，则隐藏
			sidebar.style.left = "-180px";
		} else { // 如果导航栏已经隐藏，则展开
			sidebar.style.left = "0px";
		}
	}
</script>

<script>
	function updateTimetable(cell) {
		var timeIndex = cell.parentNode.cells[0].innerHTML; // 获取时间编号
		var oldTime = cell.innerHTML; // 获取原时间信息

		// 弹出输入框，要求输入新的时间信息
		var newTime = prompt("请输入新的时间信息：", oldTime);
		if (newTime !== null && newTime !== oldTime) {
			// 发送时间编号和新时间信息到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_timetable.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("timeIndex=" + timeIndex + "&newTime=" + newTime);
		}
	}
</script>

<script>
	function updateWeekTable(cell) {
		var weekId = cell.parentNode.cells[0].innerHTML; // 获取周数编号
		var oldWeek = cell.innerHTML; // 获取原周数信息

		// 弹出输入框，要求输入新的周数信息
		var newWeek = prompt("请输入新的周数信息：", oldWeek);
		if (newWeek !== null && newWeek !== oldWeek) {
			// 发送周数编号和新周数信息到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_week_table.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("weekId=" + weekId + "&newWeek=" + newWeek);
		}
	}
</script>

<script>
	function timeDelete(cell) {
		var timeIndex = cell.innerHTML; // 获取编号
		var confirmDelete = confirm("确认删除该项？");
		if (confirmDelete) {
			// 发送编号到服务器端进行删除操作
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "delete_timetable.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示删除结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("timeIndex=" + timeIndex);
		}
	}
</script>

<script>
	function weekDelete(cell) {
		var weekId = cell.innerHTML; // 获取编号
		var confirmDelete = confirm("确认删除该项？");
		if (confirmDelete) {
			// 发送编号到服务器端进行删除操作
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "delete_week.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示删除结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("weekId=" + weekId);
		}
	}
</script>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		var insertTimetableBtn = document.getElementById("insertTimetableBtn");
		insertTimetableBtn.addEventListener("click", function() {
			var timeIndex = document.getElementById("timeIndex").value;
			var time = document.getElementById("time").value;

			// 发送 Ajax 请求
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "insert_timetable.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					if (xhr.responseText === 'duplicate') {
						alert("时间索引已被占用，请重新输入！");
						location.reload(); // 选课成功后刷新页面
					} else {
						alert("时间表插入成功！");
						location.reload(); // 选课成功后刷新页面
					}
				}
			};
			var data = "timeIndex=" + encodeURIComponent(timeIndex) + "&time=" + encodeURIComponent(time);
			xhr.send(data);
		});
	});
</script>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		var insertWeekTableBtn = document.getElementById("insertWeekTableBtn");
		insertWeekTableBtn.addEventListener("click", function() {
			var weekId = document.getElementById("weekId").value;
			var week = document.getElementById("week").value;

			// 发送 Ajax 请求
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "insert_weektable.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					if (xhr.responseText === 'duplicate') {
						alert("周编号已被占用，请重新输入！");
						location.reload(); // 选课成功后刷新页面
					} else {
						alert("周表插入成功！");
						location.reload(); // 选课成功后刷新页面
					}
				}
			};
			var data = "weekId=" + encodeURIComponent(weekId) + "&week=" + encodeURIComponent(week);
			xhr.send(data);
		});
	});
</script>
