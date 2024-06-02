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

                <?php
                }
                ?>

        </table>
    </div>

    <input type="hidden" id="prefinal_grade" value="<?php echo $prefinal_grade; ?>">
    <input type="hidden" id="final_grade" value="<?php echo $final_grade; ?>">


    <script>
        var select_average = document.getElementById("average_predict");
        // alert(select_average[1].value);
        var select_prelim = parseFloat(document.getElementById("get_prelim").innerHTML);
        var select_midterm = parseFloat(document.getElementById("get_midterm").innerHTML);
        var select_prefinal = parseFloat(document.getElementById("get_prefinal").innerHTML);
        var select_prelim_and_midterm = select_prelim + select_midterm;
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
        const rangesUnder74 = [{
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
                max: Infinity,
                id: "1"
            }
        ];

        for (let i = 1; i <= 74; i++) {
            for (let x = 1; x <= 74; x++) {
                const average = (select_prelim_and_midterm + i + x) / 4;
                for (const range of rangesUnder74) {
                    if (average >= range.min && average < range.max) {
                        const element = document.getElementById(range.id);
                        if (element) element.style.display = "none";
                        break; // Exit the loop early since we found the matching range
                    }
                }
            }
        }


        // ########################################################
        // Daya tag gina remove ru ga sobra sa 100 nga grade     ##
        // ########################################################

        const rangesOver100 = [{
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
                max: Infinity,
                id: "1"
            }
        ];

        for (let y = 100; y <= 200; y++) {
            for (let z = 100; z <= 200; z++) {
                const average = (select_prelim_and_midterm + y + z) / 4;
                for (const range of rangesOver100) {
                    if (average >= range.min && average < range.max) {
                        const element = document.getElementById(range.id);
                        if (element) element.style.display = "none";
                        break; // Exit the loop early since we found the matching range
                    }
                }
            }
        }



        // ########################################################
        // From 74 to 100 nga checking average                   ##
        // ########################################################

        const rangesCheckAverage74to100 = [{
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
                max: Infinity,
                id: "1"
            }
        ];

        for (let a = 1; a <= 74; a++) {
            const average = (select_prelim_and_midterm + select_prefinal + a) / 4;
            for (const range of rangesCheckAverage74to100) {
                if (average >= range.min && average < range.max) {
                    const element = document.getElementById(range.id);
                    if (element) element.style.display = "none";
                    break; // Exit the loop early since we found the matching range
                }
            }
        }


        // ##############################################################
        // Para e remove sa select ru sobra or kueang nga prediction   ##
        // ##############################################################

        const rangesToRemove = [{
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
                max: Infinity,
                id: "1"
            }
        ];

        for (let b = 100; b <= 150; b++) {
            const average = (select_prelim_and_midterm + select_prefinal + b) / 4;
            for (const range of rangesToRemove) {
                if (average >= range.min && average < range.max) {
                    const element = document.getElementById(range.id);
                    if (element) element.style.display = "none";
                    break; // Exit the loop early since we found the matching range
                }
            }
        }


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
            if (selected_average == "select_grade_prediction") {
                // Do nothing here
                // alert('selected');
            } else {
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
                var prelim_midterm = new_prelim + new_midterm;

                var new_prefinal;
                var new_final;


                var grade_array = [];

                for (var i = 75; i <= 95; i++) {
                    for (var j = 75; j <= 100; j++) {
                        var name = "_" + i + "_" + j;
                        var value = i + j;
                        // console.log("var " + name + " = " + value + ";");
                    }
                }

                if (get_prelim_value.innerHTML != 0 & get_midterm_value.innerHTML != 0 & (get_prefinal_value.innerHTML == 0 | confirmation_prefinal > 0) & (get_final_value.innerHTML == 0 | confirmation_final > 0)) {


                    // _75

                    if (((prelim_midterm + _75_75) / 4 >= randomNumber) & (prelim_midterm + _75_75) / 4 <= parseInt(randomNumber) + 1) {
                        // alert(randomNumber);
                        grade_array.push("_75_75");
                        new_prefinal = 75;
                        new_final = 75;
                        // alert(_75_75.valueOf());
                        // alert(grade_array);
                        // alert((prelim_midterm+_75_77)/4);
                    }

                    if (((prelim_midterm + _75_76) / 4 >= randomNumber) & (prelim_midterm + _75_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_76");
                        new_prefinal = 75;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_77) / 4 >= randomNumber) & (prelim_midterm + _75_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_77");
                        new_prefinal = 75;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_78) / 4 >= randomNumber) & (prelim_midterm + _75_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_78");
                        new_prefinal = 75;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_79) / 4 >= randomNumber) & (prelim_midterm + _75_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_79");
                        new_prefinal = 75;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_80) / 4 >= randomNumber) & (prelim_midterm + _75_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_80");
                        new_prefinal = 75;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_81) / 4 >= randomNumber) & (prelim_midterm + _75_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_81");
                        new_prefinal = 75;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_82) / 4 >= randomNumber) & (prelim_midterm + _75_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_82");
                        new_prefinal = 75;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_83) / 4 >= randomNumber) & (prelim_midterm + _75_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_83");
                        new_prefinal = 75;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_84) / 4 >= randomNumber) & (prelim_midterm + _75_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_84");
                        new_prefinal = 75;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_85) / 4 >= randomNumber) & (prelim_midterm + _75_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_85");
                        new_prefinal = 75;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_86) / 4 >= randomNumber) & (prelim_midterm + _75_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_86");
                        new_prefinal = 75;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_87) / 4 >= randomNumber) & (prelim_midterm + _75_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_87");
                        new_prefinal = 75;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_88) / 4 >= randomNumber) & (prelim_midterm + _75_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_88");
                        new_prefinal = 75;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_89) / 4 >= randomNumber) & (prelim_midterm + _75_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_89");
                        new_prefinal = 75;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_90) / 4 >= randomNumber) & (prelim_midterm + _75_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_90");
                        new_prefinal = 75;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_91) / 4 >= randomNumber) & (prelim_midterm + _75_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_91");
                        new_prefinal = 75;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_92) / 4 >= randomNumber) & (prelim_midterm + _75_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_92");
                        new_prefinal = 75;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_93) / 4 >= randomNumber) & (prelim_midterm + _75_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_93");
                        new_prefinal = 75;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_94) / 4 >= randomNumber) & (prelim_midterm + _75_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_94");
                        new_prefinal = 75;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_95) / 4 >= randomNumber) & (prelim_midterm + _75_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_95");
                        new_prefinal = 75;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_96) / 4 >= randomNumber) & (prelim_midterm + _75_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_96");
                        new_prefinal = 75;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_97) / 4 >= randomNumber) & (prelim_midterm + _75_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_97");
                        new_prefinal = 75;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_98) / 4 >= randomNumber) & (prelim_midterm + _75_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_98");
                        new_prefinal = 75;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_99) / 4 >= randomNumber) & (prelim_midterm + _75_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_99");
                        new_prefinal = 75;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _75_100) / 4 >= randomNumber) & (prelim_midterm + _75_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_75_100");
                        new_prefinal = 75;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // _76

                    if (((prelim_midterm + _76_75) / 4 >= randomNumber) & (prelim_midterm + _76_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_75");
                        new_prefinal = 76;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_76) / 4 >= randomNumber) & (prelim_midterm + _76_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_76");
                        new_prefinal = 76;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_77) / 4 >= randomNumber) & (prelim_midterm + _76_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_77");
                        new_prefinal = 76;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_78) / 4 >= randomNumber) & (prelim_midterm + _76_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_78");
                        new_prefinal = 76;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_79) / 4 >= randomNumber) & (prelim_midterm + _76_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_79");
                        new_prefinal = 76;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_80) / 4 >= randomNumber) & (prelim_midterm + _76_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_80");
                        new_prefinal = 76;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_81) / 4 >= randomNumber) & (prelim_midterm + _76_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_81");
                        new_prefinal = 76;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_82) / 4 >= randomNumber) & (prelim_midterm + _76_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_82");
                        new_prefinal = 76;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_83) / 4 >= randomNumber) & (prelim_midterm + _76_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_83");
                        new_prefinal = 76;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_84) / 4 >= randomNumber) & (prelim_midterm + _76_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_84");
                        new_prefinal = 76;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_85) / 4 >= randomNumber) & (prelim_midterm + _76_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_85");
                        new_prefinal = 76;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_86) / 4 >= randomNumber) & (prelim_midterm + _76_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_86");
                        new_prefinal = 76;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_87) / 4 >= randomNumber) & (prelim_midterm + _76_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_87");
                        new_prefinal = 76;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_88) / 4 >= randomNumber) & (prelim_midterm + _76_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_88");
                        new_prefinal = 76;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_89) / 4 >= randomNumber) & (prelim_midterm + _76_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_89");
                        new_prefinal = 76;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_90) / 4 >= randomNumber) & (prelim_midterm + _76_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_90");
                        new_prefinal = 76;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_91) / 4 >= randomNumber) & (prelim_midterm + _76_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_91");
                        new_prefinal = 76;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_92) / 4 >= randomNumber) & (prelim_midterm + _76_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_92");
                        new_prefinal = 76;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_93) / 4 >= randomNumber) & (prelim_midterm + _76_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_93");
                        new_prefinal = 76;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_94) / 4 >= randomNumber) & (prelim_midterm + _76_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_94");
                        new_prefinal = 76;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_95) / 4 >= randomNumber) & (prelim_midterm + _76_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_95");
                        new_prefinal = 76;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_96) / 4 >= randomNumber) & (prelim_midterm + _76_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_96");
                        new_prefinal = 76;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_97) / 4 >= randomNumber) & (prelim_midterm + _76_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_97");
                        new_prefinal = 76;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_98) / 4 >= randomNumber) & (prelim_midterm + _76_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_98");
                        new_prefinal = 76;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_99) / 4 >= randomNumber) & (prelim_midterm + _76_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_99");
                        new_prefinal = 76;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _76_100) / 4 >= randomNumber) & (prelim_midterm + _76_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_76_100");
                        new_prefinal = 76;
                        new_final = 100;
                        // alert(grade_array);
                    }



                    // _77

                    if (((prelim_midterm + _77_75) / 4 >= randomNumber) & (prelim_midterm + _77_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_75");
                        new_prefinal = 77;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_76) / 4 >= randomNumber) & (prelim_midterm + _77_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_76");
                        new_prefinal = 77;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_77) / 4 >= randomNumber) & (prelim_midterm + _77_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_77");
                        new_prefinal = 77;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_78) / 4 >= randomNumber) & (prelim_midterm + _77_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_78");
                        new_prefinal = 77;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_79) / 4 >= randomNumber) & (prelim_midterm + _77_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_79");
                        new_prefinal = 77;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_80) / 4 >= randomNumber) & (prelim_midterm + _77_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_80");
                        new_prefinal = 77;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_81) / 4 >= randomNumber) & (prelim_midterm + _77_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_81");
                        new_prefinal = 77;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_82) / 4 >= randomNumber) & (prelim_midterm + _77_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_82");
                        new_prefinal = 77;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_83) / 4 >= randomNumber) & (prelim_midterm + _77_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_83");
                        new_prefinal = 77;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_84) / 4 >= randomNumber) & (prelim_midterm + _77_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_84");
                        new_prefinal = 77;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_85) / 4 >= randomNumber) & (prelim_midterm + _77_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_85");
                        new_prefinal = 77;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_86) / 4 >= randomNumber) & (prelim_midterm + _77_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_86");
                        new_prefinal = 77;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_87) / 4 >= randomNumber) & (prelim_midterm + _77_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_87");
                        new_prefinal = 77;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_88) / 4 >= randomNumber) & (prelim_midterm + _77_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_88");
                        new_prefinal = 77;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_89) / 4 >= randomNumber) & (prelim_midterm + _77_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_89");
                        new_prefinal = 77;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_90) / 4 >= randomNumber) & (prelim_midterm + _77_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_90");
                        new_prefinal = 77;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_91) / 4 >= randomNumber) & (prelim_midterm + _77_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_91");
                        new_prefinal = 77;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_92) / 4 >= randomNumber) & (prelim_midterm + _77_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_92");
                        new_prefinal = 77;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_93) / 4 >= randomNumber) & (prelim_midterm + _77_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_93");
                        new_prefinal = 77;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_94) / 4 >= randomNumber) & (prelim_midterm + _77_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_94");
                        new_prefinal = 77;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_95) / 4 >= randomNumber) & (prelim_midterm + _77_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_95");
                        new_prefinal = 77;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_96) / 4 >= randomNumber) & (prelim_midterm + _77_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_96");
                        new_prefinal = 77;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_97) / 4 >= randomNumber) & (prelim_midterm + _77_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_97");
                        new_prefinal = 77;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_98) / 4 >= randomNumber) & (prelim_midterm + _77_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_98");
                        new_prefinal = 77;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_99) / 4 >= randomNumber) & (prelim_midterm + _77_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_99");
                        new_prefinal = 77;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _77_100) / 4 >= randomNumber) & (prelim_midterm + _77_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_77_100");
                        new_prefinal = 77;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 78

                    if (((prelim_midterm + _78_75) / 4 >= randomNumber) & (prelim_midterm + _78_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_75");
                        new_prefinal = 78;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_76) / 4 >= randomNumber) & (prelim_midterm + _78_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_76");
                        new_prefinal = 78;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_77) / 4 >= randomNumber) & (prelim_midterm + _78_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_77");
                        new_prefinal = 78;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_78) / 4 >= randomNumber) & (prelim_midterm + _78_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_78");
                        new_prefinal = 78;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_79) / 4 >= randomNumber) & (prelim_midterm + _78_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_79");
                        new_prefinal = 78;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_80) / 4 >= randomNumber) & (prelim_midterm + _78_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_80");
                        new_prefinal = 78;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_81) / 4 >= randomNumber) & (prelim_midterm + _78_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_81");
                        new_prefinal = 78;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_82) / 4 >= randomNumber) & (prelim_midterm + _78_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_82");
                        new_prefinal = 78;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_83) / 4 >= randomNumber) & (prelim_midterm + _78_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_83");
                        new_prefinal = 78;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_84) / 4 >= randomNumber) & (prelim_midterm + _78_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_84");
                        new_prefinal = 78;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_85) / 4 >= randomNumber) & (prelim_midterm + _78_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_85");
                        new_prefinal = 78;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_86) / 4 >= randomNumber) & (prelim_midterm + _78_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_86");
                        new_prefinal = 78;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_87) / 4 >= randomNumber) & (prelim_midterm + _78_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_87");
                        new_prefinal = 78;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_88) / 4 >= randomNumber) & (prelim_midterm + _78_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_88");
                        new_prefinal = 78;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_89) / 4 >= randomNumber) & (prelim_midterm + _78_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_89");
                        new_prefinal = 78;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_90) / 4 >= randomNumber) & (prelim_midterm + _78_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_90");
                        new_prefinal = 78;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_91) / 4 >= randomNumber) & (prelim_midterm + _78_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_91");
                        new_prefinal = 78;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_92) / 4 >= randomNumber) & (prelim_midterm + _78_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_92");
                        new_prefinal = 78;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_93) / 4 >= randomNumber) & (prelim_midterm + _78_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_93");
                        new_prefinal = 78;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_94) / 4 >= randomNumber) & (prelim_midterm + _78_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_94");
                        new_prefinal = 78;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_95) / 4 >= randomNumber) & (prelim_midterm + _78_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_95");
                        new_prefinal = 78;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_96) / 4 >= randomNumber) & (prelim_midterm + _78_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_96");
                        new_prefinal = 78;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_97) / 4 >= randomNumber) & (prelim_midterm + _78_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_97");
                        new_prefinal = 78;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_98) / 4 >= randomNumber) & (prelim_midterm + _78_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_98");
                        new_prefinal = 78;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_99) / 4 >= randomNumber) & (prelim_midterm + _78_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_99");
                        new_prefinal = 78;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _78_100) / 4 >= randomNumber) & (prelim_midterm + _78_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_78_100");
                        new_prefinal = 78;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 79

                    if (((prelim_midterm + _79_75) / 4 >= randomNumber) & (prelim_midterm + _79_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_75");
                        new_prefinal = 79;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_76) / 4 >= randomNumber) & (prelim_midterm + _79_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_76");
                        new_prefinal = 79;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_77) / 4 >= randomNumber) & (prelim_midterm + _79_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_77");
                        new_prefinal = 79;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_78) / 4 >= randomNumber) & (prelim_midterm + _79_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_78");
                        new_prefinal = 79;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_79) / 4 >= randomNumber) & (prelim_midterm + _79_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_79");
                        new_prefinal = 79;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_80) / 4 >= randomNumber) & (prelim_midterm + _79_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_80");
                        new_prefinal = 79;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_81) / 4 >= randomNumber) & (prelim_midterm + _79_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_81");
                        new_prefinal = 79;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_82) / 4 >= randomNumber) & (prelim_midterm + _79_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_82");
                        new_prefinal = 79;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_83) / 4 >= randomNumber) & (prelim_midterm + _79_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_83");
                        new_prefinal = 79;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_84) / 4 >= randomNumber) & (prelim_midterm + _79_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_84");
                        new_prefinal = 79;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_85) / 4 >= randomNumber) & (prelim_midterm + _79_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_85");
                        new_prefinal = 79;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_86) / 4 >= randomNumber) & (prelim_midterm + _79_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_86");
                        new_prefinal = 79;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_87) / 4 >= randomNumber) & (prelim_midterm + _79_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_87");
                        new_prefinal = 79;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_88) / 4 >= randomNumber) & (prelim_midterm + _79_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_88");
                        new_prefinal = 79;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_89) / 4 >= randomNumber) & (prelim_midterm + _79_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_89");
                        new_prefinal = 79;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_90) / 4 >= randomNumber) & (prelim_midterm + _79_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_90");
                        new_prefinal = 79;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_91) / 4 >= randomNumber) & (prelim_midterm + _79_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_91");
                        new_prefinal = 79;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_92) / 4 >= randomNumber) & (prelim_midterm + _79_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_92");
                        new_prefinal = 79;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_93) / 4 >= randomNumber) & (prelim_midterm + _79_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_93");
                        new_prefinal = 79;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_94) / 4 >= randomNumber) & (prelim_midterm + _79_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_94");
                        new_prefinal = 79;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_95) / 4 >= randomNumber) & (prelim_midterm + _79_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_95");
                        new_prefinal = 79;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_96) / 4 >= randomNumber) & (prelim_midterm + _79_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_96");
                        new_prefinal = 79;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_97) / 4 >= randomNumber) & (prelim_midterm + _79_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_97");
                        new_prefinal = 79;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_98) / 4 >= randomNumber) & (prelim_midterm + _79_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_98");
                        new_prefinal = 79;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_99) / 4 >= randomNumber) & (prelim_midterm + _79_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_99");
                        new_prefinal = 79;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _79_100) / 4 >= randomNumber) & (prelim_midterm + _79_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_79_100");
                        new_prefinal = 79;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 80

                    if (((prelim_midterm + _80_75) / 4 >= randomNumber) & (prelim_midterm + _80_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_75");
                        new_prefinal = 80;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_76) / 4 >= randomNumber) & (prelim_midterm + _80_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_76");
                        new_prefinal = 80;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_77) / 4 >= randomNumber) & (prelim_midterm + _80_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_77");
                        new_prefinal = 80;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_78) / 4 >= randomNumber) & (prelim_midterm + _80_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_78");
                        new_prefinal = 80;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_79) / 4 >= randomNumber) & (prelim_midterm + _80_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_79");
                        new_prefinal = 80;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_80) / 4 >= randomNumber) & (prelim_midterm + _80_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_80");
                        new_prefinal = 80;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_81) / 4 >= randomNumber) & (prelim_midterm + _80_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_81");
                        new_prefinal = 80;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_82) / 4 >= randomNumber) & (prelim_midterm + _80_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_82");
                        new_prefinal = 80;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_83) / 4 >= randomNumber) & (prelim_midterm + _80_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_83");
                        new_prefinal = 80;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_84) / 4 >= randomNumber) & (prelim_midterm + _80_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_84");
                        new_prefinal = 80;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_85) / 4 >= randomNumber) & (prelim_midterm + _80_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_85");
                        new_prefinal = 80;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_86) / 4 >= randomNumber) & (prelim_midterm + _80_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_86");
                        new_prefinal = 80;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_87) / 4 >= randomNumber) & (prelim_midterm + _80_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_87");
                        new_prefinal = 80;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_88) / 4 >= randomNumber) & (prelim_midterm + _80_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_88");
                        new_prefinal = 80;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_89) / 4 >= randomNumber) & (prelim_midterm + _80_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_89");
                        new_prefinal = 80;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_90) / 4 >= randomNumber) & (prelim_midterm + _80_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_90");
                        new_prefinal = 80;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_91) / 4 >= randomNumber) & (prelim_midterm + _80_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_91");
                        new_prefinal = 80;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_92) / 4 >= randomNumber) & (prelim_midterm + _80_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_92");
                        new_prefinal = 80;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_93) / 4 >= randomNumber) & (prelim_midterm + _80_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_93");
                        new_prefinal = 80;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_94) / 4 >= randomNumber) & (prelim_midterm + _80_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_94");
                        new_prefinal = 80;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_95) / 4 >= randomNumber) & (prelim_midterm + _80_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_95");
                        new_prefinal = 80;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_96) / 4 >= randomNumber) & (prelim_midterm + _80_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_96");
                        new_prefinal = 80;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_97) / 4 >= randomNumber) & (prelim_midterm + _80_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_97");
                        new_prefinal = 80;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_98) / 4 >= randomNumber) & (prelim_midterm + _80_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_98");
                        new_prefinal = 80;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_99) / 4 >= randomNumber) & (prelim_midterm + _80_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_99");
                        new_prefinal = 80;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _80_100) / 4 >= randomNumber) & (prelim_midterm + _80_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_80_100");
                        new_prefinal = 80;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 81

                    if (((prelim_midterm + _81_75) / 4 >= randomNumber) & (prelim_midterm + _81_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_75");
                        new_prefinal = 81;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_76) / 4 >= randomNumber) & (prelim_midterm + _81_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_76");
                        new_prefinal = 81;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_77) / 4 >= randomNumber) & (prelim_midterm + _81_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_77");
                        new_prefinal = 81;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_78) / 4 >= randomNumber) & (prelim_midterm + _81_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_78");
                        new_prefinal = 81;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_79) / 4 >= randomNumber) & (prelim_midterm + _81_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_79");
                        new_prefinal = 81;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_80) / 4 >= randomNumber) & (prelim_midterm + _81_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_80");
                        new_prefinal = 81;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_81) / 4 >= randomNumber) & (prelim_midterm + _81_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_81");
                        new_prefinal = 81;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_82) / 4 >= randomNumber) & (prelim_midterm + _81_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_82");
                        new_prefinal = 81;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_83) / 4 >= randomNumber) & (prelim_midterm + _81_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_83");
                        new_prefinal = 81;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_84) / 4 >= randomNumber) & (prelim_midterm + _81_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_84");
                        new_prefinal = 81;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_85) / 4 >= randomNumber) & (prelim_midterm + _81_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_85");
                        new_prefinal = 81;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_86) / 4 >= randomNumber) & (prelim_midterm + _81_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_86");
                        new_prefinal = 81;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_87) / 4 >= randomNumber) & (prelim_midterm + _81_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_87");
                        new_prefinal = 81;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_88) / 4 >= randomNumber) & (prelim_midterm + _81_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_88");
                        new_prefinal = 81;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_89) / 4 >= randomNumber) & (prelim_midterm + _81_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_89");
                        new_prefinal = 81;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_90) / 4 >= randomNumber) & (prelim_midterm + _81_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_90");
                        new_prefinal = 81;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_91) / 4 >= randomNumber) & (prelim_midterm + _81_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_91");
                        new_prefinal = 81;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_92) / 4 >= randomNumber) & (prelim_midterm + _81_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_92");
                        new_prefinal = 81;
                        new_final = 92
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_93) / 4 >= randomNumber) & (prelim_midterm + _81_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_93");
                        new_prefinal = 81;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_94) / 4 >= randomNumber) & (prelim_midterm + _81_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_94");
                        new_prefinal = 81;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_95) / 4 >= randomNumber) & (prelim_midterm + _81_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_95");
                        new_prefinal = 81;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_96) / 4 >= randomNumber) & (prelim_midterm + _81_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_96");
                        new_prefinal = 81;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_97) / 4 >= randomNumber) & (prelim_midterm + _81_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_97");
                        new_prefinal = 81;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_98) / 4 >= randomNumber) & (prelim_midterm + _81_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_98");
                        new_prefinal = 81;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_99) / 4 >= randomNumber) & (prelim_midterm + _81_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_99");
                        new_prefinal = 81;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _81_100) / 4 >= randomNumber) & (prelim_midterm + _81_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_81_100");
                        new_prefinal = 81;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 82

                    if (((prelim_midterm + _82_75) / 4 >= randomNumber) & (prelim_midterm + _82_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_75");
                        new_prefinal = 82;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_76) / 4 >= randomNumber) & (prelim_midterm + _82_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_76");
                        new_prefinal = 82;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_77) / 4 >= randomNumber) & (prelim_midterm + _82_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_77");
                        new_prefinal = 82;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_78) / 4 >= randomNumber) & (prelim_midterm + _82_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_78");
                        new_prefinal = 82;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_79) / 4 >= randomNumber) & (prelim_midterm + _82_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_79");
                        new_prefinal = 82;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_80) / 4 >= randomNumber) & (prelim_midterm + _82_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_80");
                        new_prefinal = 82;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_81) / 4 >= randomNumber) & (prelim_midterm + _82_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_81");
                        new_prefinal = 82;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_82) / 4 >= randomNumber) & (prelim_midterm + _82_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_82");
                        new_prefinal = 82;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_83) / 4 >= randomNumber) & (prelim_midterm + _82_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_83");
                        new_prefinal = 82;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_84) / 4 >= randomNumber) & (prelim_midterm + _82_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_84");
                        new_prefinal = 82;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_85) / 4 >= randomNumber) & (prelim_midterm + _82_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_85");
                        new_prefinal = 82;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_86) / 4 >= randomNumber) & (prelim_midterm + _82_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_86");
                        new_prefinal = 82;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_87) / 4 >= randomNumber) & (prelim_midterm + _82_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_87");
                        new_prefinal = 82;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_88) / 4 >= randomNumber) & (prelim_midterm + _82_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_88");
                        new_prefinal = 82;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_89) / 4 >= randomNumber) & (prelim_midterm + _82_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_89");
                        new_prefinal = 82;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_90) / 4 >= randomNumber) & (prelim_midterm + _82_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_90");
                        new_prefinal = 82;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_91) / 4 >= randomNumber) & (prelim_midterm + _82_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_91");
                        new_prefinal = 82;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_92) / 4 >= randomNumber) & (prelim_midterm + _82_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_92");
                        new_prefinal = 82;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_93) / 4 >= randomNumber) & (prelim_midterm + _82_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_93");
                        new_prefinal = 82;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_94) / 4 >= randomNumber) & (prelim_midterm + _82_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_94");
                        new_prefinal = 82;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_95) / 4 >= randomNumber) & (prelim_midterm + _82_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_95");
                        new_prefinal = 82;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_96) / 4 >= randomNumber) & (prelim_midterm + _82_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_96");
                        new_prefinal = 82;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_97) / 4 >= randomNumber) & (prelim_midterm + _82_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_97");
                        new_prefinal = 82;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_98) / 4 >= randomNumber) & (prelim_midterm + _82_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_98");
                        new_prefinal = 82;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_99) / 4 >= randomNumber) & (prelim_midterm + _82_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_99");
                        new_prefinal = 82;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _82_100) / 4 >= randomNumber) & (prelim_midterm + _82_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_82_100");
                        new_prefinal = 82;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 83

                    if (((prelim_midterm + _83_75) / 4 >= randomNumber) & (prelim_midterm + _83_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_75");
                        new_prefinal = 83;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_76) / 4 >= randomNumber) & (prelim_midterm + _83_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_76");
                        new_prefinal = 83;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_77) / 4 >= randomNumber) & (prelim_midterm + _83_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_77");
                        new_prefinal = 83;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_78) / 4 >= randomNumber) & (prelim_midterm + _83_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_78");
                        new_prefinal = 83;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_79) / 4 >= randomNumber) & (prelim_midterm + _83_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_79");
                        new_prefinal = 83;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_80) / 4 >= randomNumber) & (prelim_midterm + _83_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_80");
                        new_prefinal = 83;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_81) / 4 >= randomNumber) & (prelim_midterm + _83_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_81");
                        new_prefinal = 83;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_82) / 4 >= randomNumber) & (prelim_midterm + _83_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_82");
                        new_prefinal = 83;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_83) / 4 >= randomNumber) & (prelim_midterm + _83_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_83");
                        new_prefinal = 83;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_84) / 4 >= randomNumber) & (prelim_midterm + _83_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_84");
                        new_prefinal = 83;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_85) / 4 >= randomNumber) & (prelim_midterm + _83_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_85");
                        new_prefinal = 83;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_86) / 4 >= randomNumber) & (prelim_midterm + _83_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_86");
                        new_prefinal = 83;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_87) / 4 >= randomNumber) & (prelim_midterm + _83_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_87");
                        new_prefinal = 83;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_88) / 4 >= randomNumber) & (prelim_midterm + _83_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_88");
                        new_prefinal = 83;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_89) / 4 >= randomNumber) & (prelim_midterm + _83_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_89");
                        new_prefinal = 83;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_90) / 4 >= randomNumber) & (prelim_midterm + _83_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_90");
                        new_prefinal = 83;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_91) / 4 >= randomNumber) & (prelim_midterm + _83_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_91");
                        new_prefinal = 83;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_92) / 4 >= randomNumber) & (prelim_midterm + _83_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_92");
                        new_prefinal = 83;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_93) / 4 >= randomNumber) & (prelim_midterm + _83_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_93");
                        new_prefinal = 83;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_94) / 4 >= randomNumber) & (prelim_midterm + _83_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_94");
                        new_prefinal = 83;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_95) / 4 >= randomNumber) & (prelim_midterm + _83_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_95");
                        new_prefinal = 83;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_96) / 4 >= randomNumber) & (prelim_midterm + _83_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_96");
                        new_prefinal = 83;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_97) / 4 >= randomNumber) & (prelim_midterm + _83_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_97");
                        new_prefinal = 83;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_98) / 4 >= randomNumber) & (prelim_midterm + _83_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_98");
                        new_prefinal = 83;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_99) / 4 >= randomNumber) & (prelim_midterm + _83_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_99");
                        new_prefinal = 83;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _83_100) / 4 >= randomNumber) & (prelim_midterm + _83_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_83_100");
                        new_prefinal = 83;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 84

                    if (((prelim_midterm + _84_75) / 4 >= randomNumber) & (prelim_midterm + _84_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_75");
                        new_prefinal = 84;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_76) / 4 >= randomNumber) & (prelim_midterm + _84_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_76");
                        new_prefinal = 84;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_77) / 4 >= randomNumber) & (prelim_midterm + _84_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_77");
                        new_prefinal = 84;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_78) / 4 >= randomNumber) & (prelim_midterm + _84_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_78");
                        new_prefinal = 84;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_79) / 4 >= randomNumber) & (prelim_midterm + _84_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_79");
                        new_prefinal = 84;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_80) / 4 >= randomNumber) & (prelim_midterm + _84_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_80");
                        new_prefinal = 84;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_81) / 4 >= randomNumber) & (prelim_midterm + _84_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_81");
                        new_prefinal = 84;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_82) / 4 >= randomNumber) & (prelim_midterm + _84_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_82");
                        new_prefinal = 84;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_83) / 4 >= randomNumber) & (prelim_midterm + _84_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_83");
                        new_prefinal = 84;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_84) / 4 >= randomNumber) & (prelim_midterm + _84_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_84");
                        new_prefinal = 84;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_85) / 4 >= randomNumber) & (prelim_midterm + _84_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_85");
                        new_prefinal = 84;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_86) / 4 >= randomNumber) & (prelim_midterm + _84_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_86");
                        new_prefinal = 84;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_87) / 4 >= randomNumber) & (prelim_midterm + _84_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_87");
                        new_prefinal = 84;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_88) / 4 >= randomNumber) & (prelim_midterm + _84_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_88");
                        new_prefinal = 84;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_89) / 4 >= randomNumber) & (prelim_midterm + _84_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_89");
                        new_prefinal = 84;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_90) / 4 >= randomNumber) & (prelim_midterm + _84_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_90");
                        new_prefinal = 84;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_91) / 4 >= randomNumber) & (prelim_midterm + _84_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_91");
                        new_prefinal = 84;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_92) / 4 >= randomNumber) & (prelim_midterm + _84_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_92");
                        new_prefinal = 84;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_93) / 4 >= randomNumber) & (prelim_midterm + _84_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_93");
                        new_prefinal = 84;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_94) / 4 >= randomNumber) & (prelim_midterm + _84_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_94");
                        new_prefinal = 84;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_95) / 4 >= randomNumber) & (prelim_midterm + _84_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_95");
                        new_prefinal = 84;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_96) / 4 >= randomNumber) & (prelim_midterm + _84_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_96");
                        new_prefinal = 84;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_97) / 4 >= randomNumber) & (prelim_midterm + _84_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_97");
                        new_prefinal = 84;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_98) / 4 >= randomNumber) & (prelim_midterm + _84_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_98");
                        new_prefinal = 84;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_99) / 4 >= randomNumber) & (prelim_midterm + _84_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_99");
                        new_prefinal = 84;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _84_100) / 4 >= randomNumber) & (prelim_midterm + _84_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_84_100");
                        new_prefinal = 84;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 85

                    if (((prelim_midterm + _85_75) / 4 >= randomNumber) & (prelim_midterm + _85_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_75");
                        new_prefinal = 85;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_76) / 4 >= randomNumber) & (prelim_midterm + _85_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_76");
                        new_prefinal = 85;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_77) / 4 >= randomNumber) & (prelim_midterm + _85_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_77");
                        new_prefinal = 85;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_78) / 4 >= randomNumber) & (prelim_midterm + _85_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_78");
                        new_prefinal = 85;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_79) / 4 >= randomNumber) & (prelim_midterm + _85_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_79");
                        new_prefinal = 85;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_80) / 4 >= randomNumber) & (prelim_midterm + _85_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_80");
                        new_prefinal = 85;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_81) / 4 >= randomNumber) & (prelim_midterm + _85_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_81");
                        new_prefinal = 85;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_82) / 4 >= randomNumber) & (prelim_midterm + _85_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_82");
                        new_prefinal = 85;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_83) / 4 >= randomNumber) & (prelim_midterm + _85_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_83");
                        new_prefinal = 85;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_84) / 4 >= randomNumber) & (prelim_midterm + _85_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_84");
                        new_prefinal = 85;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_85) / 4 >= randomNumber) & (prelim_midterm + _85_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_85");
                        new_prefinal = 85;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_86) / 4 >= randomNumber) & (prelim_midterm + _85_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_86");
                        new_prefinal = 85;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_87) / 4 >= randomNumber) & (prelim_midterm + _85_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_87");
                        new_prefinal = 85;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_88) / 4 >= randomNumber) & (prelim_midterm + _85_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_88");
                        new_prefinal = 85;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_89) / 4 >= randomNumber) & (prelim_midterm + _85_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_89");
                        new_prefinal = 85;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_90) / 4 >= randomNumber) & (prelim_midterm + _85_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_90");
                        new_prefinal = 85;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_91) / 4 >= randomNumber) & (prelim_midterm + _85_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_91");
                        new_prefinal = 85;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_92) / 4 >= randomNumber) & (prelim_midterm + _85_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_92");
                        new_prefinal = 85;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_93) / 4 >= randomNumber) & (prelim_midterm + _85_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_93");
                        new_prefinal = 85;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_94) / 4 >= randomNumber) & (prelim_midterm + _85_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_94");
                        new_prefinal = 85;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_95) / 4 >= randomNumber) & (prelim_midterm + _85_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_95");
                        new_prefinal = 85;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_96) / 4 >= randomNumber) & (prelim_midterm + _85_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_96");
                        new_prefinal = 85;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_97) / 4 >= randomNumber) & (prelim_midterm + _85_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_97");
                        new_prefinal = 85;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_98) / 4 >= randomNumber) & (prelim_midterm + _85_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_98");
                        new_prefinal = 85;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_99) / 4 >= randomNumber) & (prelim_midterm + _85_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_99");
                        new_prefinal = 85;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _85_100) / 4 >= randomNumber) & (prelim_midterm + _85_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_85_100");
                        new_prefinal = 85;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 86

                    if (((prelim_midterm + _86_75) / 4 >= randomNumber) & (prelim_midterm + _86_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_75");
                        new_prefinal = 86;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_76) / 4 >= randomNumber) & (prelim_midterm + _86_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_76");
                        new_prefinal = 86;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_77) / 4 >= randomNumber) & (prelim_midterm + _86_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_77");
                        new_prefinal = 86;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_78) / 4 >= randomNumber) & (prelim_midterm + _86_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_78");
                        new_prefinal = 86;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_79) / 4 >= randomNumber) & (prelim_midterm + _86_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_79");
                        new_prefinal = 86;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_80) / 4 >= randomNumber) & (prelim_midterm + _86_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_80");
                        new_prefinal = 86;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_81) / 4 >= randomNumber) & (prelim_midterm + _86_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_81");
                        new_prefinal = 86;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_82) / 4 >= randomNumber) & (prelim_midterm + _86_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_82");
                        new_prefinal = 86;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_83) / 4 >= randomNumber) & (prelim_midterm + _86_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_83");
                        new_prefinal = 86;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_84) / 4 >= randomNumber) & (prelim_midterm + _86_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_84");
                        new_prefinal = 86;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_85) / 4 >= randomNumber) & (prelim_midterm + _86_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_85");
                        new_prefinal = 86;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_86) / 4 >= randomNumber) & (prelim_midterm + _86_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_86");
                        new_prefinal = 86;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_87) / 4 >= randomNumber) & (prelim_midterm + _86_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_87");
                        new_prefinal = 86;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_88) / 4 >= randomNumber) & (prelim_midterm + _86_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_88");
                        new_prefinal = 86;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_89) / 4 >= randomNumber) & (prelim_midterm + _86_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_89");
                        new_prefinal = 86;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_90) / 4 >= randomNumber) & (prelim_midterm + _86_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_90");
                        new_prefinal = 86;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_91) / 4 >= randomNumber) & (prelim_midterm + _86_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_91");
                        new_prefinal = 86;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_92) / 4 >= randomNumber) & (prelim_midterm + _86_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_92");
                        new_prefinal = 86;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_93) / 4 >= randomNumber) & (prelim_midterm + _86_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_93");
                        new_prefinal = 86;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_94) / 4 >= randomNumber) & (prelim_midterm + _86_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_94");
                        new_prefinal = 86;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_95) / 4 >= randomNumber) & (prelim_midterm + _86_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_95");
                        new_prefinal = 86;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_96) / 4 >= randomNumber) & (prelim_midterm + _86_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_96");
                        new_prefinal = 86;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_97) / 4 >= randomNumber) & (prelim_midterm + _86_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_97");
                        new_prefinal = 86;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_98) / 4 >= randomNumber) & (prelim_midterm + _86_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_98");
                        new_prefinal = 86;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_99) / 4 >= randomNumber) & (prelim_midterm + _86_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_99");
                        new_prefinal = 86;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _86_100) / 4 >= randomNumber) & (prelim_midterm + _86_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_86_100");
                        new_prefinal = 86;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 87

                    if (((prelim_midterm + _87_75) / 4 >= randomNumber) & (prelim_midterm + _87_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_75");
                        new_prefinal = 87;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_76) / 4 >= randomNumber) & (prelim_midterm + _87_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_76");
                        new_prefinal = 87;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_77) / 4 >= randomNumber) & (prelim_midterm + _87_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_77");
                        new_prefinal = 87;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_78) / 4 >= randomNumber) & (prelim_midterm + _87_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_78");
                        new_prefinal = 87;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_79) / 4 >= randomNumber) & (prelim_midterm + _87_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_79");
                        new_prefinal = 87;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_80) / 4 >= randomNumber) & (prelim_midterm + _87_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_80");
                        new_prefinal = 87;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_81) / 4 >= randomNumber) & (prelim_midterm + _87_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_81");
                        new_prefinal = 87;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_82) / 4 >= randomNumber) & (prelim_midterm + _87_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_82");
                        new_prefinal = 87;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_83) / 4 >= randomNumber) & (prelim_midterm + _87_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_83");
                        // alert(grade_array);
                        new_prefinal = 87;
                        new_final = 83;
                    }

                    if (((prelim_midterm + _87_84) / 4 >= randomNumber) & (prelim_midterm + _87_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_84");
                        new_prefinal = 87;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_85) / 4 >= randomNumber) & (prelim_midterm + _87_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_85");
                        new_prefinal = 87;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_86) / 4 >= randomNumber) & (prelim_midterm + _87_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_86");
                        new_prefinal = 87;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_87) / 4 >= randomNumber) & (prelim_midterm + _87_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_87");
                        new_prefinal = 87;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_88) / 4 >= randomNumber) & (prelim_midterm + _87_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_88");
                        new_prefinal = 87;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_89) / 4 >= randomNumber) & (prelim_midterm + _87_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_89");
                        new_prefinal = 87;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_90) / 4 >= randomNumber) & (prelim_midterm + _87_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_90");
                        new_prefinal = 87;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_91) / 4 >= randomNumber) & (prelim_midterm + _87_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_91");
                        new_prefinal = 87;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_92) / 4 >= randomNumber) & (prelim_midterm + _87_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_92");
                        new_prefinal = 87;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_93) / 4 >= randomNumber) & (prelim_midterm + _87_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_93");
                        new_prefinal = 87;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_94) / 4 >= randomNumber) & (prelim_midterm + _87_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_94");
                        new_prefinal = 87;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_95) / 4 >= randomNumber) & (prelim_midterm + _87_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_95");
                        new_prefinal = 87;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_96) / 4 >= randomNumber) & (prelim_midterm + _87_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_96");
                        new_prefinal = 87;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_97) / 4 >= randomNumber) & (prelim_midterm + _87_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_97");
                        new_prefinal = 87;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_98) / 4 >= randomNumber) & (prelim_midterm + _87_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_98");
                        new_prefinal = 87;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_99) / 4 >= randomNumber) & (prelim_midterm + _87_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_99");
                        new_prefinal = 87;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _87_100) / 4 >= randomNumber) & (prelim_midterm + _87_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_87_100");
                        new_prefinal = 87;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 88

                    if (((prelim_midterm + _88_75) / 4 >= randomNumber) & (prelim_midterm + _88_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_75");
                        new_prefinal = 88;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_76) / 4 >= randomNumber) & (prelim_midterm + _88_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_76");
                        new_prefinal = 88;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_77) / 4 >= randomNumber) & (prelim_midterm + _88_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_77");
                        new_prefinal = 88;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_78) / 4 >= randomNumber) & (prelim_midterm + _88_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_78");
                        new_prefinal = 88;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_79) / 4 >= randomNumber) & (prelim_midterm + _88_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_79");
                        new_prefinal = 88;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_80) / 4 >= randomNumber) & (prelim_midterm + _88_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_80");
                        new_prefinal = 88;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_81) / 4 >= randomNumber) & (prelim_midterm + _88_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_81");
                        new_prefinal = 88;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_82) / 4 >= randomNumber) & (prelim_midterm + _88_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_82");
                        new_prefinal = 88;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_83) / 4 >= randomNumber) & (prelim_midterm + _88_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_83");
                        new_prefinal = 88;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_84) / 4 >= randomNumber) & (prelim_midterm + _88_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_84");
                        new_prefinal = 88;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_85) / 4 >= randomNumber) & (prelim_midterm + _88_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_85");
                        new_prefinal = 88;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_86) / 4 >= randomNumber) & (prelim_midterm + _88_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_86");
                        new_prefinal = 88;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_87) / 4 >= randomNumber) & (prelim_midterm + _88_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_87");
                        new_prefinal = 88;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_88) / 4 >= randomNumber) & (prelim_midterm + _88_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_88");
                        new_prefinal = 88;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_89) / 4 >= randomNumber) & (prelim_midterm + _88_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_89");
                        new_prefinal = 88;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_90) / 4 >= randomNumber) & (prelim_midterm + _88_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_90");
                        new_prefinal = 88;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_91) / 4 >= randomNumber) & (prelim_midterm + _88_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_91");
                        new_prefinal = 88;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_92) / 4 >= randomNumber) & (prelim_midterm + _88_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_92");
                        new_prefinal = 88;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_93) / 4 >= randomNumber) & (prelim_midterm + _88_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_93");
                        new_prefinal = 88;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_94) / 4 >= randomNumber) & (prelim_midterm + _88_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_94");
                        new_prefinal = 88;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_95) / 4 >= randomNumber) & (prelim_midterm + _88_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_95");
                        new_prefinal = 88;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_96) / 4 >= randomNumber) & (prelim_midterm + _88_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_96");
                        new_prefinal = 88;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_97) / 4 >= randomNumber) & (prelim_midterm + _88_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_97");
                        new_prefinal = 88;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_98) / 4 >= randomNumber) & (prelim_midterm + _88_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_98");
                        new_prefinal = 88;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_99) / 4 >= randomNumber) & (prelim_midterm + _88_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_99");
                        new_prefinal = 88;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _88_100) / 4 >= randomNumber) & (prelim_midterm + _88_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_88_100");
                        new_prefinal = 88;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 89

                    if (((prelim_midterm + _89_75) / 4 >= randomNumber) & (prelim_midterm + _89_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_75");
                        new_prefinal = 89;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_76) / 4 >= randomNumber) & (prelim_midterm + _89_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_76");
                        new_prefinal = 89;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_77) / 4 >= randomNumber) & (prelim_midterm + _89_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_77");
                        new_prefinal = 89;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_78) / 4 >= randomNumber) & (prelim_midterm + _89_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_78");
                        new_prefinal = 89;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_79) / 4 >= randomNumber) & (prelim_midterm + _89_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_79");
                        new_prefinal = 89;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_80) / 4 >= randomNumber) & (prelim_midterm + _89_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_80");
                        new_prefinal = 89;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_81) / 4 >= randomNumber) & (prelim_midterm + _89_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_81");
                        new_prefinal = 89;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_82) / 4 >= randomNumber) & (prelim_midterm + _89_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_82");
                        new_prefinal = 89;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_83) / 4 >= randomNumber) & (prelim_midterm + _89_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_83");
                        new_prefinal = 89;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_84) / 4 >= randomNumber) & (prelim_midterm + _89_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_84");
                        new_prefinal = 89;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_85) / 4 >= randomNumber) & (prelim_midterm + _89_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_85");
                        new_prefinal = 89;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_86) / 4 >= randomNumber) & (prelim_midterm + _89_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_86");
                        new_prefinal = 89;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_87) / 4 >= randomNumber) & (prelim_midterm + _89_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_87");
                        new_prefinal = 89;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_88) / 4 >= randomNumber) & (prelim_midterm + _89_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_88");
                        new_prefinal = 89;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_89) / 4 >= randomNumber) & (prelim_midterm + _89_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_89");
                        new_prefinal = 89;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_90) / 4 >= randomNumber) & (prelim_midterm + _89_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_90");
                        new_prefinal = 89;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_91) / 4 >= randomNumber) & (prelim_midterm + _89_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_91");
                        new_prefinal = 89;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_92) / 4 >= randomNumber) & (prelim_midterm + _89_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_92");
                        new_prefinal = 89;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_93) / 4 >= randomNumber) & (prelim_midterm + _89_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_93");
                        new_prefinal = 89;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_94) / 4 >= randomNumber) & (prelim_midterm + _89_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_94");
                        new_prefinal = 89;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_95) / 4 >= randomNumber) & (prelim_midterm + _89_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_95");
                        new_prefinal = 89;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_96) / 4 >= randomNumber) & (prelim_midterm + _89_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_96");
                        new_prefinal = 89;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_97) / 4 >= randomNumber) & (prelim_midterm + _89_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_97");
                        new_prefinal = 89;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_98) / 4 >= randomNumber) & (prelim_midterm + _89_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_98");
                        new_prefinal = 89;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_99) / 4 >= randomNumber) & (prelim_midterm + _89_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_99");
                        new_prefinal = 89;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _89_100) / 4 >= randomNumber) & (prelim_midterm + _89_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_89_100");
                        new_prefinal = 89;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 90

                    if (((prelim_midterm + _90_75) / 4 >= randomNumber) & (prelim_midterm + _90_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_75");
                        new_prefinal = 90;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_76) / 4 >= randomNumber) & (prelim_midterm + _90_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_76");
                        new_prefinal = 90;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_77) / 4 >= randomNumber) & (prelim_midterm + _90_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_77");
                        new_prefinal = 90;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_78) / 4 >= randomNumber) & (prelim_midterm + _90_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_78");
                        new_prefinal = 90;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_79) / 4 >= randomNumber) & (prelim_midterm + _90_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_79");
                        new_prefinal = 90;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_80) / 4 >= randomNumber) & (prelim_midterm + _90_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_80");
                        new_prefinal = 90;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_81) / 4 >= randomNumber) & (prelim_midterm + _90_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_81");
                        new_prefinal = 90;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_82) / 4 >= randomNumber) & (prelim_midterm + _90_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_82");
                        new_prefinal = 90;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_83) / 4 >= randomNumber) & (prelim_midterm + _90_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_83");
                        new_prefinal = 90;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_84) / 4 >= randomNumber) & (prelim_midterm + _90_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_84");
                        new_prefinal = 90;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_85) / 4 >= randomNumber) & (prelim_midterm + _90_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_85");
                        new_prefinal = 90;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_86) / 4 >= randomNumber) & (prelim_midterm + _90_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_86");
                        new_prefinal = 90;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_87) / 4 >= randomNumber) & (prelim_midterm + _90_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_87");
                        new_prefinal = 90;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_88) / 4 >= randomNumber) & (prelim_midterm + _90_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_88");
                        new_prefinal = 90;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_89) / 4 >= randomNumber) & (prelim_midterm + _90_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_89");
                        new_prefinal = 90;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_90) / 4 >= randomNumber) & (prelim_midterm + _90_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_90");
                        new_prefinal = 90;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_91) / 4 >= randomNumber) & (prelim_midterm + _90_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_91");
                        new_prefinal = 90;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_92) / 4 >= randomNumber) & (prelim_midterm + _90_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_92");
                        new_prefinal = 90;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_93) / 4 >= randomNumber) & (prelim_midterm + _90_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_93");
                        new_prefinal = 90;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_94) / 4 >= randomNumber) & (prelim_midterm + _90_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_94");
                        new_prefinal = 90;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_95) / 4 >= randomNumber) & (prelim_midterm + _90_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_95");
                        new_prefinal = 90;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_96) / 4 >= randomNumber) & (prelim_midterm + _90_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_96");
                        new_prefinal = 90;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_97) / 4 >= randomNumber) & (prelim_midterm + _90_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_97");
                        new_prefinal = 90;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_98) / 4 >= randomNumber) & (prelim_midterm + _90_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_98");
                        new_prefinal = 90;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_99) / 4 >= randomNumber) & (prelim_midterm + _90_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_99");
                        new_prefinal = 90;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _90_100) / 4 >= randomNumber) & (prelim_midterm + _90_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_90_100");
                        new_prefinal = 90;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 91

                    if (((prelim_midterm + _91_75) / 4 >= randomNumber) & (prelim_midterm + _91_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_75");
                        new_prefinal = 91;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_76) / 4 >= randomNumber) & (prelim_midterm + _91_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_76");
                        new_prefinal = 91;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_77) / 4 >= randomNumber) & (prelim_midterm + _91_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_77");
                        new_prefinal = 91;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_78) / 4 >= randomNumber) & (prelim_midterm + _91_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_78");
                        new_prefinal = 91;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_79) / 4 >= randomNumber) & (prelim_midterm + _91_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_79");
                        new_prefinal = 91;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_80) / 4 >= randomNumber) & (prelim_midterm + _91_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_80");
                        new_prefinal = 91;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_81) / 4 >= randomNumber) & (prelim_midterm + _91_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_81");
                        new_prefinal = 91;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_82) / 4 >= randomNumber) & (prelim_midterm + _91_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_82");
                        new_prefinal = 91;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_83) / 4 >= randomNumber) & (prelim_midterm + _91_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_83");
                        new_prefinal = 91;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_84) / 4 >= randomNumber) & (prelim_midterm + _91_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_84");
                        new_prefinal = 91;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_85) / 4 >= randomNumber) & (prelim_midterm + _91_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_85");
                        new_prefinal = 91;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_86) / 4 >= randomNumber) & (prelim_midterm + _91_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_86");
                        new_prefinal = 91;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_87) / 4 >= randomNumber) & (prelim_midterm + _91_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_87");
                        new_prefinal = 91;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_88) / 4 >= randomNumber) & (prelim_midterm + _91_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_88");
                        new_prefinal = 91;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_89) / 4 >= randomNumber) & (prelim_midterm + _91_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_89");
                        new_prefinal = 91;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_90) / 4 >= randomNumber) & (prelim_midterm + _91_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_90");
                        new_prefinal = 91;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_91) / 4 >= randomNumber) & (prelim_midterm + _91_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_91");
                        new_prefinal = 91;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_92) / 4 >= randomNumber) & (prelim_midterm + _91_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_92");
                        new_prefinal = 91;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_93) / 4 >= randomNumber) & (prelim_midterm + _91_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_93");
                        new_prefinal = 91;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_94) / 4 >= randomNumber) & (prelim_midterm + _91_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_94");
                        new_prefinal = 91;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_95) / 4 >= randomNumber) & (prelim_midterm + _91_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_95");
                        new_prefinal = 91;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_96) / 4 >= randomNumber) & (prelim_midterm + _91_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_96");
                        new_prefinal = 91;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_97) / 4 >= randomNumber) & (prelim_midterm + _91_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_97");
                        new_prefinal = 91;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_98) / 4 >= randomNumber) & (prelim_midterm + _91_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_98");
                        new_prefinal = 91;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_99) / 4 >= randomNumber) & (prelim_midterm + _91_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_99");
                        new_prefinal = 91;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _91_100) / 4 >= randomNumber) & (prelim_midterm + _91_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_91_100");
                        new_prefinal = 91;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 92

                    if (((prelim_midterm + _92_75) / 4 >= randomNumber) & (prelim_midterm + _92_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_75");
                        new_prefinal = 92;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_76) / 4 >= randomNumber) & (prelim_midterm + _92_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_76");
                        new_prefinal = 92;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_77) / 4 >= randomNumber) & (prelim_midterm + _92_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_77");
                        new_prefinal = 92;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_78) / 4 >= randomNumber) & (prelim_midterm + _92_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_78");
                        new_prefinal = 92;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_79) / 4 >= randomNumber) & (prelim_midterm + _92_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_79");
                        new_prefinal = 92;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_80) / 4 >= randomNumber) & (prelim_midterm + _92_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_80");
                        new_prefinal = 92;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_81) / 4 >= randomNumber) & (prelim_midterm + _92_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_81");
                        new_prefinal = 92;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_82) / 4 >= randomNumber) & (prelim_midterm + _92_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_82");
                        new_prefinal = 92;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_83) / 4 >= randomNumber) & (prelim_midterm + _92_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_83");
                        new_prefinal = 92;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_84) / 4 >= randomNumber) & (prelim_midterm + _92_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_84");
                        new_prefinal = 92;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_85) / 4 >= randomNumber) & (prelim_midterm + _92_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_85");
                        new_prefinal = 92;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_86) / 4 >= randomNumber) & (prelim_midterm + _92_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_86");
                        new_prefinal = 92;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_87) / 4 >= randomNumber) & (prelim_midterm + _92_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_87");
                        new_prefinal = 92;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_88) / 4 >= randomNumber) & (prelim_midterm + _92_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_88");
                        new_prefinal = 92;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_89) / 4 >= randomNumber) & (prelim_midterm + _92_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_89");
                        new_prefinal = 92;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_90) / 4 >= randomNumber) & (prelim_midterm + _92_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_90");
                        new_prefinal = 92;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_91) / 4 >= randomNumber) & (prelim_midterm + _92_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_91");
                        new_prefinal = 92;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_92) / 4 >= randomNumber) & (prelim_midterm + _92_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_92");
                        new_prefinal = 92;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_93) / 4 >= randomNumber) & (prelim_midterm + _92_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_93");
                        new_prefinal = 92;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_94) / 4 >= randomNumber) & (prelim_midterm + _92_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_94");
                        new_prefinal = 92;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_95) / 4 >= randomNumber) & (prelim_midterm + _92_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_95");
                        new_prefinal = 92;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_96) / 4 >= randomNumber) & (prelim_midterm + _92_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_96");
                        new_prefinal = 92;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_97) / 4 >= randomNumber) & (prelim_midterm + _92_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_97");
                        new_prefinal = 92;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_98) / 4 >= randomNumber) & (prelim_midterm + _92_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_98");
                        new_prefinal = 92;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_99) / 4 >= randomNumber) & (prelim_midterm + _92_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_99");
                        new_prefinal = 92;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _92_100) / 4 >= randomNumber) & (prelim_midterm + _92_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_92_100");
                        new_prefinal = 92;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 93

                    if (((prelim_midterm + _93_75) / 4 >= randomNumber) & (prelim_midterm + _93_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_75");
                        new_prefinal = 93;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_76) / 4 >= randomNumber) & (prelim_midterm + _93_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_76");
                        new_prefinal = 93;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_77) / 4 >= randomNumber) & (prelim_midterm + _93_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_77");
                        new_prefinal = 93;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_78) / 4 >= randomNumber) & (prelim_midterm + _93_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_78");
                        new_prefinal = 93;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_79) / 4 >= randomNumber) & (prelim_midterm + _93_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_79");
                        new_prefinal = 93;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_80) / 4 >= randomNumber) & (prelim_midterm + _93_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_80");
                        new_prefinal = 93;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_81) / 4 >= randomNumber) & (prelim_midterm + _93_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_81");
                        new_prefinal = 93;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_82) / 4 >= randomNumber) & (prelim_midterm + _93_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_82");
                        new_prefinal = 93;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_83) / 4 >= randomNumber) & (prelim_midterm + _93_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_83");
                        new_prefinal = 93;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_84) / 4 >= randomNumber) & (prelim_midterm + _93_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_84");
                        new_prefinal = 93;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_85) / 4 >= randomNumber) & (prelim_midterm + _93_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_85");
                        new_prefinal = 93;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_86) / 4 >= randomNumber) & (prelim_midterm + _93_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_86");
                        new_prefinal = 93;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_87) / 4 >= randomNumber) & (prelim_midterm + _93_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_87");
                        new_prefinal = 93;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_88) / 4 >= randomNumber) & (prelim_midterm + _93_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_88");
                        new_prefinal = 93;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_89) / 4 >= randomNumber) & (prelim_midterm + _93_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_89");
                        new_prefinal = 93;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_90) / 4 >= randomNumber) & (prelim_midterm + _93_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_90");
                        new_prefinal = 93;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_91) / 4 >= randomNumber) & (prelim_midterm + _93_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_91");
                        new_prefinal = 93;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_92) / 4 >= randomNumber) & (prelim_midterm + _93_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_92");
                        new_prefinal = 93;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_93) / 4 >= randomNumber) & (prelim_midterm + _93_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_93");
                        new_prefinal = 93;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_94) / 4 >= randomNumber) & (prelim_midterm + _93_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_94");
                        new_prefinal = 93;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_95) / 4 >= randomNumber) & (prelim_midterm + _93_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_95");
                        new_prefinal = 93;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_96) / 4 >= randomNumber) & (prelim_midterm + _93_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_96");
                        new_prefinal = 93;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_97) / 4 >= randomNumber) & (prelim_midterm + _93_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_97");
                        new_prefinal = 93;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_98) / 4 >= randomNumber) & (prelim_midterm + _93_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_98");
                        new_prefinal = 93;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_99) / 4 >= randomNumber) & (prelim_midterm + _93_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_99");
                        new_prefinal = 93;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _93_100) / 4 >= randomNumber) & (prelim_midterm + _93_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_93_100");
                        new_prefinal = 93;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 94

                    if (((prelim_midterm + _94_75) / 4 >= randomNumber) & (prelim_midterm + _94_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_75");
                        new_prefinal = 94;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_76) / 4 >= randomNumber) & (prelim_midterm + _94_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_76");
                        new_prefinal = 94;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_77) / 4 >= randomNumber) & (prelim_midterm + _94_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_77");
                        new_prefinal = 94;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_78) / 4 >= randomNumber) & (prelim_midterm + _94_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_78");
                        new_prefinal = 94;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_79) / 4 >= randomNumber) & (prelim_midterm + _94_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_79");
                        new_prefinal = 94;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_80) / 4 >= randomNumber) & (prelim_midterm + _94_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_80");
                        new_prefinal = 94;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_81) / 4 >= randomNumber) & (prelim_midterm + _94_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_81");
                        new_prefinal = 94;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_82) / 4 >= randomNumber) & (prelim_midterm + _94_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_82");
                        new_prefinal = 94;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_83) / 4 >= randomNumber) & (prelim_midterm + _94_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_83");
                        new_prefinal = 94;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_84) / 4 >= randomNumber) & (prelim_midterm + _94_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_84");
                        new_prefinal = 94;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_85) / 4 >= randomNumber) & (prelim_midterm + _94_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_85");
                        new_prefinal = 94;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_86) / 4 >= randomNumber) & (prelim_midterm + _94_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_86");
                        new_prefinal = 94;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_87) / 4 >= randomNumber) & (prelim_midterm + _94_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_87");
                        new_prefinal = 94;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_88) / 4 >= randomNumber) & (prelim_midterm + _94_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_88");
                        new_prefinal = 94;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_89) / 4 >= randomNumber) & (prelim_midterm + _94_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_89");
                        new_prefinal = 94;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_90) / 4 >= randomNumber) & (prelim_midterm + _94_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_90");
                        new_prefinal = 94;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_91) / 4 >= randomNumber) & (prelim_midterm + _94_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_91");
                        new_prefinal = 94;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_92) / 4 >= randomNumber) & (prelim_midterm + _94_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_92");
                        new_prefinal = 94;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_93) / 4 >= randomNumber) & (prelim_midterm + _94_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_93");
                        new_prefinal = 94;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_94) / 4 >= randomNumber) & (prelim_midterm + _94_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_94");
                        new_prefinal = 94;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_95) / 4 >= randomNumber) & (prelim_midterm + _94_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_95");
                        new_prefinal = 94;
                        new_final = 95
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_96) / 4 >= randomNumber) & (prelim_midterm + _94_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_96");
                        new_prefinal = 94;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_97) / 4 >= randomNumber) & (prelim_midterm + _94_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_97");
                        new_prefinal = 94;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_98) / 4 >= randomNumber) & (prelim_midterm + _94_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_98");
                        new_prefinal = 94;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_99) / 4 >= randomNumber) & (prelim_midterm + _94_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_99");
                        new_prefinal = 94;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _94_100) / 4 >= randomNumber) & (prelim_midterm + _94_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_94_100");
                        new_prefinal = 94;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 95

                    if (((prelim_midterm + _95_75) / 4 >= randomNumber) & (prelim_midterm + _95_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_75");
                        new_prefinal = 95;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_76) / 4 >= randomNumber) & (prelim_midterm + _95_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_76");
                        new_prefinal = 95;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_77) / 4 >= randomNumber) & (prelim_midterm + _95_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_77");
                        new_prefinal = 95;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_78) / 4 >= randomNumber) & (prelim_midterm + _95_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_78");
                        new_prefinal = 95;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_79) / 4 >= randomNumber) & (prelim_midterm + _95_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_79");
                        new_prefinal = 95;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_80) / 4 >= randomNumber) & (prelim_midterm + _95_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_80");
                        new_prefinal = 95;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_81) / 4 >= randomNumber) & (prelim_midterm + _95_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_81");
                        new_prefinal = 95;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_82) / 4 >= randomNumber) & (prelim_midterm + _95_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_82");
                        new_prefinal = 95;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_83) / 4 >= randomNumber) & (prelim_midterm + _95_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_83");
                        new_prefinal = 95;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_84) / 4 >= randomNumber) & (prelim_midterm + _95_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_84");
                        new_prefinal = 95;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_85) / 4 >= randomNumber) & (prelim_midterm + _95_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_85");
                        new_prefinal = 95;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_86) / 4 >= randomNumber) & (prelim_midterm + _95_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_86");
                        new_prefinal = 95;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_87) / 4 >= randomNumber) & (prelim_midterm + _95_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_87");
                        new_prefinal = 95;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_88) / 4 >= randomNumber) & (prelim_midterm + _95_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_88");
                        new_prefinal = 95;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_89) / 4 >= randomNumber) & (prelim_midterm + _95_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_89");
                        new_prefinal = 95;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_90) / 4 >= randomNumber) & (prelim_midterm + _95_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_90");
                        new_prefinal = 95;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_91) / 4 >= randomNumber) & (prelim_midterm + _95_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_91");
                        new_prefinal = 95;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_92) / 4 >= randomNumber) & (prelim_midterm + _95_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_92");
                        new_prefinal = 95;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_93) / 4 >= randomNumber) & (prelim_midterm + _95_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_93");
                        new_prefinal = 95;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_94) / 4 >= randomNumber) & (prelim_midterm + _95_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_94");
                        new_prefinal = 95;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_95) / 4 >= randomNumber) & (prelim_midterm + _95_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_95");
                        new_prefinal = 95;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_96) / 4 >= randomNumber) & (prelim_midterm + _95_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_96");
                        new_prefinal = 95;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_97) / 4 >= randomNumber) & (prelim_midterm + _95_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_97");
                        new_prefinal = 95;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_98) / 4 >= randomNumber) & (prelim_midterm + _95_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_98");
                        new_prefinal = 95;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_99) / 4 >= randomNumber) & (prelim_midterm + _95_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_99");
                        new_prefinal = 95;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _95_100) / 4 >= randomNumber) & (prelim_midterm + _95_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_95_100");
                        new_prefinal = 95;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 96

                    if (((prelim_midterm + _96_75) / 4 >= randomNumber) & (prelim_midterm + _96_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_75");
                        new_prefinal = 96;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_76) / 4 >= randomNumber) & (prelim_midterm + _96_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_76");
                        new_prefinal = 96;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_77) / 4 >= randomNumber) & (prelim_midterm + _96_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_77");
                        new_prefinal = 96;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_78) / 4 >= randomNumber) & (prelim_midterm + _96_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_78");
                        new_prefinal = 96;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_79) / 4 >= randomNumber) & (prelim_midterm + _96_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_79");
                        new_prefinal = 96;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_80) / 4 >= randomNumber) & (prelim_midterm + _96_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_80");
                        new_prefinal = 96;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_81) / 4 >= randomNumber) & (prelim_midterm + _96_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_81");
                        new_prefinal = 96;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_82) / 4 >= randomNumber) & (prelim_midterm + _96_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_82");
                        new_prefinal = 96;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_83) / 4 >= randomNumber) & (prelim_midterm + _96_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_83");
                        new_prefinal = 96;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_84) / 4 >= randomNumber) & (prelim_midterm + _96_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_84");
                        new_prefinal = 96;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_85) / 4 >= randomNumber) & (prelim_midterm + _96_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_85");
                        new_prefinal = 96;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_86) / 4 >= randomNumber) & (prelim_midterm + _96_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_86");
                        new_prefinal = 96;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_87) / 4 >= randomNumber) & (prelim_midterm + _96_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_87");
                        new_prefinal = 96;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_88) / 4 >= randomNumber) & (prelim_midterm + _96_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_88");
                        new_prefinal = 96;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_89) / 4 >= randomNumber) & (prelim_midterm + _96_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_89");
                        new_prefinal = 96;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_90) / 4 >= randomNumber) & (prelim_midterm + _96_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_90");
                        new_prefinal = 96;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_91) / 4 >= randomNumber) & (prelim_midterm + _96_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_91");
                        new_prefinal = 96;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_92) / 4 >= randomNumber) & (prelim_midterm + _96_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_92");
                        new_prefinal = 96;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_93) / 4 >= randomNumber) & (prelim_midterm + _96_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_93");
                        new_prefinal = 96;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_94) / 4 >= randomNumber) & (prelim_midterm + _96_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_94");
                        new_prefinal = 96;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_95) / 4 >= randomNumber) & (prelim_midterm + _96_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_95");
                        new_prefinal = 96;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_96) / 4 >= randomNumber) & (prelim_midterm + _96_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_96");
                        new_prefinal = 96;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_97) / 4 >= randomNumber) & (prelim_midterm + _96_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_97");
                        new_prefinal = 96;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_98) / 4 >= randomNumber) & (prelim_midterm + _96_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_98");
                        new_prefinal = 96;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_99) / 4 >= randomNumber) & (prelim_midterm + _96_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_99");
                        new_prefinal = 96;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _96_100) / 4 >= randomNumber) & (prelim_midterm + _96_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_96_100");
                        new_prefinal = 96;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 97

                    if (((prelim_midterm + _97_75) / 4 >= randomNumber) & (prelim_midterm + _97_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_75");
                        new_prefinal = 97;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_76) / 4 >= randomNumber) & (prelim_midterm + _97_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_76");
                        new_prefinal = 97;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_77) / 4 >= randomNumber) & (prelim_midterm + _97_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_77");
                        new_prefinal = 97;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_78) / 4 >= randomNumber) & (prelim_midterm + _97_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_78");
                        new_prefinal = 97;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_79) / 4 >= randomNumber) & (prelim_midterm + _97_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_79");
                        new_prefinal = 97;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_80) / 4 >= randomNumber) & (prelim_midterm + _97_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_80");
                        new_prefinal = 97;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_81) / 4 >= randomNumber) & (prelim_midterm + _97_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_81");
                        new_prefinal = 97;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_82) / 4 >= randomNumber) & (prelim_midterm + _97_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_82");
                        new_prefinal = 97;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_83) / 4 >= randomNumber) & (prelim_midterm + _97_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_83");
                        new_prefinal = 97;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_84) / 4 >= randomNumber) & (prelim_midterm + _97_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_84");
                        new_prefinal = 97;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_85) / 4 >= randomNumber) & (prelim_midterm + _97_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_85");
                        new_prefinal = 97;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_86) / 4 >= randomNumber) & (prelim_midterm + _97_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_86");
                        new_prefinal = 97;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_87) / 4 >= randomNumber) & (prelim_midterm + _97_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_87");
                        new_prefinal = 97;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_88) / 4 >= randomNumber) & (prelim_midterm + _97_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_88");
                        new_prefinal = 97;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_89) / 4 >= randomNumber) & (prelim_midterm + _97_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_89");
                        new_prefinal = 97;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_90) / 4 >= randomNumber) & (prelim_midterm + _97_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_90");
                        new_prefinal = 97;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_91) / 4 >= randomNumber) & (prelim_midterm + _97_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_91");
                        new_prefinal = 97;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_92) / 4 >= randomNumber) & (prelim_midterm + _97_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_92");
                        new_prefinal = 97;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_93) / 4 >= randomNumber) & (prelim_midterm + _97_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_93");
                        new_prefinal = 97;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_94) / 4 >= randomNumber) & (prelim_midterm + _97_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_94");
                        new_prefinal = 97;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_95) / 4 >= randomNumber) & (prelim_midterm + _97_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_95");
                        new_prefinal = 97;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_96) / 4 >= randomNumber) & (prelim_midterm + _97_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_96");
                        new_prefinal = 97;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_97) / 4 >= randomNumber) & (prelim_midterm + _97_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_97");
                        new_prefinal = 97;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_98) / 4 >= randomNumber) & (prelim_midterm + _97_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_98");
                        new_prefinal = 97;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_99) / 4 >= randomNumber) & (prelim_midterm + _97_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_99");
                        new_prefinal = 97;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _97_100) / 4 >= randomNumber) & (prelim_midterm + _97_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_97_100");
                        new_prefinal = 97;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 98

                    if (((prelim_midterm + _98_75) / 4 >= randomNumber) & (prelim_midterm + _98_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_75");
                        new_prefinal = 98;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_76) / 4 >= randomNumber) & (prelim_midterm + _98_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_76");
                        new_prefinal = 98;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_77) / 4 >= randomNumber) & (prelim_midterm + _98_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_77");
                        new_prefinal = 98;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_78) / 4 >= randomNumber) & (prelim_midterm + _98_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_78");
                        new_prefinal = 98;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_79) / 4 >= randomNumber) & (prelim_midterm + _98_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_79");
                        new_prefinal = 98;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_80) / 4 >= randomNumber) & (prelim_midterm + _98_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_80");
                        new_prefinal = 98;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_81) / 4 >= randomNumber) & (prelim_midterm + _98_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_81");
                        new_prefinal = 98;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_82) / 4 >= randomNumber) & (prelim_midterm + _98_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_82");
                        new_prefinal = 98;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_83) / 4 >= randomNumber) & (prelim_midterm + _98_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_83");
                        new_prefinal = 98;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_84) / 4 >= randomNumber) & (prelim_midterm + _98_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_84");
                        new_prefinal = 98;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_85) / 4 >= randomNumber) & (prelim_midterm + _98_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_85");
                        new_prefinal = 98;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_86) / 4 >= randomNumber) & (prelim_midterm + _98_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_86");
                        new_prefinal = 98;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_87) / 4 >= randomNumber) & (prelim_midterm + _98_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_87");
                        new_prefinal = 98;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_88) / 4 >= randomNumber) & (prelim_midterm + _98_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_88");
                        new_prefinal = 98;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_89) / 4 >= randomNumber) & (prelim_midterm + _98_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_89");
                        new_prefinal = 98;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_90) / 4 >= randomNumber) & (prelim_midterm + _98_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_90");
                        new_prefinal = 98;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_91) / 4 >= randomNumber) & (prelim_midterm + _98_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_91");
                        new_prefinal = 98;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_92) / 4 >= randomNumber) & (prelim_midterm + _98_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_92");
                        new_prefinal = 98;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_93) / 4 >= randomNumber) & (prelim_midterm + _98_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_93");
                        new_prefinal = 98;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_94) / 4 >= randomNumber) & (prelim_midterm + _98_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_94");
                        new_prefinal = 98;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_95) / 4 >= randomNumber) & (prelim_midterm + _98_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_95");
                        new_prefinal = 98;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_96) / 4 >= randomNumber) & (prelim_midterm + _98_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_96");
                        new_prefinal = 98;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_97) / 4 >= randomNumber) & (prelim_midterm + _98_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_97");
                        new_prefinal = 98;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_98) / 4 >= randomNumber) & (prelim_midterm + _98_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_98");
                        new_prefinal = 98;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_99) / 4 >= randomNumber) & (prelim_midterm + _98_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_99");
                        new_prefinal = 98;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _98_100) / 4 >= randomNumber) & (prelim_midterm + _98_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_98_100");
                        new_prefinal = 98;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 99

                    if (((prelim_midterm + _99_75) / 4 >= randomNumber) & (prelim_midterm + _99_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_75");
                        new_prefinal = 99;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_76) / 4 >= randomNumber) & (prelim_midterm + _99_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_76");
                        new_prefinal = 99;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_77) / 4 >= randomNumber) & (prelim_midterm + _99_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_77");
                        new_prefinal = 99;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_78) / 4 >= randomNumber) & (prelim_midterm + _99_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_78");
                        new_prefinal = 99;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_79) / 4 >= randomNumber) & (prelim_midterm + _99_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_79");
                        new_prefinal = 99;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_80) / 4 >= randomNumber) & (prelim_midterm + _99_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_80");
                        new_prefinal = 99;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_81) / 4 >= randomNumber) & (prelim_midterm + _99_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_81");
                        new_prefinal = 99;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_82) / 4 >= randomNumber) & (prelim_midterm + _99_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_82");
                        new_prefinal = 99;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_83) / 4 >= randomNumber) & (prelim_midterm + _99_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_83");
                        new_prefinal = 99;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_84) / 4 >= randomNumber) & (prelim_midterm + _99_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_84");
                        new_prefinal = 99;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_85) / 4 >= randomNumber) & (prelim_midterm + _99_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_85");
                        new_prefinal = 99;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_86) / 4 >= randomNumber) & (prelim_midterm + _99_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_86");
                        new_prefinal = 99;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_87) / 4 >= randomNumber) & (prelim_midterm + _99_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_87");
                        new_prefinal = 99;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_88) / 4 >= randomNumber) & (prelim_midterm + _99_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_88");
                        new_prefinal = 99;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_89) / 4 >= randomNumber) & (prelim_midterm + _99_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_89");
                        new_prefinal = 99;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_90) / 4 >= randomNumber) & (prelim_midterm + _99_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_90");
                        new_prefinal = 99;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_91) / 4 >= randomNumber) & (prelim_midterm + _99_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_91");
                        new_prefinal = 99;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_92) / 4 >= randomNumber) & (prelim_midterm + _99_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_92");
                        new_prefinal = 99;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_93) / 4 >= randomNumber) & (prelim_midterm + _99_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_93");
                        new_prefinal = 99;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_94) / 4 >= randomNumber) & (prelim_midterm + _99_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_94");
                        new_prefinal = 99;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_95) / 4 >= randomNumber) & (prelim_midterm + _99_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_95");
                        new_prefinal = 99;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_96) / 4 >= randomNumber) & (prelim_midterm + _99_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_96");
                        new_prefinal = 99;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_97) / 4 >= randomNumber) & (prelim_midterm + _99_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_97");
                        new_prefinal = 99;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_98) / 4 >= randomNumber) & (prelim_midterm + _99_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_98");
                        new_prefinal = 99;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_99) / 4 >= randomNumber) & (prelim_midterm + _99_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_99");
                        new_prefinal = 99;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _99_100) / 4 >= randomNumber) & (prelim_midterm + _99_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_99_100");
                        new_prefinal = 99;
                        new_final = 100;
                        // alert(grade_array);
                    }


                    // 100

                    if (((prelim_midterm + _100_75) / 4 >= randomNumber) & (prelim_midterm + _100_75) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_75");
                        new_prefinal = 100;
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_76) / 4 >= randomNumber) & (prelim_midterm + _100_76) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_76");
                        new_prefinal = 100;
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_77) / 4 >= randomNumber) & (prelim_midterm + _100_77) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_77");
                        new_prefinal = 100;
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_78) / 4 >= randomNumber) & (prelim_midterm + _100_78) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_78");
                        new_prefinal = 100;
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_79) / 4 >= randomNumber) & (prelim_midterm + _100_79) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_79");
                        new_prefinal = 100;
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_80) / 4 >= randomNumber) & (prelim_midterm + _100_80) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_80");
                        new_prefinal = 100;
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_81) / 4 >= randomNumber) & (prelim_midterm + _100_81) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_81");
                        new_prefinal = 100;
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_82) / 4 >= randomNumber) & (prelim_midterm + _100_82) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_82");
                        new_prefinal = 100;
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_83) / 4 >= randomNumber) & (prelim_midterm + _100_83) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_83");
                        new_prefinal = 100;
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_84) / 4 >= randomNumber) & (prelim_midterm + _100_84) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_84");
                        new_prefinal = 100;
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_85) / 4 >= randomNumber) & (prelim_midterm + _100_85) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_85");
                        new_prefinal = 100;
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_86) / 4 >= randomNumber) & (prelim_midterm + _100_86) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_86");
                        new_prefinal = 100;
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_87) / 4 >= randomNumber) & (prelim_midterm + _100_87) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_87");
                        new_prefinal = 100;
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_88) / 4 >= randomNumber) & (prelim_midterm + _100_88) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_88");
                        new_prefinal = 100;
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_89) / 4 >= randomNumber) & (prelim_midterm + _100_89) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_89");
                        new_prefinal = 100;
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_90) / 4 >= randomNumber) & (prelim_midterm + _100_90) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_90");
                        new_prefinal = 100;
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_91) / 4 >= randomNumber) & (prelim_midterm + _100_91) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_91");
                        new_prefinal = 100;
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_92) / 4 >= randomNumber) & (prelim_midterm + _100_92) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_92");
                        new_prefinal = 100;
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_93) / 4 >= randomNumber) & (prelim_midterm + _100_93) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_93");
                        new_prefinal = 100;
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_94) / 4 >= randomNumber) & (prelim_midterm + _100_94) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_94");
                        new_prefinal = 100;
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_95) / 4 >= randomNumber) & (prelim_midterm + _100_95) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_95");
                        new_prefinal = 100;
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_96) / 4 >= randomNumber) & (prelim_midterm + _100_96) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_96");
                        new_prefinal = 100;
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_97) / 4 >= randomNumber) & (prelim_midterm + _100_97) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_97");
                        new_prefinal = 100;
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_98) / 4 >= randomNumber) & (prelim_midterm + _100_98) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_98");
                        new_prefinal = 100;
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_99) / 4 >= randomNumber) & (prelim_midterm + _100_99) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_99");
                        new_prefinal = 100;
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + _100_100) / 4 >= randomNumber) & (prelim_midterm + _100_100) / 4 <= parseInt(randomNumber) + 1) {
                        grade_array.push("_100_100");
                        new_prefinal = 100;
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
                    // alert(predict_grade_array);

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

                    // var xhr = new XMLHttpRequest();
                    // xhr.open('POST', 'save_prediction.php?prefinal=' + predict_prefinal + '&final=' + predict_final + '&id=' + student_no + '&s_=' + semester_value, true);
                    // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    // xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    // xhr.onreadystatechange = function() {
                    //     if (xhr.readyState == 4 && xhr.status == 200) {
                    //         var result = xhr.responseText;
                    //         console.log(result);
                    //         console.log('prefinal:' + predict_prefinal + 'final:' + predict_final);
                    //         window.location.reload();
                    //     }
                    // }
                    // xhr.send();

                    console.log(parseInt(randomNumber) + " top");

                } else if (get_prelim_value.innerHTML != 0 & get_midterm_value.innerHTML != 0 & get_prefinal_value.innerHTML != 0 & (get_final_value.innerHTML == 0 | confirmation_final > 0)) {

                    // console.log(parseInt(randomNumber) + "sa idaeom");

                    // _75
                    if (((prelim_midterm + new_prefinal + 75) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 75) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "75");
                        grade_array.push("75");
                        // console.log(grade_array);
                        new_final = 75;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 76) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 76) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "76");
                        grade_array.push("76");
                        // console.log(grade_array);
                        new_final = 76;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 77) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 77) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "77");
                        grade_array.push("77");
                        // console.log(grade_array);
                        new_final = 77;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 78) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 78) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "78");
                        grade_array.push("78");
                        // console.log(grade_array);
                        new_final = 78;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 79) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 79) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "79");
                        grade_array.push("79");
                        // console.log(grade_array);
                        new_final = 79;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 80) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 80) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "80");
                        grade_array.push("80");
                        // console.log(grade_array);
                        new_final = 80;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 81) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 81) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "81");
                        grade_array.push("81");
                        // console.log(grade_array);
                        new_final = 81;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 82) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 82) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "82");
                        grade_array.push("82");
                        // console.log(grade_array);
                        new_final = 82;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 83) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 83) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "83");
                        grade_array.push("83");
                        // console.log(grade_array);
                        new_final = 83;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 84) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 84) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "84");
                        grade_array.push("84");
                        // console.log(grade_array);
                        new_final = 84;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 85) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 85) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "85");
                        grade_array.push("85");
                        // console.log(grade_array);
                        new_final = 85;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 86) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 86) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "86");
                        grade_array.push("86");
                        // console.log(grade_array);
                        new_final = 86;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 87) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 87) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "87");
                        grade_array.push("87");
                        // console.log(grade_array);
                        new_final = 87;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 88) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 88) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "88");
                        grade_array.push("88");
                        // console.log(grade_array);
                        new_final = 88;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 89) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 89) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "89");
                        grade_array.push("89");
                        // console.log(grade_array);
                        new_final = 89;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 90) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 90) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "90");
                        grade_array.push("90");
                        // console.log(grade_array);
                        new_final = 90;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 91) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 91) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "91");
                        grade_array.push("91");
                        // console.log(grade_array);
                        new_final = 91;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 92) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 92) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "92");
                        grade_array.push("92");
                        // console.log(grade_array);
                        new_final = 92;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 93) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 93) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "93");
                        grade_array.push("93");
                        // console.log(grade_array);
                        new_final = 93;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 94) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 94) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "94");
                        grade_array.push("94");
                        // console.log(grade_array);
                        new_final = 94;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 95) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 95) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "95");
                        grade_array.push("95");
                        // console.log(grade_array);
                        new_final = 95;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 96) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 96) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "96");
                        grade_array.push("96");
                        // console.log(grade_array);
                        new_final = 96;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 97) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 97) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "97");
                        grade_array.push("97");
                        // console.log(grade_array);
                        new_final = 97;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 98) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 98) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "98");
                        grade_array.push("98");
                        // console.log(grade_array);
                        new_final = 98;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 99) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 99) / 4 <= parseInt(randomNumber) + 1) {
                        // console.log(parseInt(randomNumber) + "99");
                        grade_array.push("99");
                        // console.log(grade_array);
                        new_final = 99;
                        // alert(grade_array);
                    }

                    if (((prelim_midterm + new_prefinal + 100) / 4 >= randomNumber) & (prelim_midterm + new_prefinal + 100) / 4 <= parseInt(randomNumber) + 1) {
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