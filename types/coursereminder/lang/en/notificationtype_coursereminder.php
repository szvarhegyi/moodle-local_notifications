<?php

$string['pluginname'] = "Notification before closing the course";


$string['messageprovider:student'] = 'Notification for students';
$string['messageprovider:teacher'] = 'Notification for teachers';


$string['teacher_subject_default'] = 'Notification before closing the course';
$string['teacher_content_default'] = 'Dear {$user_fullname},

The deadline ({$course_enddate_formatted}) for completing the course, {$course_fullname}, is approaching.

The following students have not fulfilled the requirements:
{$uncompleted_user_list}

Use this link to access the materials: {$course_link}';

$string['student_subject_default'] = 'Notification before closing the course';
$string['student_content_default'] = 'Dear {$user_fullname},

The deadline ({$course_enddate_formatted}) for completing the course, {$course_fullname}, is approaching
 and have not yet fulfilled all the requirements.

You have still got time to complete the remaining tasks! Use this link to access the course: {$course_link}

You may use the Forum ({$course_forum_link}) to ask questions or send an email to {$teachermails}.

Happy learning!
The Educators';



//Emlékeztető
$string['coursereminder_teacher_subject'] = 'Értesítés a kurzus lezárása előtt';
$string['coursereminder_teacher_content'] = 'Tisztelt {$a->fullname}!

Az Ön által meghirdetett {$a->coursename} elektronikus tananyag és/vagy vizsgaanyag feldolgozási
ideje {$a->courseend} lejár.

Értesítjük, hogy az alábbi személyek nem teljesítették még a
követelményeket:
{$a->userlist}

Kurzus elérése: {$a->courselink}';


$string['coursereminder_student_subject'] = 'Értesítés a kurzus lezárása előtt';
$string['coursereminder_student_content'] = 'Tisztelt {$a->fullname}!

Értesítünk, hogy a {$a->coursename} elektronikus tananyag és/vagy vizsgaanyag feldolgozási
ideje {$a->courseend} lejár és a követelményeket még nem teljesítetted!

Kurzus elérése: {$a->courselink}

Kérdéseidet felteheted a Fórumon
({$a->forumlink}), vagy megírhatod az {$a->teachermails} e-mail címre.

Eredményes tanulást kívánunk!
az oktatók';
//END emlékeztető

