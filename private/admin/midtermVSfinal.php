<!-- overallPredictedStudentsPerformanceFirstSemesterBarChart.php -->
<style>
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


//  class myCounter implements Countable {
//   private $count = 0;
//   public function count() {
//       return ++$this->count;
//   }
// }

$counter_5 = 0;
$counter_3 = 0;
$counter_2_75 = 0;
$counter_2_5 = 0;
$counter_2_25 = 0;
$counter_2 = 0;
$counter_1_75 = 0;
$counter_1_5 = 0;
$counter_1_25 = 0;
$counter_1 = 0;
$counter_passed = 0;
$counter_failed = 0;

$countAll = 0;
$getPushData = array();
$getPushData2 = array();
$yearData = "2011";

$year_qry = mysqli_query($connections, "SELECT DISTINCT year FROM _user_tbl_ WHERE account_type='2' ");
// $row_year1 = mysqli_fetch_assoc($year_qry);
// while($row_year = mysqli_fetch_assoc($year_qry)){
//     $year = $row_year["year"];
//     // $getYear = array($year);
//     array_push($yearData, $year);


// }

$selectedYear = isset($_GET['vs']) ? $_GET['vs'] : 'select_year';
$selectedYearText = isset($selectedYear) && $selectedYear != 'select_year' ? $selectedYear : 'Select Year';

if (isset($_GET['vs'])) {
    $yearData = $_GET['vs'];
}

// echo implode(" ",$yearData);
// print_r($yearData);
// echo $year;



$prelim_qry = mysqli_query($connections, "SELECT * FROM prelim1 WHERE year='$yearData'; ");
$midterm_qry = mysqli_query($connections, "SELECT * FROM midterm1 WHERE year='$yearData'; ");
$prefinal_qry = mysqli_query($connections, "SELECT * FROM prefinal1 WHERE year='$yearData'; ");
$final_qry = mysqli_query($connections, "SELECT * FROM final1 WHERE year='$yearData'; ");
$students_qry = mysqli_query($connections, "SELECT * FROM _user_tbl_ WHERE account_type='2' ");

while ($row_prelim = mysqli_fetch_assoc($prelim_qry)) {

    $countAll++;
    $row_midterm = mysqli_fetch_assoc($midterm_qry);
    $row_prefinal = mysqli_fetch_assoc($prefinal_qry);
    $row_final = mysqli_fetch_assoc($final_qry);

    $row_students = mysqli_fetch_assoc($students_qry);
    $student_no = $row_students["student_no"];
    $id_no = $row_students["id"];
    $_year_ = $row_students["year"];
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
        $prefinal_performance_1 <= 0 && $prefinal_performance_2 <= 0 &&
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


    if (
        $final_output_1 <= 0 && $final_output_2 <= 0 &&
        $final_performance_1 <= 0 && $final_performance_2 <= 0 &&
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



    // $midtermGradeData = array("y"=> $final_grade);
    // $midtermNameData = array("label"=> $student_name);




    for ($x = 0; $x <= $countAll; $x++) {
        $dataX = $x * 10;
    }

    $test = array("x" => $dataX, "y" => $midterm_grade, "label" => $student_no, "color" => "#537bf5");
    $test2 = array("x" => $dataX, "y" => $final_grade, "label" => $student_no, "color" => "#f5536b");

    array_push($getPushData, $test);
    array_push($getPushData2, $test2);


    // echo implode(" ",$getYear);
}


?>

<br>

<?php

// for($y=0; $y<count($yearData); $y++){
//     // echo $y;

//     // echo implode("<br>",$yearData[1]);

//     // unset($yearData[1]);

//     // print_r($yearData);
//     echo $yearData[$y]."</br>";
// }

?>



<div id="midtermVSfinalBefore"></div>
<br>
<br>

<!-- <select name="midtermVSfinal" id="midtermVSfinal" class="form-control col-2 ml-3 bg-info text-white" onchange="midtermVSfinal()">
    <option value="select_year">Select Year</option>

    <?php
    // while ($row_year = mysqli_fetch_assoc($year_qry)) {
    //     $year = $row_year["year"];
    ?>
        <option value='<?php echo $year; ?>' <?php
                                                //  if (isset($_GET['vs'])) {
                                                //                                             if ($_GET['vs'] == $year) {
                                                //                                                 echo "selected";
                                                //                                             }
                                                //                                         }
                                                ?>>
        <?php
        //     echo $year;
        // }
        ?>
        </option>
</select> -->

<div class="container-fluid d-inline">
    <!-- Year Dropdown -->
    <div class="custom-select-container" id="year-container">
        <div class="select-selected"><?php echo $selectedYearText; ?></div>
        <div class="select-items">
            <div data-value='select_year'>Select Year</div>
            <?php
            while ($row_year = mysqli_fetch_assoc($year_qry)) {
                $year = $row_year["year"];
                echo "<div data-value='$year'>$year</div>";
            }
            ?>
        </div>
    </div>
</div>

<div id="midtermVSfinalChartContainer" style="height: 300px; width: 95%; "></div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const yearContainer = document.getElementById('year-container');
        const yearSelected = yearContainer.querySelector('.select-selected');
        const yearItems = yearContainer.querySelector('.select-items');

        // Function to toggle dropdown visibility
        function toggleDropdown(items) {
            items.style.display = items.style.display === 'block' ? 'none' : 'block';
        }

        yearSelected.addEventListener('click', function() {
            toggleDropdown(yearItems);
        });

        // Handle item selection
        function handleSelection(container, selected, items) {
            items.querySelectorAll('div').forEach(function(item) {
                item.addEventListener('click', function() {
                    selected.textContent = this.textContent;
                    items.style.display = 'none';

                    // Get selected values from both selects
                    const selectedYear = yearContainer.querySelector('.select-selected').textContent.trim();
                    const yearValue = Array.from(yearItems.querySelectorAll('div')).find(el => el.textContent.trim() === selectedYear).dataset.value;

                    window.location.href = `?vs=${yearValue}`;
                });
            });
        }

        handleSelection(yearContainer, yearSelected, yearItems);

        // Close the dropdown if clicked outside
        document.addEventListener('click', function(event) {
            if (!yearContainer.contains(event.target)) {
                yearItems.style.display = 'none';
            }
        });
    });

    function midtermVSfinal() {
        var midtermVSfinal = document.getElementById("midtermVSfinal");
        var selected_midtermVSfinal = midtermVSfinal.options[midtermVSfinal.selectedIndex].value;

        window.location.href = "?vs=" + selected_midtermVSfinal;

        // alert("hay");

    }
</script>

<?php
if (isset($_GET["vs"])) {
    echo "<script>window.location.href = '#midtermVSfinalBefore';</script>";
}
?>