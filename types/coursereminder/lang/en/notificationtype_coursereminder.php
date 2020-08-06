<?php

$string['pluginname'] = "Értesítés kurzus lezárása előtt";


$string['messageprovider:student'] = 'Tanulói szerepkör esetén';
$string['messageprovider:teacher'] = 'Tanári szerepkör esetén';


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

