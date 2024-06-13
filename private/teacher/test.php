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
        <tr class="text-center" data-student-no='<?php echo $student_no; ?>'>
            <td><?php echo $student_no; ?></td>
            <td><?php echo $student_name; ?></td>
            <td></td>
            <td></td>
            <td><input type="hidden" id="prefinalCheck<?php echo $student_no; ?>" value="<?php echo $prefinalCheck; ?>"></td>
            <td><input type="hidden" id="finalCheck<?php echo $student_no; ?>" value="<?php echo $finalCheck; ?>"></td>
            <td></td>
            <td><input type="hidden" id="get_student_no<?php echo $student_no; ?>" value="<?php echo $student_no; ?>"></td>
            <td></td>
        </tr>
</table>