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


<style>
  body {
    font-size: .8em;
  }


  .student_performance_active {
    border: 1.5px solid white;
    border-radius: 6px;
  }

  .black {
    background-color: #000000ef;
    height: 100%;
  }

  .small-select {
    appearance: none;
    /* Remove default arrow */
    -webkit-appearance: none;
    /* Remove default arrow in Safari */
    -moz-appearance: none;
    /* Remove default arrow in Firefox */
    background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="none" stroke="white" stroke-width="1" d="M0 0l2 2 2-2"/></svg>');
    /* Custom arrow icon */
    background-repeat: no-repeat;
    /* No repeat of the background image */
    background-position: right 0.75rem center;
    /* Position of the custom arrow icon */
    background-size: 0.65rem 0.65rem;
    /* Size of the custom arrow icon */

    border: none;
    box-shadow: none;
    border-radius: 0;
  }

  .small-select:focus {
    border-color: #495057;
    /* Slightly darker border on focus */
    box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
    /* Shadow on focus */
  }



  /* Hide default select */
  /* .custom-select-container select {
    display: none;
  } */



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
include("../bins/admin_nav.php");
?>
<br>
<center>
  <h1 class="py-3 text-info px-1">Student Performance Prediction System</h1>
</center>
<br>

<?php

// Get the selected value from the query string or set a default value
$selectedGrading = isset($_GET['redir']) ? $_GET['redir'] : 'select_grading';
$selectedYear = isset($_GET['_y']) ? $_GET['_y'] : 'select_year';
$selectedCourse = isset($_GET['_c']) ? $_GET['_c'] : 'select_course';
$selectedSemester = isset($_GET['_s_e_']) ? $_GET['_s_e_'] : 'select_semester';

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
  'sem1' => '1st Semester',
  'sem2' => '2nd Semester'
];

$selectedGradingText = isset($gradingOptions[$selectedGrading]) ? $gradingOptions[$selectedGrading] : 'Select Grading Period';
$selectedYearText = isset($selectedYear) && $selectedYear != 'select_year' ? $selectedYear : 'Select Year';
$selectedCourseText = isset($courseOptions[$selectedCourse]) ? $courseOptions[$selectedCourse] : 'Select Course';
$selectedSemesterText = isset($semesterOptions[$selectedSemester]) ? $semesterOptions[$selectedSemester] : 'Select Semester';
?>

<!-- <div class="input-group col-sm-6">
<input class="form-control mr-sm-2" type="text" placeholder="Course Name...">
<input class="form-control mr-sm-2" type="text" placeholder="Semester...">
<div class="input-group-append">
<button class="btn btn-success">View Charts</button>
</div>
</div> -->

<div class="container-fluid d-inline py-5">
  <!-- <a class="btn btn-info ml-2 my-3" href="?redir=prelim">Preliminary Period</a>
<a class="btn btn-info ml-2 my-3" href="?redir=midterm">Midterm Period</a>
<a class="btn btn-info ml-2 my-3" href="?redir=prefinal">Prefinal</a>
<a class="btn btn-info ml-2 my-3" href="?redir=final">Final</a> -->

  <select class="form-control col-3 ml-2 pt-1 pb-2 d-inline bg-info text-white small-select" id="grade_period" onchange="grade_period()">
    <option value="select_grading">Select Grading Period</option>
    <option value="prelim" <?php if (isset($_GET['redir'])) {
                              if ($_GET['redir'] == "prelim") {
                                echo "selected";
                              }
                            } ?>><a class="btn btn-info ml-2 my-3" href="?redir=prelim">Prelim</a></option>
    <option value="midterm" <?php if (isset($_GET['redir'])) {
                              if ($_GET['redir'] == "midterm") {
                                echo "selected";
                              }
                            } ?>><a class="btn btn-info ml-2 my-3" href="?redir=midterm">Midterm</a></option>
    <option value="prefinal" <?php if (isset($_GET['redir'])) {
                                if ($_GET['redir'] == "prefinal") {
                                  echo "selected";
                                }
                              } ?>><a class="btn btn-info ml-2 my-3" href="?redir=prefinal">Prefinal</a></option>
    <option value="final" <?php if (isset($_GET['redir'])) {
                            if ($_GET['redir'] == "final") {
                              echo "selected";
                            }
                          } ?>><a class="btn btn-info ml-2 my-3" href="?redir=final">Final</a></option>
  </select>


  <select class="form-control col-2 ml-2 pt-1 pb-2 d-inline text-white text-white small-select <?php if (!isset($_GET['redir'])) {
                                                                                                  echo 'bg-secondary';
                                                                                                } else {
                                                                                                  if ($_GET['redir'] == 'select_grading') {
                                                                                                    echo 'bg-secondary';
                                                                                                  } else {
                                                                                                    echo 'bg-info';
                                                                                                  }
                                                                                                } ?>" <?php if (!isset($_GET['redir'])) {
                                                                                                        echo 'disabled';
                                                                                                      } else {
                                                                                                        if ($_GET['redir'] == 'select_grading') {
                                                                                                          echo 'disabled';
                                                                                                        }
                                                                                                      } ?> id="year" onchange="year()">
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

  <!-- <select class="form-control col-2 ml-2 pt-1 pb-2 d-inline <?php /* if(!isset($_GET['_c'])){ echo "bg-secondary"; }else{ if($_GET['_c'] == "select_course"){ echo "bg-secondary"; }else{ echo "bg-info"; }} */ ?> text-white" <?php /* if(!isset($_GET['_c'])){ echo "disabled"; }else{ if($_GET['_c'] == "select_course"){ echo "disabled"; }} */ ?> id="subject" onchange="subject()">
  <option value="select_subject">Select Subject</option>
  <option value="application_programming1" <?php /* if(isset($_GET['_s'])){ if($_GET['_s'] == "application_programming1"){ echo "selected"; }} */ ?> >Application Programming 1</option>
  <option value="application_programming2" <?php /* if(isset($_GET['_s'])){ if($_GET['_s'] == "application_programming2"){ echo "selected"; }} */ ?> >Application Programming 2</option>
</select> -->


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

</div>


&nbsp;
<?php
if (!isset($_GET["redir"])) {
} else {
  if ($_GET["redir"] == "prelim") {
    if (isset($_GET["redir"]) && !isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
?>
      <a href="pdf_files_prelim?redir=<?php echo $_GET["redir"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
      <!-- <a href="pdf_files_prelim?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a> -->

    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_prelim?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_prelim?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_prelim?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
  <?php
    }
  }
  ?>



  <?php
  if ($_GET["redir"] == "midterm") {
    if (isset($_GET["redir"]) && !isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
  ?>
      <a href="pdf_files_midterm?redir=<?php echo $_GET["redir"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_midterm?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_midterm?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_midterm?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
  <?php
    }
  }
  ?>


  <?php
  if ($_GET["redir"] == "prefinal") {
    if (isset($_GET["redir"]) && !isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
  ?>
      <a href="pdf_files_prefinal?redir=<?php echo $_GET["redir"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_prefinal?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_prefinal?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_prefinal?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
  <?php
    }
  }
  ?>

  <?php
  if ($_GET["redir"] == "final") {
    if (isset($_GET["redir"]) && !isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
  ?>
      <a href="pdf_files_final?redir=<?php echo $_GET["redir"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_final?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_final?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
    <?php
    } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && isset($_GET['_s_e_'])) {
    ?>
      <a href="pdf_files_final?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a>
<?php
    }
  }
}
?>

</div>


<br>
<br>

<div>
  <h6 class="ml-3 d-inline"><b>Course Name</b>: <?php if (isset($_GET['_s_e_'])) {
                                                  if ($_GET['_s_e_'] == "sem1") {
                                                    echo "IT 2 - Application Programming 1";
                                                  } else {
                                                    echo "IT 5 - Application Programming 2";
                                                  }
                                                } ?></h6>
  <h6 class="ml-3 d-inline"><b>Year</b>: <?php if (isset($_GET['_y'])) {
                                            echo $_GET['_y'];
                                          } ?></h6>
  <h6 class="ml-3 d-inline"><b>Semester</b>: <?php if (isset($_GET['_s_e_'])) {
                                                if ($_GET['_s_e_'] == "sem1") {
                                                  echo "First Semester";
                                                } else {
                                                  echo "Second Semester";
                                                }
                                              } ?></h6>
</div>


<?php

if (isset($_GET['redir'])) {
  if ($_GET['redir'] == "prelim") {
    include("prelim.php");
  }

  if ($_GET['redir'] == "midterm") {
    include("midterm.php");
  }

  if ($_GET['redir'] == "prefinal") {
    include("prefinal.php");
  }

  if ($_GET['redir'] == "final") {
    include("final.php");
  }
}

?>

<center>
  <?php
  include("grading_system.php");
  ?>
</center>

<br>
<br>
<br>
<br>
<br>
<br>
<br>

<script>
  function grade_period() {
    var grading = document.getElementById("grade_period");
    var selected_grading = grading.options[grading.selectedIndex].value;

    window.location.href = "?redir=" + selected_grading;
    // alert("hay");
  }

  function year() {
    var grading = document.getElementById("grade_period");
    var selected_grading = grading.options[grading.selectedIndex].value;

    var year = document.getElementById("year");
    var selected_year = year.options[year.selectedIndex].value;

    window.location.href = "?redir=" + selected_grading + "&_y=" + selected_year;
    // alert("hay");
  }

  function course() {
    var grading = document.getElementById("grade_period");
    var selected_grading = grading.options[grading.selectedIndex].value;

    var year = document.getElementById("year");
    var selected_year = year.options[year.selectedIndex].value;

    var course = document.getElementById("course");
    var selected_course = course.options[course.selectedIndex].value;

    // var selected_semester = f.options[f.selectedIndex].value;

    window.location.href = "?redir=" + selected_grading + "&_y=" + selected_year + "&_c=" + selected_course;
    // alert("hay");
  }

  // function subject(){
  //   var grading = document.getElementById("grade_period");
  //   var selected_grading = grading.options[grading.selectedIndex].value;

  //   var year = document.getElementById("year");
  //   var selected_year = year.options[year.selectedIndex].value;

  //   var course = document.getElementById("course");
  //   var selected_course = course.options[course.selectedIndex].value;

  //   var subject = document.getElementById("subject");
  //   var selected_subject = subject.options[subject.selectedIndex].value;

  //   // var selected_semester = f.options[f.selectedIndex].value;

  //   window.location.href = "?redir="+selected_grading+"&_y="+selected_year+"&_c="+selected_course+"&_s="+selected_subject;
  //   // alert("hay");
  // }

  function semester() {
    var grading = document.getElementById("grade_period");
    var selected_grading = grading.options[grading.selectedIndex].value;

    var year = document.getElementById("year");
    var selected_year = year.options[year.selectedIndex].value;

    var course = document.getElementById("course");
    var selected_course = course.options[course.selectedIndex].value;

    // var subject = document.getElementById("subject");
    // var selected_subject = subject.options[subject.selectedIndex].value;

    var semester = document.getElementById("semester");
    var selected_semester = semester.options[semester.selectedIndex].value;

    window.location.href = "?redir=" + selected_grading + "&_y=" + selected_year + "&_c=" + selected_course + /* "&_s="+selected_subject+ */ "&_s_e_=" + selected_semester;
    // alert("hay");
  }
</script>

<?php
include("../../bins/footer_non_fixed.php");
?>