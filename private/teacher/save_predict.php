<?php

include("../bins/connections.php");

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


if (isset($_GET["s_"])) {
    $grade_period = $_GET["s_"];
}

if (isset($_GET["prelim"])) {
    $prelim = $_GET["prelim"];
    echo "\n" . $prelim . "\n";
}

if (isset($_GET["midterm"])) {
    $midterm = $_GET["midterm"];
    echo $midterm . "\n";
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

if (isset($_GET["prefinalPredict"])) {
    $prefinalPredict = $_GET["prefinalPredict"];
}

if (isset($_GET["finalPredict"])) {
    $finalPredict = $_GET["finalPredict"];
}

echo $id . "\nPrefinal Prediction Check = " . $prefinalPredict . "\nFinal Prediction Check = " . $finalPredict . "\n" . $grade_period . "\n";

$prefinalPrediction = $finalPrediction = $average = "";

// Generate a random equivalent
$randomPrefinal = generateRandomEquivalent();
$randomFinal = generateRandomEquivalent();

// Determine the value corresponding to the random equivalent
$prefinalPrediction = getValueFromEquivalent($randomPrefinal);
$finalPrediction = getValueFromEquivalent($randomFinal);

if ($prefinalPredict == "ok" && $finalPredict == "ok") {
    $prefinal_grade_semester = "prefinal" . substr($grade_period, -1);
    $final_grade_semester = "final" . substr($grade_period, -1);

    mysqli_query($connections, "UPDATE $prefinal_grade_semester SET 
prefinal_prediction='$prefinalPrediction' WHERE student_no='$id'");

    mysqli_query($connections, "UPDATE $final_grade_semester SET 
final_prediction='$finalPrediction' WHERE student_no='$id'");
} elseif ($finalPredict == "ok") {
    $final_grade_semester = "final" . substr($grade_period, -1);
    mysqli_query($connections, "UPDATE $final_grade_semester SET 
final_prediction='$finalPrediction' WHERE student_no='$id'");
}

echo "Prefinal Prediction = " . $prefinalPrediction . "\n";
echo "Final Prediction = " . $finalPrediction;
