<?php
session_start();

include("../bins/connections.php");
include("../../bins/header.php");


if (isset($_SESSION["username"])) {

  $session_user = $_SESSION["username"];

  $query_info = mysqli_query($connections, "SELECT * FROM _user_tbl_ WHERE username='$session_user'");
  $my_info = mysqli_fetch_assoc($query_info);
  $account_type = $my_info["account_type"];

  if ($account_type != 3) {

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
    background-color: #347B98;
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
    border: 1px solid #347B98;
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
    background-color: #347B98;
    color: white;
  }

  .select-disabled .select-selected {
    background-color: #ccc;
    cursor: not-allowed;
  }
</style>

<?php
include("../bins/teacher_nav.php");
?>
<br>

<center>
  <h1 class="py-3 text-info">Student Performance Prediction</h1>
</center>

<br>
<!-- <h1>Balik sa midterm ag prefinal may kueang sa column</h1> -->

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

<div class="container-fluid d-inline">



  <!-- Grading Period Dropdown -->
  <div class="custom-select-container" id="grading-container">
    <div class="select-selected"><?php echo $selectedGradingText; ?></div>
    <div class="select-items">
      <?php
      foreach ($gradingOptions as $value => $text) {
        echo "<div data-value='$value'>$text</div>";
      }
      ?>
    </div>
  </div>

  <!-- Year Dropdown -->
  <div class="custom-select-container select-disabled" id="year-container">
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

  <!-- Course Dropdown -->
  <div class="custom-select-container select-disabled" id="course-container">
    <div class="select-selected"><?php echo $selectedCourseText; ?></div>
    <div class="select-items">
      <?php
      foreach ($courseOptions as $value => $text) {
        echo "<div data-value='$value'>$text</div>";
      }
      ?>
    </div>
  </div>

  <!-- Semester Dropdown -->
  <div class="custom-select-container select-disabled" id="semester-container">
    <div class="select-selected"><?php echo $selectedSemesterText; ?></div>
    <div class="select-items">
      <?php
      foreach ($semesterOptions as $value => $text) {
        echo "<div data-value='$value'>$text</div>";
      }
      ?>
    </div>
  </div>

  <!-- Year Dropdown -->
  <!-- <div class="custom-select-container select-disabled" id="year-container">
    <div class="select-selected">
      <?php
      // if (isset($_GET['_y'])) {
      //                               echo $_GET['_y'];
      //                             } else {
      //                               echo "Select Year";
      //                             } 
      ?></div>
    <div class="select-items">
      <div data-value='Select Year'>Select Year</div>
      <?php
      // Reset the mysqli_data_seek to start fetching again from the beginning
      // mysqli_data_seek($year_qry, 0);
      // while ($row_year = mysqli_fetch_assoc($year_qry)) {
      //   $year = $row_year["year"];
      // Check if the current year matches the selected year from the query string
      //   echo "<div data-value='$year'>$year</div>";
      // }
      // 
      ?>
    </div>
  </div> -->


  &nbsp;


  <?php
  if (!isset($_GET["redir"])) {
  } else {
    if ($_GET["redir"] == "prelim") {
      if (isset($_GET["redir"]) && !isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
  ?>

        <a href="pdf_files_prelim?redir=<?php echo $_GET["redir"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>

        <!-- <a href="pdf_files_prelim?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="btn btn-warning col-1">Print</a> -->

      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
      ?>

        <a href="pdf_files_prelim?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>

      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
      ?>

        <a href="pdf_files_prelim?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>

      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && isset($_GET['_s_e_'])) {
      ?>

        <a href="pdf_files_prelim?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>

    <?php
      }
    }
    ?>



    <?php
    if ($_GET["redir"] == "midterm") {
      if (isset($_GET["redir"]) && !isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
    ?>
        <a href="pdf_files_midterm?redir=<?php echo $_GET["redir"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
      ?>
        <a href="pdf_files_midterm?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
      ?>
        <a href="pdf_files_midterm?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && isset($_GET['_s_e_'])) {
      ?>
        <a href="pdf_files_midterm?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
    <?php
      }
    }
    ?>


    <?php
    if ($_GET["redir"] == "prefinal") {
      if (isset($_GET["redir"]) && !isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
    ?>
        <a href="pdf_files_prefinal?redir=<?php echo $_GET["redir"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
      ?>
        <a href="pdf_files_prefinal?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
      ?>
        <a href="pdf_files_prefinal?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && isset($_GET['_s_e_'])) {
      ?>
        <a href="pdf_files_prefinal?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
    <?php
      }
    }
    ?>

    <?php
    if ($_GET["redir"] == "final") {
      if (isset($_GET["redir"]) && !isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
    ?>
        <a href="pdf_files_final?redir=<?php echo $_GET["redir"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && !isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
      ?>
        <a href="pdf_files_final?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && !isset($_GET['_s_e_'])) {
      ?>
        <a href="pdf_files_final?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
      <?php
      } elseif (isset($_GET["redir"]) && isset($_GET['_y'])  && isset($_GET['_c']) && isset($_GET['_s_e_'])) {
      ?>
        <a href="pdf_files_final?redir=<?php echo $_GET["redir"]; ?>&_y=<?php echo $_GET["_y"]; ?>&_c=<?php echo $_GET["_c"]; ?>&_s_e_=<?php echo $_GET["_s_e_"]; ?>" target="_blank" class="print">
          <div>Print</div>
        </a>
  <?php
      }
    }
  }
  ?>

</div>


<br>
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

<br>
<br>
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

<br>
<br>

<center>
  <?php
  include("grading_system.php");
  ?>
</center>

<br>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const containers = [{
        id: 'grading-container',
        param: 'redir'
      },
      {
        id: 'year-container',
        param: '_y'
      },
      {
        id: 'course-container',
        param: '_c'
      },
      {
        id: 'semester-container',
        param: '_s_e_'
      }
    ];

    containers.forEach((container, index) => {
      const containerElem = document.getElementById(container.id);
      const selectedElem = containerElem.querySelector('.select-selected');
      const itemsElem = containerElem.querySelector('.select-items');

      // Function to toggle dropdown visibility
      function toggleDropdown() {
        if (containerElem.classList.contains('select-disabled')) {
          return;
        }
        itemsElem.style.display = itemsElem.style.display === 'block' ? 'none' : 'block';
      }

      // Show the dropdown menu on click
      selectedElem.addEventListener('click', toggleDropdown);

      // Handle item selection
      itemsElem.querySelectorAll('div').forEach(item => {
        item.addEventListener('click', function() {
          if (containerElem.classList.contains('select-disabled')) {
            return;
          }
          selectedElem.textContent = this.textContent;
          itemsElem.style.display = 'none';

          // Collect all selected values
          const selectedValues = {};
          containers.forEach((cont, idx) => {
            if (idx <= index) {
              const contElem = document.getElementById(cont.id);
              const selText = contElem.querySelector('.select-selected').textContent.trim();
              const valueElem = Array.from(contElem.querySelector('.select-items').querySelectorAll('div')).find(el => el.textContent.trim() === selText);
              selectedValues[cont.param] = valueElem ? valueElem.dataset.value : null;
            }
          });

          // Enable the next container if applicable
          if (index < containers.length - 1) {
            const nextContainer = document.getElementById(containers[index + 1].id);
            if (this.dataset.value !== `select_${containers[index].param.split('_').join('')}`) {
              nextContainer.classList.remove('select-disabled');
            } else {
              for (let i = index + 1; i < containers.length; i++) {
                document.getElementById(containers[i].id).classList.add('select-disabled');
              }
            }
          }

          // Redirect with selected values
          const queryString = Object.entries(selectedValues).map(([key, value]) => `${key}=${value}`).join('&');
          window.location.href = `?${queryString}`;
        });
      });

      // Close the dropdown if clicked outside
      document.addEventListener('click', function(event) {
        if (!containerElem.contains(event.target)) {
          itemsElem.style.display = 'none';
        }
      });
    });


    // Initial enablement based on URL parameters
    const urlParams = new URLSearchParams(window.location.search);

    // Get the value associated with the "redir" parameter
    const redirParamCheckValue = urlParams.has('redir');
    const redirParamGetValue = urlParams.get('redir');

    // Get the value associated with the "redir" parameter
    const _yParamCheckValue = urlParams.has('_y');
    const _yParamGetValue = urlParams.get('_y');

    // Get the value associated with the "redir" parameter
    const _cParamCheckValue = urlParams.has('_c');
    const _cParamGetValue = urlParams.get('_c');
    console.log("Check: " + _cParamCheckValue);
    console.log("Value: " + _cParamGetValue);

    if (redirParamCheckValue) {
      if (redirParamGetValue != "select_grading") {
        // Enable the year container here
        const yearContainer = document.getElementById('year-container');
        yearContainer.classList.remove('select-disabled');
      }

    }

    if (_yParamCheckValue) {
      if (_yParamGetValue != "select_year") {
        // Enable the year container here
        const courseContainer = document.getElementById('course-container');
        courseContainer.classList.remove('select-disabled');
      }

    }

    if (_cParamCheckValue) {
      if (_cParamGetValue != "select_course") {
        // Enable the year container here
        const semesterContainer = document.getElementById('semester-container');
        semesterContainer.classList.remove('select-disabled');
      }

    }

  });
</script>

<?php
include("../../bins/footer_non_fixed.php");
?>