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
			<li class="llii"><a class="aa" href="#1">课程列表</a></li>
			<li class="llii"><a class="aa" href="#2">地点列表</a></li>
		</ul>
	</nav>



	<table align="center" width="80%" id="dynamicHeightComponent" style="position: absolute; top: 132.5px; background-color: rgba(200, 200, 200, 0.8);font-family:宋体;margin-left: 10%">


		<table class="studentcourse1" width="70%">
			<br /><br />
			<h2 class="title1" align="center" id="1">已任命教师课程列表</h2>
			<tr>
				<th> 编号 </th>
				<th> 课程名称 </th>
				<th> 时间号 </th>
				<th> 时间 </th>
				<th> 周数号 </th>
				<th> 周数 </th>
				<th> 地点号 </th>
				<th> 地点 </th>
				<th> 教师号 </th>
				<th> 授课老师 </th>
				<th> 开设学院 </th>
				<th> 容量 </th>
				<th> 学分 </th>
				<th> 已选人数 </th>
			</tr>
			<tr>
				<th><input type="text" id="courseId" name="courseId" placeholder="Course ID"></th>
				<th><input type="text" id="subject" name="subject" placeholder="Subject"></th>
				<th><input type="text" id="timeIndex" name="timeIndex" placeholder="Time Index"></th>
				<th></th>
				<th><input type="text" id="weekId" name="weekId" placeholder="Week ID"></th>
				<th></th>
				<th><input type="text" id="locationId" name="locationId" placeholder="Location ID"></th>
				<th></th>
				<th><input type="text" id="teacherId" name="teacherId" placeholder="Teacher ID"></th>
				<th></th>
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
			// WHERE your_condition

			// 添加查询条件
			$conditions = [];
			foreach ($params as $key => $value) {
				if (!empty($value)) {
					if ($key == "schoolnum") {
						$conditions[] = "account.$key LIKE '%" . $conn->real_escape_string($value) . "%'";
					} else {
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

			//$sql = "SELECT * FROM course";
			//$result = $conn->query($sql);

			// 输出数据到HTML页面的<div>中
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {

					$course = $row["courseid"];

					echo '<tr>';


					echo "<th onclick='courseDelete(this)'>" . $row["courseid"] . "</th>";
					echo "<th onclick='selectCourse(this)'>" . $row["subject"] . "</th>";

					echo "<th onclick='updateTime(this)'>" . $row["timeindex"] . "</th>";
					echo "<th onclick='updateTime(this)'>" . $row["time"] . "</th>";
					echo "<th onclick='updateWeek(this)'>" . $row["weekid"] . "</th>";
					echo "<th onclick='updateWeek(this)'>" . $row["week"] . "</th>";
					echo "<th onclick='updateLocation(this)'>" . $row["locationid"] . "</th>";
					echo "<th onclick='updateLocation(this)'>" . $row["building"] . "&nbsp" . $row["room"] . "</th>";
					echo "<th onclick='updateTeacher(this)'>" . $row["schoolnum"] . "</th>";
					echo "<th onclick='removeTeacher(this)'>" . $row["turename"] . "</th>";
					echo "<th onclick='updateDepartment(this)'>" . $row["cdep"] . "</th>";
					echo "<th onclick='updatecapacity(this)'>" . $row["realcapacity"] . "</th>";
					echo "<th onclick='updateCredit(this)'>" . $row["credit"] . "</th>";


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
				<th> <button class="button" onclick="filterCourses()">筛选</button> </th>
			</tr>

		</table>



		<table class="studentcourse1" width="70%">
			<br /><br />
			<h2 class="title1" align="center" id="1">未任命教师课程列表</h2>
			<tr>

				<th> 编号 </th>
				<th> 课程名称 </th>
				<th> 时间号 </th>
				<th> 时间 </th>
				<th> 周数号 </th>
				<th> 周数 </th>
				<th> 地点号 </th>
				<th> 地点 </th>
				<th> 教师号 </th>
				<th> 授课老师 </th>
				<th> 开设学院 </th>
				<th> 容量 </th>
				<th> 学分 </th>
				<th> 已选人数 </th>

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
					JOIN weektable ON course.weekid = weektable.weekid
					WHERE NOT EXISTS (
						SELECT 1 FROM teach WHERE teach.courseid = course.courseid
					);
					";
			// WHERE your_condition

			// 添加查询条件
			$conditions = [];
			foreach ($params as $key => $value) {
				if (!empty($value)) {

					$conditions[] = "course.$key LIKE '%" . $conn->real_escape_string($value) . "%'";
				}
			}

			// 如果有查询条件，将它们连接起来
			if (!empty($conditions)) {
				$sql .= " AND " . implode(" AND ", $conditions);
			}

			// 执行查询
			$result = $conn->query($sql);

			//$sql = "SELECT * FROM course";
			//$result = $conn->query($sql);

			// 输出数据到HTML页面的<div>中
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {

					$course = $row["courseid"];

					echo '<tr>';

					echo "<th onclick='courseDelete(this)'>" . $row["courseid"] . "</th>";
					echo "<th onclick='selectCourse(this)'>" . $row["subject"] . "</th>";

					echo "<th onclick='updateTime(this)'>" . $row["timeindex"] . "</th>";
					echo "<th onclick='updateTime(this)'>" . $row["time"] . "</th>";
					echo "<th onclick='updateWeek(this)'>" . $row["weekid"] . "</th>";
					echo "<th onclick='updateWeek(this)'>" . $row["week"] . "</th>";
					echo "<th onclick='updateLocation(this)'>" . $row["locationid"] . "</th>";
					echo "<th onclick='updateLocation(this)'>" . $row["building"] . "&nbsp" . $row["room"] . "</th>";
					echo "<th onclick='addTeacher(this)'>" . "暂无" . "</th>";
					echo "<th onclick='addTeacher(this)'>" . "请任命" . "</th>";
					echo "<th onclick='updateDepartment(this)'>" . $row["cdep"] . "</th>";
					echo "<th onclick='updatecapacity(this)'>" . $row["realcapacity"] . "</th>";
					echo "<th onclick='updateCredit(this)'>" . $row["credit"] . "</th>";

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
				<th>
					<button class="button" onclick="togglePopup()">添加课程</button>

					<div id="coursePopup" class="popup">
						<form id="courseForm">
							<label>新增课程</label><br><br><br>
							<label for="courseId">课程号： </label>
							<input type="text" id="courseId" name="courseId" required><br>

							<label for="subject">课程名称：</label>
							<input type="text" id="subject" name="subject" required><br>

							<label for="timeIndex">时间号： </label>
							<input type="text" id="timeIndex" name="timeIndex" required><br>

							<label for="locationId">地点号： </label>
							<input type="text" id="locationId" name="locationId" required><br>

							<label for="credit">学 分： </label>
							<input type="text" id="credit" name="credit" required><br>

							<label for="realCapacity">课程容量：</label>
							<input type="text" id="realCapacity" name="realCapacity" required><br>

							<label for="cdep">开设学院：</label>
							<input type="text" id="cdep" name="cdep" required><br>

							<label for="weekId">周数号： </label>
							<input type="text" id="weekId" name="weekId" required><br><br>

							<input class="button small" type="submit" value="确认提交">
							<button class="button small" type="button" onclick="cancelAdd()">取消添加</button>
						</form>

					</div>
				</th>
			<tr>


		</table>

		<table class="studentcourse1" width="70%">
			<br /><br />
			<h2 class="title1" align="center" id="temp-2">学生成绩填写</h2>


			<tr>
				<th> 课程编号 </th>
				<th> 课程名称 </th>
				<th> 时间 </th>
				<th> 周数 </th>
				<th> 学生姓名 </th>
				<th> 学号 </th>
				<th> 学生学院 </th>
				<th> 学分 </th>
				<th> 成绩 </th>
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
				$sql = "SELECT * FROM teach
						JOIN course ON course.courseid = teach.courseid 
        				JOIN location ON course.locationid = location.locationid
						JOIN timetable ON course.timeindex = timetable.timeindex
						JOIN studenttake ON course.courseid = studenttake.courseid
						JOIN account ON studenttake.schoolnum = account.schoolnum
						JOIN weektable ON course.weekid = weektable.weekid
						WHERE course.courseid = '$courseId'";



				// 执行查询
				$result = $conn->query($sql);

				//$sql = "SELECT * FROM course";
				//$result = $conn->query($sql);

				// 输出数据到HTML页面的<div>中
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {

						echo '<tr onclick="updateScore(this)">';


						echo "<th>" . $row["courseid"] . "</th>";
						echo "<th>" . $row["subject"] . "</th>";
						echo "<th>" . $row["time"] . "</th>";
						echo "<th>" . $row["week"] . "</th>";
						echo "<th>" . $row["turename"] . "</th>";
						echo "<th>" . $row["schoolnum"] . "</th>";
						echo "<th>" . $row["copname"] . "</th>";
						echo "<th>" . $row["credit"] . "</th>";
						echo "<th>" . $row["score"] . "</th>";

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





		<table class="studentcourse2" width="70%">
			<br /><br />
			<h2 class="title2" align="center" id="2">地点列表</h2>


			<tr>
				<th> 地点编号 </th>
				<th> 教学楼 </th>
				<th> 教室 </th>
				<th> 最大容量 </th>
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
				$sql = "SELECT * FROM location";



				// 执行查询
				$result = $conn->query($sql);

				//$sql = "SELECT * FROM course";
				//$result = $conn->query($sql);

				// 输出数据到HTML页面的<div>中
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {

						echo '<tr>';


						echo "<th onclick='locationDelete(this)'>" . $row["locationid"] . "</th>";
						echo "<th onclick='updateBuilding(this)'>" . $row["building"] . "</th>";
						echo "<th onclick='updateRoom(this)'>" . $row["room"] . "</th>";
						echo "<th onclick='updateMaxCapacity(this)'>" . $row["capacity"] . "</th>";

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
					<button class="button" onclick="togglePopuplocation()">添加地点</button>

					<div id="locationPopup" class="popup">
						<form id="locationForm">
							<label>新增地点</label><br><br>
							<label for="locationId1">地点号： </label>
							<input type="text" id="locationId1" name="locationId1" required><br>

							<label for="building">教学楼：</label>
							<input type="text" id="building" name="building" required><br>

							<label for="room">教室：</label>
							<input type="text" id="room" name="room" required><br>

							<label for="capacity">最大容量：</label>
							<input type="number" id="capacity" name="capacity" required><br>

							<button class="button small" type="button" id="insertLocationBtn">新增地点</button>
							<button class="button small" type="button" onclick="cancelAddlocation()">取消添加</button>
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
	function updateTeacher(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		var oldTeacherId = cell.parentNode.cells[8].innerHTML; // 获取原教师编号

		// 弹出输入框，要求输入新的教师编号
		var newTeacherId = prompt("请输入新的教师编号：", oldTeacherId);
		if (newTeacherId !== null && newTeacherId !== oldTeacherId) {
			// 发送课程ID、原教师编号和新教师编号到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_teacher.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("courseId=" + courseId + "&oldTeacherId=" + oldTeacherId + "&newTeacherId=" + newTeacherId);
		}
	}
</script>

<script>
	function updateLocation(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		var oldLocationId = cell.parentNode.cells[6].innerHTML; // 获取原教室编号

		// 弹出输入框，要求输入新的教室编号
		var newLocationId = prompt("请输入新的教室编号：", oldLocationId);
		if (newLocationId !== null && newLocationId !== oldLocationId) {
			// 发送课程ID、原教室编号和新教室编号到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_location.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("courseId=" + courseId + "&oldLocationId=" + oldLocationId + "&newLocationId=" + newLocationId);
		}
	}
</script>


<script>
	function updateTime(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		var oldTimeIndex = cell.parentNode.cells[2].innerHTML; // 获取原时间编号
		// 弹出输入框，要求输入新的时间编号
		var newTimeIndex = prompt("请输入新的时间编号：", oldTimeIndex);
		if (newTimeIndex !== null && newTimeIndex !== oldTimeIndex) {
			// 发送课程ID、原时间编号和新时间编号到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_time.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("courseId=" + courseId + "&oldTimeIndex=" + oldTimeIndex + "&newTimeIndex=" + newTimeIndex);
		}
	}
</script>

<script>
	function updateCredit(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		var oldCredit = cell.innerHTML; // 获取原学分

		// 弹出输入框，要求输入新的学分
		var newCredit = prompt("请输入新的学分：", oldCredit);
		if (newCredit !== null && newCredit !== oldCredit) {
			// 检查输入的学分是否小于等于10
			if (parseFloat(newCredit) <= 10) {
				// 发送课程ID和新学分到服务器端
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "update_credit.php", true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && xhr.status == 200) {
						alert(xhr.responseText); // 显示更新结果
						location.reload(); // 刷新页面
					}
				};
				xhr.send("courseId=" + courseId + "&newCredit=" + newCredit);
			} else {
				alert("学分必须小于等于10");
			}
		}
	}
</script>

<script>
	function updatecapacity(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		var oldcapacity = cell.innerHTML; // 获取原容量

		// 弹出输入框，要求输入新的容量
		var newcapacity = prompt("请输入新的课程容量：", oldcapacity);
		if (newcapacity !== null && newcapacity !== oldcapacity) {
			// 发送课程ID和新课程容量到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_capacity.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("courseId=" + courseId + "&newcapacity=" + newcapacity);
		}
	}
</script>

<script>
	function updateDepartment(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		var oldDepartment = cell.innerHTML; // 获取原学院名称

		// 弹出输入框，要求输入新的学院
		var newDepartment = prompt("请输入新的学院名称：", oldDepartment);
		if (newDepartment !== null && newDepartment !== oldDepartment) {
			// 发送课程ID和新学院名称到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_department.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("courseId=" + courseId + "&newDepartment=" + newDepartment);
		}
	}
</script>

<script>
	function updateWeek(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		var oldWeekId = cell.parentNode.cells[4].innerHTML; // 获取原周编号

		// 弹出输入框，要求输入新的周编号
		var newWeekId = prompt("请输入新的周编号：", oldWeekId);
		if (newWeekId !== null && newWeekId !== oldWeekId) {
			// 发送课程ID、原周编号和新周编号到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_week.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("courseId=" + courseId + "&oldWeekId=" + oldWeekId + "&newWeekId=" + newWeekId);
		}
	}
</script>

<script>
	function updateBuilding(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		var oldBuilding = cell.innerHTML; // 获取原楼信息

		// 弹出输入框，要求输入新的楼信息
		var newBuilding = prompt("请输入新的楼信息：", oldBuilding);
		if (newBuilding !== null && newBuilding !== oldBuilding) {
			// 发送课程ID和新楼信息到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_building.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("courseId=" + courseId + "&newBuilding=" + newBuilding);
		}
	}
</script>

<script>
	function updateRoom(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		var oldRoom = cell.innerHTML; // 获取原教室信息

		// 弹出输入框，要求输入新的教室信息
		var newRoom = prompt("请输入新的教室信息：", oldRoom);
		if (newRoom !== null && newRoom !== oldRoom) {
			// 发送课程ID和新教室信息到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_room.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("courseId=" + courseId + "&newRoom=" + newRoom);
		}
	}
</script>

<script>
	function updateMaxCapacity(cell) {
		var locationId = cell.parentNode.cells[0].innerHTML; // 获取地点ID
		var oldCapacity = cell.innerHTML; // 获取原最大容量信息

		// 弹出输入框，要求输入新的最大容量信息
		var newCapacity = prompt("请输入新的最大容量：", oldCapacity);
		if (newCapacity !== null && newCapacity !== oldCapacity) {
			// 发送地点ID和新最大容量信息到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_max_capacity.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("locationId=" + locationId + "&newCapacity=" + newCapacity);
		}
	}
</script>

<script>
	function courseDelete(cell) {
		var courseId = cell.innerHTML; // 获取课程编号
		var confirmDelete = confirm("确认删除该课程？");
		if (confirmDelete) {
			// 发送课程编号到服务器端进行删除操作
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "delete_course.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示删除结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("courseId=" + courseId);
		}
	}
</script>

<script>
	function locationDelete(cell) {
		var locationId = cell.innerHTML; // 获取编号
		var confirmDelete = confirm("确认删除该项？");
		if (confirmDelete) {
			// 发送编号到服务器端进行删除操作
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "delete_location.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示删除结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("locationId=" + locationId);
		}
	}
</script>

<script>
	document.getElementById("courseForm").addEventListener("submit", function(event) {
		event.preventDefault(); // 阻止表单默认提交行为

		// 获取表单数据
		var formData = new FormData(this);

		// 发送 AJAX 请求
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "insert_course.php", true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				alert(xhr.responseText); // 显示后端返回的消息
				location.reload(); // 刷新页面
			}
		};
		xhr.send(formData);
	});
</script>


<script>
	function addTeacher(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		var teacher = cell.innerHTML; // 获取原教师信息

		// 弹出输入框，要求输入新的教师编号
		var newTeacher = prompt("请输入教师编号：", teacher);
		if (newTeacher !== null && newTeacher !== teacher) {
			// 发送课程ID和新教师编号到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "add_teacher.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示添加结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("courseId=" + courseId + "&teacher=" + newTeacher);
		}
	}
</script>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		var insertLocationBtn = document.getElementById("insertLocationBtn");
		insertLocationBtn.addEventListener("click", function() {
			var locationId = document.getElementById("locationId1").value; // 修改为 locationId1
			var building = document.getElementById("building").value;
			var room = document.getElementById("room").value;
			var capacity = document.getElementById("capacity").value;

			// 发送 Ajax 请求
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "insert_location.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					// 请求完成后的处理逻辑，例如提示用户操作成功
					if (xhr.responseText.startsWith("Success")) { // 修改为检查返回值以确定是否成功
						alert("地点插入成功！");
						location.reload(); // 刷新页面
					} else {
						alert(xhr.responseText); // 显示错误信息
						location.reload(); // 刷新页面
					}
				}
			};
			var data = "locationId=" + encodeURIComponent(locationId) + "&building=" + encodeURIComponent(building) + "&room=" + encodeURIComponent(room) + "&capacity=" + encodeURIComponent(capacity);
			xhr.send(data);
		});
	});
</script>

<script>
	function removeTeacher(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		var teacherId = cell.parentNode.cells[8].innerHTML; // 获取老师编号

		// 弹出确认框
		var confirmed = confirm("确定要删除该老师吗？");
		if (confirmed) {
			// 发送课程ID和老师编号到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "remove_teacher.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示删除结果
					location.reload(); // 刷新页面
				}
			};
			xhr.send("courseId=" + courseId + "&teacherId=" + teacherId);
		}
	}
</script>

<script>
	function selectCourse(cell) {
		var courseId = cell.parentNode.cells[0].innerHTML; // 获取课程ID
		// 将课程ID传递给后端PHP页面
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "record_course.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				alert("选中的课程ID:" + courseId + "   可以编辑该课程学生成绩了");
				location.reload(); // 选课成功后刷新页面
			}
		};
		xhr.send("courseId=" + courseId); // 发送课程ID到服务器端
	}
</script>

<script>
	function updateScore(row) {
		var courseId = row.cells[0].innerHTML; // 获取课程ID
		var studentId = row.cells[5].innerHTML; // 获取学生ID

		// 弹出输入框，要求输入成绩
		var score = prompt("请输入成绩：", row.cells[8].innerHTML);
		if (score !== null) {
			// 发送课程ID、学生ID和成绩到服务器端
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "update_score.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					alert(xhr.responseText); // 显示更新结果
					if (xhr.responseText == "成绩更新成功") {
						row.cells[8].innerHTML = score; // 更新表格中的成绩显示
					}
				}
			};
			xhr.send("courseId=" + courseId + "&studentId=" + studentId + "&score=" + score);
		}
	}
</script>

<script>
	function filterCourses() {
		const params = {
			courseId: document.getElementById('courseId').value,
			subject: document.getElementById('subject').value,
			timeIndex: document.getElementById('timeIndex').value,
			weekId: document.getElementById('weekId').value,
			locationId: document.getElementById('locationId').value,
			schoolnum: document.getElementById('teacherId').value,
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
		location.reload(); // 选课成功后刷新页面
	}
</script>