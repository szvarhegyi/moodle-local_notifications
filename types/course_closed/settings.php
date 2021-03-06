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

defined('MOODLE_INTERNAL') || die();

$configs = ['teacher_subject', 'teacher_content', 'student_subject', 'student_content'];
foreach($configs as $conf) {
//    set_config($conf, false, 'notificationtype_enrollment');
    if(get_config('notificationtype_course_closed', $conf) === false) {
        $value = $conf . '_default';
        set_config($conf, get_string($value, 'notificationtype_course_closed'), 'notificationtype_course_closed');
    }
}

$settings->add(new admin_setting_configtext(
    'notificationtype_course_closed/teacher_subject',
    get_string('settings_teacher_subject', 'local_notifications'),
    "",
    ""
));

$settings->add(new admin_setting_configtextarea(
    'notificationtype_course_closed/teacher_content',
    get_string('settings_teacher_content', 'local_notifications'),
    "",
    ""
));

$settings->add(new admin_setting_configtext(
    'notificationtype_course_closed/student_subject',
    get_string('settings_student_subject', 'local_notifications'),
    "",
    ""
));

$settings->add(new admin_setting_configtextarea(
    'notificationtype_course_closed/student_content',
    get_string('settings_student_content', 'local_notifications'),
    "",
    ""
));