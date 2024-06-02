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
    // Getting elements and their values
    const selectAverage = document.getElementById("average_predict");
    const selectPrelim = parseFloat(document.getElementById("get_prelim").innerHTML);
    const selectMidterm = parseFloat(document.getElementById("get_midterm").innerHTML);
    const selectPrefinal = parseFloat(document.getElementById("get_prefinal").innerHTML);

    const selectPrelimAndMidterm = (selectPrelim * 0.70) + ((selectPrelim * 0.30) + (selectMidterm * 0.70));
    const selectPrelimAndMidtermPrefinal = selectPrelim + selectMidterm + selectPrefinal;

    const getPrelimValue = document.getElementById("get_prelim");
    const getMidtermValue = document.getElementById("get_midterm");
    const getPrefinalValue = document.getElementById("get_prefinal");
    const getFinalValue = document.getElementById("get_final");

    const confirmPrefinalPrediction = parseFloat(document.getElementById("confirm_prefinal_prediction").innerHTML);
    const confirmFinalPrediction = parseFloat(document.getElementById("confirm_final_prediction").innerHTML);

    const averagePrediction = (selectPrelim + selectMidterm + confirmPrefinalPrediction + confirmFinalPrediction) / 4;


    // Grade ID Map for hiding elements based on the grade ranges
    const gradeIDMap = {
      75: "3",
      76: "3",
      77: "2.75",
      78: "2.75",
      79: "2.75",
      80: "2.5",
      81: "2.5",
      82: "2.5",
      83: "2.25",
      84: "2.25",
      85: "2.25",
      86: "2",
      87: "2",
      88: "2",
      89: "1.75",
      90: "1.75",
      91: "1.75",
      92: "1.5",
      93: "1.5",
      94: "1.5",
      95: "1.25",
      96: "1.25",
      97: "1.25",
      98: "1",
      99: "1",
      100: "1"
    };

    const gradeArray = [];

    // Function to calculate the final score
    function calculateFinalScore(selectPrelimAndMidterm, selectMidterm, y, z) {
      return selectPrelimAndMidterm + ((selectMidterm * 0.30) + (y * 0.70)) + ((y * 0.30) + (z * 0.70));
    }

    // Function to hide elements based on the score
    function hideElements(score) {
      Object.keys(gradeIDMap).forEach(grade => {
        if (score >= grade && score < (parseFloat(grade) + 1)) {
          const element = document.getElementById(gradeIDMap[grade]);
          if (element) {
            element.style.display = "none";
          }
        }
      });
    }

    // ########################################################
    // Removing grades less than 74
    // ########################################################
    for (let i = 1; i <= 74; i++) {
      for (let x = 1; x <= 74; x++) {
        const prelimAndMidtermPrediction = calculateFinalScore(selectPrelimAndMidterm, selectMidterm, i, x);
        if (prelimAndMidtermPrediction < 75) {
          gradeArray.push(prelimAndMidtermPrediction);
          hideElements(prelimAndMidtermPrediction);
        }
      }
    }

    // Logging gradeArray to debug
    // console.log("Grades less than 74:", gradeArray);

    // ########################################################
    // Removing grades more than 100
    // ########################################################
    for (let y = 100; y <= 200; y++) {
      for (let z = 100; z <= 200; z++) {
        const finalScore = calculateFinalScore(selectPrelimAndMidterm, selectMidterm, y, z);
        if (finalScore > 100) {
          gradeArray.push(finalScore);
          hideElements(finalScore);
        }
      }
    }

    // console.log("Grades more than 100:", gradeArray);

    // Grades and corresponding IDs for ranges above 74 and up to 100
    const gradeRanges = [{
        min: 75,
        max: 76,
        id: "3"
      },
      {
        min: 76,
        max: 77,
        id: "3"
      },
      {
        min: 77,
        max: 78,
        id: "2.75"
      },
      {
        min: 78,
        max: 79,
        id: "2.75"
      },
      {
        min: 79,
        max: 80,
        id: "2.75"
      },
      {
        min: 80,
        max: 81,
        id: "2.5"
      },
      {
        min: 81,
        max: 82,
        id: "2.5"
      },
      {
        min: 82,
        max: 83,
        id: "2.5"
      },
      {
        min: 83,
        max: 84,
        id: "2.25"
      },
      {
        min: 84,
        max: 85,
        id: "2.25"
      },
      {
        min: 85,
        max: 86,
        id: "2.25"
      },
      {
        min: 86,
        max: 87,
        id: "2"
      },
      {
        min: 87,
        max: 88,
        id: "2"
      },
      {
        min: 88,
        max: 89,
        id: "2"
      },
      {
        min: 89,
        max: 90,
        id: "1.75"
      },
      {
        min: 90,
        max: 91,
        id: "1.75"
      },
      {
        min: 91,
        max: 92,
        id: "1.75"
      },
      {
        min: 92,
        max: 93,
        id: "1.5"
      },
      {
        min: 93,
        max: 94,
        id: "1.5"
      },
      {
        min: 94,
        max: 95,
        id: "1.5"
      },
      {
        min: 95,
        max: 96,
        id: "1.25"
      },
      {
        min: 96,
        max: 97,
        id: "1.25"
      },
      {
        min: 97,
        max: 98,
        id: "1.25"
      },
      {
        min: 98,
        max: 99,
        id: "1"
      },
      {
        min: 99,
        max: 100,
        id: "1"
      },
      {
        min: 100,
        max: 101,
        id: "1"
      }
    ];

    // Loop through possible scores for y and z for ranges above 100
    for (let y = 100; y <= 200; y++) {
      for (let z = 100; z <= 200; z++) {
        const finalScore = calculateFinalScore(selectPrelimAndMidterm, selectMidterm, y, z);

        // Check the final score and update the corresponding element's display
        for (const range of gradeRanges) {
          if (finalScore >= range.min && finalScore < range.max) {
            const element = document.getElementById(range.id);
            if (element) {
              element.style.display = "none";
            }
          }
        }
      }
    }

    // Logging final gradeArray to debug
    // console.log("Final gradeArray:", gradeArray);

    // Checking if any grades are available
    if (gradeArray.length === 0) {
      console.log("No valid grade predictions available.");
      alert("No valid grade predictions available.");
    } else {
      console.log("Valid grade predictions available.");
    }

    // ##########################
    // ##########################
    // ##########################
    // Second Half of the code  #
    // ##########################
    // ##########################
    // ##########################

    // ########################################################
    // From 74 to 100 nga checking average                   ##
    // ########################################################

    const gradeThresholds = [{
        min: 75,
        max: 76,
        grade: "3"
      },
      {
        min: 76,
        max: 77,
        grade: "3"
      },
      {
        min: 77,
        max: 78,
        grade: "2.75"
      },
      {
        min: 78,
        max: 79,
        grade: "2.75"
      },
      {
        min: 79,
        max: 80,
        grade: "2.75"
      },
      {
        min: 80,
        max: 81,
        grade: "2.5"
      },
      {
        min: 81,
        max: 82,
        grade: "2.5"
      },
      {
        min: 82,
        max: 83,
        grade: "2.5"
      },
      {
        min: 83,
        max: 84,
        grade: "2.25"
      },
      {
        min: 84,
        max: 85,
        grade: "2.25"
      },
      {
        min: 85,
        max: 86,
        grade: "2.25"
      },
      {
        min: 86,
        max: 87,
        grade: "2"
      },
      {
        min: 87,
        max: 88,
        grade: "2"
      },
      {
        min: 88,
        max: 89,
        grade: "2"
      },
      {
        min: 89,
        max: 90,
        grade: "1.75"
      },
      {
        min: 90,
        max: 91,
        grade: "1.75"
      },
      {
        min: 91,
        max: 92,
        grade: "1.75"
      },
      {
        min: 92,
        max: 93,
        grade: "1.5"
      },
      {
        min: 93,
        max: 94,
        grade: "1.5"
      },
      {
        min: 94,
        max: 95,
        grade: "1.5"
      },
      {
        min: 95,
        max: 96,
        grade: "1.25"
      },
      {
        min: 96,
        max: 97,
        grade: "1.25"
      },
      {
        min: 97,
        max: 98,
        grade: "1.25"
      },
      {
        min: 98,
        max: 99,
        grade: "1"
      },
      {
        min: 99,
        max: 100,
        grade: "1"
      },
      {
        min: 100,
        max: 101,
        grade: "1"
      }
    ];

    function getGradeByScore(score) {
      for (const threshold of gradeThresholds) {
        if (score >= threshold.min && score < threshold.max) {
          return threshold.grade;
        }
      }
      return null;
    }

    function removeElementById(id) {
      const element = document.getElementById(id);
      if (element) {
        element.style.display = "none";
      }
    }

    for (let i = 1; i <= 100; i++) {
      for (let j = 1; j <= 100; j++) {
        const score = calculateFinalScore(selectPrelimAndMidterm, selectMidterm, i, j);
        const grade = getGradeByScore(score);
        if (grade) {
          removeElementById(grade);
        }
      }
    }

    // ########################################################
    // Function to calculate and display average predictions ##
    // ########################################################

    const average = () => {
      const selectedAverage = selectAverage.options[selectAverage.selectedIndex].value;
      const randomNumber = {
        "1": Math.floor(Math.random() * 3) + 98,
        "1.25": Math.floor(Math.random() * 3) + 95,
        "1.5": Math.floor(Math.random() * 3) + 92,
        "1.75": Math.floor(Math.random() * 3) + 89,
        "2": Math.floor(Math.random() * 3) + 86,
        "2.25": Math.floor(Math.random() * 3) + 83,
        "2.5": Math.floor(Math.random() * 3) + 80,
        "2.75": Math.floor(Math.random() * 3) + 77,
        "3": Math.floor(Math.random() * 2) + 75
      } [selectedAverage];

      const newPrelim = parseFloat(getPrelimValue.innerHTML);
      const newMidterm = parseFloat(getMidtermValue.innerHTML);
      const prelimMidterm = (newPrelim * 0.70) + ((newPrelim * 0.30) + (newMidterm * 0.70));

      const gradeArray = [];
      const grades = Array.from({
        length: 26
      }, (_, i) => 75 + i);

      grades.forEach(prefinal => {
        grades.forEach(final => {
          const score = prelimMidterm + ((selectMidterm * 0.30) + (prefinal * 0.70)) + ((prefinal * 0.30) + (final * 0.70));
          if (score >= randomNumber && score <= randomNumber + 1) {
            gradeArray.push({
              prefinal,
              final
            });
          }
        });
      });

      if (gradeArray.length > 0) {
        const predictGrade = gradeArray[Math.floor(Math.random() * gradeArray.length)];
        const {
          prefinal: predictPrefinal,
          final: predictFinal
        } = predictGrade;

        document.getElementById("prefinal_grade_prediction").innerHTML = predictPrefinal;
        document.getElementById("final_grade_prediction").innerHTML = predictFinal;

        const studentNo = document.getElementById("get_student_no").value;
        const semesterValue = document.getElementById("get_semester").value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', `save_prediction.php?prefinal=${predictPrefinal}&final=${predictFinal}&id=${studentNo}&s_=${semesterValue}`, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            console.log(`prefinal:${predictPrefinal} final:${predictFinal}`);
            window.location.reload();
          }
        };
        xhr.send();
      } else {
        console.error('No valid grade predictions available.');
      }
    };
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