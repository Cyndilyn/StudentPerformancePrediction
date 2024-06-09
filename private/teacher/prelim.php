<?php

$prelim_output_1 = $prelim_output_2 = $prelim_output_total_score =
  $prelim_output_base = $prelim_output_weight = $prelim_performance_1 =
  $prelim_performance_2 = $prelim_performance_total_score =
  $prelim_performance_base = $prelim_performance_weight =
  $prelim_written_test = $prelim_written_test_base =
  $prelim_written_test_weight = $prelim_grade =
  $prelim_grade_equivalent = "0";



if (isset($_GET["redir"])) {

  if ($_GET["redir"] == "select_grading") {
    $grade_period = "";
  } else {
    $grade_period = $_GET["redir"];
  }
} else {
  $grade_period = "";
}


if (isset($_GET["_y"])) {

  if ($_GET["_y"] == "select_year") {
    $year = "";
  } else {
    $year = $_GET["_y"];
  }
} else {
  $year = "";
}


if (isset($_GET["_c"])) {

  if ($_GET["_c"] == "select_course") {
    $course = "";
  } else {
    $course = $_GET["_c"];
    // echo $course;
  }
} else {
  $course = "";
}

// Select Semester here Kara nag tapos
if (isset($_GET["_s_e_"])) {

  if ($_GET["_s_e_"] == "select_semester") {
    $semester = "";
  } else {
    $semester = $_GET["_s_e_"];
    // echo $semester;
  }
} else {
  $semester = "";
}



?>


<style>
  .table-no-padding td,
  .table-no-padding th {
    padding-top: 5px !important;
    padding-bottom: 5px !important;
  }

  th {
    font-weight: 500;
  }
</style>
<div class="table-responsive table_table mt-3 col-12">
  <table border="1" class="table table-hover table-no-padding">
    <thead>
      <tr>
        <th class="px-3 col-2" colspan="2"></th>
        <th class="text-center " style="background-color:#86f9a3;" colspan="17">Preliminary Period</th>
      </tr><!-- Preliminary Here -->

      <tr>
        <th class="px-3">Student&nbsp;ID</th>
        <th class="px-3 col-2">Student&nbsp;Name</th><!-- <th class="px-5 text-center " style="background-color:#86f9a3;" colspan="12">Formative Assessment</th> -->
        <th class="px-5 text-center " style="background-color:#86f9a3;" colspan="5">Output</th>
        <th class="px-5 text-center " style="background-color:#86f9a3;" colspan="5">Performance</th>
        <th class="px-5 text-cente " style="background-color:#86f9a3;" colspan="3">Major&nbsp;Exam</th>
        <th class="px-2 text-center" style="background-color:#86f9a3;">Prelim&nbsp;Grade</th>
        <th class="px-2 text-center" style="background-color:#86f9a3;">Equivalent</th>
      </tr><!-- Preliminary Here -->

      <tr>
        <th class="px-3"></th>
        <th class="px-3">Highest&nbsp;Possible&nbsp;Score</th><!-- <th class="" style="background-color:#86f9a3;">10</th><th class="" style="background-color:#86f9a3;">10</th><th class="" style="background-color:#86f9a3;">10</th><th class="" style="background-color:#86f9a3;">10</th><th class="" style="background-color:#86f9a3;">10</th><th class="" style="background-color:#86f9a3;">10</th><th class="" style="background-color:#86f9a3;">10</th><th class="" style="background-color:#86f9a3;">10</th><th class="" style="background-color:#86f9a3;">10</th><th class="" style="background-color:#86f9a3;">10</th><th class="" style="background-color:#86f9a3;">100</th><th class="" style="background-color:#86f9a3;">60</th> -->
        <th class="" style="background-color:#86f9a3;">
          <center>20</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>20</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>40</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>60</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>0.40</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>20</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>20</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>40</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>60</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>0.40</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>70</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>60</center>
        </th>
        <th class="" style="background-color:#86f9a3;">
          <center>0.20</center>
        </th>
        <th class="" style="background-color:#86f9a3;"></th>
        <th class="" style="background-color:#86f9a3;"></th>
      </tr><!-- Preliminary Here -->
    </thead>

    <tbody>

      <?php


      if ($grade_period == "prelim") {
        if (isset($_GET["_y"])) {
          if ($year == $_GET["_y"]) {
            if (isset($_GET["_c"])) {
              if ($course == $_GET["_c"]) {
                // if(isset($_GET["_s"])){
                //   if($subject == $_GET["_s"]){
                if (isset($_GET["_s_e_"])) {
                  if ($semester == $_GET["_s_e_"]) {

                    $grade_period = $grade_period . $semester[3];
                    $grading_period = mysqli_query($connections, "SELECT * FROM $grade_period WHERE course='$course' AND year='$year' ");

                    prelim_query($grading_period);
                  }
                }
              }
            }
          }
        }
      }


      function prelim_query($grading_period)
      {

        while ($row_prelim = mysqli_fetch_assoc($grading_period)) {

          $student_no = $row_prelim["student_no"];
          $fullname = $row_prelim["student_name"];
          $prelim_output_1 = $row_prelim["prelim_output_1"];
          $prelim_output_2 = $row_prelim["prelim_output_2"];
          $prelim_output_total_score = $row_prelim["prelim_output_total_score"];
          $prelim_output_base = $row_prelim["prelim_output_base"];
          $prelim_output_weight = $row_prelim["prelim_output_weight"];
          $prelim_performance_1 = $row_prelim["prelim_performance_1"];
          $prelim_performance_2 = $row_prelim["prelim_performance_2"];
          $prelim_performance_total_score = $row_prelim["prelim_performance_total_score"];
          $prelim_performance_base = $row_prelim["prelim_performance_base"];
          $prelim_performance_weight = $row_prelim["prelim_performance_weight"];
          $prelim_written_test = $row_prelim["prelim_written_test"];
          $prelim_written_test_base = $row_prelim["prelim_written_test_base"];
          $prelim_written_test_weight = $row_prelim["prelim_written_test_weight"];
          $prelim_grade = $row_prelim["prelim_grade"];
          $prelim_grade_equivalent = $row_prelim["prelim_grade_equivalent"];

          // ####################______Prelim Formulas______####################
          // $prelim_formative_assessment_total_score =
          // $prelim_formative_assessment_1 + $prelim_formative_assessment_2 +
          // $prelim_formative_assessment_3 + $prelim_formative_assessment_4 +
          // $prelim_formative_assessment_5 + $prelim_formative_assessment_6 +
          // $prelim_formative_assessment_7 + $prelim_formative_assessment_8 +
          // $prelim_formative_assessment_9 + $prelim_formative_assessment_10;

          // $prelim_formative_assessment_base = $prelim_formative_assessment_total_score / 100 * 40 + 60;
          $prelim_output_total_score = $prelim_output_1 + $prelim_output_2;
          $prelim_output_base = $prelim_output_total_score / 40 * 40 + 60;
          $prelim_output_weight = $prelim_output_base * 0.40;
          $prelim_performance_total_score = $prelim_performance_1 + $prelim_performance_2;
          $prelim_performance_base = $prelim_performance_total_score / 40 * 40 + 60;
          $prelim_performance_weight = $prelim_performance_base * 0.40;
          $prelim_written_test_base = $prelim_written_test / 70 * 40 + 60;
          $prelim_written_test_weight = $prelim_written_test_base * 0.20;
          $prelim_grade = $prelim_output_weight + $prelim_performance_weight + $prelim_written_test_weight;

          switch (true) {
              //   case ($prelim_grade <= 74.4):
              //       $prelim_grade_equivalent = "5";
              //       break;
            case ($prelim_grade >= 74.5 && $prelim_grade <= 76.49):
              $prelim_grade_equivalent = "3";
              break;
            case ($prelim_grade >= 76.5 && $prelim_grade <= 79.49):
              $prelim_grade_equivalent = "2.75";
              break;
            case ($prelim_grade >= 79.5 && $prelim_grade <= 82.49):
              $prelim_grade_equivalent = "2.5";
              break;
            case ($prelim_grade >= 82.5 && $prelim_grade <= 85.49):
              $prelim_grade_equivalent = "2.25";
              break;
            case ($prelim_grade >= 85.5 && $prelim_grade <= 88.49):
              $prelim_grade_equivalent = "2";
              break;
            case ($prelim_grade >= 88.5 && $prelim_grade <= 91.49):
              $prelim_grade_equivalent = "1.75";
              break;
            case ($prelim_grade >= 91.5 && $prelim_grade <= 94.49):
              $prelim_grade_equivalent = "1.5";
              break;
            case ($prelim_grade >= 94.5 && $prelim_grade <= 97.49):
              $prelim_grade_equivalent = "1.25";
              break;
            case ($prelim_grade >= 97.5 && $prelim_grade <= 100):
              $prelim_grade_equivalent = "1";
              break;

            default:
              $prelim_grade_equivalent = "5";
          }


          $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $qws = md5(rand(0, 3));
          //   $rd = substr(str_shuffle($permitted_chars), 0, 5);

          $a1 = substr(str_shuffle($permitted_chars), 0, 5);

          $year = $_GET["_y"];
          $course = $_GET["_c"];
          $semester = $_GET["_s_e_"];

      ?>

          <tr>
            <td><?php echo $student_no; ?></td>
            <td class="col-2"><?php echo $fullname; ?></td>
            <td>
              <center><a class="text-primary"><?php echo $prelim_output_1; ?></a></center>
            </td>
            <td>
              <center><a class="text-primary"><?php echo $prelim_output_2; ?></a></center>
            </td>
            <td>
              <center><a class="text-danger"><?php echo $prelim_output_total_score; ?></a></center>
            </td>
            <td>
              <center><a class="text-danger"><?php echo $prelim_output_base; ?></a></center>
            </td>
            <!-- <td><center><a class="text-danger"> -->

            <?php
            // echo $prelim_output_weight;
            if ($prelim_output_weight < 30) {
              echo
              "<td class='text-white' style='background-color: #ff8080;'><center>" . $prelim_output_weight . "</center></td>";
            } else {
            ?>
              <td>
                <center><a class="text-danger">
                  <?php
                  echo $prelim_output_weight;
                }
                  ?>
                  </a></center>
              </td>



              <td>
                <center><a class="text-primary"><?php echo $prelim_performance_1; ?></a></center>
              </td>
              <td>
                <center><a class="text-primary"><?php echo $prelim_performance_2; ?></a></center>
              </td>
              <td>
                <center><a class="text-danger"><?php echo $prelim_performance_total_score; ?></a></center>
              </td>
              <td>
                <center><a class="text-danger"><?php echo $prelim_performance_base; ?></a></center>
              </td>



              <!-- <td><center><a class="text-danger"><?php echo $prelim_performance_weight; ?></a></center></td>  -->


              <?php
              // echo $prelim_output_weight;
              if ($prelim_performance_weight < 30) {
                echo
                "<td class='text-white' style='background-color: #ff8080;'><center>" . $prelim_performance_weight . "</center></td>";
              } else {
              ?>
                <td>
                  <center><a class="text-danger">
                    <?php
                    echo $prelim_performance_weight;
                  }
                    ?>
                    </a></center>
                </td>




                <td>
                  <center><a class="text-primary"><?php echo $prelim_written_test; ?></a></center>
                </td>
                <td>
                  <center><a class="text-danger"><?php echo number_format((float)$prelim_written_test_base, 2, ".", ""); ?></a></center>
                </td>


                <!-- <td><center><a class="text-danger"><?php echo number_format((float)$prelim_written_test_weight, 2, ".", ""); ?></a></center></td>  -->

                <?php
                // echo $prelim_output_weight;
                if ($prelim_written_test_weight < 15) {
                  echo
                  "<td class='text-white' style='background-color: #ff8080;'><center>" . number_format((float)$prelim_written_test_weight, 2, ".", "") . "</center></td>";
                } else {
                ?>
                  <td>
                    <center><a class="text-danger">
                      <?php
                      echo number_format((float)$prelim_written_test_weight, 2, ".", "");
                    }
                      ?>
                      </a></center>
                  </td>




                  <td>
                    <center><a class="<?php if ($prelim_grade >= '74.5') {
                                        echo 'text-success';
                                      } else {
                                        echo 'text-danger';
                                      } ?>"><?php echo number_format((float)$prelim_grade, 2, ".", ""); ?></a></center>
                  </td>
                  <td>
                    <center><a class="<?php if ($prelim_grade >= '74.5') {
                                        echo 'text-success';
                                      } else {
                                        echo 'text-danger';
                                      } ?>"><?php echo $prelim_grade_equivalent; ?></a></center>
                  </td>
                  <!-- <td><center><a href="?redir=prelim&_y=<?php echo $year; ?>&_c=<?php echo $course; ?>&_s_e_=<?php echo $semester; ?>&in_=<?php echo $student_no; ?>" class="btn btn-success">Input Grade</a></center></td> -->
          </tr>



      <?php
        }
      }
      ?>

  </table>
</div>

<?php
if (isset($_GET["redir"]) & isset($_GET["_y"]) & isset($_GET["_c"]) & isset($_GET["_s_e_"])) {
?>

  <div class="mt-5">
    <center>
      <a href="?redir=prelim&_y=<?php echo $year; ?>&_c=<?php echo $course; ?>&_s_e_=<?php echo $semester; ?>&in_=output1" class="btn btn-success col-sm-2 mb-3 ml-3">Output 1 Grade</a>
      <a href="?redir=prelim&_y=<?php echo $year; ?>&_c=<?php echo $course; ?>&_s_e_=<?php echo $semester; ?>&in_=output2" class="btn btn-success col-sm-2 mb-3 ml-3">Output 2 Grade</a>
      <a href="?redir=prelim&_y=<?php echo $year; ?>&_c=<?php echo $course; ?>&_s_e_=<?php echo $semester; ?>&in_=performance1" class="btn btn-success col-sm-2 mb-3 ml-3">Performance 1 Grade</a>
      <a href="?redir=prelim&_y=<?php echo $year; ?>&_c=<?php echo $course; ?>&_s_e_=<?php echo $semester; ?>&in_=performance2" class="btn btn-success col-sm-2 mb-3 ml-3">Performance 2 Grade</a>
      <a href="?redir=prelim&_y=<?php echo $year; ?>&_c=<?php echo $course; ?>&_s_e_=<?php echo $semester; ?>&in_=written_test" class="btn btn-success col-sm-2 mb-3 ml-3">Major Exam Grade</a>
    </center>
  </div>

<?php
}
?>


<div class="fixed-top">
  <?php
  // if(isset($_GET["a1"])){
  //   include("redir.php");
  // }elseif(isset($_GET["a2"])){
  //   include("redir.php");
  // }elseif(isset($_GET["a3"])){
  //   include("redir.php");
  // }elseif(isset($_GET["a4"])){
  //   include("redir.php");
  // }elseif(isset($_GET["a5"])){
  //   include("redir.php");
  // }elseif(isset($_GET["a6"])){
  //   include("redir.php");
  // }elseif(isset($_GET["a7"])){
  //   include("redir.php");
  // }elseif(isset($_GET["a8"])){
  //   include("redir.php");
  // }elseif(isset($_GET["a9"])){
  //   include("redir.php");
  // }elseif(isset($_GET["a10"])){
  //   include("redir.php");
  // }elseif(isset($_GET["pfats"])){
  //   include("redir.php");
  // }elseif(isset($_GET["pfab"])){
  //   include("redir.php");
  /* }else */ if (isset($_GET["po1"])) {
    include("redir.php");
  } elseif (isset($_GET["po2"])) {
    include("redir.php");
  } elseif (isset($_GET["pots"])) {
    include("redir.php");
  } elseif (isset($_GET["pob"])) {
    include("redir.php");
  } elseif (isset($_GET["pow"])) {
    include("redir.php");
  } elseif (isset($_GET["pp1"])) {
    include("redir.php");
  } elseif (isset($_GET["pp2"])) {
    include("redir.php");
  } elseif (isset($_GET["ppts"])) {
    include("redir.php");
  } elseif (isset($_GET["ppb"])) {
    include("redir.php");
  } elseif (isset($_GET["ppw"])) {
    include("redir.php");
  } elseif (isset($_GET["pwt"])) {
    include("redir.php");
  } elseif (isset($_GET["pwtb"])) {
    include("redir.php");
  } elseif (isset($_GET["pwtw"])) {
    include("redir.php");
  } elseif (isset($_GET["pg"])) {
    include("redir.php");
  } elseif (isset($_GET["pge"])) {
    include("redir.php");
  }

  if (isset($_GET["in_"])) {
    include("redir.php");
  }
  ?>
</div>

<!-- <a href="pdf_files_prelim?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="btn btn-warning fixed-bottom col-1 mb-3 ml-3">Get PDF</a> -->

<input type="hidden" value="<?php if (isset($_GET["redir"])) {
                              echo "prelim";
                            } ?>" id="grade_period">
<input type="hidden" value="<?php if (isset($_GET["_y"])) {
                              echo "2011";
                            } ?>" id="year">
<input type="hidden" value="<?php if (isset($_GET["_c"])) {
                              echo "BSIT";
                            } ?>" id="course">
<input type="hidden" value="<?php if (isset($_GET["_s_e_"])) {
                              echo "sem1";
                            } ?>" id="semester">

<script>
  // var black_cover = document.getElementById("myModal");


  // function reload_page(){
  //     location.reload();
  // }

  // black_cover.addEventListener("click", reload_page);

  // check if mabuoe du class ni body then reload the page using location.reload();

  // grading = document.getElementById("grade_period").value;
  // year = document.getElementById("year").value;
  // course = document.getElementById("course").value;
  // semester = document.getElementById("semester").value;

  var grading = document.getElementById("grade_period").value;
  var year = document.getElementById("year");
  var selected_year = year.value;
  var course = document.getElementById("course");
  var selected_course = course.value;
  var semester = document.getElementById("semester");
  var selected_semester = semester.value;

  // function relocate() {
  //   window.location.href = "studentperformance?redir=" + grading + "&_y=" + selected_year + "&_c=" + selected_course + "&_s_e_=" + selected_semester;
  //   // alert("hay");
  // }


  // get_black = document.getElementById("black1");

  // get_black.addEventListener("click", relocate);
</script>