<?php

$string['pluginname'] = "Értesítés kurzus indulásáról";


$string['messageprovider:student'] = 'Tanulói szerepkör esetén';
$string['messageprovider:teacher'] = 'Tanári szerepkör esetén';

$string['coursestarted_teacher_subject'] = 'Értesítés kurzus indulásáról';
$string['coursestarted_teacher_content'] = 'Tisztelt {$a->fullname}!

Az Ön által meghirdetett {$a->coursename} elektronikus
tananyag és/vagy vizsgaanyag, vagy kérdőív elindult.

Kurzus elérése: {$a->courselink}';

$string['coursestarted_student_subject'] = 'Értesítés kurzus indulásáról';
$string['coursestarted_student_content'] = 'Tisztelt {$a->fullname}!

Értesítünk, hogy a {$a->coursename} 
elektronikus tananyag és/vagy vizsgaanyag elérhető számodra.

Elérési hely: {$a->courselink}

Felhívjuk figyelmedet, hogy a záró dátumot követően az anyagot már nem
éred el!

Amennyiben csak vizsgát tartalmaz az anyag, vagy vizsga is kapcsolódik a
tananyaghoz, és a tanár megállapított minimum elérendő eredményt, az
alacsonyabb vizsgaeredményről tájékoztatunk az ismétlés szükségessége
miatt.

Kérdéseidet felteheted a Fórumon
({$a->forumlink}), vagy megírhatod az {$a->teachermails} e-mail címre.

Eredményes tanulást kívánunk!
az oktatók';