<?php
session_start();

include("../bins/connections.php");
include("../../bins/header.php");


if (isset($_SESSION["username"])) {

	$session_user = $_SESSION["username"];

	$query_info = mysqli_query($connections, "SELECT * FROM _user_tbl_ WHERE username='$session_user'");
	$my_info = mysqli_fetch_assoc($query_info);
	$account_type = $my_info["account_type"];

	if ($account_type != 3) {

		header('Location: ../../forbidden');
	}
} else {

	header('Location: ../../');
}


?>


<center>
	<h1 class="py-3 text-info px-1">Student Performance Chart</h1>
</center>


<style>
	canvas {
		user-select: none;
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}

	.chart_active {
		border: 1.5px solid white;
		border-radius: 6px;
	}

	.secondSemester {
		display: none;
	}

	.bsit {
		display: none;
	}

	.displayBlock {
		display: block;
	}

	.displayNone {
		display: none;
	}

	/* Custom select container */
	.custom-select-container {
		position: relative;
		display: inline-block;
		width: 160px;
	}

	/* Custom select container */
	.print {
		position: relative;
		display: inline-block;
		background-color: #FFC107;
		/* background-color: #E0A800; */
		text-align: center;
		color: white;
		padding: 5px 10px;
		font-size: 14px;
		cursor: pointer;
		width: 90px;
	}

	.print {
		/* width: 100%; */
		text-decoration: none;
		color: black;
	}

	.print:hover {
		background-color: #E0A800;
		text-decoration: none;
		color: white;
	}

	/* Custom select displayed element */
	.select-selected {
		background-color: #17a2b8;
		color: white;
		padding: 5px 10px;
		font-size: 14px;
		border: 1px solid #ccc;
		cursor: pointer;
	}

	/* Custom select dropdown */
	.select-items {
		position: absolute;
		background-color: #f8f9fa;
		border: 1px solid #ccc;
		z-index: 99;
		width: 100%;
		top: 35px;
		display: none;
	}

	/* Custom select items */
	.select-items div {
		color: #343a40;
		padding: 8px 12px;
		cursor: pointer;
	}

	/* Highlight selected item */
	.select-items div:hover,
	.same-as-selected {
		background-color: #17a2b8;
		color: white;
	}

	.select-disabled .select-selected {
		background-color: #ccc;
		cursor: not-allowed;
	}
</style>

<?php
include("../bins/teacher_nav.php");
?>

<?php

// Get the selected value from the query string or set a default value
$selectedGrading = isset($_GET['redir']) ? $_GET['redir'] : 'select_grading';
$selectedYear = isset($_GET['_y']) ? $_GET['_y'] : 'select_year';
$selectedCourse = isset($_GET['course']) ? $_GET['course'] : 'select_course';
$selectedSemester = isset($_GET['sem']) ? $_GET['sem'] : 'select_semester';

// Map for displaying text based on value
$gradingOptions = [
	'select_grading' => 'Select Grading Period',
	'prelim' => 'Prelim',
	'midterm' => 'Midterm',
	'prefinal' => 'Prefinal',
	'final' => 'Final'
];

$courseOptions = [
	'select_course' => 'Select Course',
	'BSIT' => 'BSIT',
	'BSCS' => 'BSCS'
];
$semesterOptions = [
	'select_semester' => 'Select Semester',
	'firstSemester' => '1st Semester',
	'secondSemester' => '2nd Semester'
];

$selectedGradingText = isset($gradingOptions[$selectedGrading]) ? $gradingOptions[$selectedGrading] : 'Select Grading Period';
$selectedYearText = isset($selectedYear) && $selectedYear != 'select_year' ? $selectedYear : 'Select Year';
$selectedCourseText = isset($courseOptions[$selectedCourse]) ? $courseOptions[$selectedCourse] : 'Select Course';
$selectedSemesterText = isset($semesterOptions[$selectedSemester]) ? $semesterOptions[$selectedSemester] : 'Select Semester';
?>

<br>

<center>
	<!-- <h1 class="py-3 text-info px-1"><font color="red">Student ID sa Register</font></h1> -->
</center>

<div>

	<div id="overAllSemesterBefore"></div>
	<br>

	<!-- <select name="overAllSemester" id="overAllSemester" class="form-control col-2 ml-3 bg-info text-white" onchange="semester()">
		<option value="firstSemester">First Semester</option>
		<option value="secondSemester">Second Semester</option>
	</select> -->

	<div class="container-fluid d-inline">
		<!-- Semester Dropdown -->
		<div class="custom-select-container" id="semester-container">
			<div class="select-selected"><?php echo $selectedSemesterText; ?></div>
			<div class="select-items">
				<?php
				foreach ($semesterOptions as $value => $text) {
					echo "<div data-value='$value'>$text</div>";
				}
				?>
			</div>
		</div>
	</div>

	<input type="hidden" id="overAllSemesterText" value="<?php if (isset($_GET['sem'])) {
																echo $_GET['sem'];
															} ?>">

	<div id="firstSemester" class="firstSemester">
		<?php
		include('overallPredictedStudentsPerformanceFirstSemesterBarChart.php');
		?>
	</div>

	<div id="secondSemester" class="secondSemester">
		<?php
		include('overallPredictedStudentsPerformanceSecondSemesterBarChart.php');
		?>
	</div>

</div>

<hr>

<?php
include('pieChartPassAndFailure.php');
?>

<hr>


<div>

	<div id="overAllByCourseBefore"></div>
	<br>
	<br>
	<!-- <select name="overAllByCourse" id="overAllByCourse" class="form-control col-2 ml-3 bg-info text-white" onchange="course()">
		<option value="BSCS">BSCS</option>
		<option value="BSIT">BSIT</option>
	</select> -->

	<div class="container-fluid d-inline">
		<!-- Course Dropdown -->
		<div class="custom-select-container" id="course-container">
			<div class="select-selected"><?php echo $selectedCourseText; ?></div>
			<div class="select-items">
				<?php
				foreach ($courseOptions as $value => $text) {
					echo "<div data-value='$value'>$text</div>";
				}
				?>
			</div>
		</div>
	</div>

	<input type="hidden" id="overAllByCourseText" value="<?php if (isset($_GET['course'])) {
																echo $_GET['course'];
															} ?>">

	<div id="bscs" class="bscs">
		<?php
		include('overallStudentsPerfomanceBSCS.php');
		?>
	</div>

	<div id="bsit" class="bsit">
		<?php
		include('overallStudentsPerfomanceBSIT.php');
		?>
	</div>

</div>

<br>
<hr>


<?php
include('midtermVSfinal.php');
?>


<script>
	document.addEventListener('DOMContentLoaded', (event) => {

		const semesterContainer = document.getElementById('semester-container');
		const courseContainer = document.getElementById('course-container');

		const semesterSelected = semesterContainer.querySelector('.select-selected');
		const courseSelected = courseContainer.querySelector('.select-selected');

		const semesterItems = semesterContainer.querySelector('.select-items');
		const courseItems = courseContainer.querySelector('.select-items');

		// Function to toggle dropdown visibility
		function toggleDropdown(items) {
			items.style.display = items.style.display === 'block' ? 'none' : 'block';
		}

		// Show the dropdown menu on click
		semesterSelected.addEventListener('click', function() {
			toggleDropdown(semesterItems);
		});

		courseSelected.addEventListener('click', function() {
			toggleDropdown(courseItems);
		});

		// Handle item selection
		function handleSemesterSelection(container, selected, items) {
			items.querySelectorAll('div').forEach(function(item) {
				item.addEventListener('click', function() {
					selected.textContent = this.textContent;
					items.style.display = 'none';

					// Get selected values from both selects
					const selectedSemester = semesterContainer.querySelector('.select-selected').textContent.trim();
					const semesterValue = Array.from(semesterItems.querySelectorAll('div')).find(el => el.textContent.trim() === selectedSemester).dataset.value;

					window.location.href = `?sem=${semesterValue}`;
				});
			});
		}

		handleSemesterSelection(semesterContainer, semesterSelected, semesterItems);

		// Handle item selection
		function handleCourseSelection(container, selected, items) {
			items.querySelectorAll('div').forEach(function(item) {
				item.addEventListener('click', function() {
					selected.textContent = this.textContent;
					items.style.display = 'none';

					// Get selected values from both selects
					const selectedCourse = courseContainer.querySelector('.select-selected').textContent.trim();
					const courseValue = Array.from(courseItems.querySelectorAll('div')).find(el => el.textContent.trim() === selectedCourse).dataset.value;

					window.location.href = `?course=${courseValue}`;
				});
			});
		}


		handleCourseSelection(courseContainer, courseSelected, courseItems);

		// Close the dropdown if clicked outside
		document.addEventListener('click', function(event) {
			if (!semesterContainer.contains(event.target)) {
				semesterItems.style.display = 'none';
			}
			if (!courseContainer.contains(event.target)) {
				courseItems.style.display = 'none';
			}
		});

	});

	window.onload = function() {

		var overAllSemesterText = document.getElementById("overAllSemesterText");
		var overAllSemester = document.getElementById("overAllSemester");
		var firstSemester = document.getElementById("firstSemester");
		var secondSemester = document.getElementById("secondSemester");
		var secondSemesterValue = document.getElementById("secondSemester").value;


		if (overAllSemesterText.value == "secondSemester") {
			// alert("hay");
			// overAllSemester.value = "secondSemester";
			secondSemester.classList.add("displayBlock");
			firstSemester.classList.add("displayNone");
			window.location.href = "#overAllSemesterBefore";
		}

		if (overAllSemesterText.value == "firstSemester") {
			window.location.href = "#overAllSemesterBefore";
		}


		var overAllByCourseText = document.getElementById("overAllByCourseText");
		var overAllByCourse = document.getElementById("overAllByCourse");
		var bscs = document.getElementById("bscs");
		var bsit = document.getElementById("bsit");


		if (overAllByCourseText.value == "BSIT") {
			// alert("hay");
			// overAllByCourse.value = "BSIT";
			bsit.classList.add("displayBlock");
			bscs.classList.add("displayNone");
			window.location.href = "#overAllByCourseBefore";
		}

		if (overAllByCourseText.value == "BSCS") {
			// alert("hay");
			window.location.href = "#overAllByCourseBefore";
		}


		var barChartFirstSemester = new CanvasJS.Chart("barChartContainerFirstSem", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light1", // "light1", "light2", "dark1", "dark2"
			title: {
				fontColor: "red",
				text: "Overall Predicted Student's Performance First Semester"
			},
			axisY: {
				title: "Number of Students"
			},
			axisX: {
				title: "Grade Equivalent"
			},
			data: [{
				type: "column", //change type to bar, line, area, pie, etc
				indexLabel: "{y}", //Shows y value on all Data Points
				indexLabelFontColor: /* "#5A5757", */ "#fff",
				indexLabelFontWeight: "bold",
				indexLabelFontSize: 16,
				indexLabelPlacement: "inside",
				dataPoints: <?php echo json_encode($dataPointsFirstSemester, JSON_NUMERIC_CHECK); ?>
			}]
		});
		barChartFirstSemester.render();


		// setTimeout(function(){

		var barChartSecondSemester = new CanvasJS.Chart("barChartContainerSecondSem", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light1", // "light1", "light2", "dark1", "dark2"
			title: {
				fontColor: "red",
				text: "Overall Predicted Student's Performance Second Semester"
			},
			axisY: {
				title: "Number of Students"
			},
			axisX: {
				title: "Grade Equivalent"
			},
			data: [{
				type: "column", //change type to bar, line, area, pie, etc
				indexLabel: "{y}", //Shows y value on all Data Points
				indexLabelFontColor: /* "#5A5757", */ "#fff",
				indexLabelFontWeight: "bold",
				indexLabelFontSize: 16,
				indexLabelPlacement: "inside",
				dataPoints: <?php echo json_encode($dataPointsSecondSemester, JSON_NUMERIC_CHECK); ?>
			}]
		});

		barChartSecondSemester.render();

		// },1000);


		var pieChart = new CanvasJS.Chart("pieChartContainer", {
			exportEnabled: true,
			animationEnabled: true,
			title: {
				text: "Pass and Failure Percentage",
				fontColor: "green"
			},
			legend: {
				cursor: "pointer",
				itemclick: explodePie
			},
			data: [{
				type: "pie",
				showInLegend: true,
				toolTipContent: "{label}: <strong>{y}%</strong>",
				indexLabel: "{label} - {y}%",
				// indexLabelFontWeight: "bold",
				indexLabelFontSize: 15,
				indexLabelLineThickness: 2,
				dataPoints: <?php echo json_encode($pieChartDataPoints, JSON_NUMERIC_CHECK); ?>
			}]
		});
		pieChart.render();


		var barChart_BSCS = new CanvasJS.Chart("barChartContainer_BSCS", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light1", // "light1", "light2", "dark1", "dark2"
			title: {
				fontColor: "red",
				text: "Overall Student's Performance of BSCS"
			},
			axisY: {
				title: "Number of Students"
			},
			axisX: {
				title: "Grade Equivalent"
			},
			data: [{
				type: "column", //change type to bar, line, area, pie, etc
				indexLabel: "{y}", //Shows y value on all Data Points
				indexLabelFontColor: /* "#5A5757", */ "#fff",
				indexLabelFontWeight: "bold",
				indexLabelFontSize: 16,
				indexLabelPlacement: "inside",
				dataPoints: <?php echo json_encode($dataPoints_BSCS, JSON_NUMERIC_CHECK); ?>
			}]
		});
		barChart_BSCS.render();


		// setTimeout(function(){

		var barChart_BSIT = new CanvasJS.Chart("barChartContainer_BSIT", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light1", // "light1", "light2", "dark1", "dark2"
			title: {
				fontColor: "red",
				text: "Overall Student's Performance of BSIT"
			},
			axisY: {
				title: "Number of Students"
			},
			axisX: {
				title: "Grade Equivalent"
			},
			data: [{
				type: "column", //change type to bar, line, area, pie, etc
				indexLabel: "{y}", //Shows y value on all Data Points
				indexLabelFontColor: /* "#5A5757", */ "#fff",
				indexLabelFontWeight: "bold",
				indexLabelFontSize: 16,
				indexLabelPlacement: "inside",
				dataPoints: <?php echo json_encode($dataPoints_BSIT, JSON_NUMERIC_CHECK); ?>
			}]
		});

		barChart_BSIT.render();

		// },1000);


		var midtermVSfinalChart = new CanvasJS.Chart("midtermVSfinalChartContainer", {
			animationEnabled: true,
			exportEnabled: true,
			axisX: {
				labelAngle: -90,
			},
			theme: "light1", // "light1", "light2", "dark1", "dark2"
			title: {
				fontColor: "red",
				text: "Midterm vs Final Marks"
			},
			axisY: {
				title: "Student Grade"
			},
			axisX: {
				title: "Student number"
			},
			toolTip: {
				shared: true
			},
			legend: {
				cursor: "pointer",
				itemclick: toggleDataSeries
			},
			data: [{
				type: "column", //change type to bar, line, area, pie, etc
				indexLabel: "{y}", //Shows y value on all Data Points
				indexLabelOrientation: "vertical",
				indexLabelFontColor: /* "#5A5757", */ "#fff",
				indexLabelFontWeight: "bold",
				indexLabelFontSize: 16,
				indexLabelPlacement: "inside",
				name: "Midterm Grade",
				showInLegend: true,
				dataPoints: <?php echo json_encode($getPushData, JSON_NUMERIC_CHECK); ?>
			}, {
				type: "column",
				name: "Final Grade",
				axisYType: "secondary",
				showInLegend: true,
				dataPoints: <?php echo json_encode($getPushData2, JSON_NUMERIC_CHECK); ?>
			}]
		});
		midtermVSfinalChart.render();


	}

	function explodePie(e) {
		if (typeof(e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
			e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
		} else {
			e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
		}
		e.pieChart.render();

	}

	function toggleDataSeries(e) {
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		} else {
			e.dataSeries.visible = true;
		}
		e.chart.render();
	}
</script>

<script src="../../canvasjs-2.3.2/canvasjs.min.js"></script>
<script src="../bins/sc/charts.js"></script>


<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->

<?php
include("../../bins/footer_non_fixed.php");
?>