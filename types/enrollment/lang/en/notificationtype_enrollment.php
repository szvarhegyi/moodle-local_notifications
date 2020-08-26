<?php

$string['pluginname'] = "Notification about course enrollment";


$string['messageprovider:inprogress'] = 'When the course has already started';
$string['messageprovider:infuture'] = 'When the course will start in the future';

$string['message_inprogress_subject'] = "When the course has already started subject";
$string['message_inprogress_subject_default'] = "Course enrollment notification";
$string['message_inprogress'] = "When the course has already started message";
$string['message_inprogress_desc'] = "";
$string['message_inprogress_default'] = 'Dear {$user_fullname},

We would like to notify you that the learning material and/or the tests for the following course,
{$course_fullname}, is available for you.

Use this link to access the materials: {$course_link}

Please keep in mind that after the deadline, the learning materials will not be available.

If the course contains tests or exams the teachers can set a passing grade. If you score lower than that, 
you will be notified about the option of retaking the tests or exams.

You may use the Forum ({$course_forum_link}) to ask questions or send an email to {$teachermails}.

Happy learning!
The Educators';


$string['message_infuture_subject'] = "When the course will start in the future subject";
$string['message_infuture_subject_default'] = "Notification about course enrollment";
$string['message_infuture'] = "When the course will start in the future message";
$string['message_infuture_desc'] = "When the course will start in the future desc";
$string['message_infuture_default'] = 'Dear {$user_fullname},

We would like to notify you that the learning material and/or the tests for the following course,
{$course_fullname} will be available from {$course_startdate_formatted}.

Use this link to access the materials: {$course_link}

Please keep in mind that after the deadline, the learning materials will not be available.

If the course contains tests or exams the teachers can set a passing grade. If you score lower than that, 
you will be notified about the option of retaking the tests or exams.

You may use the Forum ({$course_forum_link}) to ask questions or send an email to {$teachermails}.

Happy learning!
The Educators';