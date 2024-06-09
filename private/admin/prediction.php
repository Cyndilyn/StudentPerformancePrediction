<?php
session_start();

include("../bins/connections.php");
include("../../bins/header.php");


if (isset($_SESSION["username"])) {

  $session_user = $_SESSION["username"];

  $query_info = mysqli_query($connections, "SELECT * FROM _user_tbl_ WHERE username='$session_user'");
  $my_info = mysqli_fetch_assoc($query_info);
  $account_type = $my_info["account_type"];

  if ($account_type != 1) {

    header('Location: ../../forbidden');
  }
} else {

  header('Location: ../../');
}

$year_qry = mysqli_query($connections, "SELECT DISTINCT year FROM _user_tbl_ WHERE account_type='2' ");


?>

<center>
  <h1 class="py-3 text-info px-1">Student Performance Prediction</h1>
</center>


<style>
  body {
    font-size: .8em;
  }

  .prediction {
    border: 1.5px solid white;
    border-radius: 6px;
  }


  #prefinal_grade_prediction {
    border: none;
    background-color: transparent;
  }

  #final_grade_prediction {
    border: none;
    background-color: transparent;
  }


  .table-hover tbody tr:hover {
    background: #e6e6e6;
    cursor: pointer;
  }

  .table-hover tbody h6,
  .predictColor {
    color: #007bff;
  }

  .table-hover tbody .passed {
    color: #28a745;
  }

  .table-hover tbody .failed {
    color: #dc3545;
  }

  td:hover {
    background-color: #b3e7ff;
    color: #000;
  }

  td:hover a {
    color: #fff;
  }

  td:hover h6 {
    color: #fff;
  }

  td:hover .remarks {
    color: #fff;
  }

  table tbody {
    display: block;
    max-height: 450px;
    overflow-y: scroll;
  }

  table thead,
  table tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
  }


  .long_specs {
    overflow: auto;
  }

  table tbody::-webkit-scrollbar {
    width: 3px;
  }

  table tbody::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  table tbody::-webkit-scrollbar-thumb {
    background: #81b7f5;
    border-radius: 2px;
  }

  table tbody::-webkit-scrollbar-thumb:hover {
    background: #2379db;
  }

  .table-no-padding td,
  .table-no-padding th {
    padding-top: 5px !important;
    padding-bottom: 5px !important;
  }

  th {
    font-weight: 500;
  }

  .small-select {
    width: 180px;
    font-size: 13px;
  }
</style>

<?php
include("../bins/admin_nav.php");
?>
<br>

<div class="container-fluid d-inline py-5">

  <select class="form-control col-2 ml-2 pt-1 pb-2 d-inline text-white text-white bg-info small-select" id="year" onchange="year()">
    <option value="select_year">Select Year</option>

    <?php
    while ($row_year = mysqli_fetch_assoc($year_qry)) {
      $year = $row_year["year"];
    ?>
      <option value='<?php echo $year; ?>' <?php if (isset($_GET['_y'])) {
                                              if ($_GET['_y'] == $year) {
                                                echo "selected";
                                              }
                                            } ?>>
      <?php
      echo $year;
    }
      ?>
      </option>
  </select>

  <select class="form-control col-2 ml-2 pt-1 pb-2 d-inline small-select <?php if (!isset($_GET['_y'])) {
                                                                            echo "bg-secondary";
                                                                          } else {
                                                                            if ($_GET['_y'] == "select_year") {
                                                                              echo "bg-secondary";
                                                                            } else {
                                                                              echo "bg-info";
                                                                            }
                                                                          } ?> text-white" <?php if (!isset($_GET['_y'])) {
                                                                                              echo "disabled";
                                                                                            } else {
                                                                                              if ($_GET['_y'] == "select_year") {
                                                                                                echo "disabled";
                                                                                              }
                                                                                            } ?> id="course" onchange="course()">
    <option value="select_course">Select Course</option>
    <option value="BSIT" <?php if (isset($_GET['_c'])) {
                            if ($_GET['_c'] == "BSIT") {
                              echo "selected";
                            }
                          } ?>>BSIT</option>
    <option value="BSCS" <?php if (isset($_GET['_c'])) {
                            if ($_GET['_c'] == "BSCS") {
                              echo "selected";
                            }
                          } ?>>BSCS</option>
  </select>

  <select class="form-control col-2 ml-2 pt-1 pb-2 d-inline small-select <?php if (!isset($_GET['_c'])) {
                                                                            echo "bg-secondary";
                                                                          } else {
                                                                            if ($_GET['_c'] == "select_semester") {
                                                                              echo "bg-secondary";
                                                                            } else {
                                                                              echo "bg-info";
                                                                            }
                                                                          } ?> text-white" <?php if (!isset($_GET['_c'])) {
                                                                                              echo "disabled";
                                                                                            } else {
                                                                                              if ($_GET['_c'] == "select_semester") {
                                                                                                echo "disabled";
                                                                                              }
                                                                                            } ?> id="semester" onchange="semester()">
    <option value="select_semester">Select Semester</option>
    <option value="sem1" <?php if (isset($_GET['_s_e_'])) {
                            if ($_GET['_s_e_'] == "sem1") {
                              echo "selected";
                            }
                          } ?>>1st Semester</option>
    <option value="sem2" <?php if (isset($_GET['_s_e_'])) {
                            if ($_GET['_s_e_'] == "sem2") {
                              echo "selected";
                            }
                          } ?>>2nd Semester</option>
  </select>

  &nbsp;
  <?php
  if (isset($_GET['_y']) && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
  ?>
    <a href="pdf_files_prediction?_y=<?php echo $_GET["_y"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
  <?php
  } else if (isset($_GET['_y']) && isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
  ?>
    <a href="pdf_files_prediction?_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
  <?php
  } else if (isset($_GET['_y']) && isset($_GET['_c']) && isset($_GET['_s_e_'])) {
  ?>
    <a href="pdf_files_prediction?_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
  <?php
  }
  ?>
</div>

<br>
<br>

<div>
  <h6 class="ml-3 d-inline"><b>Course Name</b>: <?php if (isset($_GET['_s_e_'])) {
                                                  if ($_GET['_s_e_'] == "sem1") {
                                                    echo "IT 2 - Application Programming 1";
                                                  } else if ($_GET['_s_e_'] == "sem2") {
                                                    echo "IT 5 - Application Programming 2";
                                                  } else {
                                                    echo "Empty";
                                                  }
                                                } ?></h6>
  <h6 class="ml-3 d-inline"><b>Year</b>: <?php if (isset($_GET['_y'])) {
                                            if ($_GET['_y'] == "select_year") {
                                              echo "Empty";
                                            } else {
                                              echo $_GET['_y'];
                                            }
                                          } ?></h6>
  <h6 class="ml-3 d-inline"><b>Semester</b>: <?php if (isset($_GET['_s_e_'])) {
                                                if ($_GET['_s_e_'] == "sem1") {
                                                  echo "First Semester";
                                                } else if ($_GET['_s_e_'] == "sem2") {
                                                  echo "Second Semester";
                                                } else {
                                                  echo "Empty";
                                                }
                                              } ?></h6>
</div>

<!-- ######################################################################################### -->
<!-- ################################### Table Starts Here ################################### -->
<!-- ######################################################################################### -->

<input type="hidden" id="get_semester" value="<?php if (isset($_GET['_s_e_'])) {
                                                echo $_GET['_s_e_'];
                                              } ?>">
<div class="table-responsive table_table mt-3 col-12">
  <table border="1" class="table table-hover mt-3 col-sm table-no-padding">
    <thead>
      <tr>
        <th class="px-3 text-center bg-info text-white" colspan="9">Student Grade</th>
      </tr><!-- Preliminary Here -->

      <tr class="text-center">
        <th class="px-3">Student ID</th>
        <th class="px-3">Student Name</th>
        <th class="px-3" style="background-color:#B1FBC4; color:#000;">Prelim</th>
        <th class="px-3" style="background-color:#cdddfe; color:#000;">Midterm</th>
        <th class="px-3" style="background-color:#ffb3b3; color:#000;" id="prefinal">Prefinal</th>
        <th class="px-3" style="background-color:#ffffcc; color:#000;" id="final">Final</th>
        <th class="px-3 bg-secondary text-white" id="average">Average</th>
        <th class="px-3 bg-secondary text-white" id="average">Equivalent</th>
        <th class="px-3 bg-secondary text-white" id="remarks">Remarks</th>
      </tr>

    </thead>

    <tbody>

      <?php

      if (isset($_GET["_y"])) {
        $year = $_GET["_y"];
      } else {
        $year = "";
      }



      if (isset($_GET["_c"])) {
        $course = $_GET["_c"];
      } else {
        $course = "BSIT";
      }


      if (isset($_GET["_s_e_"])) {
        if ($_GET["_s_e_"] == "select_semester") {
          $semester = "";
        } else {
          $semester = $_GET["_s_e_"];
        }
      } else {
        $semester = "sem1";
      }

      if (isset($_GET["_y"]) && !isset($_GET["_c"]) && !isset($_GET["_s_e_"])) {
        $ready = "100";
      } elseif (isset($_GET["_y"]) && isset($_GET["_c"]) && !isset($_GET["_s_e_"])) {
        $ready = "110";
      } elseif (isset($_GET["_y"]) && isset($_GET["_c"]) && isset($_GET["_s_e_"])) {
        $ready = "111";
      } else {
        $ready = "";
      }

      if ($semester == "") {
        echo "<center><h4 class='text-danger'>Please select semester</h4></center>";
      } else {

        $prelim = "prelim$semester[3]";
        $midterm = "midterm$semester[3]";
        $prefinal = "prefinal$semester[3]";
        $final = "final$semester[3]";
        $equivalentCheck = 0;

        if ($ready == "100") {
          $prelim_qry = mysqli_query($connections, "SELECT * FROM $prelim WHERE year='$year' ");
          $midterm_qry = mysqli_query($connections, "SELECT * FROM $midterm WHERE year='$year' ");
          $prefinal_qry = mysqli_query($connections, "SELECT * FROM $prefinal WHERE year='$year' ");
          $final_qry = mysqli_query($connections, "SELECT * FROM $final WHERE year='$year' ");
          $students_qry = mysqli_query($connections, "SELECT * FROM _user_tbl_ WHERE account_type='2' AND year='$year' ");
          // echo "<script>alert('there is a year');</script>";
        } elseif ($ready == "110") {
          $prelim_qry = mysqli_query($connections, "SELECT * FROM $prelim WHERE year='$year' AND course='$course' ");
          $midterm_qry = mysqli_query($connections, "SELECT * FROM $midterm WHERE year='$year' AND course='$course' ");
          $prefinal_qry = mysqli_query($connections, "SELECT * FROM $prefinal WHERE year='$year' AND course='$course' ");
          $final_qry = mysqli_query($connections, "SELECT * FROM $final WHERE year='$year' AND course='$course' ");
          $students_qry = mysqli_query($connections, "SELECT * FROM _user_tbl_ WHERE account_type='2' AND year='$year' AND course='$course' ");
          // echo "<script>alert('$course');</script>";
        } elseif ($ready == "111") {
          $prelim_qry = mysqli_query($connections, "SELECT * FROM $prelim WHERE year='$year' AND course='$course' ");
          $midterm_qry = mysqli_query($connections, "SELECT * FROM $midterm WHERE year='$year' AND course='$course' ");
          $prefinal_qry = mysqli_query($connections, "SELECT * FROM $prefinal WHERE year='$year' AND course='$course' ");
          $final_qry = mysqli_query($connections, "SELECT * FROM $final WHERE year='$year' AND course='$course' ");
          $students_qry = mysqli_query($connections, "SELECT * FROM _user_tbl_ WHERE account_type='2' AND year='$year' AND course='$course' ");
        } else {
          $prelim_qry = mysqli_query($connections, "SELECT * FROM $prelim ");
          $midterm_qry = mysqli_query($connections, "SELECT * FROM $midterm ");
          $prefinal_qry = mysqli_query($connections, "SELECT * FROM $prefinal ");
          $final_qry = mysqli_query($connections, "SELECT * FROM $final ");
          $students_qry = mysqli_query($connections, "SELECT * FROM _user_tbl_ WHERE account_type='2' ");
          // echo "<script>alert('there is no year');</script>";
        }

        function generateRandomEquivalent()
        {
          // Generate a random number from the specified range of equivalents
          $equivalents = array(1, 1.25, 1.5, 1.75, 2, 2.25);
          $random_index = array_rand($equivalents);
          return $equivalents[$random_index];
        }

        function getValueFromEquivalent($equivalent)
        {
          // Determine the value based on the equivalent
          if ($equivalent == 2.25) {
            return 85.4;
          } elseif ($equivalent == 2) {
            return mt_rand(855, 884) / 10;
          } elseif ($equivalent == 1.75) {
            return mt_rand(885, 914) / 10;
          } elseif ($equivalent == 1.5) {
            return mt_rand(915, 944) / 10;
          } elseif ($equivalent == 1.25) {
            return mt_rand(945, 974) / 10;
          } elseif ($equivalent == 1) {
            return mt_rand(975, 1000) / 10;
          } else {
            // Handle invalid equivalents
            return null;
          }
        }

        while ($row_prelim = mysqli_fetch_assoc($prelim_qry)) {


          $row_midterm = mysqli_fetch_assoc($midterm_qry);
          $row_prefinal = mysqli_fetch_assoc($prefinal_qry);
          $row_final = mysqli_fetch_assoc($final_qry);

          $row_students = mysqli_fetch_assoc($students_qry);
          $student_no = $row_students["student_no"];
          $lastname = $row_students["lastname"];
          $firstname = $row_students["firstname"];
          $middlename = $row_students["middlename"];
          $student_name = $firstname . " " . $middlename[0] . ". " . $lastname;


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

            $prelim_grade = $prelim_grade;

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

          if (
            $prefinal_output_1 <= 0 && $prefinal_output_2 <= 0 &&
            $prefinal_performance_1 <= 0 && $prefinal_performance_1 <= 0 &&
            $prefinal_written_test <= 0
          ) {

            $prefinal_grade = 0;
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
          $equivalent = $row_final["equivalent"];

          if (
            $final_output_1 <= 0 && $final_output_2 <= 0 &&
            $final_performance_1 <= 0 && $final_performance_1 <= 0 &&
            $final_written_test <= 0
          ) {

            $final_grade = 0;
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
          $prefinalCheck = 0;

          $final_status = 0;
          $final_status_missed = "";
          $finalCheck = 0;

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
            <td><?php echo $student_no; ?></td>
            <td><?php echo $student_name; ?></td>

            <td>
              <?php
              if ($prelim_grade > 0) {
                if ($prelim_status > 0) {
                  echo $prelim_grade . " <sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#prelim$student_no'><b>$prelim_status</b><sup>";
                } else {
                  echo "<span id='prelimGrade$student_no'>" . $prelim_grade . "</span>";
                }
              } else {
                echo "<span id='prelimGradeEmpty$student_no'>" . $prelim_grade . "</span>";
              }
              ?>
            </td>


            <td>
              <?php
              if ($midterm_grade > 0) {
                if ($midterm_status > 0) {
                  echo "<span id='midtermGrade$student_no'>" . $midterm_grade . "</span><sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#midterm$student_no'><b>$midterm_status</b><sup>";
                } else {
                  echo "<span id='midtermGrade$student_no'>" . $midterm_grade . "</span>";
                }
              } else {
                echo "<span id='midtermGradeEmpty$student_no'>" . $midterm_grade . "</span>";
              }
              ?>
            </td>


            <td>
              <?php

              if ($prefinal_grade > 0) {
                if ($prefinal_status > 0) {
                  echo $prefinal_grade . " <sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#prefinal$student_no'><b>$prefinal_status</b><sup>";
                } else {
                  echo $prefinal_grade;
                }
              } else {

                if ($prefinal_prediction > 0) {


                  echo "<span class='predictColor'><sup class='badge badge-warning'>Prediction</sup><br/>" . $prefinal_prediction . "</span>";
                } elseif ($prefinal_prediction == "") {
                  // check if prefinal prediction if empty (if value == 1, prefinal predition is empty)
                  if (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_prediction == "") && ($final_prediction == "")) {
                    $prefinalCheck = 1;

                    echo "<span class='predictColor'><sup class='badge badge-warning'>Prediction</sup><br/>" . $prefinal_prediction . "</span>";
                  } else {
                    echo $prefinal_grade;
                  }
                }
              }


              ?>
              <input type="hidden" id="prefinalCheck<?php echo $student_no; ?>" value="<?php echo $prefinalCheck; ?>">
            </td>

            <td>
              <?php
              if ($final_grade > 0) {
                if ($final_status > 0) {
                  echo $final_grade . " <sup class='grade_status bg-warning rounded-circle px-1' data-toggle='modal' data-target='#final$student_no'><b>$final_status</b><sup>";
                } else {
                  echo $final_grade;
                }
              } else {
                if ($final_prediction > 0) {


                  echo "<span class='predictColor'><sup class='badge badge-warning'>Prediction</sup><br/>" . $final_prediction . "</span>";
                } elseif ($final_prediction == "") {
                  // check if prefinal prediction if empty (if value == 1, prefinal predition is empty)
                  if (($prelim_grade > 0) && ($midterm_grade > 0) && ($prefinal_prediction == "") && ($final_prediction == "")) {
                    $finalCheck = 1;
                    // if ($equivalentCheck == 1) {
                    // echo $equivalentCheck;
                    echo "<span class='predictColor'><sup class='badge badge-warning'>Prediction</sup><br/>" . $final_prediction . "</span>";
                    // }
                  } else {
                    echo $final_grade;
                  }
                }
              }

              ?>
              <input type="hidden" id="finalCheck<?php echo $student_no; ?>" value="<?php echo $finalCheck; ?>">
            </td>
            <td>
              <?php

              if ((floatval($prelim_grade) > 0) && (floatval($midterm_grade) > 0) && (floatval($prefinal_grade) > 0) && (floatval($final_grade) > 0)) {

                $average = floatval($prelim_grade) + floatval($midterm_grade) + floatval($prefinal_grade) + floatval($final_grade);
                echo "<span class='predictColor'>" . round(($average / 4), 2) . "</span>";
              } elseif ((floatval($prelim_grade) > 0) && (floatval($midterm_grade) > 0) && (floatval($prefinal_grade) > 0) && (floatval($final_grade) == 0)) {

                if ($final_prediction == "") {
                } else {
                  $average =  floatval($prelim_grade) + floatval($midterm_grade) + floatval($prefinal_grade) + (floatval($prefinal_grade) * 0.3) + (floatval($final_prediction) * 0.7);
                  echo "<span class='predictColor'>" . round(($average / 4), 2) . "</span>";
                }
              } elseif ((floatval($prelim_grade) > 0) && (floatval($midterm_grade) > 0) && (floatval($prefinal_grade) == 0) && (floatval($final_grade) == 0)) {

                if ($prefinal_prediction == "" && $final_prediction == "") {
                } else {
                  $average = floatval($prelim_grade) + floatval($midterm_grade) + ((floatval($midterm_grade) * 0.30) + (floatval($prefinal_prediction) * 0.70)) + ((floatval($prefinal_prediction) * 0.30) + floatval($final_prediction) * 0.7);
                  echo "<span class='predictColor'>" . round(($average / 4), 2) . "</span>";
                }
              }

              ?>
            </td>
            <td>
              <input type="hidden" id="get_student_no<?php echo $student_no; ?>" value="<?php echo $student_no; ?>">
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
                    echo "<span class='predictColor'>" . $equivalent . "</span>";
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
                    echo "<span class='predictColor'>" . $equivalent . "</span>";
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

                    echo "<span class='predictColor'>" . $equivalent . "</span>";
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
                    echo "<span class='predictColor' id='prefinal_final_empty_equiv$student_no'>" . $equivalent . "</span>";
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
                  echo "<span class='predictColor' id='prefinal_final_not_empty_equiv$student_no'>" . $equivalent . "</span>";
                }
              }
              ?>
            </td>

            <td>
              <?php


              if ($equivalent > 0 && $equivalent <= 3) {
                $remarks = "Passed";
                echo "<span class='passed remarks predictColor'>" . $remarks . "</span>";
              } elseif ($equivalent == 5) {
                $remarks = "Failed";
                echo "<span class='failed remarks predictColor'>" . $remarks . "</span>";
              } else {
                $remarks = "---";
                echo $remarks;
              }

              ?>
            </td>

          </tr>



          <!-- The Prelim Modal -->
          <div class="modal" id="<?php echo "prelim" . $student_no; ?>">
            <div class="modal-dialog">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header text-white" style="background-color:#3399ff;">
                  <h4 class="modal-title"><?php echo $student_name; ?></h4>
                  <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                  <h3 class="text-danger">Defeciencies:</h3>
                  <?php echo $prelim_status_missed; ?>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="background-color:#3399ff;">
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
                <div class="modal-header text-white" style="background-color:#3399ff;">
                  <h4 class="modal-title"><?php echo $student_name; ?></h4>
                  <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                  <h3 class="text-danger">Defeciencies:</h3>
                  <?php echo $midterm_status_missed; ?>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="background-color:#3399ff;">
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
                <div class="modal-header text-white" style="background-color:#3399ff;">
                  <h4 class="modal-title"><?php echo $student_name; ?></h4>
                  <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                  <h3 class="text-danger">Defeciencies:</h3>
                  <?php echo $prefinal_status_missed; ?>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="background-color:#3399ff;">
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
                <div class="modal-header" style="background-color:#3399ff;">
                  <h4 class="modal-title text-white"><?php echo $student_name; ?></h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                  <h3 class="text-danger">Defeciencies:</h3>
                  <?php echo $final_status_missed; ?>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="background-color:#3399ff;">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

              </div>
            </div>
          </div>

      <?php
        }
      }
      ?>

  </table>
</div>

<!-- ######################################################################################### -->
<!-- ################################### Table Ends Here ################################### -->
<!-- ######################################################################################### -->


<?php
if (isset($_GET["id"])) {
  include("student_prediction.php");
}
?>

<br>
<br>
<br>
<br>
<br>
<br>
<br>


<script>
  var close_button = document.getElementsByClassName("close");
  window.onkeyup = function(event) {
    if (event.keyCode == 27) {
      // document.getElementById(boxid).style.visibility="hidden";
      window.location.href = "prediction";
    }
  }

  function year() {

    var year = document.getElementById("year");
    var selected_year = year.options[year.selectedIndex].value;

    window.location.href = "?_y=" + selected_year;
    // alert("hay");
  }

  function course() {

    var year = document.getElementById("year");
    var selected_year = year.options[year.selectedIndex].value;

    var course = document.getElementById("course");
    var selected_course = course.options[course.selectedIndex].value;

    // var selected_semester = f.options[f.selectedIndex].value;

    window.location.href = "?_y=" + selected_year + "&_c=" + selected_course;
    // alert("hay");
  }

  function semester() {

    var year = document.getElementById("year");
    var selected_year = year.options[year.selectedIndex].value;

    var course = document.getElementById("course");
    var selected_course = course.options[course.selectedIndex].value;

    var semester = document.getElementById("semester");
    var selected_semester = semester.options[semester.selectedIndex].value;

    window.location.href = "?_y=" + selected_year + "&_c=" + selected_course + /* "&_s="+selected_subject+ */ "&_s_e_=" + selected_semester;
    // alert("hay");
  }

  document.addEventListener('DOMContentLoaded', (event) => {

    semster = document.getElementById('get_semester').value;
    // Get all rows in the table
    var rows = document.querySelectorAll('tr[data-student-no]');

    rows.forEach(function(row) {
      var studentNo = row.getAttribute('data-student-no');
      var inputField = document.getElementById('get_student_no' + studentNo);
      var prelim = document.getElementById('prelimGrade' + studentNo);
      var prelimEmpty = document.getElementById('prelimGradeEmpty' + studentNo);
      var midterm = document.getElementById('midtermGrade' + studentNo);
      var midtermEmpty = document.getElementById('midtermGradeEmpty' + studentNo);
      var prefinalCheck = document.getElementById('prefinalCheck' + studentNo);
      var finalCheck = document.getElementById('finalCheck' + studentNo);
      var equivalentEmpty = document.getElementById('prefinal_final_empty_equiv' + studentNo);
      var equivalentNotEmpty = document.getElementById('prefinal_final_not_empty_equiv' + studentNo);

      if (prelim) {
        var prelimValue = prelim.innerHTML;
        // console.log("Prelim:" + prelimValue);
      }

      if (prelimEmpty) {
        var prelimEmptyValue = prelimEmpty.innerHTML;
        // console.log("Prelim Empty:" + prelimEmptyValue);
      }

      if (midterm) {
        var midtermValue = midterm.innerHTML;
        // console.log("Midterm:" + midtermValue);
      }

      if (midtermEmpty) {
        var midtermEmptyValue = midtermEmpty.innerHTML;
        // console.log("Midterm Empty:" + midtermEmptyValue);
      }

      if (prefinalCheck) {
        var prefinalCheckValue = prefinalCheck.value;
        var prefinalPrediction = "";
        if (prefinalCheckValue == 1) {
          var prefinalPrediction = "ok";
          // console.log("Prefinal Check: " + prefinalCheck);
        }
        // console.log("Midterm Empty:" + midtermEmptyValue);
      }

      if (finalCheck) {
        var finalCheckValue = finalCheck.value;
        var finalPrediction = "";
        if (finalCheckValue == 1) {
          var finalPrediction = "ok";
          // console.log("Prefinal Check: " + finalCheck);
        }
        // console.log("Midterm Empty:" + midtermEmptyValue);
      }

      if (equivalentEmpty) {
        var equivalentEmptyValue = equivalentEmpty.innerHTML;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_predict.php?id=' + studentNo + "&prelim=" + prelimValue + "&midterm=" + midtermValue + "&prefinalPredict=" + prefinalPrediction + "&finalPredict=" + finalPrediction + "&s_=" + semster, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            var result = xhr.responseText;
            console.log(result);
            // console.log('prefinal:'+predict_prefinal+'final:'+predict_final);
            window.location.reload();
          }
        }
        xhr.send();
        // console.log("Not Empty:" + equivalentNotEmptyValue);

        // console.log("Empty:" + equivalentEmptyValue);
      }

      if (equivalentNotEmpty) {
        var equivalentNotEmptyValue = equivalentNotEmpty.innerHTML;
        // var xhr = new XMLHttpRequest();
        // xhr.open('POST', 'save_predict.php?id=' + studentNo + "&equiv=" + equivalentNotEmptyValue, true);
        // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        // xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        // xhr.onreadystatechange = function() {
        //   if (xhr.readyState == 4 && xhr.status == 200) {
        //     var result = xhr.responseText;
        //     console.log(result);
        //     // console.log('prefinal:'+predict_prefinal+'final:'+predict_final);
        //     // window.location.reload();
        //   }
        // }
        // xhr.send();
        // console.log("Not Empty:" + equivalentNotEmptyValue);
      }

      if (inputField) {
        var inputValue = inputField.value;
        // var xhr = new XMLHttpRequest();
        // xhr.open('POST', 'save_predict.php?id=' + studentNo, true);
        // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        // xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        // xhr.onreadystatechange = function() {
        //   if (xhr.readyState == 4 && xhr.status == 200) {
        //     var result = xhr.responseText;
        //     console.log(result);
        //     // console.log('prefinal:'+predict_prefinal+'final:'+predict_final);
        //     // window.location.reload();
        //   }
        // }
        // xhr.send();
        // console.log('Student No:', studentNo, 'Grade:', inputValue);
      }
    });
  });
</script>

<?php
include("../../bins/footer_non_fixed.php");
?>