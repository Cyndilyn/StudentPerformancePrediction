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

if (isset($_GET["_y"])) {
    $year = $_GET["_y"];
} else {
    $year = "2011";
}

if (isset($_GET["_c"])) {
    $course = $_GET["_c"];
} else {
    $course = "BSIT";
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

        var select_prelim = parseFloat(document.getElementById("get_prelim").innerHTML);
        var selectMidterm = parseFloat(document.getElementById("get_midterm").innerHTML);
        var select_prefinal = parseFloat(document.getElementById("get_prefinal").innerHTML);
        var selectPrelimAndMidterm = select_prelim + selectMidterm;
        var select_prelim_and_midterm_prefinal = select_prelim + selectMidterm + select_prefinal;


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

        if (get_prelim_value.innerHTML != 0 && get_midterm_value.innerHTML != 0 && get_prefinal_value.innerHTML == 0 && get_final_value.innerHTML == 0 && confirmation_prefinal == 0 && confirmation_final == 0) {

            if (prefinal_grade.value == 0 && final_grade.value == 0 && confirmation_prefinal == 0 && confirmation_final == 0) {
                prefinal_grade_prediction.style.display = "block";
                get_prefinal.style.display = "none";
                // prefinal.innerHTML += "<sup class='badge badge-warning'>Prediction</sup>";
            } else {
                prefinal_grade_prediction.style.display = "none";
                get_prefinal.style.display = "block";
            }



            if (final_grade.value == 0) {
                final_grade_prediction.style.display = "block";
                get_final.style.display = "none";
            } else {
                final_grade_prediction.style.display = "none";
                get_final.style.display = "block";
            }
        } else if (get_prelim_value.innerHTML != 0 && get_midterm_value.innerHTML != 0 && get_prefinal_value.innerHTML != 0 && get_final_value.innerHTML == 0 && confirmation_prefinal == 0 && confirmation_final == 0) {

            if (final_grade.value == 0 && confirmation_prefinal == 0 && confirmation_final == 0) {

                final_grade_prediction.style.display = "block";
                get_final.style.display = "none";
                final.innerHTML += "<sup class='badge badge-warning'>Prediction</sup>";

            } else {
                final_grade_prediction.style.display = "none";
                get_final.style.display = "block";
            }


        } else if (get_prelim_value.innerHTML != 0 && get_midterm_value.innerHTML != 0 && get_prefinal_value.innerHTML != 0 && get_final_value.innerHTML != 0 && confirmation_prefinal != 0 && confirmation_final != 0) {
            var new_select_average = document.getElementById("average_predict").selectedIndex.value;
        } else {
            get_prefinal.style.display = "block";
            get_final.style.display = "block";
        }


        function average() {

            var average = document.getElementById("average_predict");
            var selected_average = average.options[average.selectedIndex].value;
            let randomNumber = 0;

            // window.location.href="?ave="+selected_average;

            const baseNumbers = {
                "1": 98,
                "1.25": 95,
                "1.5": 92,
                "1.75": 89,
                "2": 86,
                "2.25": 83,
                "2.5": 80,
                "2.75": 77,
                "3": 75
            };

            if (selected_average in baseNumbers) {
                const base = baseNumbers[selected_average];
                const randomNumber = Math.floor(Math.random() * 3) + base;
            }
            alert(randomNumber);


            var new_prelim = parseFloat(get_prelim_value.innerHTML);
            var new_midterm = parseFloat(get_midterm_value.innerHTML);
            var new_prefinal = parseFloat(get_prefinal_value.innerHTML);
            var prelim_midterm = new_prelim + new_midterm;

            var new_prefinal;
            var new_final;


            if (get_prelim_value.innerHTML != 0 && get_midterm_value.innerHTML != 0 && (get_prefinal_value.innerHTML == 0 || confirmation_prefinal > 0) && (get_final_value.innerHTML == 0 || confirmation_final > 0)) {



                // for (let prefinal = 75; prefinal <= 100; prefinal++) {
                //     for (let final of scores) {
                //         let key = `_${prefinal}_${final}`;
                //         let average = (prelim_midterm + key) / 4;
                //         if (average >= randomNumber && average <= parseInt(randomNumber) + 1) {
                //             grade_array.push(key);
                //             new_prefinal = prefinal;
                //             new_final = final;
                //         }
                //         console.log(grade_array);
                //     }
                // }

                // alert Umpisa iya

                // alert(grade_array.length);
                // alert(grade_array);
                get_random_array = Math.floor(Math.random() * grade_array.length);
                random_array = get_random_array;
                predict_grade_array = grade_array[random_array];
                // alert(predict_grade_array);

                // alert(predict_grade_array.length);

                // console.log(confirmation_prefinal);

                // if (predict_grade_array.length == 6) {
                //     var predict_prefinal = predict_grade_array.slice(1, 3);
                //     var predict_final = predict_grade_array.slice(4, 6);
                // }

                // if (predict_grade_array.length == 7) {
                //     if (predict_grade_array[1] == 1) {
                //         // alert("100 sa una it daya!");
                //         var predict_prefinal = predict_grade_array.slice(1, 4);
                //         var predict_final = predict_grade_array.slice(5, 7);
                //     } else {
                //         // alert("100 sa ulihi it daya!");
                //         var predict_prefinal = predict_grade_array.slice(1, 3);
                //         var predict_final = predict_grade_array.slice(4, 7);
                //     }
                // }


                var get_prefinal_prediction = document.getElementById("prefinal_grade_prediction");
                var get_final_prediction = document.getElementById("final_grade_prediction");

                // location.relaod();
                // get_prefinal_prediction.innerHTML = predict_prefinal;
                // get_final_prediction.innerHTML = predict_final;




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


                console.log(parseInt(randomNumber) + "top");

            } else if (get_prelim_value.innerHTML != 0 && get_midterm_value.innerHTML != 0 && get_prefinal_value.innerHTML != 0 && (get_final_value.innerHTML == 0 || confirmation_final > 0)) {

                // console.log(parseInt(randomNumber) + "sa idaeom");

                for (let final = 75; final <= 100; final++) {
                    let average = (prelim_midterm + new_prefinal + final) / 4;
                    if (average >= randomNumber && average <= parseInt(randomNumber) + 1) {
                        grade_array.push(final.toString());
                        new_final = final;
                    }
                }

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