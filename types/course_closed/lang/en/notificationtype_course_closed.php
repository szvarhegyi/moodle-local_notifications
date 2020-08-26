<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Configurable notifications - Course closed notification
 *
 * @package     local_notifications
 * @copyright   Várhegyi Szabolcs <sz.varhegyi@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = "Course ending notification";

$string['messageprovider:courseclosed'] = 'Course ending';
$string['messageprovider:student'] = 'Notification for students';
$string['messageprovider:teacher'] = 'Notification for teachers';

$string['teacher_subject_default'] = 'Course ending';
$string['teacher_content_default'] = 'Dear {$user_fullname},

{$course_fullname} course that you have been teaching is closed now.';

$string['student_subject_default'] = 'Course ending';
$string['student_content_default'] = 'Dear {$user_fullname},

We would like to notify you that {$course_fullname} course is closed now.';