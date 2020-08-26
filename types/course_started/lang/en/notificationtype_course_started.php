<?php

$string['pluginname'] = "Course is live notification";


$string['messageprovider:student'] = 'Notification for students';
$string['messageprovider:teacher'] = 'Notification for teachers';

$string['teacher_subject_default'] = 'Course is live';
$string['teacher_content_default'] = 'Dear {$user_fullname},

We would like to notify you that the {$course_fullname} course in now open.

Use this link to access the course: {$course_link}';

$string['student_subject_default'] = 'Course is live';
$string['student_content_default'] = 'Dear {$user_fullname},

We would like to notify you that the {$course_fullname} course in now open.

Use this link to access the course: {$course_link}

If the course contains tests or exams the teachers can set a passing grade. If you score lower than that, you will be notified about the option of retaking the tests or exams.

You may use the Forum ({$course_forum_link}) to ask questions or send an email to {$teachermails}.

Happy learning!
The Educators';