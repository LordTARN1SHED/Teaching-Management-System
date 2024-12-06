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
	<h1 class="H">学生选课系统</h1>

	<div class="nav" height="50px" style=font-family:华文新魏>
		<a href="studentinfo.php" class="navbox" align="center">个人信息</a>
		<a href="student.php" class="navbox" align="center">学生选课</a>
	</div>


	<nav class="nnaa2" id="sidebar" style="z-index: 999;">
		<button class="sidebut" onclick="toggleNav()"></button> <!-- 点击按钮切换导航栏状态 -->
		<ul class="uull">
			<li style="padding: 30px;">
				<h3 align="center" style="color: rgb(104, 104, 104)">目录</h3>
			</li>
			<li class="llii"><a class="aa" href="#1">可选课程</a></li>
			<li class="llii"><a class="aa" href="#2">已选课程</a></li>
		</ul>
	</nav>


	<table align="center" width="80%" id="dynamicHeightComponent" style="position: absolute; top: 132.5px; background-color: rgba(200, 200, 200, 0.8);font-family:宋体;margin-left: 10%">


		<table class="studentcourse1" width="70%">
			<br /><br />
			<h2 class="title1" align="center" id="1">可选课程列表</h2>
			<tr>
				<th> 编号 </th>
				<th> 课程名称 </th>
				<th> 时间 </th>
				<th> 周数 </th>
				<th> 地点 </th>
				<th> 授课老师 </th>
				<th> 开设学院 </th>
				<th> 容量 </th>
				<th> 学分 </th>
				<th> 已选人数 </th>
			<tr>
			<tr>
				<th><input type="text" id="courseId" name="courseId" placeholder="Course ID"></th>
				<th><input type="text" id="subject" name="subject" placeholder="Subject"></th>
				<th><input type="text" id="timeIndex" name="timeIndex" placeholder="Time"></th>
				<th><input type="text" id="weekId" name="weekId" placeholder="Week"></th>
				<th><input type="text" id="locationId" name="locationId" placeholder="Building"></th>
				<th><input type="text" id="teacherId" name="teacherId" placeholder="Teacher"></th>
				<th><input type="text" id="cdep" name="cdep" placeholder="Department"></th>
				<th><input type="text" id="capacity" name="capacity" placeholder="Capacity"></th>
				<th><input type="text" id="credit" name="credit" placeholder="Credit"></th>

			</tr>

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
			$params = $_SESSION['course_filter'];

			// 查询数据库中的course表
			$sql = "SELECT * FROM course
        				JOIN location ON course.locationid = location.locationid
						JOIN timetable ON course.timeindex = timetable.timeindex
						JOIN teach ON course.courseid = teach.courseid 
						JOIN account ON teach.schoolnum = account.schoolnum
						JOIN weektable ON course.weekid = weektable.weekid
        				";

			// 添加查询条件
			$conditions = [];
			foreach ($params as $key => $value) {
				if (!empty($value)) {
					if($key=="turename"){
						$conditions[] = "account.$key LIKE '%" . $conn->real_escape_string($value) . "%'";
					}else if($key=="time"){
						$conditions[] = "timetable.$key LIKE '%" . $conn->real_escape_string($value) . "%'";
					}else if($key=="week"){
						$conditions[] = "weektable.$key LIKE '%" . $conn->real_escape_string($value) . "%'";
					}else if($key=="building"){
						$conditions[] = "location.$key LIKE '%" . $conn->real_escape_string($value) . "%'";
					}else{
						$conditions[] = "course.$key LIKE '%" . $conn->real_escape_string($value) . "%'";
					}
					
				}
			}
			
						// 如果有查询条件，将它们连接起来
						if (!empty($conditions)) {
							$sql .= " AND " . implode(" AND ", $conditions);
						}


			// 执行查询
			$result = $conn->query($sql);



			// 输出数据到HTML页面的<div>中
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {

					$course = $row["courseid"];

					echo '<tr onclick="confirmInsert(this)">';


					echo "<th>" . $row["courseid"] . "</th>";
					echo "<th>" . $row["subject"] . "</th>";
					echo "<th>" . $row["time"] . "</th>";
					echo "<th>" . $row["week"] . "</th>";
					echo "<th>" . $row["building"] . "&nbsp" . $row["room"] . "</th>";
					echo "<th>" . $row["turename"] . "</th>";
					echo "<th>" . $row["cdep"] . "</th>";
					echo "<th>" . $row["realcapacity"] . "</th>";
					echo "<th>" . $row["credit"] . "</th>";

					// 构造 SQL 查询语句
					$sql = "SELECT COUNT(*) AS studentnum FROM studenttake WHERE courseid = '$course'";

					// 执行查询
					$result2 = $conn->query($sql);

					// 检查查询结果
					if ($result2->num_rows > 0) {
						// 输出数据
						while ($row = $result2->fetch_assoc()) {
							// 获取选课学生数量
							$studentnum = $row["studentnum"];

							// 在 HTML 表格中输出统计结果
							echo "<th>" . $studentnum . "</th>";
						}
					} else {
						// 如果没有匹配的结果
						echo "<th>0</th>"; // 或者输出其他内容，表示没有学生选课
					}

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
				<th> <button class="button small" onclick="filterCourses()">筛选</button> </th>
			</tr>
		</table>




		<table class="studentcourse2" width="70%">
			<br /><br />
			<h2 class="title2" align="center" id="2">已选课程列表</h2>
			<tr>
				<th> 编号 </th>
				<th> 课程名称 </th>
				<th> 时间 </th>
				<th> 周数 </th>
				<th> 地点 </th>
				<th> 授课老师 </th>
				<th> 开设学院 </th>
				<th> 容量 </th>
				<th> 学分 </th>
				<th> 得分 </th>
				<th> 已选人数 </th>
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
				$schoolnum = $_SESSION["uschoolnum"];
				// 查询数据库中的course表
				$sql = "SELECT * FROM studenttake
						JOIN course ON course.courseid = studenttake.courseid 
        				JOIN location ON course.locationid = location.locationid
						JOIN timetable ON course.timeindex = timetable.timeindex
						JOIN teach ON course.courseid = teach.courseid 
						JOIN account ON teach.schoolnum = account.schoolnum 
						JOIN weektable ON course.weekid = weektable.weekid
        				WHERE studenttake.schoolnum = '$schoolnum'
						";

				// 执行查询
				$result = $conn->query($sql);

				//$sql = "SELECT * FROM course";
				//$result = $conn->query($sql);

				// 输出数据到HTML页面的<div>中
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {

						$course = $row["courseid"];

						echo '<tr onclick="confirmDelete(this)">';

						echo "<th>" . $row["courseid"] . "</th>";
						echo "<th>" . $row["subject"] . "</th>";
						echo "<th>" . $row["time"] . "</th>";
						echo "<th>" . $row["week"] . "</th>";
						echo "<th>" . $row["building"] . "&nbsp" . $row["room"] . "</th>";
						echo "<th>" . $row["turename"] . "</th>";
						echo "<th>" . $row["cdep"] . "</th>";
						echo "<th>" . $row["realcapacity"] . "</th>";
						echo "<th>" . $row["credit"] . "</th>";
						echo "<th>" . $row["score"] . "</th>";

						// 构造 SQL 查询语句
						$sql = "SELECT COUNT(*) AS studentnum FROM studenttake WHERE courseid = '$course'";

						// 执行查询
						$result2 = $conn->query($sql);

						// 检查查询结果
						if ($result2->num_rows > 0) {
							// 输出数据
							while ($row = $result2->fetch_assoc()) {
								// 获取选课学生数量
								$studentnum = $row["studentnum"];

								// 在 HTML 表格中输出统计结果
								echo "<th>" . $studentnum . "</th>";
							}
						} else {
							// 如果没有匹配的结果
							echo "<th>0</th>"; // 或者输出其他内容，表示没有学生选课
						}

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
	function confirmInsert(row) {
		var courseId = row.cells[0].innerHTML; // 获取课程ID
		var courseName = row.cells[1].innerHTML; // 获取课程名称

		// 弹出确认框
		var confirmMessage = "你确定要选择课程 '" + courseName + "' 吗？";
		if (confirm(confirmMessage)) {
			// 用户点击确认后执行插入操作
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "insert.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示插入结果
					location.reload(); // 选课成功后刷新页面
				}
			};
			xhr.send("courseId=" + courseId); // 发送课程ID到服务器端
		}
	}
</script>


<script>
	function confirmDelete(row) {
		var courseId = row.cells[0].innerHTML; // 获取课程ID
		var courseName = row.cells[1].innerHTML; // 获取课程名称

		// 弹出确认框
		var confirmMessage = "你确定要删除课程 '" + courseName + "' 的选课吗？";
		if (confirm(confirmMessage)) {
			// 用户点击确认后执行删除操作
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "delete.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示删除结果
					location.reload(); // 选课成功后刷新页面
				}
			};
			xhr.send("courseId=" + courseId); // 发送课程ID到服务器端
		}
	}
</script>

<script>
	function filterCourses() {
		const params = {
			courseId: document.getElementById('courseId').value,
			subject: document.getElementById('subject').value,
			time: document.getElementById('timeIndex').value,
			week: document.getElementById('weekId').value,
			building: document.getElementById('locationId').value,
			turename: document.getElementById('teacherId').value,
			cdep: document.getElementById('cdep').value,
			realcapacity: document.getElementById('capacity').value,
			credit: document.getElementById('credit').value,

		};

		fetch('filter_courses.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(params)
		})
		//.then(response => response.json()) // 解析响应的JSON数据
		//.then(data => {
		//    alert(JSON.stringify(data)); // 使用alert显示JSON数据
		//})
		//.catch(error => console.error('Error:', error));
		location.reload(); // 选课成功后刷新页面
	}
</script>