<style>
  .black {
    background-color: #000000ef;
    height: 100%;
  }

  .close_btn {
    width: 5%;
    height: 10%;
  }

  #prefinal_grade_prediction {
    border: none;
    background-color: transparent;
  }

  #final_grade_prediction {
    border: none;
    background-color: transparent;
  }

  td:hover {
    color: #000;
  }
</style>

<?php

if (isset($_GET["id"])) {
  $student_no = $_GET["id"];
}


if (isset($_GET["s_"])) {
  $semester_no = $_GET["s_"];
} else {
  $semester_no = "1";
}



// $final_prediction_qry = mysqli_query($connections, "SELECT * FROM $final_prediction_table_semester WHERE student_no='$student_no' ");
// $row_final_prediction = mysqli_fetch_assoc($final_prediction_qry);

$student_qry = mysqli_query($connections, "SELECT * FROM _user_tbl_ WHERE student_no='$student_no' ");
$row_student = mysqli_fetch_assoc($student_qry);
$lastname = $row_student['lastname'];
$firstname = $row_student['firstname'];
$middlename = $row_student['middlename'];
$student_name = $firstname . " " . $middlename[0] . ". " . $lastname;


?>
<div class="black p-5 fixed-top">
  <input type="hidden" id="get_student_no" value="<?php echo $student_no; ?>">

  <input type="hidden" id="get_semester" value="<?php echo $_GET["s_"]; ?>">

  <div class="table-responsive table_table mt-3 col-10 container-fluid">
    <table border="1" class="table table-hover">
      <thead>
        <tr>
          <th class="px-3 text-center bg-info text-white" colspan="6">Student Grade</th>
        </tr><!-- Preliminary Here -->

        <tr class="text-center">
          <th class="px-3 bg-white">Student Name</th>
          <th class="px-3 bg-success text-white">Prelim</th>
          <th class="px-3 bg-primary text-white">Midterm</th>
          <th class="px-3 bg-danger text-white" id="prefinal_student_predict">Prefinal</th>
          <th class="px-3 bg-warning text-white" id="final_student_predict">Final</th>
          <th class="px-3 bg-dark text-white" id="prediction">Prediction<sup class='badge badge-warning'>Prediction</sup></th>
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

          if (
            $prefinal_output_1 == 0 && $prefinal_output_2 == 0 &&
            $prefinal_performance_1 == 0 && $prefinal_performance_1 == 0 &&
            $prefinal_written_test == 0
          ) {

            if ($prefinal_prediction > 0) {
              $prefinal_prediction = $row_prefinal["prefinal_prediction"];
              $confirm_prefinal_prediction = $prefinal_prediction;
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


          if (
            $final_output_1 == 0 && $final_output_2 == 0 &&
            $final_performance_1 == 0 && $final_performance_1 == 0 &&
            $final_written_test == 0
          ) {

            // $final_grade = 0;

            if ($final_prediction > 0) {
              $final_prediction = $row_final["final_prediction"];
              $confirm_final_prediction = $final_prediction;
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



        ?>

          <tr class="text-center">
            <td class="bg-white"><?php echo $student_name; ?></td>
            <td id="get_prelim" class="bg-white"><?php echo $prelim_grade; ?></td>
            <td id="get_midterm" class="bg-white"><?php echo $midterm_grade; ?></td>
            <td class="bg-white"><span id="get_prefinal"><?php if ($prefinal_prediction > 0) {
                                                            echo $prefinal_prediction;
                                                          } else {
                                                            echo $prefinal_grade;
                                                          } ?></span><input type="text" id="prefinal_grade_prediction" class="text-center col-5 container-fluid" disabled></td>
            <td class="bg-white"><span id="get_final"><?php if ($final_prediction > 0) {
                                                        echo $final_prediction;
                                                      } else {
                                                        echo $final_grade;
                                                      } ?></span><input type="text" id="final_grade_prediction" class="text-center col-5 container-fluid" disabled></td>
            <td id="select_prediction" class="bg-white">
              <select class="form-control pt-1 pb-2 bg-dark text-white" id="average_predict" onchange="average()">
                <option value="select_grade_prediction">Select Value</option>
                <option value="1" id="1" <?php if (isset($_GET['ave'])) {
                                            if ($_GET['ave'] == "1") {
                                              echo 'selected';
                                            }
                                          } ?>>1</option>
                <option value="1.25" id="1.25" <?php if (isset($_GET['ave'])) {
                                                  if ($_GET['ave'] == "1.25") {
                                                    echo 'selected';
                                                  }
                                                } ?>>1.25</option>
                <option value="1.5" id="1.5" <?php if (isset($_GET['ave'])) {
                                                if ($_GET['ave'] == "1.5") {
                                                  echo 'selected';
                                                }
                                              } ?>>1.5</option>
                <option value="1.75" id="1.75" <?php if (isset($_GET['ave'])) {
                                                  if ($_GET['ave'] == "1.75") {
                                                    echo 'selected';
                                                  }
                                                } ?>>1.75</option>
                <option value="2" id="2" <?php if (isset($_GET['ave'])) {
                                            if ($_GET['ave'] == "2") {
                                              echo 'selected';
                                            }
                                          } ?>>2</option>
                <option value="2.25" id="2.25" <?php if (isset($_GET['ave'])) {
                                                  if ($_GET['ave'] == "2.25") {
                                                    echo 'selected';
                                                  }
                                                } ?>>2.25</option>
                <option value="2.5" id="2.5" <?php if (isset($_GET['ave'])) {
                                                if ($_GET['ave'] == "2.5") {
                                                  echo 'selected';
                                                }
                                              } ?>>2.5</option>
                <option value="2.75" id="2.75" <?php if (isset($_GET['ave'])) {
                                                  if ($_GET['ave'] == "2.75") {
                                                    echo 'selected';
                                                  }
                                                } ?>>2.75</option>
                <option value="3" id="3" <?php if (isset($_GET['ave'])) {
                                            if ($_GET['ave'] == "3") {
                                              echo 'selected';
                                            }
                                          } ?>>3</option>



              </select>
            </td>
          </tr>
          <!-- <tr class="text-center"> -->
          <!-- <td></td> -->
          <!-- <td></td> -->
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

  <!-- ma remove it grade prediction kung di kaabot it 75 -->

  <!-- Retain tag remove grade prediction select then bayluhan lang it 1 to 5
  Check lang ru equivalent it 75 to 100 sa 1 to 5 ag kato lang ma random it pili
   -->

  <!-- <input type="text" id="final_grade_prediction">
<input type="text" id="prefinal_grade_prediction"> -->

  <script>
    var select_average = document.getElementById("average_predict");
    // alert(select_average[1].value);
    var select_prelim = parseFloat(document.getElementById("get_prelim").innerHTML);
    var select_midterm = parseFloat(document.getElementById("get_midterm").innerHTML);
    var select_prefinal = parseFloat(document.getElementById("get_prefinal").innerHTML);
    // var select_prelim_and_midterm = select_prelim + select_midterm;
    var select_prelim_and_midterm = (select_prelim * 0.70) + ((select_prelim * 0.30) + (select_midterm * 0.70));
    var select_prelim_and_midterm_prefinal = select_prelim + select_midterm + select_prefinal;


    var get_prelim_value = document.getElementById("get_prelim");
    var get_midterm_value = document.getElementById("get_midterm");
    var get_prefinal_value = document.getElementById("get_prefinal");
    var get_final_value = document.getElementById("get_final");

    var confirm_prefinal_prediction = document.getElementById("confirm_prefinal_prediction").innerHTML;
    var confirm_final_prediction = document.getElementById("confirm_final_prediction").innerHTML;

    var average_prediction = (parseFloat(get_prelim_value.innerHTML) + parseFloat(get_midterm_value.innerHTML) + parseFloat(confirm_prefinal_prediction) + parseFloat(confirm_final_prediction)) / 4;


    var close_button = document.getElementById("close_btn");
    window.onkeyup = function(event) {
      if (event.keyCode == 27) {
        // document.getElementById(boxid).style.visibility="hidden";
        window.location.href = "prediction";
      }
    }


    // ########################################################
    // Daya tag gina remove ru kueang nga grade from 74      ##
    // ########################################################
    for (i = 1; i <= 74; i++) {
      // console.log("i = " + i);
      for (x = 1; x <= 74; x++) {
        // console.log(i + "+" + x);
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) > 75) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 76) {
          // alert("75");
          _75_3 = document.getElementById("3");
          _75_3.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 76) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 77) {
          // alert("76");
          _76_3 = document.getElementById("3");
          _76_3.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 77) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 78) {
          // alert("77");
          _77_2p75 = document.getElementById("2.75");
          _77_2p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 78) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 79) {
          // alert("78");
          _78_2p75 = document.getElementById("2.75");
          _78_2p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 79) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 80) {
          // alert("79");
          _79_2p75 = document.getElementById("2.75");
          _79_2p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 80) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 81) {
          // alert("80");
          _80_2p5 = document.getElementById("2.5");
          _80_2p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 81) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 82) {
          // alert("81");
          _81_2p5 = document.getElementById("2.5");
          _81_2p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 82) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 83) {
          // alert("82");
          _82_2p5 = document.getElementById("2.5");
          _82_2p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 83) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 84) {
          // alert("83");
          _83_2p25 = document.getElementById("2.25");
          _83_2p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 84) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 85) {
          // alert("84");
          _84_2p25 = document.getElementById("2.25");
          _84_2p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 85) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 86) {
          // alert("85");
          _85_2p25 = document.getElementById("2.25");
          _85_2p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 86) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 87) {
          // alert("86");
          _86_2 = document.getElementById("2");
          _86_2.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 87) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 88) {
          // alert("87");
          _87_2 = document.getElementById("2");
          _87_2.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 88) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 89) {
          // alert("88");
          _88_2 = document.getElementById("2");
          _88_2.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 89) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 90) {
          // alert("89");
          _89_1p75 = document.getElementById("1.75");
          _89_1p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 90) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 91) {
          // alert("90");
          _90_1p75 = document.getElementById("1.75");
          _90_1p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 91) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 92) {
          // alert("91");
          _91_1p75 = document.getElementById("1.75");
          _91_1p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 92) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 93) {
          // alert("92");
          _92_1p5 = document.getElementById("1.5");
          _92_1p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 93) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 94) {
          // alert("93");
          _93_1p5 = document.getElementById("1.5");
          _93_1p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 94) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 95) {
          // alert("94");
          _94_1p5 = document.getElementById("1.5");
          _94_1p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 95) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 96) {
          // alert("95");
          _95_1p25 = document.getElementById("1.25");
          _95_1p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 96) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 97) {
          // alert("96");
          _96_1p25 = document.getElementById("1.25");
          _96_1p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 97) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 98) {
          // alert("97");
          _97_1p25 = document.getElementById("1.25");
          _97_1p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 98) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 99) {
          // alert("98");
          _98_1 = document.getElementById("1");
          _98_1.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 99) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) < 100) {
          // alert("99");
          _99_1 = document.getElementById("1");
          _99_1.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (i * 0.70)) + ((i * 0.30) + (x * 0.70))) >= 100)) {
          // alert("100");
          _100_1 = document.getElementById("1");
          _100_1.style.display = "none";
        }
      }
    }

    // ########################################################
    // Daya tag gina remove ru ga sobra sa 100 nga grade     ##
    // ########################################################

    for (y = 100; y <= 200; y++) {
      // console.log("Y are you here? " + y);
      for (z = 100; z <= 200; z++) {
        // console.log(y+"+"+z);
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 75) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 76) {
          // alert("75");
          _75_3 = document.getElementById("3");
          _75_3.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 76) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 77) {
          // alert("76");
          _76_3 = document.getElementById("3");
          _76_3.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 77) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 78) {
          // alert("77");
          _77_2p75 = document.getElementById("2.75");
          _77_2p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 78) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 79) {
          // alert("78");
          _78_2p75 = document.getElementById("2.75");
          _78_2p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 79) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 80) {
          // alert("79");
          _79_2p75 = document.getElementById("2.75");
          _79_2p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 80) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 81) {
          // alert("80");
          _80_2p5 = document.getElementById("2.5");
          _80_2p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 81) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 82) {
          // alert("81");
          _81_2p5 = document.getElementById("2.5");
          _81_2p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 82) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 83) {
          // alert("82");
          _82_2p5 = document.getElementById("2.5");
          _82_2p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 83) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 84) {
          // alert("83");
          _83_2p25 = document.getElementById("2.25");
          _83_2p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 84) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 85) {
          // alert("84");
          _84_2p25 = document.getElementById("2.25");
          _84_2p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 85) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 86) {
          // alert("85");
          _85_2p25 = document.getElementById("2.25");
          _85_2p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 86) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 87) {
          // alert("86");
          _86_2 = document.getElementById("2");
          _86_2.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 87) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 88) {
          // alert("87");
          _87_2 = document.getElementById("2");
          _87_2.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 88) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 89) {
          // alert("88");
          _88_2 = document.getElementById("2");
          _88_2.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 89) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 90) {
          // alert("89");
          _89_1p75 = document.getElementById("1.75");
          _89_1p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 90) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 91) {
          // alert("90");
          _90_1p75 = document.getElementById("1.75");
          _90_1p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 91) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 92) {
          // alert("91");
          _91_1p75 = document.getElementById("1.75");
          _91_1p75.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 92) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 93) {
          // alert("92");
          _92_1p5 = document.getElementById("1.5");
          _92_1p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 93) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 94) {
          // alert("93");
          _93_1p5 = document.getElementById("1.5");
          _93_1p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 94) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 95) {
          // alert("94");
          _94_1p5 = document.getElementById("1.5");
          _94_1p5.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 95) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 96) {
          // alert("95");
          _95_1p25 = document.getElementById("1.25");
          _95_1p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 96) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 97) {
          // alert("96");
          _96_1p25 = document.getElementById("1.25");
          _96_1p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 97) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 98) {
          // alert("97");
          _97_1p25 = document.getElementById("1.25");
          _97_1p25.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 98) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 99) {
          // alert("98");
          _98_1 = document.getElementById("1");
          _98_1.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 99) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) < 100) {
          // alert("99");
          _99_1 = document.getElementById("1");
          _99_1.style.display = "none";
        }
        if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70))) >= 100)) {
          // alert("100");
          _100_1 = document.getElementById("1");
          _100_1.style.display = "none";
        }
      }
    }


    // if(get_prelim_value.innerHTML != 0 & get_midterm_value.innerHTML != 0 & get_prefinal_value.innerHTML != 0 & (get_final_value.innerHTML  == 0 | confirm_final_prediction > 0)){


    // ########################################################
    // From 74 to 100 nga checking average                   ##
    // ########################################################

    for (a = 1; a <= 74; a++) {
      // console.log("okay A: " + a);
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 75) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 76) {
        // alert("75");
        _75_3 = document.getElementById("3");
        _75_3.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 76) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 77) {
        // alert("76");
        _76_3 = document.getElementById("3");
        _76_3.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 77) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 78) {
        // alert("77");
        _77_2p75 = document.getElementById("2.75");
        _77_2p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 78) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 79) {
        // alert("78");
        _78_2p75 = document.getElementById("2.75");
        _78_2p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 79) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 80) {
        // alert("79");
        _79_2p75 = document.getElementById("2.75");
        _79_2p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 80) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 81) {
        // alert("80");
        _80_2p5 = document.getElementById("2.5");
        _80_2p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 81) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 82) {
        // alert("81");
        _81_2p5 = document.getElementById("2.5");
        _81_2p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 82) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 83) {
        // alert("82");
        _82_2p5 = document.getElementById("2.5");
        _82_2p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 83) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 84) {
        // alert("83");
        _83_2p25 = document.getElementById("2.25");
        _83_2p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 84) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 85) {
        // alert("84");
        _84_2p25 = document.getElementById("2.25");
        _84_2p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 85) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 86) {
        // alert("85");
        _85_2p25 = document.getElementById("2.25");
        _85_2p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 86) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 87) {
        // alert("86");
        _86_2 = document.getElementById("2");
        _86_2.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 87) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 88) {
        // alert("87");
        _87_2 = document.getElementById("2");
        _87_2.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 88) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 89) {
        // alert("88");
        _88_2 = document.getElementById("2");
        _88_2.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 89) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 90) {
        // alert("89");
        _89_1p75 = document.getElementById("1.75");
        _89_1p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 90) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 91) {
        // alert("90");
        _90_1p75 = document.getElementById("1.75");
        _90_1p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 91) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 92) {
        // alert("91");
        _91_1p75 = document.getElementById("1.75");
        _91_1p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 92) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 93) {
        // alert("92");
        _92_1p5 = document.getElementById("1.5");
        _92_1p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 93) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 94) {
        // alert("93");
        _93_1p5 = document.getElementById("1.5");
        _93_1p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 94) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 95) {
        // alert("94");
        _94_1p5 = document.getElementById("1.5");
        _94_1p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 95) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 96) {
        // alert("95");
        _95_1p25 = document.getElementById("1.25");
        _95_1p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 96) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 97) {
        // alert("96");
        _96_1p25 = document.getElementById("1.25");
        _96_1p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 97) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 98) {
        // alert("97");
        _97_1p25 = document.getElementById("1.25");
        _97_1p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 98) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 99) {
        // alert("98");
        _98_1 = document.getElementById("1");
        _98_1.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 99) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) < 100) {
        // alert("99");
        _99_1 = document.getElementById("1");
        _99_1.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (a * 0.70))) >= 100)) {
        // alert("100");
        _100_1 = document.getElementById("1");
        _100_1.style.display = "none";
      }
    }

    // ##############################################################
    // Para e remove sa select ru sobra or kueang nga prediction   ##
    // ##############################################################

    for (b = 100; b <= 150; b++) {
      // console.log(+b);
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 75) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 76) {
        // alert("75");
        _75_3 = document.getElementById("3");
        _75_3.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 76) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 77) {
        // alert("76");
        _76_3 = document.getElementById("3");
        _76_3.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 77) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 78) {
        // alert("77");
        _77_2p75 = document.getElementById("2.75");
        _77_2p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 78) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 79) {
        // alert("78");
        _78_2p75 = document.getElementById("2.75");
        _78_2p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 79) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 80) {
        // alert("79");
        _79_2p75 = document.getElementById("2.75");
        _79_2p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 80) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 81) {
        // alert("80");
        _80_2p5 = document.getElementById("2.5");
        _80_2p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 81) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 82) {
        // alert("81");
        _81_2p5 = document.getElementById("2.5");
        _81_2p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 82) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 83) {
        // alert("82");
        _82_2p5 = document.getElementById("2.5");
        _82_2p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 83) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 84) {
        // alert("83");
        _83_2p25 = document.getElementById("2.25");
        _83_2p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 84) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 85) {
        // alert("84");
        _84_2p25 = document.getElementById("2.25");
        _84_2p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 85) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 86) {
        // alert("85");
        _85_2p25 = document.getElementById("2.25");
        _85_2p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 86) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 87) {
        // alert("86");
        _86_2 = document.getElementById("2");
        _86_2.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 87) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 88) {
        // alert("87");
        _87_2 = document.getElementById("2");
        _87_2.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 88) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 89) {
        // alert("88");
        _88_2 = document.getElementById("2");
        _88_2.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 89) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 90) {
        // alert("89");
        _89_1p75 = document.getElementById("1.75");
        _89_1p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 90) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 91) {
        // alert("90");
        _90_1p75 = document.getElementById("1.75");
        _90_1p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 91) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 92) {
        // alert("91");
        _91_1p75 = document.getElementById("1.75");
        _91_1p75.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 92) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 93) {
        // alert("92");
        _92_1p5 = document.getElementById("1.5");
        _92_1p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 93) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 94) {
        // alert("93");
        _93_1p5 = document.getElementById("1.5");
        _93_1p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 94) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 95) {
        // alert("94");
        _94_1p5 = document.getElementById("1.5");
        _94_1p5.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 95) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 96) {
        // alert("95");
        _95_1p25 = document.getElementById("1.25");
        _95_1p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 96) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 97) {
        // alert("96");
        _96_1p25 = document.getElementById("1.25");
        _96_1p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 97) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 98) {
        // alert("97");
        _97_1p25 = document.getElementById("1.25");
        _97_1p25.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 98) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 99) {
        // alert("98");
        _98_1 = document.getElementById("1");
        _98_1.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 99) & (select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) < 100) {
        // alert("99");
        _99_1 = document.getElementById("1");
        _99_1.style.display = "none";
      }
      if (((select_prelim_and_midterm + ((select_midterm * 0.30) + (select_prefinal * 0.70)) + ((select_prefinal * 0.30) + (b * 0.70))) >= 100)) {
        // alert("100");
        _100_1 = document.getElementById("1");
        _100_1.style.display = "none";
      }
    }
    // ###############################
    // enddddd

    // }


    // alert("Low average value");

    // if(((select_prelim_and_midterm + 151) / 4) < select_average[2].value ){
    //   select_average.remove(1);
    //   if(((select_prelim_and_midterm + 151) / 4) < select_average[1].value ){
    //     select_average.remove(1);
    //   }
    // }

    // if(((select_prelim_and_midterm + 151) / 4) < select_average[3].value ){
    //   select_average.remove(1);
    //   if(((select_prelim_and_midterm + 151) / 4) < select_average[2].value ){
    //     select_average.remove(1);
    //       if(((select_prelim_and_midterm + 151) / 4) < select_average[1].value ){
    //       select_average.remove(1);
    //       }
    //   }
    // }



    var prefinal = document.getElementById("prefinal_student_predict");
    var prefinal_grade = document.getElementById("prefinal_grade");

    var prefinal_grade_prediction = document.getElementById("prefinal_grade_prediction");
    var get_prefinal = document.getElementById("get_prefinal");

    var final_grade_prediction = document.getElementById("final_grade_prediction");
    var get_final = document.getElementById("get_final");
    var final = document.getElementById("final_student_predict");
    var final_grade = document.getElementById("final_grade");
    var prediction = document.getElementById("prediction");
    var select_prediction = document.getElementById("select_prediction");

    var confirm_prefinal_prediction = document.getElementById("confirm_prefinal_prediction").innerHTML;
    var confirm_final_prediction = document.getElementById("confirm_final_prediction").innerHTML;
    var confirmation_prefinal = 0;
    var confirmation_final = 0;

    if (confirm_prefinal_prediction > 0) {
      confirmation_prefinal = 1;
      prefinal.classList.remove("bg-danger");
      prefinal.classList.add("bg-dark");
      prefinal.innerHTML += " <sup class='badge badge-warning'>Prediction</sup>";
    }
    if (confirm_final_prediction > 0) {
      confirmation_final = 1;
      final.classList.remove("bg-warning");
      final.classList.add("bg-dark");
      final.innerHTML += " <sup class='badge badge-warning'>Prediction</sup>";
    }

    if (get_prelim_value.innerHTML != 0 & get_midterm_value.innerHTML != 0 & get_prefinal_value.innerHTML == 0 & get_final_value.innerHTML == 0 & confirmation_prefinal == 0 & confirmation_final == 0) {

      if (prefinal_grade.value == 0 & final_grade.value == 0 & confirmation_prefinal == 0 & confirmation_final == 0) {
        prefinal_grade_prediction.style.display = "block";
        get_prefinal.style.display = "none";
        // prefinal.innerHTML += "<sup class='badge badge-warning'>Prediction</sup>";
      } else {
        prefinal_grade_prediction.style.display = "none";
        get_prefinal.style.display = "block";
      }



      if (final_grade.value == 0) {
        // var final_str = final.innerHTML;
        // var b = "<sup class='badge badge-warning'>Prediction</sup>";
        // var pos = 5;
        // final.innerHTML = [b,final_str.slice(pos)].join(final_str);

        final_grade_prediction.style.display = "block";
        get_final.style.display = "none";
        // final.innerHTML += "<sup class='badge badge-warning'>Prediction</sup>";


        // alert(final_str);
        // [final_str.slice(0),"<sup class='badge badge-warning'><small>Predict</small></sup>",0].join('');
        // final.innerHTML += string.slice("Final", "<sup class='badge badge-warning'><small>Predict</small></sup>");
      } else {
        final_grade_prediction.style.display = "none";
        get_final.style.display = "block";
      }
    } else if (get_prelim_value.innerHTML != 0 & get_midterm_value.innerHTML != 0 & get_prefinal_value.innerHTML != 0 & get_final_value.innerHTML == 0 & confirmation_prefinal == 0 & confirmation_final == 0) {

      if (final_grade.value == 0 & confirmation_prefinal == 0 & confirmation_final == 0) {

        final_grade_prediction.style.display = "block";
        get_final.style.display = "none";
        final.innerHTML += "<sup class='badge badge-warning'>Prediction</sup>";

      } else {
        final_grade_prediction.style.display = "none";
        get_final.style.display = "block";
      }


    } else if (get_prelim_value.innerHTML != 0 & get_midterm_value.innerHTML != 0 & get_prefinal_value.innerHTML != 0 & get_final_value.innerHTML != 0 & confirmation_prefinal != 0 & confirmation_final != 0) {

      // select_average.selectedIndex = 75;
      // select_average = select_average.options[select_average.selectedIndex].value;
      // select_average.selectedIndex.value = "87";

      // select_average = average_prediction;
      // alert(average_prediction);
      // alert(new_select_average);
      // get_prefinal.style.display = "block";
      // get_final.style.display = "block";
      // prefinal_grade_prediction.style.display = "none";
      // final_grade_prediction.style.display = "none";
      // prediction.style.display = "none";
      // select_prediction.style.display = "none";

      var new_select_average = document.getElementById("average_predict").selectedIndex.value;

      // new_select_average = "74";
      // alert(new_select_average);


    } else {
      get_prefinal.style.display = "block";
      get_final.style.display = "block";
      // prefinal_grade_prediction.style.display = "none";
      // final_grade_prediction.style.display = "none";
      // prediction.style.display = "none";
      // select_prediction.style.display = "none";
    }


    function average() {
      // var semester = document.getElementById("semester");
      var average = document.getElementById("average_predict");
      var selected_average = average.options[average.selectedIndex].value;
      let randomNumber = 0;

      // window.location.href="?ave="+selected_average;

      if (selected_average == "1") {
        randomNumber = Math.floor(Math.random() * 3) + 98;
        // alert(randomNumber);
      }

      if (selected_average == "1.25") {
        randomNumber = Math.floor(Math.random() * 3) + 95;
        // alert(randomNumber);
      }

      if (selected_average == "1.5") {
        randomNumber = Math.floor(Math.random() * 3) + 92;
        // alert(randomNumber);
      }

      if (selected_average == "1.75") {
        randomNumber = Math.floor(Math.random() * 3) + 89;
        // alert(randomNumber);
      }

      if (selected_average == "2") {
        randomNumber = Math.floor(Math.random() * 3) + 86;
        // alert(randomNumber);
      }

      if (selected_average == "2.25") {
        randomNumber = Math.floor(Math.random() * 3) + 83;
        // alert(randomNumber);
      }

      if (selected_average == "2.5") {
        randomNumber = Math.floor(Math.random() * 3) + 80;
        // alert(randomNumber);
      }

      if (selected_average == "2.75") {
        randomNumber = Math.floor(Math.random() * 3) + 77;
        // alert(randomNumber);
      }

      if (selected_average == "3") {
        randomNumber = Math.floor(Math.random() * 2) + 75;
        // alert(randomNumber);
      }

      var new_prelim = parseFloat(get_prelim_value.innerHTML);
      var new_midterm = parseFloat(get_midterm_value.innerHTML);
      var new_prefinal = parseFloat(get_prefinal_value.innerHTML);
      var prelim_midterm = (new_prelim * 0.70) + ((new_prelim * 0.30) + (new_midterm * 0.70));

      // alert(prelim_midterm.toFixed(2)/2);

      // var a = Math.floor((Math.random() * 74.4) + 0);

      // var a = Math.floor((Math.random() * 25) + 74.5);
      // var b = Math.floor((Math.random() * 25) + 74.5);
      // prefinal.innerHTML = a;
      // final.innerHTML = b;

      // var prefinal_final;
      var new_prefinal;
      var new_final;
      // var overall_average;

      var grade_array = [];

      // ___________75

      var _75_75 = ((select_midterm * 0.30) + (75 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _75_76 = ((select_midterm * 0.30) + (75 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _75_77 = ((select_midterm * 0.30) + (75 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _75_78 = ((select_midterm * 0.30) + (75 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _75_79 = ((select_midterm * 0.30) + (75 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _75_80 = ((select_midterm * 0.30) + (75 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _75_81 = ((select_midterm * 0.30) + (75 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _75_82 = ((select_midterm * 0.30) + (75 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _75_83 = ((select_midterm * 0.30) + (75 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _75_84 = ((select_midterm * 0.30) + (75 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _75_85 = ((select_midterm * 0.30) + (75 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _75_86 = ((select_midterm * 0.30) + (75 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _75_87 = ((select_midterm * 0.30) + (75 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _75_88 = ((select_midterm * 0.30) + (75 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _75_89 = ((select_midterm * 0.30) + (75 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _75_90 = ((select_midterm * 0.30) + (75 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _75_91 = ((select_midterm * 0.30) + (75 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _75_92 = ((select_midterm * 0.30) + (75 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _75_93 = ((select_midterm * 0.30) + (75 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _75_94 = ((select_midterm * 0.30) + (75 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _75_95 = ((select_midterm * 0.30) + (75 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _75_96 = ((select_midterm * 0.30) + (75 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _75_97 = ((select_midterm * 0.30) + (75 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _75_98 = ((select_midterm * 0.30) + (75 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _75_99 = ((select_midterm * 0.30) + (75 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _75_100 = ((select_midterm * 0.30) + (75 * 0.70)) + ((100 * 0.30) + (100 * 0.70));



      // ___________76

      var _76_75 = ((select_midterm * 0.30) + (76 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _76_76 = ((select_midterm * 0.30) + (76 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _76_77 = ((select_midterm * 0.30) + (76 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _76_78 = ((select_midterm * 0.30) + (76 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _76_79 = ((select_midterm * 0.30) + (76 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _76_80 = ((select_midterm * 0.30) + (76 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _76_81 = ((select_midterm * 0.30) + (76 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _76_82 = ((select_midterm * 0.30) + (76 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _76_83 = ((select_midterm * 0.30) + (76 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _76_84 = ((select_midterm * 0.30) + (76 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _76_85 = ((select_midterm * 0.30) + (76 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _76_86 = ((select_midterm * 0.30) + (76 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _76_87 = ((select_midterm * 0.30) + (76 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _76_88 = ((select_midterm * 0.30) + (76 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _76_89 = ((select_midterm * 0.30) + (76 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _76_90 = ((select_midterm * 0.30) + (76 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _76_91 = ((select_midterm * 0.30) + (76 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _76_92 = ((select_midterm * 0.30) + (76 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _76_93 = ((select_midterm * 0.30) + (76 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _76_94 = ((select_midterm * 0.30) + (76 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _76_95 = ((select_midterm * 0.30) + (76 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _76_96 = ((select_midterm * 0.30) + (76 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _76_97 = ((select_midterm * 0.30) + (76 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _76_98 = ((select_midterm * 0.30) + (76 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _76_99 = ((select_midterm * 0.30) + (76 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _76_100 = ((select_midterm * 0.30) + (76 * 0.70)) + ((100 * 0.30) + (100 * 0.70));



      // ___________77

      var _77_75 = ((select_midterm * 0.30) + (77 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _77_76 = ((select_midterm * 0.30) + (77 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _77_77 = ((select_midterm * 0.30) + (77 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _77_78 = ((select_midterm * 0.30) + (77 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _77_79 = ((select_midterm * 0.30) + (77 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _77_80 = ((select_midterm * 0.30) + (77 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _77_81 = ((select_midterm * 0.30) + (77 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _77_82 = ((select_midterm * 0.30) + (77 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _77_83 = ((select_midterm * 0.30) + (77 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _77_84 = ((select_midterm * 0.30) + (77 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _77_85 = ((select_midterm * 0.30) + (77 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _77_86 = ((select_midterm * 0.30) + (77 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _77_87 = ((select_midterm * 0.30) + (77 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _77_88 = ((select_midterm * 0.30) + (77 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _77_89 = ((select_midterm * 0.30) + (77 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _77_90 = ((select_midterm * 0.30) + (77 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _77_91 = ((select_midterm * 0.30) + (77 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _77_92 = ((select_midterm * 0.30) + (77 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _77_93 = ((select_midterm * 0.30) + (77 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _77_94 = ((select_midterm * 0.30) + (77 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _77_95 = ((select_midterm * 0.30) + (77 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _77_96 = ((select_midterm * 0.30) + (77 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _77_97 = ((select_midterm * 0.30) + (77 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _77_98 = ((select_midterm * 0.30) + (77 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _77_99 = ((select_midterm * 0.30) + (77 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _77_100 = ((select_midterm * 0.30) + (77 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________78

      var _78_75 = ((select_midterm * 0.30) + (78 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _78_76 = ((select_midterm * 0.30) + (78 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _78_77 = ((select_midterm * 0.30) + (78 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _78_78 = ((select_midterm * 0.30) + (78 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _78_79 = ((select_midterm * 0.30) + (78 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _78_80 = ((select_midterm * 0.30) + (78 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _78_81 = ((select_midterm * 0.30) + (78 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _78_82 = ((select_midterm * 0.30) + (78 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _78_83 = ((select_midterm * 0.30) + (78 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _78_84 = ((select_midterm * 0.30) + (78 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _78_85 = ((select_midterm * 0.30) + (78 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _78_86 = ((select_midterm * 0.30) + (78 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _78_87 = ((select_midterm * 0.30) + (78 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _78_88 = ((select_midterm * 0.30) + (78 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _78_89 = ((select_midterm * 0.30) + (78 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _78_90 = ((select_midterm * 0.30) + (78 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _78_91 = ((select_midterm * 0.30) + (78 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _78_92 = ((select_midterm * 0.30) + (78 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _78_93 = ((select_midterm * 0.30) + (78 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _78_94 = ((select_midterm * 0.30) + (78 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _78_95 = ((select_midterm * 0.30) + (78 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _78_96 = ((select_midterm * 0.30) + (78 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _78_97 = ((select_midterm * 0.30) + (78 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _78_98 = ((select_midterm * 0.30) + (78 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _78_99 = ((select_midterm * 0.30) + (78 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _78_100 = ((select_midterm * 0.30) + (78 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________79

      var _79_75 = ((select_midterm * 0.30) + (79 * 0.70)) + ((75 + 0.30) + (75 + 0.70));
      var _79_76 = ((select_midterm * 0.30) + (79 * 0.70)) + ((76 + 0.30) + (76 + 0.70));
      var _79_77 = ((select_midterm * 0.30) + (79 * 0.70)) + ((77 + 0.30) + (77 + 0.70));
      var _79_78 = ((select_midterm * 0.30) + (79 * 0.70)) + ((78 + 0.30) + (78 + 0.70));
      var _79_79 = ((select_midterm * 0.30) + (79 * 0.70)) + ((79 + 0.30) + (79 + 0.70));
      var _79_80 = ((select_midterm * 0.30) + (79 * 0.70)) + ((80 + 0.30) + (80 + 0.70));
      var _79_81 = ((select_midterm * 0.30) + (79 * 0.70)) + ((81 + 0.30) + (81 + 0.70));
      var _79_82 = ((select_midterm * 0.30) + (79 * 0.70)) + ((82 + 0.30) + (82 + 0.70));
      var _79_83 = ((select_midterm * 0.30) + (79 * 0.70)) + ((83 + 0.30) + (83 + 0.70));
      var _79_84 = ((select_midterm * 0.30) + (79 * 0.70)) + ((84 + 0.30) + (84 + 0.70));
      var _79_85 = ((select_midterm * 0.30) + (79 * 0.70)) + ((85 + 0.30) + (85 + 0.70));
      var _79_86 = ((select_midterm * 0.30) + (79 * 0.70)) + ((86 + 0.30) + (86 + 0.70));
      var _79_87 = ((select_midterm * 0.30) + (79 * 0.70)) + ((87 + 0.30) + (87 + 0.70));
      var _79_88 = ((select_midterm * 0.30) + (79 * 0.70)) + ((88 + 0.30) + (88 + 0.70));
      var _79_89 = ((select_midterm * 0.30) + (79 * 0.70)) + ((89 + 0.30) + (89 + 0.70));
      var _79_90 = ((select_midterm * 0.30) + (79 * 0.70)) + ((90 + 0.30) + (90 + 0.70));
      var _79_91 = ((select_midterm * 0.30) + (79 * 0.70)) + ((91 + 0.30) + (91 + 0.70));
      var _79_92 = ((select_midterm * 0.30) + (79 * 0.70)) + ((92 + 0.30) + (92 + 0.70));
      var _79_93 = ((select_midterm * 0.30) + (79 * 0.70)) + ((93 + 0.30) + (93 + 0.70));
      var _79_94 = ((select_midterm * 0.30) + (79 * 0.70)) + ((94 + 0.30) + (94 + 0.70));
      var _79_95 = ((select_midterm * 0.30) + (79 * 0.70)) + ((95 + 0.30) + (95 + 0.70));
      var _79_96 = ((select_midterm * 0.30) + (79 * 0.70)) + ((96 + 0.30) + (96 + 0.70));
      var _79_97 = ((select_midterm * 0.30) + (79 * 0.70)) + ((97 + 0.30) + (97 + 0.70));
      var _79_98 = ((select_midterm * 0.30) + (79 * 0.70)) + ((98 + 0.30) + (98 + 0.70));
      var _79_99 = ((select_midterm * 0.30) + (79 * 0.70)) + ((99 + 0.30) + (99 + 0.70));
      var _79_100 = ((select_midterm * 0.30) + (79 * 0.70)) + ((100 + 0.30) + (100 + 0.70));


      // ___________80

      var _80_75 = ((select_midterm * 0.30) + (80 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _80_76 = ((select_midterm * 0.30) + (80 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _80_77 = ((select_midterm * 0.30) + (80 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _80_78 = ((select_midterm * 0.30) + (80 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _80_79 = ((select_midterm * 0.30) + (80 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _80_80 = ((select_midterm * 0.30) + (80 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _80_81 = ((select_midterm * 0.30) + (80 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _80_82 = ((select_midterm * 0.30) + (80 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _80_83 = ((select_midterm * 0.30) + (80 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _80_84 = ((select_midterm * 0.30) + (80 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _80_85 = ((select_midterm * 0.30) + (80 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _80_86 = ((select_midterm * 0.30) + (80 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _80_87 = ((select_midterm * 0.30) + (80 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _80_88 = ((select_midterm * 0.30) + (80 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _80_89 = ((select_midterm * 0.30) + (80 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _80_90 = ((select_midterm * 0.30) + (80 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _80_91 = ((select_midterm * 0.30) + (80 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _80_92 = ((select_midterm * 0.30) + (80 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _80_93 = ((select_midterm * 0.30) + (80 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _80_94 = ((select_midterm * 0.30) + (80 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _80_95 = ((select_midterm * 0.30) + (80 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _80_96 = ((select_midterm * 0.30) + (80 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _80_97 = ((select_midterm * 0.30) + (80 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _80_98 = ((select_midterm * 0.30) + (80 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _80_99 = ((select_midterm * 0.30) + (80 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _80_100 = ((select_midterm * 0.30) + (80 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________81

      var _81_75 = ((select_midterm * 0.30) + (81 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _81_76 = ((select_midterm * 0.30) + (81 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _81_77 = ((select_midterm * 0.30) + (81 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _81_78 = ((select_midterm * 0.30) + (81 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _81_79 = ((select_midterm * 0.30) + (81 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _81_80 = ((select_midterm * 0.30) + (81 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _81_81 = ((select_midterm * 0.30) + (81 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _81_82 = ((select_midterm * 0.30) + (81 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _81_83 = ((select_midterm * 0.30) + (81 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _81_84 = ((select_midterm * 0.30) + (81 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _81_85 = ((select_midterm * 0.30) + (81 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _81_86 = ((select_midterm * 0.30) + (81 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _81_87 = ((select_midterm * 0.30) + (81 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _81_88 = ((select_midterm * 0.30) + (81 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _81_89 = ((select_midterm * 0.30) + (81 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _81_90 = ((select_midterm * 0.30) + (81 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _81_91 = ((select_midterm * 0.30) + (81 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _81_92 = ((select_midterm * 0.30) + (81 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _81_93 = ((select_midterm * 0.30) + (81 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _81_94 = ((select_midterm * 0.30) + (81 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _81_95 = ((select_midterm * 0.30) + (81 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _81_96 = ((select_midterm * 0.30) + (81 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _81_97 = ((select_midterm * 0.30) + (81 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _81_98 = ((select_midterm * 0.30) + (81 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _81_99 = ((select_midterm * 0.30) + (81 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _81_100 = ((select_midterm * 0.30) + (81 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________82

      var _82_75 = ((select_midterm * 0.30) + (82 + 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _82_76 = ((select_midterm * 0.30) + (82 + 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _82_77 = ((select_midterm * 0.30) + (82 + 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _82_78 = ((select_midterm * 0.30) + (82 + 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _82_79 = ((select_midterm * 0.30) + (82 + 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _82_80 = ((select_midterm * 0.30) + (82 + 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _82_81 = ((select_midterm * 0.30) + (82 + 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _82_82 = ((select_midterm * 0.30) + (82 + 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _82_83 = ((select_midterm * 0.30) + (82 + 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _82_84 = ((select_midterm * 0.30) + (82 + 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _82_85 = ((select_midterm * 0.30) + (82 + 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _82_86 = ((select_midterm * 0.30) + (82 + 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _82_87 = ((select_midterm * 0.30) + (82 + 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _82_88 = ((select_midterm * 0.30) + (82 + 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _82_89 = ((select_midterm * 0.30) + (82 + 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _82_90 = ((select_midterm * 0.30) + (82 + 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _82_91 = ((select_midterm * 0.30) + (82 + 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _82_92 = ((select_midterm * 0.30) + (82 + 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _82_93 = ((select_midterm * 0.30) + (82 + 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _82_94 = ((select_midterm * 0.30) + (82 + 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _82_95 = ((select_midterm * 0.30) + (82 + 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _82_96 = ((select_midterm * 0.30) + (82 + 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _82_97 = ((select_midterm * 0.30) + (82 + 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _82_98 = ((select_midterm * 0.30) + (82 + 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _82_99 = ((select_midterm * 0.30) + (82 + 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _82_100 = ((select_midterm * 0.30) + (82 + 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________83

      var _83_75 = ((select_midterm * 0.30) + (83 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _83_76 = ((select_midterm * 0.30) + (83 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _83_77 = ((select_midterm * 0.30) + (83 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _83_78 = ((select_midterm * 0.30) + (83 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _83_79 = ((select_midterm * 0.30) + (83 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _83_80 = ((select_midterm * 0.30) + (83 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _83_81 = ((select_midterm * 0.30) + (83 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _83_82 = ((select_midterm * 0.30) + (83 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _83_83 = ((select_midterm * 0.30) + (83 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _83_84 = ((select_midterm * 0.30) + (83 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _83_85 = ((select_midterm * 0.30) + (83 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _83_86 = ((select_midterm * 0.30) + (83 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _83_87 = ((select_midterm * 0.30) + (83 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _83_88 = ((select_midterm * 0.30) + (83 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _83_89 = ((select_midterm * 0.30) + (83 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _83_90 = ((select_midterm * 0.30) + (83 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _83_91 = ((select_midterm * 0.30) + (83 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _83_92 = ((select_midterm * 0.30) + (83 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _83_93 = ((select_midterm * 0.30) + (83 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _83_94 = ((select_midterm * 0.30) + (83 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _83_95 = ((select_midterm * 0.30) + (83 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _83_96 = ((select_midterm * 0.30) + (83 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _83_97 = ((select_midterm * 0.30) + (83 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _83_98 = ((select_midterm * 0.30) + (83 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _83_99 = ((select_midterm * 0.30) + (83 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _83_100 = ((select_midterm * 0.30) + (83 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________84

      var _84_75 = ((select_midterm * 0.30) + (84 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _84_76 = ((select_midterm * 0.30) + (84 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _84_77 = ((select_midterm * 0.30) + (84 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _84_78 = ((select_midterm * 0.30) + (84 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _84_79 = ((select_midterm * 0.30) + (84 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _84_80 = ((select_midterm * 0.30) + (84 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _84_81 = ((select_midterm * 0.30) + (84 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _84_82 = ((select_midterm * 0.30) + (84 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _84_83 = ((select_midterm * 0.30) + (84 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _84_84 = ((select_midterm * 0.30) + (84 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _84_85 = ((select_midterm * 0.30) + (84 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _84_86 = ((select_midterm * 0.30) + (84 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _84_87 = ((select_midterm * 0.30) + (84 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _84_88 = ((select_midterm * 0.30) + (84 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _84_89 = ((select_midterm * 0.30) + (84 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _84_90 = ((select_midterm * 0.30) + (84 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _84_91 = ((select_midterm * 0.30) + (84 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _84_92 = ((select_midterm * 0.30) + (84 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _84_93 = ((select_midterm * 0.30) + (84 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _84_94 = ((select_midterm * 0.30) + (84 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _84_95 = ((select_midterm * 0.30) + (84 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _84_96 = ((select_midterm * 0.30) + (84 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _84_97 = ((select_midterm * 0.30) + (84 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _84_98 = ((select_midterm * 0.30) + (84 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _84_99 = ((select_midterm * 0.30) + (84 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _84_100 = ((select_midterm * 0.30) + (84 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________85

      var _85_75 = ((select_midterm * 0.30) + (85 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _85_76 = ((select_midterm * 0.30) + (85 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _85_77 = ((select_midterm * 0.30) + (85 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _85_78 = ((select_midterm * 0.30) + (85 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _85_79 = ((select_midterm * 0.30) + (85 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _85_80 = ((select_midterm * 0.30) + (85 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _85_81 = ((select_midterm * 0.30) + (85 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _85_82 = ((select_midterm * 0.30) + (85 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _85_83 = ((select_midterm * 0.30) + (85 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _85_84 = ((select_midterm * 0.30) + (85 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _85_85 = ((select_midterm * 0.30) + (85 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _85_86 = ((select_midterm * 0.30) + (85 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _85_87 = ((select_midterm * 0.30) + (85 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _85_88 = ((select_midterm * 0.30) + (85 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _85_89 = ((select_midterm * 0.30) + (85 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _85_90 = ((select_midterm * 0.30) + (85 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _85_91 = ((select_midterm * 0.30) + (85 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _85_92 = ((select_midterm * 0.30) + (85 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _85_93 = ((select_midterm * 0.30) + (85 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _85_94 = ((select_midterm * 0.30) + (85 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _85_95 = ((select_midterm * 0.30) + (85 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _85_96 = ((select_midterm * 0.30) + (85 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _85_97 = ((select_midterm * 0.30) + (85 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _85_98 = ((select_midterm * 0.30) + (85 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _85_99 = ((select_midterm * 0.30) + (85 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _85_100 = ((select_midterm * 0.30) + (85 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________86

      var _86_75 = ((select_midterm * 0.30) + (86 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _86_76 = ((select_midterm * 0.30) + (86 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _86_77 = ((select_midterm * 0.30) + (86 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _86_78 = ((select_midterm * 0.30) + (86 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _86_79 = ((select_midterm * 0.30) + (86 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _86_80 = ((select_midterm * 0.30) + (86 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _86_81 = ((select_midterm * 0.30) + (86 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _86_82 = ((select_midterm * 0.30) + (86 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _86_83 = ((select_midterm * 0.30) + (86 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _86_84 = ((select_midterm * 0.30) + (86 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _86_85 = ((select_midterm * 0.30) + (86 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _86_86 = ((select_midterm * 0.30) + (86 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _86_87 = ((select_midterm * 0.30) + (86 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _86_88 = ((select_midterm * 0.30) + (86 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _86_89 = ((select_midterm * 0.30) + (86 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _86_90 = ((select_midterm * 0.30) + (86 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _86_91 = ((select_midterm * 0.30) + (86 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _86_92 = ((select_midterm * 0.30) + (86 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _86_93 = ((select_midterm * 0.30) + (86 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _86_94 = ((select_midterm * 0.30) + (86 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _86_95 = ((select_midterm * 0.30) + (86 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _86_96 = ((select_midterm * 0.30) + (86 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _86_97 = ((select_midterm * 0.30) + (86 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _86_98 = ((select_midterm * 0.30) + (86 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _86_99 = ((select_midterm * 0.30) + (86 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _86_100 = ((select_midterm * 0.30) + (86 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________87

      var _87_75 = ((select_midterm * 0.30) + (87 + 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _87_76 = ((select_midterm * 0.30) + (87 + 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _87_77 = ((select_midterm * 0.30) + (87 + 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _87_78 = ((select_midterm * 0.30) + (87 + 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _87_79 = ((select_midterm * 0.30) + (87 + 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _87_80 = ((select_midterm * 0.30) + (87 + 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _87_81 = ((select_midterm * 0.30) + (87 + 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _87_82 = ((select_midterm * 0.30) + (87 + 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _87_83 = ((select_midterm * 0.30) + (87 + 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _87_84 = ((select_midterm * 0.30) + (87 + 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _87_85 = ((select_midterm * 0.30) + (87 + 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _87_86 = ((select_midterm * 0.30) + (87 + 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _87_87 = ((select_midterm * 0.30) + (87 + 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _87_88 = ((select_midterm * 0.30) + (87 + 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _87_89 = ((select_midterm * 0.30) + (87 + 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _87_90 = ((select_midterm * 0.30) + (87 + 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _87_91 = ((select_midterm * 0.30) + (87 + 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _87_92 = ((select_midterm * 0.30) + (87 + 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _87_93 = ((select_midterm * 0.30) + (87 + 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _87_94 = ((select_midterm * 0.30) + (87 + 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _87_95 = ((select_midterm * 0.30) + (87 + 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _87_96 = ((select_midterm * 0.30) + (87 + 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _87_97 = ((select_midterm * 0.30) + (87 + 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _87_98 = ((select_midterm * 0.30) + (87 + 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _87_99 = ((select_midterm * 0.30) + (87 + 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _87_100 = ((select_midterm * 0.30) + (87 + 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________88

      var _88_75 = ((select_midterm * 0.30) + (88 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _88_76 = ((select_midterm * 0.30) + (88 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _88_77 = ((select_midterm * 0.30) + (88 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _88_78 = ((select_midterm * 0.30) + (88 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _88_79 = ((select_midterm * 0.30) + (88 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _88_80 = ((select_midterm * 0.30) + (88 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _88_81 = ((select_midterm * 0.30) + (88 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _88_82 = ((select_midterm * 0.30) + (88 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _88_83 = ((select_midterm * 0.30) + (88 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _88_84 = ((select_midterm * 0.30) + (88 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _88_85 = ((select_midterm * 0.30) + (88 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _88_86 = ((select_midterm * 0.30) + (88 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _88_87 = ((select_midterm * 0.30) + (88 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _88_88 = ((select_midterm * 0.30) + (88 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _88_89 = ((select_midterm * 0.30) + (88 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _88_90 = ((select_midterm * 0.30) + (88 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _88_91 = ((select_midterm * 0.30) + (88 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _88_92 = ((select_midterm * 0.30) + (88 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _88_93 = ((select_midterm * 0.30) + (88 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _88_94 = ((select_midterm * 0.30) + (88 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _88_95 = ((select_midterm * 0.30) + (88 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _88_96 = ((select_midterm * 0.30) + (88 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _88_97 = ((select_midterm * 0.30) + (88 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _88_98 = ((select_midterm * 0.30) + (88 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _88_99 = ((select_midterm * 0.30) + (88 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _88_100 = ((select_midterm * 0.30) + (88 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________89

      var _89_75 = ((select_midterm * 0.30) + (89 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _89_76 = ((select_midterm * 0.30) + (89 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _89_77 = ((select_midterm * 0.30) + (89 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _89_78 = ((select_midterm * 0.30) + (89 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _89_79 = ((select_midterm * 0.30) + (89 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _89_80 = ((select_midterm * 0.30) + (89 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _89_81 = ((select_midterm * 0.30) + (89 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _89_82 = ((select_midterm * 0.30) + (89 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _89_83 = ((select_midterm * 0.30) + (89 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _89_84 = ((select_midterm * 0.30) + (89 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _89_85 = ((select_midterm * 0.30) + (89 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _89_86 = ((select_midterm * 0.30) + (89 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _89_87 = ((select_midterm * 0.30) + (89 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _89_88 = ((select_midterm * 0.30) + (89 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _89_89 = ((select_midterm * 0.30) + (89 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _89_90 = ((select_midterm * 0.30) + (89 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _89_91 = ((select_midterm * 0.30) + (89 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _89_92 = ((select_midterm * 0.30) + (89 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _89_93 = ((select_midterm * 0.30) + (89 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _89_94 = ((select_midterm * 0.30) + (89 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _89_95 = ((select_midterm * 0.30) + (89 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _89_96 = ((select_midterm * 0.30) + (89 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _89_97 = ((select_midterm * 0.30) + (89 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _89_98 = ((select_midterm * 0.30) + (89 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _89_99 = ((select_midterm * 0.30) + (89 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _89_100 = ((select_midterm * 0.30) + (89 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________90

      var _90_75 = ((select_midterm * 0.30) + (90 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _90_76 = ((select_midterm * 0.30) + (90 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _90_77 = ((select_midterm * 0.30) + (90 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _90_78 = ((select_midterm * 0.30) + (90 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _90_79 = ((select_midterm * 0.30) + (90 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _90_80 = ((select_midterm * 0.30) + (90 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _90_81 = ((select_midterm * 0.30) + (90 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _90_82 = ((select_midterm * 0.30) + (90 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _90_83 = ((select_midterm * 0.30) + (90 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _90_84 = ((select_midterm * 0.30) + (90 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _90_85 = ((select_midterm * 0.30) + (90 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _90_86 = ((select_midterm * 0.30) + (90 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _90_87 = ((select_midterm * 0.30) + (90 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _90_88 = ((select_midterm * 0.30) + (90 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _90_89 = ((select_midterm * 0.30) + (90 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _90_90 = ((select_midterm * 0.30) + (90 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _90_91 = ((select_midterm * 0.30) + (90 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _90_92 = ((select_midterm * 0.30) + (90 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _90_93 = ((select_midterm * 0.30) + (90 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _90_94 = ((select_midterm * 0.30) + (90 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _90_95 = ((select_midterm * 0.30) + (90 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _90_96 = ((select_midterm * 0.30) + (90 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _90_97 = ((select_midterm * 0.30) + (90 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _90_98 = ((select_midterm * 0.30) + (90 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _90_99 = ((select_midterm * 0.30) + (90 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _90_100 = ((select_midterm * 0.30) + (90 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________91

      var _91_75 = ((select_midterm * 0.30) + (91 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _91_76 = ((select_midterm * 0.30) + (91 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _91_77 = ((select_midterm * 0.30) + (91 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _91_78 = ((select_midterm * 0.30) + (91 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _91_79 = ((select_midterm * 0.30) + (91 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _91_80 = ((select_midterm * 0.30) + (91 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _91_81 = ((select_midterm * 0.30) + (91 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _91_82 = ((select_midterm * 0.30) + (91 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _91_83 = ((select_midterm * 0.30) + (91 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _91_84 = ((select_midterm * 0.30) + (91 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _91_85 = ((select_midterm * 0.30) + (91 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _91_86 = ((select_midterm * 0.30) + (91 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _91_87 = ((select_midterm * 0.30) + (91 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _91_88 = ((select_midterm * 0.30) + (91 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _91_89 = ((select_midterm * 0.30) + (91 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _91_90 = ((select_midterm * 0.30) + (91 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _91_91 = ((select_midterm * 0.30) + (91 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _91_92 = ((select_midterm * 0.30) + (91 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _91_93 = ((select_midterm * 0.30) + (91 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _91_94 = ((select_midterm * 0.30) + (91 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _91_95 = ((select_midterm * 0.30) + (91 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _91_96 = ((select_midterm * 0.30) + (91 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _91_97 = ((select_midterm * 0.30) + (91 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _91_98 = ((select_midterm * 0.30) + (91 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _91_99 = ((select_midterm * 0.30) + (91 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _91_100 = ((select_midterm * 0.30) + (91 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________92

      var _92_75 = ((select_midterm * 0.30) + (92 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _92_76 = ((select_midterm * 0.30) + (92 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _92_77 = ((select_midterm * 0.30) + (92 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _92_78 = ((select_midterm * 0.30) + (92 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _92_79 = ((select_midterm * 0.30) + (92 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _92_80 = ((select_midterm * 0.30) + (92 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _92_81 = ((select_midterm * 0.30) + (92 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _92_82 = ((select_midterm * 0.30) + (92 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _92_83 = ((select_midterm * 0.30) + (92 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _92_84 = ((select_midterm * 0.30) + (92 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _92_85 = ((select_midterm * 0.30) + (92 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _92_86 = ((select_midterm * 0.30) + (92 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _92_87 = ((select_midterm * 0.30) + (92 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _92_88 = ((select_midterm * 0.30) + (92 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _92_89 = ((select_midterm * 0.30) + (92 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _92_90 = ((select_midterm * 0.30) + (92 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _92_91 = ((select_midterm * 0.30) + (92 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _92_92 = ((select_midterm * 0.30) + (92 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _92_93 = ((select_midterm * 0.30) + (92 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _92_94 = ((select_midterm * 0.30) + (92 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _92_95 = ((select_midterm * 0.30) + (92 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _92_96 = ((select_midterm * 0.30) + (92 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _92_97 = ((select_midterm * 0.30) + (92 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _92_98 = ((select_midterm * 0.30) + (92 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _92_99 = ((select_midterm * 0.30) + (92 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _92_100 = ((select_midterm * 0.30) + (92 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________93

      var _93_75 = ((select_midterm * 0.30) + (93 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _93_76 = ((select_midterm * 0.30) + (93 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _93_77 = ((select_midterm * 0.30) + (93 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _93_78 = ((select_midterm * 0.30) + (93 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _93_79 = ((select_midterm * 0.30) + (93 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _93_80 = ((select_midterm * 0.30) + (93 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _93_81 = ((select_midterm * 0.30) + (93 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _93_82 = ((select_midterm * 0.30) + (93 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _93_83 = ((select_midterm * 0.30) + (93 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _93_84 = ((select_midterm * 0.30) + (93 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _93_85 = ((select_midterm * 0.30) + (93 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _93_86 = ((select_midterm * 0.30) + (93 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _93_87 = ((select_midterm * 0.30) + (93 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _93_88 = ((select_midterm * 0.30) + (93 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _93_89 = ((select_midterm * 0.30) + (93 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _93_90 = ((select_midterm * 0.30) + (93 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _93_91 = ((select_midterm * 0.30) + (93 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _93_92 = ((select_midterm * 0.30) + (93 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _93_93 = ((select_midterm * 0.30) + (93 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _93_94 = ((select_midterm * 0.30) + (93 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _93_95 = ((select_midterm * 0.30) + (93 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _93_96 = ((select_midterm * 0.30) + (93 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _93_97 = ((select_midterm * 0.30) + (93 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _93_98 = ((select_midterm * 0.30) + (93 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _93_99 = ((select_midterm * 0.30) + (93 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _93_100 = ((select_midterm * 0.30) + (93 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________94

      var _94_75 = ((select_midterm * 0.30) + (94 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _94_76 = ((select_midterm * 0.30) + (94 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _94_77 = ((select_midterm * 0.30) + (94 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _94_78 = ((select_midterm * 0.30) + (94 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _94_79 = ((select_midterm * 0.30) + (94 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _94_80 = ((select_midterm * 0.30) + (94 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _94_81 = ((select_midterm * 0.30) + (94 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _94_82 = ((select_midterm * 0.30) + (94 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _94_83 = ((select_midterm * 0.30) + (94 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _94_84 = ((select_midterm * 0.30) + (94 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _94_85 = ((select_midterm * 0.30) + (94 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _94_86 = ((select_midterm * 0.30) + (94 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _94_87 = ((select_midterm * 0.30) + (94 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _94_88 = ((select_midterm * 0.30) + (94 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _94_89 = ((select_midterm * 0.30) + (94 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _94_90 = ((select_midterm * 0.30) + (94 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _94_91 = ((select_midterm * 0.30) + (94 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _94_92 = ((select_midterm * 0.30) + (94 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _94_93 = ((select_midterm * 0.30) + (94 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _94_94 = ((select_midterm * 0.30) + (94 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _94_95 = ((select_midterm * 0.30) + (94 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _94_96 = ((select_midterm * 0.30) + (94 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _94_97 = ((select_midterm * 0.30) + (94 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _94_98 = ((select_midterm * 0.30) + (94 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _94_99 = ((select_midterm * 0.30) + (94 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _94_100 = ((select_midterm * 0.30) + (94 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________95

      var _95_75 = ((select_midterm * 0.30) + (95 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _95_76 = ((select_midterm * 0.30) + (95 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _95_77 = ((select_midterm * 0.30) + (95 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _95_78 = ((select_midterm * 0.30) + (95 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _95_79 = ((select_midterm * 0.30) + (95 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _95_80 = ((select_midterm * 0.30) + (95 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _95_81 = ((select_midterm * 0.30) + (95 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _95_82 = ((select_midterm * 0.30) + (95 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _95_83 = ((select_midterm * 0.30) + (95 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _95_84 = ((select_midterm * 0.30) + (95 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _95_85 = ((select_midterm * 0.30) + (95 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _95_86 = ((select_midterm * 0.30) + (95 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _95_87 = ((select_midterm * 0.30) + (95 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _95_88 = ((select_midterm * 0.30) + (95 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _95_89 = ((select_midterm * 0.30) + (95 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _95_90 = ((select_midterm * 0.30) + (95 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _95_91 = ((select_midterm * 0.30) + (95 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _95_92 = ((select_midterm * 0.30) + (95 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _95_93 = ((select_midterm * 0.30) + (95 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _95_94 = ((select_midterm * 0.30) + (95 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _95_95 = ((select_midterm * 0.30) + (95 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _95_96 = ((select_midterm * 0.30) + (95 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _95_97 = ((select_midterm * 0.30) + (95 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _95_98 = ((select_midterm * 0.30) + (95 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _95_99 = ((select_midterm * 0.30) + (95 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _95_100 = ((select_midterm * 0.30) + (95 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________96

      var _96_75 = ((select_midterm * 0.30) + (96 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _96_76 = ((select_midterm * 0.30) + (96 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _96_77 = ((select_midterm * 0.30) + (96 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _96_78 = ((select_midterm * 0.30) + (96 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _96_79 = ((select_midterm * 0.30) + (96 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _96_80 = ((select_midterm * 0.30) + (96 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _96_81 = ((select_midterm * 0.30) + (96 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _96_82 = ((select_midterm * 0.30) + (96 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _96_83 = ((select_midterm * 0.30) + (96 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _96_84 = ((select_midterm * 0.30) + (96 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _96_85 = ((select_midterm * 0.30) + (96 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _96_86 = ((select_midterm * 0.30) + (96 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _96_87 = ((select_midterm * 0.30) + (96 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _96_88 = ((select_midterm * 0.30) + (96 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _96_89 = ((select_midterm * 0.30) + (96 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _96_90 = ((select_midterm * 0.30) + (96 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _96_91 = ((select_midterm * 0.30) + (96 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _96_92 = ((select_midterm * 0.30) + (96 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _96_93 = ((select_midterm * 0.30) + (96 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _96_94 = ((select_midterm * 0.30) + (96 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _96_95 = ((select_midterm * 0.30) + (96 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _96_96 = ((select_midterm * 0.30) + (96 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _96_97 = ((select_midterm * 0.30) + (96 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _96_98 = ((select_midterm * 0.30) + (96 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _96_99 = ((select_midterm * 0.30) + (96 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _96_100 = ((select_midterm * 0.30) + (96 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________97

      var _97_75 = ((select_midterm * 0.30) + (97 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _97_76 = ((select_midterm * 0.30) + (97 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _97_77 = ((select_midterm * 0.30) + (97 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _97_78 = ((select_midterm * 0.30) + (97 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _97_79 = ((select_midterm * 0.30) + (97 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _97_80 = ((select_midterm * 0.30) + (97 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _97_81 = ((select_midterm * 0.30) + (97 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _97_82 = ((select_midterm * 0.30) + (97 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _97_83 = ((select_midterm * 0.30) + (97 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _97_84 = ((select_midterm * 0.30) + (97 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _97_85 = ((select_midterm * 0.30) + (97 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _97_86 = ((select_midterm * 0.30) + (97 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _97_87 = ((select_midterm * 0.30) + (97 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _97_88 = ((select_midterm * 0.30) + (97 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _97_89 = ((select_midterm * 0.30) + (97 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _97_90 = ((select_midterm * 0.30) + (97 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _97_91 = ((select_midterm * 0.30) + (97 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _97_92 = ((select_midterm * 0.30) + (97 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _97_93 = ((select_midterm * 0.30) + (97 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _97_94 = ((select_midterm * 0.30) + (97 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _97_95 = ((select_midterm * 0.30) + (97 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _97_96 = ((select_midterm * 0.30) + (97 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _97_97 = ((select_midterm * 0.30) + (97 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _97_98 = ((select_midterm * 0.30) + (97 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _97_99 = ((select_midterm * 0.30) + (97 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _97_100 = ((select_midterm * 0.30) + (97 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________98

      var _98_75 = ((select_midterm * 0.30) + (98 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _98_76 = ((select_midterm * 0.30) + (98 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _98_77 = ((select_midterm * 0.30) + (98 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _98_78 = ((select_midterm * 0.30) + (98 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _98_79 = ((select_midterm * 0.30) + (98 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _98_80 = ((select_midterm * 0.30) + (98 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _98_81 = ((select_midterm * 0.30) + (98 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _98_82 = ((select_midterm * 0.30) + (98 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _98_83 = ((select_midterm * 0.30) + (98 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _98_84 = ((select_midterm * 0.30) + (98 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _98_85 = ((select_midterm * 0.30) + (98 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _98_86 = ((select_midterm * 0.30) + (98 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _98_87 = ((select_midterm * 0.30) + (98 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _98_88 = ((select_midterm * 0.30) + (98 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _98_89 = ((select_midterm * 0.30) + (98 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _98_90 = ((select_midterm * 0.30) + (98 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _98_91 = ((select_midterm * 0.30) + (98 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _98_92 = ((select_midterm * 0.30) + (98 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _98_93 = ((select_midterm * 0.30) + (98 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _98_94 = ((select_midterm * 0.30) + (98 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _98_95 = ((select_midterm * 0.30) + (98 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _98_96 = ((select_midterm * 0.30) + (98 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _98_97 = ((select_midterm * 0.30) + (98 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _98_98 = ((select_midterm * 0.30) + (98 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _98_99 = ((select_midterm * 0.30) + (98 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _98_100 = ((select_midterm * 0.30) + (98 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________99

      var _99_75 = ((select_midterm * 0.30) + (99 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _99_76 = ((select_midterm * 0.30) + (99 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _99_77 = ((select_midterm * 0.30) + (99 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _99_78 = ((select_midterm * 0.30) + (99 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _99_79 = ((select_midterm * 0.30) + (99 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _99_80 = ((select_midterm * 0.30) + (99 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _99_81 = ((select_midterm * 0.30) + (99 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _99_82 = ((select_midterm * 0.30) + (99 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _99_83 = ((select_midterm * 0.30) + (99 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _99_84 = ((select_midterm * 0.30) + (99 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _99_85 = ((select_midterm * 0.30) + (99 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _99_86 = ((select_midterm * 0.30) + (99 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _99_87 = ((select_midterm * 0.30) + (99 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _99_88 = ((select_midterm * 0.30) + (99 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _99_89 = ((select_midterm * 0.30) + (99 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _99_90 = ((select_midterm * 0.30) + (99 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _99_91 = ((select_midterm * 0.30) + (99 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _99_92 = ((select_midterm * 0.30) + (99 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _99_93 = ((select_midterm * 0.30) + (99 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _99_94 = ((select_midterm * 0.30) + (99 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _99_95 = ((select_midterm * 0.30) + (99 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _99_96 = ((select_midterm * 0.30) + (99 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _99_97 = ((select_midterm * 0.30) + (99 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _99_98 = ((select_midterm * 0.30) + (99 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _99_99 = ((select_midterm * 0.30) + (99 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _99_100 = ((select_midterm * 0.30) + (99 * 0.70)) + ((100 * 0.30) + (100 * 0.70));


      // ___________100

      var _100_75 = ((select_midterm * 0.30) + (100 * 0.70)) + ((75 * 0.30) + (75 * 0.70));
      var _100_76 = ((select_midterm * 0.30) + (100 * 0.70)) + ((76 * 0.30) + (76 * 0.70));
      var _100_77 = ((select_midterm * 0.30) + (100 * 0.70)) + ((77 * 0.30) + (77 * 0.70));
      var _100_78 = ((select_midterm * 0.30) + (100 * 0.70)) + ((78 * 0.30) + (78 * 0.70));
      var _100_79 = ((select_midterm * 0.30) + (100 * 0.70)) + ((79 * 0.30) + (79 * 0.70));
      var _100_80 = ((select_midterm * 0.30) + (100 * 0.70)) + ((80 * 0.30) + (80 * 0.70));
      var _100_81 = ((select_midterm * 0.30) + (100 * 0.70)) + ((81 * 0.30) + (81 * 0.70));
      var _100_82 = ((select_midterm * 0.30) + (100 * 0.70)) + ((82 * 0.30) + (82 * 0.70));
      var _100_83 = ((select_midterm * 0.30) + (100 * 0.70)) + ((83 * 0.30) + (83 * 0.70));
      var _100_84 = ((select_midterm * 0.30) + (100 * 0.70)) + ((84 * 0.30) + (84 * 0.70));
      var _100_85 = ((select_midterm * 0.30) + (100 * 0.70)) + ((85 * 0.30) + (85 * 0.70));
      var _100_86 = ((select_midterm * 0.30) + (100 * 0.70)) + ((86 * 0.30) + (86 * 0.70));
      var _100_87 = ((select_midterm * 0.30) + (100 * 0.70)) + ((87 * 0.30) + (87 * 0.70));
      var _100_88 = ((select_midterm * 0.30) + (100 * 0.70)) + ((88 * 0.30) + (88 * 0.70));
      var _100_89 = ((select_midterm * 0.30) + (100 * 0.70)) + ((89 * 0.30) + (89 * 0.70));
      var _100_90 = ((select_midterm * 0.30) + (100 * 0.70)) + ((90 * 0.30) + (90 * 0.70));
      var _100_91 = ((select_midterm * 0.30) + (100 * 0.70)) + ((91 * 0.30) + (91 * 0.70));
      var _100_92 = ((select_midterm * 0.30) + (100 * 0.70)) + ((92 * 0.30) + (92 * 0.70));
      var _100_93 = ((select_midterm * 0.30) + (100 * 0.70)) + ((93 * 0.30) + (93 * 0.70));
      var _100_94 = ((select_midterm * 0.30) + (100 * 0.70)) + ((94 * 0.30) + (94 * 0.70));
      var _100_95 = ((select_midterm * 0.30) + (100 * 0.70)) + ((95 * 0.30) + (95 * 0.70));
      var _100_96 = ((select_midterm * 0.30) + (100 * 0.70)) + ((96 * 0.30) + (96 * 0.70));
      var _100_97 = ((select_midterm * 0.30) + (100 * 0.70)) + ((97 * 0.30) + (97 * 0.70));
      var _100_98 = ((select_midterm * 0.30) + (100 * 0.70)) + ((98 * 0.30) + (98 * 0.70));
      var _100_99 = ((select_midterm * 0.30) + (100 * 0.70)) + ((99 * 0.30) + (99 * 0.70));
      var _100_100 = ((select_midterm * 0.30) + (100 * 0.70)) + ((100 * 0.30) + (100 * 0.70));

      if (get_prelim_value.innerHTML != 0 & get_midterm_value.innerHTML != 0 & (get_prefinal_value.innerHTML == 0 | confirmation_prefinal > 0) & (get_final_value.innerHTML == 0 | confirmation_final > 0)) {


        // _75

        if (((prelim_midterm + _75_75) >= randomNumber) & (prelim_midterm + _75_75) <= parseInt(randomNumber) + 1) {
          // alert(randomNumber);
          grade_array.push("_75_75");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(_75_75.valueOf());
          // alert(grade_array);
          // alert((prelim_midterm+_75_77)/4);
        }

        if (((prelim_midterm + _75_76) >= randomNumber) & (prelim_midterm + _75_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_76");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_77) >= randomNumber) & (prelim_midterm + _75_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_77");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_78) >= randomNumber) & (prelim_midterm + _75_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_78");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_79) >= randomNumber) & (prelim_midterm + _75_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_79");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_80) >= randomNumber) & (prelim_midterm + _75_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_80");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_81) >= randomNumber) & (prelim_midterm + _75_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_81");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_82) >= randomNumber) & (prelim_midterm + _75_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_82");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_83) >= randomNumber) & (prelim_midterm + _75_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_83");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_84) >= randomNumber) & (prelim_midterm + _75_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_84");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_85) >= randomNumber) & (prelim_midterm + _75_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_85");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_86) >= randomNumber) & (prelim_midterm + _75_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_86");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_87) >= randomNumber) & (prelim_midterm + _75_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_87");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_88) >= randomNumber) & (prelim_midterm + _75_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_88");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_89) >= randomNumber) & (prelim_midterm + _75_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_89");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_90) >= randomNumber) & (prelim_midterm + _75_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_90");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_91) >= randomNumber) & (prelim_midterm + _75_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_91");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_92) >= randomNumber) & (prelim_midterm + _75_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_92");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_93) >= randomNumber) & (prelim_midterm + _75_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_93");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_94) >= randomNumber) & (prelim_midterm + _75_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_94");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_95) >= randomNumber) & (prelim_midterm + _75_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_95");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_96) >= randomNumber) & (prelim_midterm + _75_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_96");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_97) >= randomNumber) & (prelim_midterm + _75_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_97");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_98) >= randomNumber) & (prelim_midterm + _75_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_98");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_99) >= randomNumber) & (prelim_midterm + _75_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_99");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _75_100) >= randomNumber) & (prelim_midterm + _75_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_75_100");
          new_prefinal = ((select_midterm * 0.30) + (75 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // _76

        if (((prelim_midterm + _76_75) >= randomNumber) & (prelim_midterm + _76_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_75");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_76) >= randomNumber) & (prelim_midterm + _76_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_76");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_77) >= randomNumber) & (prelim_midterm + _76_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_77");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_78) >= randomNumber) & (prelim_midterm + _76_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_78");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_79) >= randomNumber) & (prelim_midterm + _76_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_79");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_80) >= randomNumber) & (prelim_midterm + _76_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_80");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_81) >= randomNumber) & (prelim_midterm + _76_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_81");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_82) >= randomNumber) & (prelim_midterm + _76_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_82");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_83) >= randomNumber) & (prelim_midterm + _76_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_83");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_84) >= randomNumber) & (prelim_midterm + _76_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_84");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_85) >= randomNumber) & (prelim_midterm + _76_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_85");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_86) >= randomNumber) & (prelim_midterm + _76_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_86");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_87) >= randomNumber) & (prelim_midterm + _76_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_87");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_88) >= randomNumber) & (prelim_midterm + _76_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_88");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_89) >= randomNumber) & (prelim_midterm + _76_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_89");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_90) >= randomNumber) & (prelim_midterm + _76_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_90");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_91) >= randomNumber) & (prelim_midterm + _76_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_91");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_92) >= randomNumber) & (prelim_midterm + _76_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_92");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_93) >= randomNumber) & (prelim_midterm + _76_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_93");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_94) >= randomNumber) & (prelim_midterm + _76_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_94");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_95) >= randomNumber) & (prelim_midterm + _76_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_95");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_96) >= randomNumber) & (prelim_midterm + _76_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_96");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_97) >= randomNumber) & (prelim_midterm + _76_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_97");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_98) >= randomNumber) & (prelim_midterm + _76_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_98");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_99) >= randomNumber) & (prelim_midterm + _76_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_99");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _76_100) >= randomNumber) & (prelim_midterm + _76_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_76_100");
          new_prefinal = ((select_midterm * 0.30) + (76 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }



        // _77

        if (((prelim_midterm + _77_75) >= randomNumber) & (prelim_midterm + _77_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_75");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_76) >= randomNumber) & (prelim_midterm + _77_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_76");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_77) >= randomNumber) & (prelim_midterm + _77_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_77");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_78) >= randomNumber) & (prelim_midterm + _77_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_78");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_79) >= randomNumber) & (prelim_midterm + _77_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_79");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_80) >= randomNumber) & (prelim_midterm + _77_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_80");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_81) >= randomNumber) & (prelim_midterm + _77_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_81");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_82) >= randomNumber) & (prelim_midterm + _77_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_82");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_83) >= randomNumber) & (prelim_midterm + _77_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_83");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_84) >= randomNumber) & (prelim_midterm + _77_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_84");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_85) >= randomNumber) & (prelim_midterm + _77_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_85");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_86) >= randomNumber) & (prelim_midterm + _77_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_86");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_87) >= randomNumber) & (prelim_midterm + _77_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_87");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_88) >= randomNumber) & (prelim_midterm + _77_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_88");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_89) >= randomNumber) & (prelim_midterm + _77_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_89");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_90) >= randomNumber) & (prelim_midterm + _77_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_90");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_91) >= randomNumber) & (prelim_midterm + _77_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_91");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_92) >= randomNumber) & (prelim_midterm + _77_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_92");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_93) >= randomNumber) & (prelim_midterm + _77_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_93");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_94) >= randomNumber) & (prelim_midterm + _77_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_94");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_95) >= randomNumber) & (prelim_midterm + _77_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_95");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_96) >= randomNumber) & (prelim_midterm + _77_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_96");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_97) >= randomNumber) & (prelim_midterm + _77_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_97");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_98) >= randomNumber) & (prelim_midterm + _77_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_98");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_99) >= randomNumber) & (prelim_midterm + _77_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_99");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _77_100) >= randomNumber) & (prelim_midterm + _77_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_77_100");
          new_prefinal = ((select_midterm * 0.30) + (77 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 78

        if (((prelim_midterm + _78_75) >= randomNumber) & (prelim_midterm + _78_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_75");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_76) >= randomNumber) & (prelim_midterm + _78_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_76");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_77) >= randomNumber) & (prelim_midterm + _78_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_77");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_78) >= randomNumber) & (prelim_midterm + _78_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_78");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_79) >= randomNumber) & (prelim_midterm + _78_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_79");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_80) >= randomNumber) & (prelim_midterm + _78_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_80");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_81) >= randomNumber) & (prelim_midterm + _78_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_81");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_82) >= randomNumber) & (prelim_midterm + _78_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_82");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_83) >= randomNumber) & (prelim_midterm + _78_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_83");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_84) >= randomNumber) & (prelim_midterm + _78_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_84");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_85) >= randomNumber) & (prelim_midterm + _78_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_85");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_86) >= randomNumber) & (prelim_midterm + _78_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_86");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_87) >= randomNumber) & (prelim_midterm + _78_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_87");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_88) >= randomNumber) & (prelim_midterm + _78_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_88");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_89) >= randomNumber) & (prelim_midterm + _78_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_89");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_90) >= randomNumber) & (prelim_midterm + _78_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_90");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_91) >= randomNumber) & (prelim_midterm + _78_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_91");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_92) >= randomNumber) & (prelim_midterm + _78_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_92");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_93) >= randomNumber) & (prelim_midterm + _78_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_93");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_94) >= randomNumber) & (prelim_midterm + _78_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_94");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_95) >= randomNumber) & (prelim_midterm + _78_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_95");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_96) >= randomNumber) & (prelim_midterm + _78_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_96");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_97) >= randomNumber) & (prelim_midterm + _78_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_97");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_98) >= randomNumber) & (prelim_midterm + _78_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_98");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_99) >= randomNumber) & (prelim_midterm + _78_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_99");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _78_100) >= randomNumber) & (prelim_midterm + _78_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_78_100");
          new_prefinal = ((select_midterm * 0.30) + (78 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 79

        if (((prelim_midterm + _79_75) >= randomNumber) & (prelim_midterm + _79_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_75");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_76) >= randomNumber) & (prelim_midterm + _79_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_76");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_77) >= randomNumber) & (prelim_midterm + _79_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_77");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_78) >= randomNumber) & (prelim_midterm + _79_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_78");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_79) >= randomNumber) & (prelim_midterm + _79_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_79");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_80) >= randomNumber) & (prelim_midterm + _79_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_80");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_81) >= randomNumber) & (prelim_midterm + _79_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_81");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_82) >= randomNumber) & (prelim_midterm + _79_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_82");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_83) >= randomNumber) & (prelim_midterm + _79_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_83");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_84) >= randomNumber) & (prelim_midterm + _79_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_84");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_85) >= randomNumber) & (prelim_midterm + _79_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_85");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_86) >= randomNumber) & (prelim_midterm + _79_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_86");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_87) >= randomNumber) & (prelim_midterm + _79_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_87");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_88) >= randomNumber) & (prelim_midterm + _79_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_88");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_89) >= randomNumber) & (prelim_midterm + _79_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_89");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_90) >= randomNumber) & (prelim_midterm + _79_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_90");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_91) >= randomNumber) & (prelim_midterm + _79_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_91");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_92) >= randomNumber) & (prelim_midterm + _79_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_92");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_93) >= randomNumber) & (prelim_midterm + _79_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_93");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_94) >= randomNumber) & (prelim_midterm + _79_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_94");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_95) >= randomNumber) & (prelim_midterm + _79_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_95");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_96) >= randomNumber) & (prelim_midterm + _79_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_96");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_97) >= randomNumber) & (prelim_midterm + _79_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_97");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_98) >= randomNumber) & (prelim_midterm + _79_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_98");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_99) >= randomNumber) & (prelim_midterm + _79_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_99");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _79_100) >= randomNumber) & (prelim_midterm + _79_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_79_100");
          new_prefinal = ((select_midterm * 0.30) + (79 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 80

        if (((prelim_midterm + _80_75) >= randomNumber) & (prelim_midterm + _80_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_75");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_76) >= randomNumber) & (prelim_midterm + _80_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_76");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_77) >= randomNumber) & (prelim_midterm + _80_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_77");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_78) >= randomNumber) & (prelim_midterm + _80_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_78");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_79) >= randomNumber) & (prelim_midterm + _80_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_79");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_80) >= randomNumber) & (prelim_midterm + _80_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_80");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_81) >= randomNumber) & (prelim_midterm + _80_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_81");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_82) >= randomNumber) & (prelim_midterm + _80_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_82");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_83) >= randomNumber) & (prelim_midterm + _80_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_83");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_84) >= randomNumber) & (prelim_midterm + _80_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_84");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_85) >= randomNumber) & (prelim_midterm + _80_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_85");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_86) >= randomNumber) & (prelim_midterm + _80_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_86");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_87) >= randomNumber) & (prelim_midterm + _80_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_87");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_88) >= randomNumber) & (prelim_midterm + _80_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_88");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_89) >= randomNumber) & (prelim_midterm + _80_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_89");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_90) >= randomNumber) & (prelim_midterm + _80_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_90");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_91) >= randomNumber) & (prelim_midterm + _80_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_91");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_92) >= randomNumber) & (prelim_midterm + _80_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_92");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_93) >= randomNumber) & (prelim_midterm + _80_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_93");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_94) >= randomNumber) & (prelim_midterm + _80_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_94");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_95) >= randomNumber) & (prelim_midterm + _80_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_95");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_96) >= randomNumber) & (prelim_midterm + _80_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_96");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_97) >= randomNumber) & (prelim_midterm + _80_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_97");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_98) >= randomNumber) & (prelim_midterm + _80_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_98");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_99) >= randomNumber) & (prelim_midterm + _80_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_99");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _80_100) >= randomNumber) & (prelim_midterm + _80_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_80_100");
          new_prefinal = ((select_midterm * 0.30) + (80 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 81

        if (((prelim_midterm + _81_75) >= randomNumber) & (prelim_midterm + _81_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_75");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_76) >= randomNumber) & (prelim_midterm + _81_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_76");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_77) >= randomNumber) & (prelim_midterm + _81_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_77");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_78) >= randomNumber) & (prelim_midterm + _81_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_78");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_79) >= randomNumber) & (prelim_midterm + _81_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_79");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_80) >= randomNumber) & (prelim_midterm + _81_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_80");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_81) >= randomNumber) & (prelim_midterm + _81_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_81");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_82) >= randomNumber) & (prelim_midterm + _81_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_82");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_83) >= randomNumber) & (prelim_midterm + _81_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_83");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_84) >= randomNumber) & (prelim_midterm + _81_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_84");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_85) >= randomNumber) & (prelim_midterm + _81_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_85");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_86) >= randomNumber) & (prelim_midterm + _81_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_86");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_87) >= randomNumber) & (prelim_midterm + _81_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_87");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_88) >= randomNumber) & (prelim_midterm + _81_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_88");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_89) >= randomNumber) & (prelim_midterm + _81_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_89");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_90) >= randomNumber) & (prelim_midterm + _81_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_90");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_91) >= randomNumber) & (prelim_midterm + _81_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_91");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_92) >= randomNumber) & (prelim_midterm + _81_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_92");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_93) >= randomNumber) & (prelim_midterm + _81_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_93");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_94) >= randomNumber) & (prelim_midterm + _81_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_94");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_95) >= randomNumber) & (prelim_midterm + _81_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_95");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_96) >= randomNumber) & (prelim_midterm + _81_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_96");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_97) >= randomNumber) & (prelim_midterm + _81_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_97");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_98) >= randomNumber) & (prelim_midterm + _81_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_98");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_99) >= randomNumber) & (prelim_midterm + _81_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_99");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _81_100) >= randomNumber) & (prelim_midterm + _81_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_81_100");
          new_prefinal = ((select_midterm * 0.30) + (81 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 82

        if (((prelim_midterm + _82_75) >= randomNumber) & (prelim_midterm + _82_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_75");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_76) >= randomNumber) & (prelim_midterm + _82_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_76");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_77) >= randomNumber) & (prelim_midterm + _82_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_77");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_78) >= randomNumber) & (prelim_midterm + _82_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_78");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_79) >= randomNumber) & (prelim_midterm + _82_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_79");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_80) >= randomNumber) & (prelim_midterm + _82_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_80");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_81) >= randomNumber) & (prelim_midterm + _82_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_81");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_82) >= randomNumber) & (prelim_midterm + _82_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_82");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_83) >= randomNumber) & (prelim_midterm + _82_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_83");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_84) >= randomNumber) & (prelim_midterm + _82_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_84");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_85) >= randomNumber) & (prelim_midterm + _82_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_85");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_86) >= randomNumber) & (prelim_midterm + _82_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_86");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_87) >= randomNumber) & (prelim_midterm + _82_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_87");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_88) >= randomNumber) & (prelim_midterm + _82_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_88");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_89) >= randomNumber) & (prelim_midterm + _82_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_89");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_90) >= randomNumber) & (prelim_midterm + _82_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_90");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_91) >= randomNumber) & (prelim_midterm + _82_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_91");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_92) >= randomNumber) & (prelim_midterm + _82_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_92");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_93) >= randomNumber) & (prelim_midterm + _82_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_93");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_94) >= randomNumber) & (prelim_midterm + _82_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_94");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_95) >= randomNumber) & (prelim_midterm + _82_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_95");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_96) >= randomNumber) & (prelim_midterm + _82_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_96");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_97) >= randomNumber) & (prelim_midterm + _82_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_97");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_98) >= randomNumber) & (prelim_midterm + _82_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_98");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_99) >= randomNumber) & (prelim_midterm + _82_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_99");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _82_100) >= randomNumber) & (prelim_midterm + _82_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_82_100");
          new_prefinal = ((select_midterm * 0.30) + (82 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 83

        if (((prelim_midterm + _83_75) >= randomNumber) & (prelim_midterm + _83_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_75");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_76) >= randomNumber) & (prelim_midterm + _83_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_76");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_77) >= randomNumber) & (prelim_midterm + _83_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_77");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_78) >= randomNumber) & (prelim_midterm + _83_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_78");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_79) >= randomNumber) & (prelim_midterm + _83_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_79");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_80) >= randomNumber) & (prelim_midterm + _83_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_80");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_81) >= randomNumber) & (prelim_midterm + _83_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_81");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_82) >= randomNumber) & (prelim_midterm + _83_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_82");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_83) >= randomNumber) & (prelim_midterm + _83_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_83");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_84) >= randomNumber) & (prelim_midterm + _83_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_84");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_85) >= randomNumber) & (prelim_midterm + _83_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_85");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_86) >= randomNumber) & (prelim_midterm + _83_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_86");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_87) >= randomNumber) & (prelim_midterm + _83_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_87");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_88) >= randomNumber) & (prelim_midterm + _83_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_88");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_89) >= randomNumber) & (prelim_midterm + _83_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_89");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_90) >= randomNumber) & (prelim_midterm + _83_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_90");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_91) >= randomNumber) & (prelim_midterm + _83_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_91");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_92) >= randomNumber) & (prelim_midterm + _83_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_92");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_93) >= randomNumber) & (prelim_midterm + _83_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_93");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_94) >= randomNumber) & (prelim_midterm + _83_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_94");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_95) >= randomNumber) & (prelim_midterm + _83_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_95");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_96) >= randomNumber) & (prelim_midterm + _83_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_96");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_97) >= randomNumber) & (prelim_midterm + _83_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_97");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_98) >= randomNumber) & (prelim_midterm + _83_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_98");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_99) >= randomNumber) & (prelim_midterm + _83_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_99");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _83_100) >= randomNumber) & (prelim_midterm + _83_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_83_100");
          new_prefinal = ((select_midterm * 0.30) + (83 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 84

        if (((prelim_midterm + _84_75) >= randomNumber) & (prelim_midterm + _84_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_75");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_76) >= randomNumber) & (prelim_midterm + _84_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_76");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_77) >= randomNumber) & (prelim_midterm + _84_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_77");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_78) >= randomNumber) & (prelim_midterm + _84_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_78");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_79) >= randomNumber) & (prelim_midterm + _84_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_79");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_80) >= randomNumber) & (prelim_midterm + _84_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_80");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_81) >= randomNumber) & (prelim_midterm + _84_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_81");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_82) >= randomNumber) & (prelim_midterm + _84_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_82");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_83) >= randomNumber) & (prelim_midterm + _84_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_83");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_84) >= randomNumber) & (prelim_midterm + _84_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_84");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_85) >= randomNumber) & (prelim_midterm + _84_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_85");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_86) >= randomNumber) & (prelim_midterm + _84_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_86");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_87) >= randomNumber) & (prelim_midterm + _84_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_87");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_88) >= randomNumber) & (prelim_midterm + _84_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_88");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_89) >= randomNumber) & (prelim_midterm + _84_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_89");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_90) >= randomNumber) & (prelim_midterm + _84_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_90");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_91) >= randomNumber) & (prelim_midterm + _84_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_91");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_92) >= randomNumber) & (prelim_midterm + _84_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_92");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_93) >= randomNumber) & (prelim_midterm + _84_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_93");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_94) >= randomNumber) & (prelim_midterm + _84_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_94");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_95) >= randomNumber) & (prelim_midterm + _84_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_95");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_96) >= randomNumber) & (prelim_midterm + _84_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_96");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_97) >= randomNumber) & (prelim_midterm + _84_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_97");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_98) >= randomNumber) & (prelim_midterm + _84_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_98");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_99) >= randomNumber) & (prelim_midterm + _84_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_99");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _84_100) >= randomNumber) & (prelim_midterm + _84_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_84_100");
          new_prefinal = ((select_midterm * 0.30) + (84 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 85

        if (((prelim_midterm + _85_75) >= randomNumber) & (prelim_midterm + _85_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_75");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_76) >= randomNumber) & (prelim_midterm + _85_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_76");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_77) >= randomNumber) & (prelim_midterm + _85_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_77");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_78) >= randomNumber) & (prelim_midterm + _85_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_78");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_79) >= randomNumber) & (prelim_midterm + _85_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_79");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_80) >= randomNumber) & (prelim_midterm + _85_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_80");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_81) >= randomNumber) & (prelim_midterm + _85_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_81");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_82) >= randomNumber) & (prelim_midterm + _85_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_82");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_83) >= randomNumber) & (prelim_midterm + _85_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_83");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_84) >= randomNumber) & (prelim_midterm + _85_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_84");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_85) >= randomNumber) & (prelim_midterm + _85_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_85");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_86) >= randomNumber) & (prelim_midterm + _85_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_86");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_87) >= randomNumber) & (prelim_midterm + _85_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_87");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_88) >= randomNumber) & (prelim_midterm + _85_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_88");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_89) >= randomNumber) & (prelim_midterm + _85_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_89");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_90) >= randomNumber) & (prelim_midterm + _85_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_90");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_91) >= randomNumber) & (prelim_midterm + _85_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_91");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_92) >= randomNumber) & (prelim_midterm + _85_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_92");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_93) >= randomNumber) & (prelim_midterm + _85_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_93");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_94) >= randomNumber) & (prelim_midterm + _85_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_94");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_95) >= randomNumber) & (prelim_midterm + _85_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_95");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_96) >= randomNumber) & (prelim_midterm + _85_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_96");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_97) >= randomNumber) & (prelim_midterm + _85_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_97");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_98) >= randomNumber) & (prelim_midterm + _85_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_98");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_99) >= randomNumber) & (prelim_midterm + _85_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_99");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _85_100) >= randomNumber) & (prelim_midterm + _85_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_85_100");
          new_prefinal = ((select_midterm * 0.30) + (85 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 86

        if (((prelim_midterm + _86_75) >= randomNumber) & (prelim_midterm + _86_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_75");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_76) >= randomNumber) & (prelim_midterm + _86_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_76");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_77) >= randomNumber) & (prelim_midterm + _86_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_77");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_78) >= randomNumber) & (prelim_midterm + _86_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_78");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_79) >= randomNumber) & (prelim_midterm + _86_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_79");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_80) >= randomNumber) & (prelim_midterm + _86_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_80");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_81) >= randomNumber) & (prelim_midterm + _86_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_81");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_82) >= randomNumber) & (prelim_midterm + _86_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_82");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_83) >= randomNumber) & (prelim_midterm + _86_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_83");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_84) >= randomNumber) & (prelim_midterm + _86_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_84");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_85) >= randomNumber) & (prelim_midterm + _86_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_85");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_86) >= randomNumber) & (prelim_midterm + _86_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_86");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_87) >= randomNumber) & (prelim_midterm + _86_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_87");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_88) >= randomNumber) & (prelim_midterm + _86_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_88");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_89) >= randomNumber) & (prelim_midterm + _86_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_89");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_90) >= randomNumber) & (prelim_midterm + _86_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_90");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_91) >= randomNumber) & (prelim_midterm + _86_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_91");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_92) >= randomNumber) & (prelim_midterm + _86_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_92");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_93) >= randomNumber) & (prelim_midterm + _86_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_93");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_94) >= randomNumber) & (prelim_midterm + _86_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_94");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_95) >= randomNumber) & (prelim_midterm + _86_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_95");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_96) >= randomNumber) & (prelim_midterm + _86_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_96");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_97) >= randomNumber) & (prelim_midterm + _86_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_97");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_98) >= randomNumber) & (prelim_midterm + _86_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_98");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_99) >= randomNumber) & (prelim_midterm + _86_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_99");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _86_100) >= randomNumber) & (prelim_midterm + _86_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_86_100");
          new_prefinal = ((select_midterm * 0.30) + (86 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 87

        if (((prelim_midterm + _87_75) >= randomNumber) & (prelim_midterm + _87_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_75");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_76) >= randomNumber) & (prelim_midterm + _87_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_76");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_77) >= randomNumber) & (prelim_midterm + _87_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_77");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_78) >= randomNumber) & (prelim_midterm + _87_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_78");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_79) >= randomNumber) & (prelim_midterm + _87_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_79");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_80) >= randomNumber) & (prelim_midterm + _87_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_80");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_81) >= randomNumber) & (prelim_midterm + _87_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_81");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_82) >= randomNumber) & (prelim_midterm + _87_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_82");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_83) >= randomNumber) & (prelim_midterm + _87_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_83");
          // alert(grade_array);
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
        }

        if (((prelim_midterm + _87_84) >= randomNumber) & (prelim_midterm + _87_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_84");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_85) >= randomNumber) & (prelim_midterm + _87_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_85");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_86) >= randomNumber) & (prelim_midterm + _87_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_86");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_87) >= randomNumber) & (prelim_midterm + _87_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_87");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_88) >= randomNumber) & (prelim_midterm + _87_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_88");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_89) >= randomNumber) & (prelim_midterm + _87_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_89");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_90) >= randomNumber) & (prelim_midterm + _87_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_90");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_91) >= randomNumber) & (prelim_midterm + _87_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_91");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_92) >= randomNumber) & (prelim_midterm + _87_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_92");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_93) >= randomNumber) & (prelim_midterm + _87_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_93");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_94) >= randomNumber) & (prelim_midterm + _87_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_94");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_95) >= randomNumber) & (prelim_midterm + _87_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_95");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_96) >= randomNumber) & (prelim_midterm + _87_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_96");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_97) >= randomNumber) & (prelim_midterm + _87_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_97");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_98) >= randomNumber) & (prelim_midterm + _87_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_98");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_99) >= randomNumber) & (prelim_midterm + _87_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_99");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _87_100) >= randomNumber) & (prelim_midterm + _87_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_87_100");
          new_prefinal = ((select_midterm * 0.30) + (87 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 88

        if (((prelim_midterm + _88_75) >= randomNumber) & (prelim_midterm + _88_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_75");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_76) >= randomNumber) & (prelim_midterm + _88_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_76");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_77) >= randomNumber) & (prelim_midterm + _88_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_77");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_78) >= randomNumber) & (prelim_midterm + _88_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_78");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_79) >= randomNumber) & (prelim_midterm + _88_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_79");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_80) >= randomNumber) & (prelim_midterm + _88_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_80");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_81) >= randomNumber) & (prelim_midterm + _88_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_81");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_82) >= randomNumber) & (prelim_midterm + _88_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_82");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_83) >= randomNumber) & (prelim_midterm + _88_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_83");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_84) >= randomNumber) & (prelim_midterm + _88_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_84");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_85) >= randomNumber) & (prelim_midterm + _88_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_85");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_86) >= randomNumber) & (prelim_midterm + _88_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_86");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_87) >= randomNumber) & (prelim_midterm + _88_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_87");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_88) >= randomNumber) & (prelim_midterm + _88_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_88");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_89) >= randomNumber) & (prelim_midterm + _88_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_89");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_90) >= randomNumber) & (prelim_midterm + _88_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_90");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_91) >= randomNumber) & (prelim_midterm + _88_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_91");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_92) >= randomNumber) & (prelim_midterm + _88_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_92");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_93) >= randomNumber) & (prelim_midterm + _88_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_93");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_94) >= randomNumber) & (prelim_midterm + _88_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_94");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_95) >= randomNumber) & (prelim_midterm + _88_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_95");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_96) >= randomNumber) & (prelim_midterm + _88_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_96");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_97) >= randomNumber) & (prelim_midterm + _88_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_97");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_98) >= randomNumber) & (prelim_midterm + _88_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_98");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_99) >= randomNumber) & (prelim_midterm + _88_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_99");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _88_100) >= randomNumber) & (prelim_midterm + _88_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_88_100");
          new_prefinal = ((select_midterm * 0.30) + (88 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 89

        if (((prelim_midterm + _89_75) >= randomNumber) & (prelim_midterm + _89_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_75");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_76) >= randomNumber) & (prelim_midterm + _89_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_76");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_77) >= randomNumber) & (prelim_midterm + _89_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_77");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_78) >= randomNumber) & (prelim_midterm + _89_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_78");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_79) >= randomNumber) & (prelim_midterm + _89_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_79");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_80) >= randomNumber) & (prelim_midterm + _89_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_80");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_81) >= randomNumber) & (prelim_midterm + _89_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_81");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_82) >= randomNumber) & (prelim_midterm + _89_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_82");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_83) >= randomNumber) & (prelim_midterm + _89_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_83");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_84) >= randomNumber) & (prelim_midterm + _89_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_84");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_85) >= randomNumber) & (prelim_midterm + _89_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_85");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_86) >= randomNumber) & (prelim_midterm + _89_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_86");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_87) >= randomNumber) & (prelim_midterm + _89_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_87");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_88) >= randomNumber) & (prelim_midterm + _89_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_88");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_89) >= randomNumber) & (prelim_midterm + _89_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_89");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_90) >= randomNumber) & (prelim_midterm + _89_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_90");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_91) >= randomNumber) & (prelim_midterm + _89_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_91");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_92) >= randomNumber) & (prelim_midterm + _89_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_92");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_93) >= randomNumber) & (prelim_midterm + _89_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_93");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_94) >= randomNumber) & (prelim_midterm + _89_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_94");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_95) >= randomNumber) & (prelim_midterm + _89_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_95");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_96) >= randomNumber) & (prelim_midterm + _89_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_96");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_97) >= randomNumber) & (prelim_midterm + _89_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_97");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_98) >= randomNumber) & (prelim_midterm + _89_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_98");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_99) >= randomNumber) & (prelim_midterm + _89_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_99");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _89_100) >= randomNumber) & (prelim_midterm + _89_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_89_100");
          new_prefinal = ((select_midterm * 0.30) + (89 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 90

        if (((prelim_midterm + _90_75) >= randomNumber) & (prelim_midterm + _90_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_75");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_76) >= randomNumber) & (prelim_midterm + _90_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_76");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_77) >= randomNumber) & (prelim_midterm + _90_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_77");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_78) >= randomNumber) & (prelim_midterm + _90_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_78");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_79) >= randomNumber) & (prelim_midterm + _90_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_79");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_80) >= randomNumber) & (prelim_midterm + _90_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_80");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_81) >= randomNumber) & (prelim_midterm + _90_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_81");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_82) >= randomNumber) & (prelim_midterm + _90_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_82");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_83) >= randomNumber) & (prelim_midterm + _90_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_83");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_84) >= randomNumber) & (prelim_midterm + _90_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_84");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_85) >= randomNumber) & (prelim_midterm + _90_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_85");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_86) >= randomNumber) & (prelim_midterm + _90_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_86");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_87) >= randomNumber) & (prelim_midterm + _90_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_87");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_88) >= randomNumber) & (prelim_midterm + _90_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_88");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_89) >= randomNumber) & (prelim_midterm + _90_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_89");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_90) >= randomNumber) & (prelim_midterm + _90_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_90");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_91) >= randomNumber) & (prelim_midterm + _90_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_91");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_92) >= randomNumber) & (prelim_midterm + _90_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_92");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_93) >= randomNumber) & (prelim_midterm + _90_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_93");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_94) >= randomNumber) & (prelim_midterm + _90_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_94");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_95) >= randomNumber) & (prelim_midterm + _90_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_95");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_96) >= randomNumber) & (prelim_midterm + _90_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_96");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_97) >= randomNumber) & (prelim_midterm + _90_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_97");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_98) >= randomNumber) & (prelim_midterm + _90_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_98");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_99) >= randomNumber) & (prelim_midterm + _90_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_99");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _90_100) >= randomNumber) & (prelim_midterm + _90_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_90_100");
          new_prefinal = ((select_midterm * 0.30) + (90 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 91

        if (((prelim_midterm + _91_75) >= randomNumber) & (prelim_midterm + _91_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_75");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_76) >= randomNumber) & (prelim_midterm + _91_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_76");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_77) >= randomNumber) & (prelim_midterm + _91_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_77");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_78) >= randomNumber) & (prelim_midterm + _91_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_78");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_79) >= randomNumber) & (prelim_midterm + _91_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_79");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_80) >= randomNumber) & (prelim_midterm + _91_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_80");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_81) >= randomNumber) & (prelim_midterm + _91_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_81");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_82) >= randomNumber) & (prelim_midterm + _91_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_82");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_83) >= randomNumber) & (prelim_midterm + _91_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_83");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_84) >= randomNumber) & (prelim_midterm + _91_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_84");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_85) >= randomNumber) & (prelim_midterm + _91_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_85");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_86) >= randomNumber) & (prelim_midterm + _91_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_86");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_87) >= randomNumber) & (prelim_midterm + _91_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_87");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_88) >= randomNumber) & (prelim_midterm + _91_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_88");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_89) >= randomNumber) & (prelim_midterm + _91_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_89");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_90) >= randomNumber) & (prelim_midterm + _91_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_90");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_91) >= randomNumber) & (prelim_midterm + _91_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_91");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_92) >= randomNumber) & (prelim_midterm + _91_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_92");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_93) >= randomNumber) & (prelim_midterm + _91_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_93");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_94) >= randomNumber) & (prelim_midterm + _91_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_94");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_95) >= randomNumber) & (prelim_midterm + _91_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_95");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_96) >= randomNumber) & (prelim_midterm + _91_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_96");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_97) >= randomNumber) & (prelim_midterm + _91_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_97");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_98) >= randomNumber) & (prelim_midterm + _91_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_98");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_99) >= randomNumber) & (prelim_midterm + _91_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_99");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _91_100) >= randomNumber) & (prelim_midterm + _91_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_91_100");
          new_prefinal = ((select_midterm * 0.30) + (91 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 92

        if (((prelim_midterm + _92_75) >= randomNumber) & (prelim_midterm + _92_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_75");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_76) >= randomNumber) & (prelim_midterm + _92_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_76");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_77) >= randomNumber) & (prelim_midterm + _92_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_77");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_78) >= randomNumber) & (prelim_midterm + _92_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_78");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_79) >= randomNumber) & (prelim_midterm + _92_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_79");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_80) >= randomNumber) & (prelim_midterm + _92_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_80");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_81) >= randomNumber) & (prelim_midterm + _92_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_81");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_82) >= randomNumber) & (prelim_midterm + _92_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_82");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_83) >= randomNumber) & (prelim_midterm + _92_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_83");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_84) >= randomNumber) & (prelim_midterm + _92_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_84");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_85) >= randomNumber) & (prelim_midterm + _92_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_85");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_86) >= randomNumber) & (prelim_midterm + _92_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_86");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_87) >= randomNumber) & (prelim_midterm + _92_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_87");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_88) >= randomNumber) & (prelim_midterm + _92_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_88");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_89) >= randomNumber) & (prelim_midterm + _92_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_89");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_90) >= randomNumber) & (prelim_midterm + _92_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_90");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_91) >= randomNumber) & (prelim_midterm + _92_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_91");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_92) >= randomNumber) & (prelim_midterm + _92_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_92");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_93) >= randomNumber) & (prelim_midterm + _92_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_93");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_94) >= randomNumber) & (prelim_midterm + _92_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_94");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_95) >= randomNumber) & (prelim_midterm + _92_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_95");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_96) >= randomNumber) & (prelim_midterm + _92_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_96");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_97) >= randomNumber) & (prelim_midterm + _92_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_97");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_98) >= randomNumber) & (prelim_midterm + _92_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_98");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_99) >= randomNumber) & (prelim_midterm + _92_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_99");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _92_100) >= randomNumber) & (prelim_midterm + _92_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_92_100");
          new_prefinal = ((select_midterm * 0.30) + (92 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 93

        if (((prelim_midterm + _93_75) >= randomNumber) & (prelim_midterm + _93_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_75");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_76) >= randomNumber) & (prelim_midterm + _93_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_76");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_77) >= randomNumber) & (prelim_midterm + _93_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_77");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_78) >= randomNumber) & (prelim_midterm + _93_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_78");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_79) >= randomNumber) & (prelim_midterm + _93_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_79");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_80) >= randomNumber) & (prelim_midterm + _93_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_80");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_81) >= randomNumber) & (prelim_midterm + _93_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_81");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_82) >= randomNumber) & (prelim_midterm + _93_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_82");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_83) >= randomNumber) & (prelim_midterm + _93_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_83");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_84) >= randomNumber) & (prelim_midterm + _93_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_84");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_85) >= randomNumber) & (prelim_midterm + _93_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_85");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_86) >= randomNumber) & (prelim_midterm + _93_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_86");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_87) >= randomNumber) & (prelim_midterm + _93_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_87");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_88) >= randomNumber) & (prelim_midterm + _93_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_88");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_89) >= randomNumber) & (prelim_midterm + _93_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_89");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_90) >= randomNumber) & (prelim_midterm + _93_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_90");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_91) >= randomNumber) & (prelim_midterm + _93_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_91");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_92) >= randomNumber) & (prelim_midterm + _93_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_92");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_93) >= randomNumber) & (prelim_midterm + _93_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_93");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_94) >= randomNumber) & (prelim_midterm + _93_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_94");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_95) >= randomNumber) & (prelim_midterm + _93_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_95");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_96) >= randomNumber) & (prelim_midterm + _93_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_96");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_97) >= randomNumber) & (prelim_midterm + _93_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_97");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_98) >= randomNumber) & (prelim_midterm + _93_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_98");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_99) >= randomNumber) & (prelim_midterm + _93_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_99");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _93_100) >= randomNumber) & (prelim_midterm + _93_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_93_100");
          new_prefinal = ((select_midterm * 0.30) + (93 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 94

        if (((prelim_midterm + _94_75) >= randomNumber) & (prelim_midterm + _94_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_75");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_76) >= randomNumber) & (prelim_midterm + _94_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_76");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_77) >= randomNumber) & (prelim_midterm + _94_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_77");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_78) >= randomNumber) & (prelim_midterm + _94_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_78");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_79) >= randomNumber) & (prelim_midterm + _94_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_79");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_80) >= randomNumber) & (prelim_midterm + _94_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_80");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_81) >= randomNumber) & (prelim_midterm + _94_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_81");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_82) >= randomNumber) & (prelim_midterm + _94_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_82");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_83) >= randomNumber) & (prelim_midterm + _94_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_83");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_84) >= randomNumber) & (prelim_midterm + _94_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_84");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_85) >= randomNumber) & (prelim_midterm + _94_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_85");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_86) >= randomNumber) & (prelim_midterm + _94_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_86");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_87) >= randomNumber) & (prelim_midterm + _94_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_87");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_88) >= randomNumber) & (prelim_midterm + _94_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_88");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_89) >= randomNumber) & (prelim_midterm + _94_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_89");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_90) >= randomNumber) & (prelim_midterm + _94_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_90");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_91) >= randomNumber) & (prelim_midterm + _94_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_91");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_92) >= randomNumber) & (prelim_midterm + _94_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_92");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_93) >= randomNumber) & (prelim_midterm + _94_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_93");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_94) >= randomNumber) & (prelim_midterm + _94_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_94");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_95) >= randomNumber) & (prelim_midterm + _94_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_95");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_96) >= randomNumber) & (prelim_midterm + _94_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_96");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_97) >= randomNumber) & (prelim_midterm + _94_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_97");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_98) >= randomNumber) & (prelim_midterm + _94_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_98");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_99) >= randomNumber) & (prelim_midterm + _94_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_99");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _94_100) >= randomNumber) & (prelim_midterm + _94_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_94_100");
          new_prefinal = ((select_midterm * 0.30) + (94 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 95

        if (((prelim_midterm + _95_75) >= randomNumber) & (prelim_midterm + _95_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_75");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_76) >= randomNumber) & (prelim_midterm + _95_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_76");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_77) >= randomNumber) & (prelim_midterm + _95_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_77");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_78) >= randomNumber) & (prelim_midterm + _95_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_78");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_79) >= randomNumber) & (prelim_midterm + _95_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_79");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_80) >= randomNumber) & (prelim_midterm + _95_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_80");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_81) >= randomNumber) & (prelim_midterm + _95_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_81");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_82) >= randomNumber) & (prelim_midterm + _95_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_82");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_83) >= randomNumber) & (prelim_midterm + _95_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_83");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_84) >= randomNumber) & (prelim_midterm + _95_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_84");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_85) >= randomNumber) & (prelim_midterm + _95_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_85");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_86) >= randomNumber) & (prelim_midterm + _95_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_86");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_87) >= randomNumber) & (prelim_midterm + _95_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_87");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_88) >= randomNumber) & (prelim_midterm + _95_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_88");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_89) >= randomNumber) & (prelim_midterm + _95_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_89");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_90) >= randomNumber) & (prelim_midterm + _95_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_90");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_91) >= randomNumber) & (prelim_midterm + _95_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_91");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_92) >= randomNumber) & (prelim_midterm + _95_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_92");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_93) >= randomNumber) & (prelim_midterm + _95_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_93");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_94) >= randomNumber) & (prelim_midterm + _95_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_94");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_95) >= randomNumber) & (prelim_midterm + _95_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_95");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_96) >= randomNumber) & (prelim_midterm + _95_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_96");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_97) >= randomNumber) & (prelim_midterm + _95_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_97");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_98) >= randomNumber) & (prelim_midterm + _95_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_98");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_99) >= randomNumber) & (prelim_midterm + _95_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_99");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _95_100) >= randomNumber) & (prelim_midterm + _95_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_95_100");
          new_prefinal = ((select_midterm * 0.30) + (95 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 96

        if (((prelim_midterm + _96_75) >= randomNumber) & (prelim_midterm + _96_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_75");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_76) >= randomNumber) & (prelim_midterm + _96_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_76");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_77) >= randomNumber) & (prelim_midterm + _96_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_77");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_78) >= randomNumber) & (prelim_midterm + _96_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_78");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_79) >= randomNumber) & (prelim_midterm + _96_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_79");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_80) >= randomNumber) & (prelim_midterm + _96_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_80");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_81) >= randomNumber) & (prelim_midterm + _96_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_81");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_82) >= randomNumber) & (prelim_midterm + _96_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_82");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_83) >= randomNumber) & (prelim_midterm + _96_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_83");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_84) >= randomNumber) & (prelim_midterm + _96_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_84");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_85) >= randomNumber) & (prelim_midterm + _96_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_85");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_86) >= randomNumber) & (prelim_midterm + _96_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_86");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_87) >= randomNumber) & (prelim_midterm + _96_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_87");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_88) >= randomNumber) & (prelim_midterm + _96_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_88");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_89) >= randomNumber) & (prelim_midterm + _96_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_89");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_90) >= randomNumber) & (prelim_midterm + _96_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_90");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_91) >= randomNumber) & (prelim_midterm + _96_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_91");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_92) >= randomNumber) & (prelim_midterm + _96_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_92");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_93) >= randomNumber) & (prelim_midterm + _96_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_93");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_94) >= randomNumber) & (prelim_midterm + _96_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_94");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_95) >= randomNumber) & (prelim_midterm + _96_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_95");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_96) >= randomNumber) & (prelim_midterm + _96_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_96");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_97) >= randomNumber) & (prelim_midterm + _96_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_97");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_98) >= randomNumber) & (prelim_midterm + _96_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_98");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_99) >= randomNumber) & (prelim_midterm + _96_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_99");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _96_100) >= randomNumber) & (prelim_midterm + _96_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_96_100");
          new_prefinal = ((select_midterm * 0.30) + (96 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 97

        if (((prelim_midterm + _97_75) >= randomNumber) & (prelim_midterm + _97_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_75");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_76) >= randomNumber) & (prelim_midterm + _97_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_76");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_77) >= randomNumber) & (prelim_midterm + _97_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_77");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_78) >= randomNumber) & (prelim_midterm + _97_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_78");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_79) >= randomNumber) & (prelim_midterm + _97_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_79");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_80) >= randomNumber) & (prelim_midterm + _97_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_80");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_81) >= randomNumber) & (prelim_midterm + _97_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_81");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_82) >= randomNumber) & (prelim_midterm + _97_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_82");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_83) >= randomNumber) & (prelim_midterm + _97_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_83");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_84) >= randomNumber) & (prelim_midterm + _97_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_84");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_85) >= randomNumber) & (prelim_midterm + _97_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_85");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_86) >= randomNumber) & (prelim_midterm + _97_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_86");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_87) >= randomNumber) & (prelim_midterm + _97_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_87");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_88) >= randomNumber) & (prelim_midterm + _97_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_88");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_89) >= randomNumber) & (prelim_midterm + _97_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_89");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_90) >= randomNumber) & (prelim_midterm + _97_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_90");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_91) >= randomNumber) & (prelim_midterm + _97_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_91");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_92) >= randomNumber) & (prelim_midterm + _97_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_92");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_93) >= randomNumber) & (prelim_midterm + _97_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_93");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_94) >= randomNumber) & (prelim_midterm + _97_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_94");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_95) >= randomNumber) & (prelim_midterm + _97_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_95");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_96) >= randomNumber) & (prelim_midterm + _97_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_96");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_97) >= randomNumber) & (prelim_midterm + _97_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_97");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_98) >= randomNumber) & (prelim_midterm + _97_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_98");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_99) >= randomNumber) & (prelim_midterm + _97_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_99");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _97_100) >= randomNumber) & (prelim_midterm + _97_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_97_100");
          new_prefinal = ((select_midterm * 0.30) + (97 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 98

        if (((prelim_midterm + _98_75) >= randomNumber) & (prelim_midterm + _98_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_75");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_76) >= randomNumber) & (prelim_midterm + _98_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_76");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_77) >= randomNumber) & (prelim_midterm + _98_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_77");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_78) >= randomNumber) & (prelim_midterm + _98_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_78");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_79) >= randomNumber) & (prelim_midterm + _98_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_79");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_80) >= randomNumber) & (prelim_midterm + _98_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_80");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_81) >= randomNumber) & (prelim_midterm + _98_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_81");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_82) >= randomNumber) & (prelim_midterm + _98_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_82");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_83) >= randomNumber) & (prelim_midterm + _98_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_83");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_84) >= randomNumber) & (prelim_midterm + _98_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_84");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_85) >= randomNumber) & (prelim_midterm + _98_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_85");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_86) >= randomNumber) & (prelim_midterm + _98_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_86");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_87) >= randomNumber) & (prelim_midterm + _98_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_87");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_88) >= randomNumber) & (prelim_midterm + _98_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_88");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_89) >= randomNumber) & (prelim_midterm + _98_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_89");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_90) >= randomNumber) & (prelim_midterm + _98_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_90");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_91) >= randomNumber) & (prelim_midterm + _98_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_91");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_92) >= randomNumber) & (prelim_midterm + _98_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_92");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_93) >= randomNumber) & (prelim_midterm + _98_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_93");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_94) >= randomNumber) & (prelim_midterm + _98_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_94");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_95) >= randomNumber) & (prelim_midterm + _98_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_95");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_96) >= randomNumber) & (prelim_midterm + _98_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_96");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_97) >= randomNumber) & (prelim_midterm + _98_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_97");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_98) >= randomNumber) & (prelim_midterm + _98_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_98");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_99) >= randomNumber) & (prelim_midterm + _98_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_99");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _98_100) >= randomNumber) & (prelim_midterm + _98_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_98_100");
          new_prefinal = ((select_midterm * 0.30) + (98 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 99

        if (((prelim_midterm + _99_75) >= randomNumber) & (prelim_midterm + _99_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_75");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_76) >= randomNumber) & (prelim_midterm + _99_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_76");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_77) >= randomNumber) & (prelim_midterm + _99_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_77");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_78) >= randomNumber) & (prelim_midterm + _99_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_78");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_79) >= randomNumber) & (prelim_midterm + _99_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_79");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_80) >= randomNumber) & (prelim_midterm + _99_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_80");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_81) >= randomNumber) & (prelim_midterm + _99_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_81");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_82) >= randomNumber) & (prelim_midterm + _99_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_82");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_83) >= randomNumber) & (prelim_midterm + _99_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_83");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_84) >= randomNumber) & (prelim_midterm + _99_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_84");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_85) >= randomNumber) & (prelim_midterm + _99_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_85");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_86) >= randomNumber) & (prelim_midterm + _99_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_86");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_87) >= randomNumber) & (prelim_midterm + _99_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_87");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_88) >= randomNumber) & (prelim_midterm + _99_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_88");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_89) >= randomNumber) & (prelim_midterm + _99_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_89");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_90) >= randomNumber) & (prelim_midterm + _99_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_90");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_91) >= randomNumber) & (prelim_midterm + _99_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_91");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_92) >= randomNumber) & (prelim_midterm + _99_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_92");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_93) >= randomNumber) & (prelim_midterm + _99_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_93");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_94) >= randomNumber) & (prelim_midterm + _99_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_94");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_95) >= randomNumber) & (prelim_midterm + _99_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_95");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_96) >= randomNumber) & (prelim_midterm + _99_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_96");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_97) >= randomNumber) & (prelim_midterm + _99_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_97");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_98) >= randomNumber) & (prelim_midterm + _99_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_98");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_99) >= randomNumber) & (prelim_midterm + _99_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_99");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _99_100) >= randomNumber) & (prelim_midterm + _99_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_99_100");
          new_prefinal = ((select_midterm * 0.30) + (99 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }


        // 100

        if (((prelim_midterm + _100_75) >= randomNumber) & (prelim_midterm + _100_75) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_75");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (75 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_76) >= randomNumber) & (prelim_midterm + _100_76) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_76");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (76 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_77) >= randomNumber) & (prelim_midterm + _100_77) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_77");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (77 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_78) >= randomNumber) & (prelim_midterm + _100_78) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_78");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (78 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_79) >= randomNumber) & (prelim_midterm + _100_79) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_79");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (79 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_80) >= randomNumber) & (prelim_midterm + _100_80) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_80");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (80 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_81) >= randomNumber) & (prelim_midterm + _100_81) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_81");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (81 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_82) >= randomNumber) & (prelim_midterm + _100_82) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_82");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (82 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_83) >= randomNumber) & (prelim_midterm + _100_83) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_83");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (83 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_84) >= randomNumber) & (prelim_midterm + _100_84) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_84");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (84 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_85) >= randomNumber) & (prelim_midterm + _100_85) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_85");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (85 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_86) >= randomNumber) & (prelim_midterm + _100_86) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_86");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (86 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_87) >= randomNumber) & (prelim_midterm + _100_87) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_87");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (87 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_88) >= randomNumber) & (prelim_midterm + _100_88) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_88");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (88 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_89) >= randomNumber) & (prelim_midterm + _100_89) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_89");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (89 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_90) >= randomNumber) & (prelim_midterm + _100_90) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_90");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (90 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_91) >= randomNumber) & (prelim_midterm + _100_91) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_91");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (91 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_92) >= randomNumber) & (prelim_midterm + _100_92) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_92");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (92 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_93) >= randomNumber) & (prelim_midterm + _100_93) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_93");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (93 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_94) >= randomNumber) & (prelim_midterm + _100_94) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_94");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (94 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_95) >= randomNumber) & (prelim_midterm + _100_95) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_95");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (95 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_96) >= randomNumber) & (prelim_midterm + _100_96) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_96");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (96 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_97) >= randomNumber) & (prelim_midterm + _100_97) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_97");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (97 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_98) >= randomNumber) & (prelim_midterm + _100_98) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_98");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (98 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_99) >= randomNumber) & (prelim_midterm + _100_99) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_99");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (99 * 0.70));
          // alert(grade_array);
        }

        if (((prelim_midterm + _100_100) >= randomNumber) & (prelim_midterm + _100_100) <= parseInt(randomNumber) + 1) {
          grade_array.push("_100_100");
          new_prefinal = ((select_midterm * 0.30) + (100 * 0.70));
          new_final = ((new_prefinal * 0.30) + (100 * 0.70));
          // alert(grade_array);
        }

        // grade_array.count();
        // for(i=0;i<=grade_array.length;i++){
        // alert(i+"."+grade_array[i]);
        // }

        // alert Umpisa iya

        // alert(grade_array.length);
        // alert(grade_array);
        get_random_array = Math.floor(Math.random() * grade_array.length);
        random_array = get_random_array;
        predict_grade_array = grade_array[random_array];
        alert(predict_grade_array);

        // alert(predict_grade_array.length);

        if (predict_grade_array.length == 6) {
          var predict_prefinal = predict_grade_array.slice(1, 3);
          var predict_final = predict_grade_array.slice(4, 6);
        }

        if (predict_grade_array.length == 7) {
          if (predict_grade_array[1] == 1) {
            // alert("100 sa una it daya!");
            var predict_prefinal = predict_grade_array.slice(1, 4);
            var predict_final = predict_grade_array.slice(5, 7);
          } else {
            // alert("100 sa ulihi it daya!");
            var predict_prefinal = predict_grade_array.slice(1, 3);
            var predict_final = predict_grade_array.slice(4, 7);
          }
        }

        // alert("prefinal= "+predict_prefinal);
        // alert("final= "+predict_final);

        // if(random_array == get_random_array){
        //   predict_prefinal = new_prefinal;
        //   predict_final = new_final;
        //   alert("newPrefinal="+new_prefinal+"newFinal="+new_final);
        // }


        var get_prefinal_prediction = document.getElementById("prefinal_grade_prediction");
        var get_final_prediction = document.getElementById("final_grade_prediction");

        // location.relaod();
        get_prefinal_prediction.innerHTML = predict_prefinal;
        get_final_prediction.innerHTML = predict_final;




        var student_no = document.getElementById("get_student_no").value;
        var semester_value = document.getElementById("get_semester").value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_prediction.php?prefinal=' + predict_prefinal + '&final=' + predict_final + '&id=' + student_no + '&s_=' + semester_value, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            var result = xhr.responseText;
            console.log(result);
            console.log('prefinal:' + predict_prefinal + 'final:' + predict_final);
            window.location.reload();
          }
        }
        xhr.send();

        // document.getElementById("get_prefinal").innerHTML = predict_prefinal;
        // document.getElementById("get_final").innerHTML = predict_final;
        // alert("predictPrefinal="+predict_prefinal+"predictFinal="+predict_final);

        // if(random_array == 1){
        //   new_prefinal = 75;
        //   new_final = 75;
        //   alert("newPrefinal="+new_prefinal+"newFinal="+new_final);
        // }else if(random_array == 2){
        //   new_prefinal = 75;
        //   new_final = 76;
        //   alert("newPrefinal="+new_prefinal+"newFinal="+new_final);
        // }else if(random_array == 3){
        //   new_prefinal = 75;
        //   new_final = 77;
        //   alert("newPrefinal="+new_prefinal+"newFinal="+new_final);
        // }




        // for(a=75;a<=100;a++){
        //   for(b=75;b<=100;b++){
        //   // console.log(a+"="+b+"="+(a+b));
        //    prefinal.innerHTML = a;
        //   final.innerHTML = b;
        //   new_prefinal = parseFloat(prefinal.innerHTML);
        //   new_final = parseFloat(final.innerHTML);
        //   prefinal_final = new_prefinal + new_final;

        //   overall_average = (prelim_midterm + prefinal_final)/4;
        //   // if(selected_average == overall_average ){
        //     console.log(new_prefinal+"+"+new_final)
        //     // console.log("prefinal="+new_prefinal+"final="+new_final+"overall="+overall_average)
        //   // }
        //   // alert()

        // //   var new_prefinal = parseFloat(prefinal.innerHTML);
        // // var new_final = parseFloat(final.innerHTML);
        //   // console.log("a="+new_prefinal+"b="+new_final+"a&b="+(new_prefinal+new_final));
        //   }
        // }

        // var new_prefinal = parseFloat(prefinal.innerHTML);
        // var new_final = parseFloat(final.innerHTML);
        // // console.log(new_prefinal+"="+new_final+"="+(new_prefinal+new_final))

        // var prefinal_final = new_prefinal + new_final;
        // alert(prefinal.innerHTML + "=" + final.innerHTML)
        // console.log("a="+new_prefinal+"b="+new_final+"a&b="+(new_prefinal+new_final));




        //  var average = (prelim_midterm+prefinal_final)/4;
        // alert("Average=" + average + "Prefinal=" + new_prefinal + "Final=" + new_prefinal);


        // window.location.href="?ave="+selected_average+"&_p="+new_prefinal+"&_f="+new_final;
        // alert("Average=" + average + "Prefinal=" + new_prefinal + "Final=" + new_prefinal);
        console.log(parseInt(randomNumber) + "top");

      } else if (get_prelim_value.innerHTML != 0 & get_midterm_value.innerHTML != 0 & get_prefinal_value.innerHTML != 0 & (get_final_value.innerHTML == 0 | confirmation_final > 0)) {

        // console.log(parseInt(randomNumber) + "sa idaeom");

        // _75
        if (((prelim_midterm + new_prefinal + 75) >= randomNumber) & (prelim_midterm + new_prefinal + 75) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "75");
          grade_array.push("75");
          // console.log(grade_array);
          new_final = 75;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 76) >= randomNumber) & (prelim_midterm + new_prefinal + 76) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "76");
          grade_array.push("76");
          // console.log(grade_array);
          new_final = 76;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 77) >= randomNumber) & (prelim_midterm + new_prefinal + 77) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "77");
          grade_array.push("77");
          // console.log(grade_array);
          new_final = 77;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 78) >= randomNumber) & (prelim_midterm + new_prefinal + 78) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "78");
          grade_array.push("78");
          // console.log(grade_array);
          new_final = 78;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 79) >= randomNumber) & (prelim_midterm + new_prefinal + 79) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "79");
          grade_array.push("79");
          // console.log(grade_array);
          new_final = 79;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 80) >= randomNumber) & (prelim_midterm + new_prefinal + 80) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "80");
          grade_array.push("80");
          // console.log(grade_array);
          new_final = 80;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 81) >= randomNumber) & (prelim_midterm + new_prefinal + 81) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "81");
          grade_array.push("81");
          // console.log(grade_array);
          new_final = 81;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 82) >= randomNumber) & (prelim_midterm + new_prefinal + 82) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "82");
          grade_array.push("82");
          // console.log(grade_array);
          new_final = 82;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 83) >= randomNumber) & (prelim_midterm + new_prefinal + 83) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "83");
          grade_array.push("83");
          // console.log(grade_array);
          new_final = 83;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 84) >= randomNumber) & (prelim_midterm + new_prefinal + 84) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "84");
          grade_array.push("84");
          // console.log(grade_array);
          new_final = 84;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 85) >= randomNumber) & (prelim_midterm + new_prefinal + 85) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "85");
          grade_array.push("85");
          // console.log(grade_array);
          new_final = 85;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 86) >= randomNumber) & (prelim_midterm + new_prefinal + 86) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "86");
          grade_array.push("86");
          // console.log(grade_array);
          new_final = 86;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 87) >= randomNumber) & (prelim_midterm + new_prefinal + 87) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "87");
          grade_array.push("87");
          // console.log(grade_array);
          new_final = 87;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 88) >= randomNumber) & (prelim_midterm + new_prefinal + 88) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "88");
          grade_array.push("88");
          // console.log(grade_array);
          new_final = 88;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 89) >= randomNumber) & (prelim_midterm + new_prefinal + 89) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "89");
          grade_array.push("89");
          // console.log(grade_array);
          new_final = 89;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 90) >= randomNumber) & (prelim_midterm + new_prefinal + 90) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "90");
          grade_array.push("90");
          // console.log(grade_array);
          new_final = 90;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 91) >= randomNumber) & (prelim_midterm + new_prefinal + 91) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "91");
          grade_array.push("91");
          // console.log(grade_array);
          new_final = 91;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 92) >= randomNumber) & (prelim_midterm + new_prefinal + 92) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "92");
          grade_array.push("92");
          // console.log(grade_array);
          new_final = 92;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 93) >= randomNumber) & (prelim_midterm + new_prefinal + 93) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "93");
          grade_array.push("93");
          // console.log(grade_array);
          new_final = 93;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 94) >= randomNumber) & (prelim_midterm + new_prefinal + 94) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "94");
          grade_array.push("94");
          // console.log(grade_array);
          new_final = 94;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 95) >= randomNumber) & (prelim_midterm + new_prefinal + 95) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "95");
          grade_array.push("95");
          // console.log(grade_array);
          new_final = 95;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 96) >= randomNumber) & (prelim_midterm + new_prefinal + 96) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "96");
          grade_array.push("96");
          // console.log(grade_array);
          new_final = 96;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 97) >= randomNumber) & (prelim_midterm + new_prefinal + 97) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "97");
          grade_array.push("97");
          // console.log(grade_array);
          new_final = 97;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 98) >= randomNumber) & (prelim_midterm + new_prefinal + 98) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "98");
          grade_array.push("98");
          // console.log(grade_array);
          new_final = 98;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 99) >= randomNumber) & (prelim_midterm + new_prefinal + 99) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "99");
          grade_array.push("99");
          // console.log(grade_array);
          new_final = 99;
          // alert(grade_array);
        }

        if (((prelim_midterm + new_prefinal + 100) >= randomNumber) & (prelim_midterm + new_prefinal + 100) <= parseInt(randomNumber) + 1) {
          // console.log(parseInt(randomNumber) + "100");
          grade_array.push("100");
          // console.log(grade_array);
          new_final = 100;
          // alert(grade_array);
        }


        // grade_array.count();
        // for(i=0;i<=grade_array.length;i++){
        // alert(i+"."+grade_array[i]);
        // }

        // alert Umpisa iya

        // alert(grade_array.length);
        // alert(grade_array);
        get_random_array = Math.floor(Math.random() * grade_array.length);
        random_array = get_random_array;
        predict_grade_array = grade_array[random_array];


        var get_final_prediction = document.getElementById("final_grade_prediction");

        // location.relaod();
        // get_prefinal_prediction.value = predict_prefinal;
        get_final_prediction.innerHTML = predict_grade_array;

        // console.log(grade_array);
        var student_no = document.getElementById("get_student_no").value;
        var semester_value = document.getElementById("get_semester").value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_prediction.php?final=' + predict_grade_array + '&id=' + student_no + '&s_=' + semester_value, true);
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

      }

    }

    // if(prelim.innerHTML != 0 & midterm.innerHTML != 0 & prefinal.innerHTML != 0 & final.innerHTML  == 0){
    //   alert("sabe may sero");
    // }

    // alert(prelim.innerHTML+"|"+midterm.innerHTML+"|"+prefinal.innerHTML+"|"+final.innerHTML);
  </script>

</div>








<div class="btn close_btn text-white bg-danger fixed-top col-1 ml-auto rounded-circle mt-3 mr-3 container-fluid" id="close_btn">
  <h3>
    <?php


    if (isset($_GET['_y'])) {
      $g_y = $_GET['_y'];
    }
    if (isset($_GET['_c'])) {
      $g_c = $_GET['_c'];
    }
    if (isset($_GET['s_'])) {
      $g_s = $_GET['s_'];
    }

    if (isset($_GET["_y"]) && !isset($_GET["_c"])) {
      echo '<a href="prediction?_y=' . $g_y . '" class="text-white text-decoration-none">';
    } elseif (isset($_GET["_y"]) && isset($_GET["_c"])) {
      echo '<a href="prediction?_y=' . $g_y . '&_c=' . $g_c . '&_s_e_=sem' . $g_s . '" class="text-white text-decoration-none">';
    }
    ?>
    <!-- <a href="prediction?" class="text-white text-decoration-none"> -->
    &times;
    </a>
  </h3>
</div>