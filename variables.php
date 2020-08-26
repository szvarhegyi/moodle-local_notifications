<?php

require('../../config.php');

require_once($CFG->libdir . '/adminlib.php');
require "$CFG->libdir/tablelib.php";

global $DB;

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('variables', 'local_notifications'));

$context = context_system::instance();
echo $OUTPUT->box(format_text(get_string('courseexplanation', 'tool_generator'),
    FORMAT_MARKDOWN, array('context' => $context)));

$type = required_param('notificationtype', PARAM_RAW);

$class_name = 'notificationtype_' . $type . '\\' . $type . '_notification';

/** @var \local_notifications\notification $notification */
$notification = new $class_name($DB->get_record('course', ['id' => 2]), core_user::get_user(2));

foreach(array_keys($notification->getVariables()) as $variable_type) {

    if($variable_type != 'custom') {
        echo html_writer::tag('h3', get_string($variable_type));
    } else {
        echo html_writer::tag('h3', get_string($variable_type, 'local_notifications'));
    }

    $name = $variable_type;
    $variable_type = new html_table();
    $variable_type->head = ['variable_name', 'name', 'usage', 'sample_value'];
    $data = [];
    foreach($notification->getVariables()[$name] as $var) {
        switch ($name) {
            case 'custom':
                $var_name = $var;
                break;
            case 'user':
                $var_name = get_string(str_replace(['user_', '_formatted'], '', $var));
                break;
            case 'course':
                $var_name = get_string(str_replace(['course_', '_formatted'], '', $var));
                break;
        }
        $data[] = [$var, $var_name, "{\${$var}}", $notification->data->$var];
    }
    $variable_type->data = $data;
    echo html_writer::table($variable_type);

}