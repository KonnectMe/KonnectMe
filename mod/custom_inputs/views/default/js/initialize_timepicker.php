<?php
    jquery_ui_load_options();
    global $CONFIG;
?>

$(document).ready(function(){
    $('input.jquery_ui-timepicker').datetimepicker(<?php echo json_encode($CONFIG->jquery_ui_datetime_options);?>);
});
