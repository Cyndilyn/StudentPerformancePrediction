<?php

session_start();

include("../bins/connections.php");
include("../../bins/header.php");

$session_user = $_SESSION["username"];

$query_info = mysqli_query($connections, "SELECT * FROM _user_tbl_ WHERE username='$session_user'");
$my_info = mysqli_fetch_assoc($query_info);
$account_type = $my_info["account_type"];
$student_no = $my_info["student_no"];
$firstname = $my_info["firstname"];
$course = $my_info["course"];
$year = $my_info["year"];

$lastname = $my_info['lastname'];
// $firstname = $my_info['firstname'];
$middlename = $my_info['middlename'];
$student_name = $firstname . " " . $middlename[0] . ". " . $lastname;


if (isset($_SESSION["username"])) {



  if ($account_type != 2) {

    header('Location: ../../forbidden');
  }
} else {

  header('Location: ../../');
}


?>


<style>
  .my_grades_active {
    border: 1.5px solid white;
    border-radius: 6px;
  }

  #prefinal_grade_prediction {
    display: none;
    border: none;
    background-color: transparent;
  }

  #final_grade_prediction {
    display: none;
    border: none;
    background-color: transparent;
  }

  .table-hover tbody tr:hover {
    /* background: #4ef0a2; */
    cursor: pointer;
  }

  /* .table-hover tbody tr:hover td {
    background: #4ef0a2;
    cursor:pointer;
} */
  .table-hover tbody h6 {
    color: #007bff;
  }

  .table-hover tbody .passed {
    color: #28a745;
  }

  .table-hover tbody .failed {
    color: #dc3545;
  }

  /* td:hover { background-color: #f75271; color: #fff; } */
  td:hover a {
    color: #fff;
  }

  td:hover h6 {
    color: #fff;
  }

  td:hover .remarks {
    color: #fff;
  }
</style>


<center>
  <h1 class="py-3 text-info px-1">View Grades</h1>
  <!-- <h1 class="py-3 text-info px-1">Welcome <?php echo $firstname; ?>!</h1> -->
</center>


<?php

include('../bins/student_nav.php');

$predict = "<sup class='badge badge-warning'>Predict</sup>";


?>


<select class="form-control col-2 ml-2 pt-1 pb-2 d-inline bg-info text-white mt-3" id="semester" onchange="semester()">
  <!-- <option value="select_semester">Select Semester</option> -->
  <option value="1" <?php if (isset($_GET['s_'])) {
                      if ($_GET['s_'] == "1") {
                        echo "selected";
                      }
                    } ?>>1st Semester</option>
  <option value="2" <?php if (isset($_GET['s_'])) {
                      if ($_GET['s_'] == "2") {
                        echo "selected";
                      }
                    } ?>>2nd Semester</option>
</select>
&nbsp;
<?php
if (isset($_GET['s_'])) {
?>
  <a href="pdf_files_user?s_=<?php echo $_GET["s_"]; ?>&_c=<?php echo $course; ?>&_y=<?php echo $year; ?>&_sn=<?php echo $student_no; ?>&_n=<?php echo $student_name; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
<?php
} else {
?>
  <a href="pdf_files_user?s_=<?php echo "1"; ?>&_c=<?php echo $course; ?>&_y=<?php echo $year; ?>&_sn=<?php echo $student_no; ?>&_n=<?php echo $student_name; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
<?php
}
?>

<div>
  <h6 class="ml-3 d-inline"><b>Course Name</b>: <?php if (isset($_GET['s_'])) {
                                                  if ($_GET['s_'] == "1") {
                                                    echo "IT 2 - Application Programming 1";
                                                  } else if ($_GET['s_'] == "2") {
                                                    echo "IT 5 - Application Programming 2";
                                                  }
                                                } else {
                                                  echo "IT 2 - Application Programming 1";
                                                } ?></h6>
  <h6 class="ml-3 d-inline"><b>Year</b>: <?php echo $year; ?></h6>
  <h6 class="ml-3 d-inline"><b>Semester</b>: <?php if (isset($_GET['s_'])) {
                                                if ($_GET['s_'] == "1") {
                                                  echo "First Semester";
                                                } else {
                                                  echo "Second Semester";
                                                }
                                              } else {
                                                echo "First Semester";
                                              } ?></h6>
</div>

<?php


if (isset($_GET["s_"])) {
  $semester_no = $_GET["s_"];

  if ($semester_no == "2") {
    $semester_no = "2";
  } else if ($semester_no == "select_semester") {
    $semester_no = "1";
  }
} else {
  $semester_no = "1";
}

// if($semester_no = "select_semester"){
//   $semester_no = "1";
// }



// $final_prediction_qry = mysqli_query($connections, "SELECT * FROM $final_prediction_table_semester WHERE student_no='$student_no' ");
// $row_final_prediction = mysqli_fetch_assoc($final_prediction_qry);

$student_qry = mysqli_query($connections, "SELECT * FROM _user_tbl_ WHERE student_no='$student_no' ");
$row_student = mysqli_fetch_assoc($student_qry);
$lastname = $row_student['lastname'];
$firstname = $row_student['firstname'];
$middlename = $row_student['middlename'];
$student_name = $firstname . " " . $middlename[0] . ". " . $lastname;


// ######################## Check Grades #################


$final_qry1 = mysqli_query($connections, "SELECT * FROM final1 WHERE student_no='$student_no' ");
$prefinal_qry1 = mysqli_query($connections, "SELECT * FROM prefinal1 WHERE student_no='$student_no' ");
$midterm_qry1 = mysqli_query($connections, "SELECT * FROM midterm1 WHERE student_no='$student_no' ");
$prelim_qry1 = mysqli_query($connections, "SELECT * FROM prelim1 WHERE student_no='$student_no' ");



$row1_student = mysqli_fetch_assoc($final_qry1);
$row1_prefinal = mysqli_fetch_assoc($prefinal_qry1);
$row1_midterm = mysqli_fetch_assoc($midterm_qry1);
$row1_prelim = mysqli_fetch_assoc($prelim_qry1);


$final1_output_1 = $row1_student["final_output_1"];
$final1_output_2 = $row1_student["final_output_2"];
$final1_output_total_score = $row1_student["final_output_total_score"];
$final1_output_base = $row1_student["final_output_base"];
$final1_output_weight = $row1_student["final_output_weight"];
$final1_performance_1 = $row1_student["final_performance_1"];
$final1_performance_2 = $row1_student["final_performance_2"];
$final1_performance_total_score = $row1_student["final_performance_total_score"];
$final1_performance_base = $row1_student["final_performance_base"];
$final1_performance_weight = $row1_student["final_performance_weight"];
$final1_written_test = $row1_student["final_written_test"];
$final1_written_test_base = $row1_student["final_written_test_base"];
$final1_written_test_weight = $row1_student["final_written_test_weight"];
$final1_grade = $row1_student["final_grade"];
$final1_grade_equivalent = $row1_student["final_grade_equivalent"];




$prelim1_output_1 = $row1_prelim['prelim_output_1'];
$prelim1_output_2 = $row1_prelim['prelim_output_2'];
$prelim1_performance_1 = $row1_prelim['prelim_performance_1'];
$prelim1_performance_2 = $row1_prelim['prelim_performance_2'];
$prelim1_written_test = $row1_prelim['prelim_written_test'];

$prelim1_output_total_score = $prelim1_output_1 + $prelim1_output_2;
$prelim1_performance_total_score = $prelim1_performance_1 + $prelim1_performance_2;

$prelim1_output_base = $prelim1_output_total_score / 40 * 40 + 60;
$prelim1_performance_base = $prelim1_performance_total_score / 40 * 40 + 60;
$prelim1_written_test_base =  $prelim1_written_test / 70 * 40 + 60;

$prelim1_output_weight = $prelim1_output_base * 0.40;
$prelim1_performance_weight = $prelim1_performance_base * 0.40;
$prelim1_written_test_weight = $prelim1_written_test_base * 0.20;

$prelim1_grade = $prelim1_output_weight + $prelim1_performance_weight + $prelim1_written_test_weight;

$prelim1_grade = $prelim1_grade;

$prelim1_grade = number_format((float)$prelim1_grade, 2, ".", "");

$midterm1_output_1 = $row1_midterm["midterm_output_1"];
$midterm1_output_2 = $row1_midterm["midterm_output_2"];
$midterm1_performance_1 = $row1_midterm["midterm_performance_1"];
$midterm1_performance_2 = $row1_midterm["midterm_performance_2"];
$midterm1_written_test = $row1_midterm["midterm_written_test"];

$midterm1_output_total_score = $midterm1_output_1 + $midterm1_output_2;
$midterm1_output_base = $midterm1_output_total_score / 40 * 40 + 60;


$midterm1_performance_total_score = $midterm1_performance_1 + $midterm1_performance_2;
$midterm1_performance_base = $midterm1_performance_total_score / 40 * 40 + 60;
$midterm1_written_test_base = $midterm1_written_test / 70 * 40 + 60;

$midterm1_output_weight = $midterm1_output_base * 0.40;
$midterm1_performance_weight = $midterm1_performance_base * 0.40;
$midterm1_written_test_weight = $midterm1_written_test_base * 0.20;
$midterm1_2nd_quarter = $midterm1_output_weight + $midterm1_performance_weight + $midterm1_written_test_weight;


$midterm1_grade = ($prelim1_grade * 0.3) + ($midterm1_2nd_quarter * 0.7);
$midterm1_grade = number_format((float)$midterm1_grade, 2, ".", "");


$prefinal1_output_1 = $row1_prefinal["prefinal_output_1"]; //ok
$prefinal1_output_2 = $row1_prefinal["prefinal_output_2"]; //ok
$prefinal1_performance_1 = $row1_prefinal["prefinal_performance_1"]; //ok
$prefinal1_performance_2 = $row1_prefinal["prefinal_performance_2"]; //ok
$prefinal1_written_test = $row1_prefinal["prefinal_written_test"]; //ok
// $prefinal_grade_equivalent = $row_prefinal["prefinal_grade_equivalent"];

$prefinal1_output_total_score = $prefinal1_output_1 + $prefinal1_output_2; //ok
$prefinal1_performance_total_score = $prefinal1_performance_1 + $prefinal1_performance_2; //ok

$prefinal1_output_base = $prefinal1_output_total_score / 40 * 40 + 60; //ok
$prefinal1_performance_base = $prefinal1_performance_total_score / 40 * 40 + 60; //ok
$prefinal1_written_test_base = $prefinal1_written_test / 70 * 40 + 60; //ok

$prefinal1_output_weight = $prefinal1_output_base * 0.40; //ok
$prefinal1_performance_weight = $prefinal1_performance_base * 0.40; //ok
$prefinal1_written_test_weight = $prefinal1_written_test_base * 0.20; //ok

$prefinal1_3rd_quarter = $prefinal1_output_weight + $prefinal1_performance_weight + $prefinal1_written_test_weight; //ok
$prefinal1_grade = ($midterm1_grade * 0.3) + ($prefinal1_3rd_quarter * 0.7);

$prefinal1_grade = number_format((float)$prefinal1_grade, 2, ".", "");


$check_prelim1_grade = $prelim1_output_1 + $prelim1_output_2 + $prelim1_performance_1 + $prelim1_performance_2 + $prelim1_written_test;
$check_midterm1_grade = $midterm1_output_1 + $midterm1_output_2 + $midterm1_performance_1 + $midterm1_performance_2 + $midterm1_written_test;
$check_prefinal1_grade = $prefinal1_output_1 + $prefinal1_output_2 + $prefinal1_performance_1 + $prefinal1_performance_2 + $prefinal1_written_test;


// ####################______Final Formulas______####################
// $final_formative_assessment_total_score =
// $final_formative_assessment_1 + $final_formative_assessment_2 +
// $final_formative_assessment_3 + $final_formative_assessment_4 +
// $final_formative_assessment_5 + $final_formative_assessment_6 +
// $final_formative_assessment_7 + $final_formative_assessment_8 +
// $final_formative_assessment_9 + $final_formative_assessment_10;

// $final_formative_assessment_base = $final_formative_assessment_total_score / 100 * 40 + 60;
$final1_output_total_score = $final1_output_1 + $final1_output_2;
$final1_output_base = $final1_output_total_score / 40 * 40 + 60;
$final1_output_weight = $final1_output_base * 0.40;
$final1_performance_total_score = $final1_performance_1 + $final1_performance_2;
$final1_performance_base = $final1_performance_total_score / 40 * 40 + 60;
$final1_performance_weight = $final1_performance_base * 0.40;
$final1_written_test_base = $final1_written_test / 70 * 40 + 60;
$final1_written_test_weight = $final1_written_test_base * 0.20;
$final1_4th_quarter = $final1_output_weight + $final1_performance_weight + $final1_written_test_weight;
$final1_grade = ($prefinal1_grade * 0.3) + ($final1_4th_quarter * 0.7);

$final1_grade = number_format((float)$final1_grade, 2, ".", "");


// ################### End of Check Grades ################




if ($semester_no == "2") {
  if ($final1_grade > 74) {

?>
    <!-- <div class="black p-5 fixed-top"> -->
    <input type="hidden" id="get_student_no" value="<?php echo $student_no; ?>">

    <input type="hidden" id="get_semester" value="<?php if (isset($_GET["s_"])) {
                                                    echo $_GET["s_"];
                                                  } else {
                                                    echo "1";
                                                  } ?>">

    <div class="table-responsive table_table mt-3 col-10 container-fluid">
      <table border="1" class="table table-hover">
        <thead>
          <tr>
            <th class="px-3 text-center bg-info text-white" colspan="8">My Grade</th>
          </tr><!-- Preliminary Here -->

          <tr class="text-center">
            <th class="px-3 bg-white">Student Name</th>
            <th class="px-3" style="background-color: #b1fbc4;">Prelim</th>
            <th class="px-3" style="background-color: #cdddfe;">Midterm</th>
            <th class="px-3" style="background-color: #ffb3b3;">Prefinal</th>
            <th class="px-3" style="background-color: #ffffcc;" id="final_student_predict">Final</th>
            <th class="px-3 bg-secondary text-white" id="average">Average</th>
            <th class="px-3 bg-secondary text-white" id="average">Equivalent</th>
            <th class="px-3 bg-secondary text-white" id="remarks">Remarks</th>
            <!-- <th class="px-3 bg-dark text-white" id="prediction">Prediction<sup class='badge badge-warning'>Prediction</sup></th> -->
          </tr>

        </thead>

        <tbody>

          <?php



          $prelim = "prelim$semester_no";
          $midterm = "midterm$semester_no";
          $prefinal = "prefinal$semester_no";
          $final = "final$semester_no";
          $prelim_qry = mysqli_query($connections, "SELECT * FROM $prelim WHERE student_no='$student_no' ");
          $midterm_qry = mysqli_query($connections, "SELECT * FROM $midterm WHERE student_no='$student_no' ");
          $prefinal_qry = mysqli_query($connections, "SELECT * FROM $prefinal WHERE student_no='$student_no' ");
          $final_qry = mysqli_query($connections, "SELECT * FROM $final WHERE student_no='$student_no' ");

          // $prefinal_prediction_qry = mysqli_query($connections, "SELECT * FROM $prefinal WHERE student_no='$student_no' ");


          while ($row_prelim = mysqli_fetch_assoc($prelim_qry)) {


            $row_midterm = mysqli_fetch_assoc($midterm_qry);
            $row_prefinal = mysqli_fetch_assoc($prefinal_qry);
            $row_final = mysqli_fetch_assoc($final_qry);



            $prelim_output_1 = $row_prelim['prelim_output_1'];
            $prelim_output_2 = $row_prelim['prelim_output_2'];
            $prelim_performance_1 = $row_prelim['prelim_performance_1'];
            $prelim_performance_2 = $row_prelim['prelim_performance_2'];
            $prelim_written_test = $row_prelim['prelim_written_test'];

            if (
              $prelim_output_1 == 0 && $prelim_output_2 == 0 &&
              $prelim_performance_1 == 0 && $prelim_performance_1 == 0 &&
              $prelim_written_test == 0
            ) {

              $prelim_grade = 0;
            } else {

              $prelim_output_total_score = $prelim_output_1 + $prelim_output_2;
              $prelim_performance_total_score = $prelim_performance_1 + $prelim_performance_2;

              $prelim_output_base = $prelim_output_total_score / 40 * 40 + 60;
              $prelim_performance_base = $prelim_performance_total_score / 40 * 40 + 60;
              $prelim_written_test_base =  $prelim_written_test / 70 * 40 + 60;

              $prelim_output_weight = $prelim_output_base * 0.40;
              $prelim_performance_weight = $prelim_performance_base * 0.40;
              $prelim_written_test_weight = $prelim_written_test_base * 0.20;

              $prelim_grade = $prelim_output_weight + $prelim_performance_weight + $prelim_written_test_weight;

              $prelim_grade = number_format((float)$prelim_grade, 2, ".", "");
            }

            $midterm_output_1 = $row_midterm["midterm_output_1"];
            $midterm_output_2 = $row_midterm["midterm_output_2"];
            $midterm_performance_1 = $row_midterm["midterm_performance_1"];
            $midterm_performance_2 = $row_midterm["midterm_performance_2"];
            $midterm_written_test = $row_midterm["midterm_written_test"];

            if (
              $midterm_output_1 == 0 && $midterm_output_2 == 0 &&
              $midterm_performance_1 == 0 && $midterm_performance_1 == 0 &&
              $midterm_written_test == 0
            ) {

              $midterm_grade = 0;
            } else {

              $midterm_output_total_score = $midterm_output_1 + $midterm_output_2;
              $midterm_output_base = $midterm_output_total_score / 40 * 40 + 60;
              $midterm_output_weight = $midterm_output_base * 0.40;


              $midterm_performance_total_score = $midterm_performance_1 + $midterm_performance_2;
              $midterm_performance_base = $midterm_performance_total_score / 40 * 40 + 60;
              $midterm_written_test_base = $midterm_written_test / 70 * 40 + 60;
              $midterm_performance_weight = $midterm_performance_base * 0.40;
              $midterm_written_test_weight = $midterm_written_test_base * 0.20;
              $midterm_2nd_quarter = $midterm_output_weight + $midterm_performance_weight + $midterm_written_test_weight;

              $midterm_output_weight = $midterm_output_base * 0.40;
              $midterm_performance_weight = $midterm_performance_base * 0.40;
              $midterm_written_test_weight = $midterm_written_test_base * 0.20;
              $midterm_grade = $prelim_grade * 0.3 + $midterm_2nd_quarter * 0.7;

              $midterm_grade = number_format((float)$midterm_grade, 2, ".", "");
            }


            $prefinal_output_1 = $row_prefinal["prefinal_output_1"]; //ok
            $prefinal_output_2 = $row_prefinal["prefinal_output_2"]; //ok
            $prefinal_performance_1 = $row_prefinal["prefinal_performance_1"]; //ok
            $prefinal_performance_2 = $row_prefinal["prefinal_performance_2"]; //ok
            $prefinal_written_test = $row_prefinal["prefinal_written_test"]; //ok

            $prefinal_prediction = $row_prefinal["prefinal_prediction"];

            // new line of condition
            if (
              $prefinal_output_1 <= 0 && $prefinal_output_2 <= 0 &&
              $prefinal_performance_1 <= 0 && $prefinal_performance_2 <= 0 &&
              $prefinal_written_test <= 0
            ) {

              if ($prefinal_prediction > 0) {
                $prefinal_prediction = $row_prefinal["prefinal_prediction"];
                $confirm_prefinal_prediction = $prefinal_prediction;
                $prefinal_grade = 0;
              } else {
                $prefinal_grade = 0;
                $prefinal_prediction = 0;
              }
            } else {

              $prefinal_output_total_score = $prefinal_output_1 + $prefinal_output_2; //ok
              $prefinal_performance_total_score = $prefinal_performance_1 + $prefinal_performance_2; //ok

              $prefinal_output_base = $prefinal_output_total_score / 40 * 40 + 60; //ok
              $prefinal_performance_base = $prefinal_performance_total_score / 40 * 40 + 60; //ok
              $prefinal_written_test_base = $prefinal_written_test / 70 * 40 + 60; //ok

              $prefinal_output_weight = $prefinal_output_base * 0.40; //ok
              $prefinal_performance_weight = $prefinal_performance_base * 0.40; //ok
              $prefinal_written_test_weight = $prefinal_written_test_base * 0.20; //ok

              $prefinal_3rd_quarter = $prefinal_output_weight + $prefinal_performance_weight + $prefinal_written_test_weight; //ok
              $prefinal_grade = $midterm_grade * 0.3 + $prefinal_3rd_quarter * 0.7;

              $prefinal_grade = number_format((float)$prefinal_grade, 2, ".", "");
            }


            $final_output_1 = $row_final["final_output_1"];
            $final_output_2 = $row_final["final_output_2"];
            $final_performance_1 = $row_final["final_performance_1"];
            $final_performance_2 = $row_final["final_performance_2"];
            $final_written_test = $row_final["final_written_test"];

            $final_prediction = $row_final["final_prediction"];


            // new line of condition
            if (
              $final_output_1 <= 0 && $final_output_2 <= 0 &&
              $final_performance_1 <= 0 && $final_performance_2 <= 0 &&
              $final_written_test <= 0
            ) {

              if ($final_prediction > 0) {
                $final_prediction = $row_final["final_prediction"];
                $confirm_final_prediction = $final_prediction;
                $final_grade = 0;
              } else {
                $final_grade = 0;
                $final_prediction = 0;
              }
            } else {

              $final_output_total_score = $final_output_1 + $final_output_2;
              $final_output_base = $final_output_total_score / 40 * 40 + 60;
              $final_output_weight = $final_output_base * 0.40;
              $final_performance_total_score = $final_performance_1 + $final_performance_2;
              $final_performance_base = $final_performance_total_score / 40 * 40 + 60;
              $final_performance_weight = $final_performance_base * 0.40;
              $final_written_test_base = $final_written_test / 70 * 40 + 60;
              $final_written_test_weight = $final_written_test_base * 0.20;
              $final_4th_quarter = $final_output_weight + $final_performance_weight + $final_written_test_weight;
              $final_grade = $prefinal_grade * 0.3 + $final_4th_quarter * 0.7;

              $final_grade = number_format((float)$final_grade, 2, ".", "");
            }




            $average_prediction = 0;

            $average = "";

            $prelim_status = 0;
            $prelim_status_missed = "";

            $midterm_status = 0;
            $midterm_status_missed = "";

            $prefinal_status = 0;
            $prefinal_status_missed = "";

            $final_status = 0;
            $final_status_missed = "";
            $finalCheck = 0;

            $equivalent = $row_final["equivalent"];

            if ($prelim_output_1 == 0) {
              $prelim_status++;
              $prelim_status_missed .= "Prelim Output 1 </br>";
            }

            if ($prelim_output_2 == 0) {
              $prelim_status++;
              $prelim_status_missed .= "Prelim Output 2 </br>";
            }

            if ($prelim_performance_1 == 0) {
              $prelim_status++;
              $prelim_status_missed .= "Prelim Performance 1 </br>";
            }

            if ($prelim_performance_2 == 0) {
              $prelim_status++;
              $prelim_status_missed .= "Prelim Performance 2 </br>";
            }

            if ($prelim_written_test == 0) {
              $prelim_status++;
              $prelim_status_missed .= "Prelim Written Test </br>";
            }



            if ($midterm_output_1 == 0) {
              $midterm_status += 1;
              $midterm_status_missed .= "Midterm Output 1 </br>";
            }

            if ($midterm_output_2 == 0) {
              $midterm_status += 1;
              $midterm_status_missed .= "Midterm Output 2 </br>";
            }

            if ($midterm_performance_1 == 0) {
              $midterm_status += 1;
              $midterm_status_missed .= "Midterm Performance 1 </br>";
            }

            if ($midterm_performance_2 == 0) {
              $midterm_status += 1;
              $midterm_status_missed .= "Midterm Performance 2 </br>";
            }

            if ($midterm_written_test == 0) {
              $midterm_status += 1;
              $midterm_status_missed .= "Midterm Written Test </br>";
            }


            if ($prefinal_output_1 == 0) {
              $prefinal_status += 1;
              $prefinal_status_missed .= "Prefinal Output 1 </br>";
            }

            if ($prefinal_output_2 == 0) {
              $prefinal_status += 1;
              $prefinal_status_missed .= "Prefinal Output 2 </br>";
            }

            if ($prefinal_performance_1 == 0) {
              $prefinal_status += 1;
              $prefinal_status_missed .= "Prefinal Performance 1 </br>";
            }

            if ($prefinal_performance_2 == 0) {
              $prefinal_status += 1;
              $prefinal_status_missed .= "Prefinal Performance 2 </br>";
            }

            if ($prefinal_written_test == 0) {
              $prefinal_status += 1;
              $prefinal_status_missed .= "Prefinal Written Test </br>";
            }


            if ($final_output_1 == 0) {
              $final_status += 1;
              $final_status_missed .= "final Output 1 </br>";
            }

            if ($final_output_2 == 0) {
              $final_status += 1;
              $final_status_missed .= "final Output 2 </br>";
            }

            if ($final_performance_1 == 0) {
              $final_status += 1;
              $final_status_missed .= "final Performance 1 </br>";
            }

            if ($final_performance_2 == 0) {
              $final_status += 1;
              $final_status_missed .= "final Performance 2 </br>";
            }

            if ($final_written_test == 0) {
              $final_status += 1;
              $final_status_missed .= "final Written Test </br>";
            }

          ?>

            <tr class="text-center">
              <td><?php echo $student_name; ?></td>


              <td id="get_prelim">
                <?php
                if ($prelim_grade > 0) {
                  if ($prelim_status > 0) {
                    echo $prelim_grade . " <sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#prelim$student_no'><b>$prelim_status</b><sup>";
                  } else {
                    echo $prelim_grade;
                  }
                } else {
                  echo $prelim_grade;
                }
                ?>
              </td>


              <td id="get_midterm">
                <?php
                if ($midterm_grade > 0) {
                  if ($midterm_status > 0) {
                    echo $midterm_grade . " <sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#midterm$student_no'><b>$midterm_status</b><sup>";
                  } else {
                    echo $midterm_grade;
                  }
                } else {
                  echo $midterm_grade;
                }
                ?>
              </td>


              <td><span id="get_prefinal">
                  <?php
                  if ($prefinal_grade > 0) {
                    if ($prefinal_status > 0) {
                      echo $prefinal_grade . " <sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#prefinal$student_no'><b>$prefinal_status</b><sup>";
                    } else {
                      echo $prefinal_grade;
                    }
                  } else {

                    if ($prefinal_prediction > 0) {


                      echo "<h6><sup class='badge badge-warning'>Prediction</sup><br/>" . $prefinal_prediction . "</h6>";
                    } elseif ($prefinal_prediction == "") {
                      // check if prefinal prediction if empty (if value == 1, prefinal predition is empty)
                      if (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_prediction == "") && ($final_prediction == "")) {
                        $prefinalCheck = 1;

                        echo "<h6><sup class='badge badge-warning'>Prediction</sup><br/>" . $prefinal_prediction . "</h6>";
                      } else {
                        echo $prefinal_grade;
                      }
                    }
                  }
                  ?>
                  <input type="hidden" id="finalCheck<?php echo $student_no; ?>" value="<?php echo $finalCheck; ?>">
                </span>
                <?php
                ?>
              </td>


              <td><span id="get_final">
                  <?php
                  if ($final_grade > 0) {
                    if ($final_status > 0) {
                      echo $final_grade . " <sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#final$student_no'><b>$final_status</b><sup>";
                    } else {
                      echo $final_grade;
                    }
                  } else {
                    if ($final_prediction > 0) {


                      echo "<h6><sup class='badge badge-warning'>Prediction</sup><br/>" . $final_prediction . "</h6>";
                    } elseif ($final_prediction == "") {
                      // check if prefinal prediction if empty (if value == 1, prefinal predition is empty)
                      if (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_prediction == "") && ($final_prediction == "")) {
                        $finalCheck = 1;
                        // if ($equivalentCheck == 1) {
                        // echo $equivalentCheck;
                        echo "<h6><sup class='badge badge-warning'>Prediction</sup><br/>" . $final_prediction . "</h6>";
                        // }
                      } else {
                        echo $final_grade;
                      }
                    }
                  }
                  ?>
                </span>
                <input type="hidden" id="finalCheck<?php echo $student_no; ?>" value="<?php echo $finalCheck; ?>">
                <?php
                ?>
              </td>


              <td>
                <?php
                if ((floatval($prelim_grade) > 0) && (floatval($midterm_grade) > 0) && (floatval($prefinal_grade) > 0) && (floatval($final_grade) > 0)) {

                  $average = floatval($prelim_grade) + floatval($midterm_grade) + floatval($prefinal_grade) + floatval($final_grade);
                  echo "<h6>" . round(($average / 4), 2) . "</h6>";
                } elseif ((floatval($prelim_grade) > 0) && (floatval($midterm_grade) > 0) && (floatval($prefinal_grade) > 0) && (floatval($final_grade) == 0)) {

                  if ($final_prediction == "") {
                  } else {
                    $average =  floatval($prelim_grade) + floatval($midterm_grade) + floatval($prefinal_grade) + (floatval($prefinal_grade) * 0.3) + (floatval($final_prediction) * 0.7);
                    echo "<h6>" . round(($average / 4), 2) . "</h6>";
                  }
                } elseif ((floatval($prelim_grade) > 0) && (floatval($midterm_grade) > 0) && (floatval($prefinal_grade) == 0) && (floatval($final_grade) == 0)) {

                  if ($prefinal_prediction == "" && $final_prediction == "") {
                  } else {
                    $average = floatval($prelim_grade) + floatval($midterm_grade) + ((floatval($midterm_grade) * 0.30) + (floatval($prefinal_prediction) * 0.70)) + ((floatval($prefinal_prediction) * 0.30) + floatval($final_prediction) * 0.7);
                    echo "<h6>" . round(($average / 4), 2) . "</h6>";
                  }
                }
                ?>
              </td>
              <td>
                <?php
                if (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_grade > 0) && ($final_grade > 0)) {
                  // $equivalent = generateRandomEquivalent();
                  $average = (floatval($prelim_grade) + floatval($midterm_grade) + floatval($prefinal_grade) + floatval($final_grade)) / 4;
                  switch (true) {
                      // case ($average <= 74.4):
                      //     $equivalent = "5";
                      //     break;
                    case ($average >= 74.5 && $average <= 76.49):
                      $equivalent = "3";
                      break;
                    case ($average >= 76.5 && $average <= 79.49):
                      $equivalent = "2.75";
                      break;
                    case ($average >= 79.5 && $average <= 82.49):
                      $equivalent = "2.5";
                      break;
                    case ($average >= 82.5 && $average <= 85.49):
                      $equivalent = "2.25";
                      break;
                    case ($average >= 85.5 && $average <= 88.49):
                      $equivalent = "2";
                      break;
                    case ($average >= 88.5 && $average <= 91.49):
                      $equivalent = "1.75";
                      break;
                    case ($average >= 91.5 && $average <= 94.49):
                      $equivalent = "1.5";
                      break;
                    case ($average >= 94.5 && $average <= 97.49):
                      $equivalent = "1.25";
                      break;
                    case ($average >= 97.5 && $average <= 100):
                      $equivalent = "1";
                      break;

                    default:
                      $equivalent = "---";
                  }

                  if ($average > 0 && $average <= 74.4) {
                    $equivalent = "5";
                  }

                  echo $equivalent;
                } else {
                  if ($equivalent == "") {

                    if (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_grade > 0) && ($final_prediction > 0)) {
                      $average = (floatval($prelim_grade) + floatval($midterm_grade) + floatval($prefinal_grade) + floatval($final_prediction)) / 4;
                      switch (true) {

                        case ($average >= 74.5 && $average <= 76.49):
                          $equivalent = "3";
                          break;
                        case ($average >= 76.5 && $average <= 79.49):
                          $equivalent = "2.75";
                          break;
                        case ($average >= 79.5 && $average <= 82.49):
                          $equivalent = "2.5";
                          break;
                        case ($average >= 82.5 && $average <= 85.49):
                          $equivalent = "2.25";
                          break;
                        case ($average >= 85.5 && $average <= 88.49):
                          $equivalent = "2";
                          break;
                        case ($average >= 88.5 && $average <= 91.49):
                          $equivalent = "1.75";
                          break;
                        case ($average >= 91.5 && $average <= 94.49):
                          $equivalent = "1.5";
                          break;
                        case ($average >= 94.5 && $average <= 97.49):
                          $equivalent = "1.25";
                          break;
                        case ($average >= 97.5 && $average <= 100):
                          $equivalent = "1";
                          break;

                        default:
                          $equivalent = "---";
                      }

                      if ($average > 0 && $average <= 74.4) {
                        $equivalent = "5";
                      }
                      echo "<h6>" . $equivalent . "</h6>";
                    } elseif (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_grade > 0) && ($final_prediction == "")) {
                      $average = (floatval($prelim_grade) + floatval($midterm_grade) + floatval($prefinal_grade) + floatval($final_prediction)) / 4;
                      switch (true) {

                        case ($average >= 74.5 && $average <= 76.49):
                          $equivalent = "3";
                          break;
                        case ($average >= 76.5 && $average <= 79.49):
                          $equivalent = "2.75";
                          break;
                        case ($average >= 79.5 && $average <= 82.49):
                          $equivalent = "2.5";
                          break;
                        case ($average >= 82.5 && $average <= 85.49):
                          $equivalent = "2.25";
                          break;
                        case ($average >= 85.5 && $average <= 88.49):
                          $equivalent = "2";
                          break;
                        case ($average >= 88.5 && $average <= 91.49):
                          $equivalent = "1.75";
                          break;
                        case ($average >= 91.5 && $average <= 94.49):
                          $equivalent = "1.5";
                          break;
                        case ($average >= 94.5 && $average <= 97.49):
                          $equivalent = "1.25";
                          break;
                        case ($average >= 97.5 && $average <= 100):
                          $equivalent = "1";
                          break;

                        default:
                          $equivalent = "---";
                      }

                      if ($average > 0 && $average <= 74.4) {
                        $equivalent = "5";
                      }
                      echo "<h6>" . $equivalent . "</h6>";
                    } elseif (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_prediction > 0) && ($final_prediction > 0)) {
                      $average = (floatval($prelim_grade) + floatval($midterm_grade) + floatval($prefinal_prediction) + floatval($final_prediction)) / 4;

                      switch (true) {

                        case ($average >= 74.5 && $average <= 76.49):
                          $equivalent = "3";
                          break;
                        case ($average >= 76.5 && $average <= 79.49):
                          $equivalent = "2.75";
                          break;
                        case ($average >= 79.5 && $average <= 82.49):
                          $equivalent = "2.5";
                          break;
                        case ($average >= 82.5 && $average <= 85.49):
                          $equivalent = "2.25";
                          break;
                        case ($average >= 85.5 && $average <= 88.49):
                          $equivalent = "2";
                          break;
                        case ($average >= 88.5 && $average <= 91.49):
                          $equivalent = "1.75";
                          break;
                        case ($average >= 91.5 && $average <= 94.49):
                          $equivalent = "1.5";
                          break;
                        case ($average >= 94.5 && $average <= 97.49):
                          $equivalent = "1.25";
                          break;
                        case ($average >= 97.5 && $average <= 100):
                          $equivalent = "1";
                          break;

                        default:
                          $equivalent = "---";
                      }

                      if ($average > 0 && $average <= 74.4) {
                        $equivalent = "5";
                      }

                      echo "<h6>" . $equivalent . "</h6>";
                    } elseif (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_prediction == "") && ($final_prediction == "")) {
                      $average = (floatval($prelim_grade) + floatval($midterm_grade) + floatval($prefinal_prediction) + floatval($final_prediction)) / 4;
                      switch (true) {

                        case ($average >= 74.5 && $average <= 76.49):
                          $equivalent = "3";
                          break;
                        case ($average >= 76.5 && $average <= 79.49):
                          $equivalent = "2.75";
                          break;
                        case ($average >= 79.5 && $average <= 82.49):
                          $equivalent = "2.5";
                          break;
                        case ($average >= 82.5 && $average <= 85.49):
                          $equivalent = "2.25";
                          break;
                        case ($average >= 85.5 && $average <= 88.49):
                          $equivalent = "2";
                          break;
                        case ($average >= 88.5 && $average <= 91.49):
                          $equivalent = "1.75";
                          break;
                        case ($average >= 91.5 && $average <= 94.49):
                          $equivalent = "1.5";
                          break;
                        case ($average >= 94.5 && $average <= 97.49):
                          $equivalent = "1.25";
                          break;
                        case ($average >= 97.5 && $average <= 100):
                          $equivalent = "1";
                          break;

                        default:
                          $equivalent = "---";
                      }

                      if ($average > 0 && $average <= 74.4) {
                        $equivalent = "5";
                      }
                      $equivalentCheck = 1;
                      echo "<h6 id='prefinal_final_empty_equiv$student_no'>" . $equivalent . "</h6>";
                    }
                  } else {
                    switch (true) {

                      case ($average >= 74.5 && $average <= 76.49):
                        $equivalent = "3";
                        break;
                      case ($average >= 76.5 && $average <= 79.49):
                        $equivalent = "2.75";
                        break;
                      case ($average >= 79.5 && $average <= 82.49):
                        $equivalent = "2.5";
                        break;
                      case ($average >= 82.5 && $average <= 85.49):
                        $equivalent = "2.25";
                        break;
                      case ($average >= 85.5 && $average <= 88.49):
                        $equivalent = "2";
                        break;
                      case ($average >= 88.5 && $average <= 91.49):
                        $equivalent = "1.75";
                        break;
                      case ($average >= 91.5 && $average <= 94.49):
                        $equivalent = "1.5";
                        break;
                      case ($average >= 94.5 && $average <= 97.49):
                        $equivalent = "1.25";
                        break;
                      case ($average >= 97.5 && $average <= 100):
                        $equivalent = "1";
                        break;

                      default:
                        $equivalent = "---";
                    }

                    if ($average > 0 && $average <= 74.4) {
                      $equivalent = "5";
                    }
                    echo "<h6 id='prefinal_final_not_empty_equiv$student_no'>" . $equivalent . "</h6>";
                  }
                }
                ?>
              </td>

              <td>
                <?php
                if ($equivalent > 0 && $equivalent <= 3) {
                  $remarks = "Passed";
                  echo "<h6 class='passed remarks'>" . $remarks . "</h6>";
                } elseif ($equivalent == 5) {
                  $remarks = "Failed";
                  echo "<h6 class='failed remarks'>" . $remarks . "</h6>";
                } else {
                  $remarks = "---";
                  echo $remarks;
                }
                ?>
              </td>


            </tr>

            <td id="confirm_prefinal_prediction" class="bg-white d-none"><?php if ($prefinal_prediction > 0) {
                                                                            echo $confirm_prefinal_prediction;
                                                                          } else {
                                                                            echo $confirm_prefinal_prediction;
                                                                          } ?></td>
            <td id="confirm_final_prediction" class="bg-white d-none"><?php if ($final_prediction > 0) {
                                                                        echo $confirm_final_prediction;
                                                                      } else {
                                                                        echo $confirm_final_prediction;
                                                                      } ?></td>

            <!-- The Prelim Modal -->
            <div class="modal" id="<?php echo "prelim" . $student_no; ?>">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header bg-success text-white">
                    <h4 class="modal-title"><?php echo $student_name; ?></h4>
                    <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">
                    <h3 class="text-danger">Defeciencies:</h3>
                    <?php echo $prelim_status_missed; ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer bg-success">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>



            <!-- The Midterm Modal -->
            <div class="modal" id="<?php echo "midterm" . $student_no; ?>">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title"><?php echo $student_name; ?></h4>
                    <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">
                    <h3 class="text-danger">Defeciencies:</h3>
                    <?php echo $midterm_status_missed; ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-warning text-white" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>


            <!-- The Prefinal Modal -->
            <div class="modal" id="<?php echo "prefinal" . $student_no; ?>">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header bg-danger text-white">
                    <h4 class="modal-title"><?php echo $student_name; ?></h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">
                    <h3 class="text-danger">Defeciencies:</h3>
                    <?php echo $prefinal_status_missed; ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer bg-danger">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>


            <!-- The final Modal -->
            <div class="modal" id="<?php echo "final" . $student_no; ?>">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header bg-warning">
                    <h4 class="modal-title text-white"><?php echo $student_name; ?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">
                    <h3 class="text-danger">Defeciencies:</h3>
                    <?php echo $final_status_missed; ?>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer bg-warning">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>


          <?php
            // }
          }
          ?>

      </table>
    </div>

    <input type="hidden" id="prefinal_grade" value="<?php echo $prefinal_grade; ?>">
    <input type="hidden" id="final_grade" value="<?php echo $final_grade; ?>">


  <?php


  } else {
  ?>
    <br>
    <br>
    <br>
    <h3 class="text-center text-danger">Pre-requisite subject: IT 2 - Application Programming 1</h3>
    <br>
    <br>
    <br>
    <br>
    <br>
  <?php
  }
} else {

  ?>
  <!-- <div class="black p-5 fixed-top"> -->
  <input type="hidden" id="get_student_no" value="<?php echo $student_no; ?>">

  <input type="hidden" id="get_semester" value="<?php if (isset($_GET["s_"])) {
                                                  echo $_GET["s_"];
                                                } else {
                                                  echo "1";
                                                } ?>">

  <div class="table-responsive table_table mt-3 col-10 container-fluid">
    <table border="1" class="table table-hover">
      <thead>
        <tr>
          <th class="px-3 text-center bg-info text-white" colspan="9">My Grade</th>
        </tr><!-- Preliminary Here -->

        <tr class="text-center">
          <th class="px-3 bg-white">Student Name</th>
          <th class="px-3" style="background-color: #b1fbc4;">Prelim</th>
          <th class="px-3" style="background-color: #cdddfe;">Midterm</th>
          <th class="px-3" style="background-color: #ffb3b3;" id="prefinal_student_predict">Prefinal</th>
          <th class="px-3" style="background-color: #ffffcc;" id="final_student_predict">Final</th>
          <th class="px-3 bg-secondary text-white" id="average">Average</th>
          <th class="px-3 bg-secondary text-white" id="average">Equivalent</th>
          <th class="px-3 bg-secondary text-white" id="remarks">Remarks</th>
          <!-- <th class="px-3 bg-dark text-white" id="prediction">Prediction<sup class='badge badge-warning'>Prediction</sup></th> -->
        </tr>

      </thead>

      <tbody>

        <?php



        $prelim = "prelim$semester_no";
        $midterm = "midterm$semester_no";
        $prefinal = "prefinal$semester_no";
        $final = "final$semester_no";
        $prelim_qry = mysqli_query($connections, "SELECT * FROM $prelim WHERE student_no='$student_no' ");
        $midterm_qry = mysqli_query($connections, "SELECT * FROM $midterm WHERE student_no='$student_no' ");
        $prefinal_qry = mysqli_query($connections, "SELECT * FROM $prefinal WHERE student_no='$student_no' ");
        $final_qry = mysqli_query($connections, "SELECT * FROM $final WHERE student_no='$student_no' ");

        while ($row_prelim = mysqli_fetch_assoc($prelim_qry)) {


          $row_midterm = mysqli_fetch_assoc($midterm_qry);
          $row_prefinal = mysqli_fetch_assoc($prefinal_qry);
          $row_final = mysqli_fetch_assoc($final_qry);



          $prelim_output_1 = $row_prelim['prelim_output_1'];
          $prelim_output_2 = $row_prelim['prelim_output_2'];
          $prelim_performance_1 = $row_prelim['prelim_performance_1'];
          $prelim_performance_2 = $row_prelim['prelim_performance_2'];
          $prelim_written_test = $row_prelim['prelim_written_test'];

          if (
            $prelim_output_1 == 0 && $prelim_output_2 == 0 &&
            $prelim_performance_1 == 0 && $prelim_performance_1 == 0 &&
            $prelim_written_test == 0
          ) {

            $prelim_grade = 0;
          } else {

            $prelim_output_total_score = $prelim_output_1 + $prelim_output_2;
            $prelim_performance_total_score = $prelim_performance_1 + $prelim_performance_2;

            $prelim_output_base = $prelim_output_total_score / 40 * 40 + 60;
            $prelim_performance_base = $prelim_performance_total_score / 40 * 40 + 60;
            $prelim_written_test_base =  $prelim_written_test / 70 * 40 + 60;

            $prelim_output_weight = $prelim_output_base * 0.40;
            $prelim_performance_weight = $prelim_performance_base * 0.40;
            $prelim_written_test_weight = $prelim_written_test_base * 0.20;

            $prelim_grade = $prelim_output_weight + $prelim_performance_weight + $prelim_written_test_weight;

            $prelim_grade = number_format((float)$prelim_grade, 2, ".", "");
          }

          $midterm_output_1 = $row_midterm["midterm_output_1"];
          $midterm_output_2 = $row_midterm["midterm_output_2"];
          $midterm_performance_1 = $row_midterm["midterm_performance_1"];
          $midterm_performance_2 = $row_midterm["midterm_performance_2"];
          $midterm_written_test = $row_midterm["midterm_written_test"];

          if (
            $midterm_output_1 == 0 && $midterm_output_2 == 0 &&
            $midterm_performance_1 == 0 && $midterm_performance_1 == 0 &&
            $midterm_written_test == 0
          ) {

            $midterm_grade = 0;
          } else {

            $midterm_output_total_score = $midterm_output_1 + $midterm_output_2;
            $midterm_output_base = $midterm_output_total_score / 40 * 40 + 60;
            $midterm_output_weight = $midterm_output_base * 0.40;


            $midterm_performance_total_score = $midterm_performance_1 + $midterm_performance_2;
            $midterm_performance_base = $midterm_performance_total_score / 40 * 40 + 60;
            $midterm_written_test_base = $midterm_written_test / 70 * 40 + 60;
            $midterm_performance_weight = $midterm_performance_base * 0.40;
            $midterm_written_test_weight = $midterm_written_test_base * 0.20;
            $midterm_2nd_quarter = $midterm_output_weight + $midterm_performance_weight + $midterm_written_test_weight;

            $midterm_output_weight = $midterm_output_base * 0.40;
            $midterm_performance_weight = $midterm_performance_base * 0.40;
            $midterm_written_test_weight = $midterm_written_test_base * 0.20;
            $midterm_grade = $prelim_grade * 0.3 + $midterm_2nd_quarter * 0.7;

            $midterm_grade = number_format((float)$midterm_grade, 2, ".", "");
          }


          $prefinal_output_1 = $row_prefinal["prefinal_output_1"]; //ok
          $prefinal_output_2 = $row_prefinal["prefinal_output_2"]; //ok
          $prefinal_performance_1 = $row_prefinal["prefinal_performance_1"]; //ok
          $prefinal_performance_2 = $row_prefinal["prefinal_performance_2"]; //ok
          $prefinal_written_test = $row_prefinal["prefinal_written_test"]; //ok

          $prefinal_prediction = $row_prefinal["prefinal_prediction"];


          // new line of condition
          if (
            $prefinal_output_1 <= 0 && $prefinal_output_2 <= 0 &&
            $prefinal_performance_1 <= 0 && $prefinal_performance_2 <= 0 &&
            $prefinal_written_test <= 0
          ) {

            if ($prefinal_prediction > 0) {
              $prefinal_prediction = $row_prefinal["prefinal_prediction"];
              $confirm_prefinal_prediction = $prefinal_prediction;
              $prefinal_grade = 0;
            } else {
              $prefinal_grade = 0;
              $prefinal_prediction = 0;
            }
          } else {

            $prefinal_output_total_score = $prefinal_output_1 + $prefinal_output_2; //ok
            $prefinal_performance_total_score = $prefinal_performance_1 + $prefinal_performance_2; //ok

            $prefinal_output_base = $prefinal_output_total_score / 40 * 40 + 60; //ok
            $prefinal_performance_base = $prefinal_performance_total_score / 40 * 40 + 60; //ok
            $prefinal_written_test_base = $prefinal_written_test / 70 * 40 + 60; //ok

            $prefinal_output_weight = $prefinal_output_base * 0.40; //ok
            $prefinal_performance_weight = $prefinal_performance_base * 0.40; //ok
            $prefinal_written_test_weight = $prefinal_written_test_base * 0.20; //ok

            $prefinal_3rd_quarter = $prefinal_output_weight + $prefinal_performance_weight + $prefinal_written_test_weight; //ok
            $prefinal_grade = $midterm_grade * 0.3 + $prefinal_3rd_quarter * 0.7;

            $prefinal_grade = number_format((float)$prefinal_grade, 2, ".", "");
          }


          $final_output_1 = $row_final["final_output_1"];
          $final_output_2 = $row_final["final_output_2"];
          $final_performance_1 = $row_final["final_performance_1"];
          $final_performance_2 = $row_final["final_performance_2"];
          $final_written_test = $row_final["final_written_test"];

          $final_prediction = $row_final["final_prediction"];

          // new line of condition
          if (
            $final_output_1 <= 0 && $final_output_2 <= 0 &&
            $final_performance_1 <= 0 && $final_performance_2 <= 0 &&
            $final_written_test <= 0
          ) {

            if ($final_prediction > 0) {
              $final_prediction = $row_final["final_prediction"];
              $confirm_final_prediction = $final_prediction;
              $final_grade = 0;
            } else {
              $final_grade = 0;
              $final_prediction = 0;
            }
          } else {

            $final_output_total_score = $final_output_1 + $final_output_2;
            $final_output_base = $final_output_total_score / 40 * 40 + 60;
            $final_output_weight = $final_output_base * 0.40;
            $final_performance_total_score = $final_performance_1 + $final_performance_2;
            $final_performance_base = $final_performance_total_score / 40 * 40 + 60;
            $final_performance_weight = $final_performance_base * 0.40;
            $final_written_test_base = $final_written_test / 70 * 40 + 60;
            $final_written_test_weight = $final_written_test_base * 0.20;
            $final_4th_quarter = $final_output_weight + $final_performance_weight + $final_written_test_weight;
            $final_grade = $prefinal_grade * 0.3 + $final_4th_quarter * 0.7;

            $final_grade = number_format((float)$final_grade, 2, ".", "");
          }




          $average_prediction = 0;

          $average = "";

          $prelim_status = 0;
          $prelim_status_missed = "";

          $midterm_status = 0;
          $midterm_status_missed = "";

          $prefinal_status = 0;
          $prefinal_status_missed = "";

          $final_status = 0;
          $final_status_missed = "";

          if ($prelim_output_1 == 0) {
            $prelim_status++;
            $prelim_status_missed .= "Prelim Output 1 </br>";
          }

          if ($prelim_output_2 == 0) {
            $prelim_status++;
            $prelim_status_missed .= "Prelim Output 2 </br>";
          }

          if ($prelim_performance_1 == 0) {
            $prelim_status++;
            $prelim_status_missed .= "Prelim Performance 1 </br>";
          }

          if ($prelim_performance_2 == 0) {
            $prelim_status++;
            $prelim_status_missed .= "Prelim Performance 2 </br>";
          }

          if ($prelim_written_test == 0) {
            $prelim_status++;
            $prelim_status_missed .= "Prelim Written Test </br>";
          }



          if ($midterm_output_1 == 0) {
            $midterm_status += 1;
            $midterm_status_missed .= "Midterm Output 1 </br>";
          }

          if ($midterm_output_2 == 0) {
            $midterm_status += 1;
            $midterm_status_missed .= "Midterm Output 2 </br>";
          }

          if ($midterm_performance_1 == 0) {
            $midterm_status += 1;
            $midterm_status_missed .= "Midterm Performance 1 </br>";
          }

          if ($midterm_performance_2 == 0) {
            $midterm_status += 1;
            $midterm_status_missed .= "Midterm Performance 2 </br>";
          }

          if ($midterm_written_test == 0) {
            $midterm_status += 1;
            $midterm_status_missed .= "Midterm Written Test </br>";
          }


          if ($prefinal_output_1 == 0) {
            $prefinal_status += 1;
            $prefinal_status_missed .= "Prefinal Output 1 </br>";
          }

          if ($prefinal_output_2 == 0) {
            $prefinal_status += 1;
            $prefinal_status_missed .= "Prefinal Output 2 </br>";
          }

          if ($prefinal_performance_1 == 0) {
            $prefinal_status += 1;
            $prefinal_status_missed .= "Prefinal Performance 1 </br>";
          }

          if ($prefinal_performance_2 == 0) {
            $prefinal_status += 1;
            $prefinal_status_missed .= "Prefinal Performance 2 </br>";
          }

          if ($prefinal_written_test == 0) {
            $prefinal_status += 1;
            $prefinal_status_missed .= "Prefinal Written Test </br>";
          }


          if ($final_output_1 == 0) {
            $final_status += 1;
            $final_status_missed .= "final Output 1 </br>";
          }

          if ($final_output_2 == 0) {
            $final_status += 1;
            $final_status_missed .= "final Output 2 </br>";
          }

          if ($final_performance_1 == 0) {
            $final_status += 1;
            $final_status_missed .= "final Performance 1 </br>";
          }

          if ($final_performance_2 == 0) {
            $final_status += 1;
            $final_status_missed .= "final Performance 2 </br>";
          }

          if ($final_written_test == 0) {
            $final_status += 1;
            $final_status_missed .= "final Written Test </br>";
          }

        ?>

          <tr class="text-center">
            <td><?php echo $student_name; ?></td>


            <td id="get_prelim">
              <?php
              if ($prelim_grade > 0) {
                if ($prelim_status > 0) {
                  echo $prelim_grade . " <sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#prelim$student_no'><b>$prelim_status</b><sup>";
                } else {
                  echo $prelim_grade;
                }
              } else {
                echo $prelim_grade;
              }
              ?>
            </td>


            <td id="get_midterm">
              <?php
              if ($midterm_grade > 0) {
                if ($midterm_status > 0) {
                  echo $midterm_grade . " <sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#midterm$student_no'><b>$midterm_status</b><sup>";
                } else {
                  echo $midterm_grade;
                }
              } else {
                echo $midterm_grade;
              }
              ?>
            </td>


            <td><span id="get_prefinal">
                <?php
                if ($prefinal_grade > 0) {
                  if ($prefinal_status > 0) {
                    echo $prefinal_grade . " <sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#prefinal$student_no'><b>$prefinal_status</b><sup>";
                  } else {
                    echo $prefinal_grade;
                  }
                } else {
                  if ($prefinal_prediction > 0) {
                    echo "<h6>" . $prefinal_prediction . "</h6>";
                  }
                }
                ?>
              </span><input type="text" id="prefinal_grade_prediction" class="text-center col-5 container-fluid" disabled>
              <?php
              ?>
            </td>


            <td><span id="get_final">
                <?php
                if ($final_grade > 0) {
                  if ($final_status > 0) {
                    echo $final_grade . " <sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#final$student_no'><b>$final_status</b><sup>";
                  } else {
                    echo $final_grade;
                  }
                } else {
                  if ($final_prediction > 0) {
                    echo "<h6>" . $final_prediction . "</h6>";
                  }
                }
                ?>
              </span><input type="text" id="final_grade_prediction" class="text-center col-5 container-fluid" disabled>
              <?php
              ?>
            </td>


            <td>
              <?php

              if ($final_grade > 0) {
                $average = $final_grade;

                echo $final_grade;
                // }
              } else {
                if ($final_prediction > 0) {
                  $average = $final_prediction;
                  echo "<h6>" . $final_prediction . "</h6>";
                }
              }
              ?>
            </td>
            <td>
              <?php

              switch (true) {

                case ($average >= 74.5 && $average <= 76.49):
                  $equivalent = "3";
                  break;
                case ($average >= 76.5 && $average <= 79.49):
                  $equivalent = "2.75";
                  break;
                case ($average >= 79.5 && $average <= 82.49):
                  $equivalent = "2.5";
                  break;
                case ($average >= 82.5 && $average <= 85.49):
                  $equivalent = "2.25";
                  break;
                case ($average >= 85.5 && $average <= 88.49):
                  $equivalent = "2";
                  break;
                case ($average >= 88.5 && $average <= 91.49):
                  $equivalent = "1.75";
                  break;
                case ($average >= 91.5 && $average <= 94.49):
                  $equivalent = "1.5";
                  break;
                case ($average >= 94.5 && $average <= 97.49):
                  $equivalent = "1.25";
                  break;
                case ($average >= 97.5 && $average <= 100):
                  $equivalent = "1";
                  break;

                default:
                  $equivalent = "---";
              }

              if ($average > 0 && $average <= 74.4) {
                $equivalent = "5";
              }


              if (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_grade > 0) && ($final_grade > 0)) {
                echo $equivalent;
              } else {
                if (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_prediction > 0) && ($final_prediction > 0)) {
                  echo "<h6>" . $equivalent . "</h6>";
                } elseif (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_grade > 0) && ($final_prediction > 0)) {
                  // $average = ($prelim_grade + $midterm_grade + $prefinal_grade + $final_prediction) / 4;
                  echo "<h6>" . $equivalent . "</h6>";
                }
              }
              ?>
            </td>

            <td>
              <?php
              if ($equivalent > 0 && $equivalent <= 3) {
                $remarks = "Passed";
                echo "<h6 class='passed remarks'>" . $remarks . "</h6>";
              } elseif ($equivalent == 5) {
                $remarks = "Failed";
                echo "<h6 class='failed remarks'>" . $remarks . "</h6>";
              } else {
                $remarks = "---";
                echo $remarks;
              }
              ?>
            </td>

          </tr>

          <td id="confirm_prefinal_prediction" class="bg-white d-none"><?php if ($prefinal_prediction > 0) {
                                                                          echo $confirm_prefinal_prediction;
                                                                        } else {
                                                                          echo $confirm_prefinal_prediction;
                                                                        } ?></td>
          <td id="confirm_final_prediction" class="bg-white d-none"><?php if ($final_prediction > 0) {
                                                                      echo $confirm_final_prediction;
                                                                    } else {
                                                                      echo $confirm_final_prediction;
                                                                    } ?></td>
          <!-- <td id="average_prediction"><?php echo $average_prediction; ?></td> -->
          <!-- </tr> -->



        <?php
          // }
        }
        ?>

    </table>
  </div>

  <input type="hidden" id="prefinal_grade" value="<?php echo $prefinal_grade; ?>">
  <input type="hidden" id="final_grade" value="<?php echo $final_grade; ?>">



  <!-- The Prelim Modal -->
  <div class="modal" id="<?php echo "prelim" . $student_no; ?>">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-success text-white">
          <h4 class="modal-title"><?php echo $student_name; ?></h4>
          <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <h3 class="text-danger">Defeciencies:</h3>
          <?php echo $prelim_status_missed; ?>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer bg-success">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>



  <!-- The Midterm Modal -->
  <div class="modal" id="<?php echo "midterm" . $student_no; ?>">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title"><?php echo $student_name; ?></h4>
          <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <h3 class="text-danger">Defeciencies:</h3>
          <?php echo $midterm_status_missed; ?>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer bg-primary">
          <button type="button" class="btn btn-warning text-white" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>


  <!-- The Prefinal Modal -->
  <div class="modal" id="<?php echo "prefinal" . $student_no; ?>">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-danger text-white">
          <h4 class="modal-title"><?php echo $student_name; ?></h4>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <h3 class="text-danger">Defeciencies:</h3>
          <?php echo $prefinal_status_missed; ?>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer bg-danger">
          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>


  <!-- The final Modal -->
  <div class="modal" id="<?php echo "final" . $student_no; ?>">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-warning">
          <h4 class="modal-title text-white"><?php echo $student_name; ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <h3 class="text-danger">Defeciencies:</h3>
          <?php echo $final_status_missed; ?>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer bg-warning">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>


<?php
}
?>
<!-- ma remove it grade prediction kung di kaabot it 75 -->

<!-- <input type="text" id="final_grade_prediction">
<input type="text" id="prefinal_grade_prediction"> -->


<br>
<br>

<center>
  <?php
  include("grading_system.php");
  ?>
</center>

<script>
  var select_average = document.getElementById("average_predict");
  // alert(select_average[1].value);
  var select_prelim = parseFloat(document.getElementById("get_prelim").innerHTML);
  var select_midterm = parseFloat(document.getElementById("get_midterm").innerHTML);
  var select_prefinal = parseFloat(document.getElementById("get_prefinal").innerHTML);
  var select_prelim_and_midterm = select_prelim + select_midterm;


  var get_prelim_value = document.getElementById("get_prelim");
  var get_midterm_value = document.getElementById("get_midterm");
  var get_prefinal_value = document.getElementById("get_prefinal");
  var get_final_value = document.getElementById("get_final");

  var confirm_prefinal_prediction = document.getElementById("confirm_prefinal_prediction").innerHTML;
  var confirm_final_prediction = document.getElementById("confirm_final_prediction").innerHTML;

  var average_prediction = (parseFloat(get_prelim_value.innerHTML) + parseFloat(get_midterm_value.innerHTML) + parseFloat(confirm_prefinal_prediction) + parseFloat(confirm_final_prediction)) / 4;

  function semester() {

    var semester = document.getElementById("semester");
    var selected_semester = semester.options[semester.selectedIndex].value;

    window.location.href = "?s_=" + selected_semester;
    // alert("hay");
  }
</script>


<?php
include("../../bins/footer_non_fixed.php");
?>