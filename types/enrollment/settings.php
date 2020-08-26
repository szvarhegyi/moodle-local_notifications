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
 * Custom notifications
 *
 * @package     local_notifications
 * @copyright   Várhegyi Szabolcs <sz.varhegyi@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
//global $DB;
//$course = $DB->get_record('course', ['id' => 2]);
//$user = core_user::get_user(2);
//$notification = new \local_notifications\notification($course, $user);
//echo '<pre>'; var_dump($notification); die();


$configs = ['message_inprogress_subject', 'message_inprogress', 'message_infuture_subject', 'message_infuture'];
foreach($configs as $conf) {
//    set_config($conf, false, 'notificationtype_enrollment');
    if(!get_config($conf, 'notificationtype_enrollment')) {
        $value = $conf . '_default';
        //set_config($conf, get_string($value, 'notificationtype_enrollment'), 'notificationtype_enrollment');
    }
}

$settings->add(new admin_setting_configtext(
    'notificationtype_enrollment/message_inprogress_subject',
    get_string('message_inprogress_subject', 'notificationtype_enrollment'),
    "",
    ""
));

$settings->add(new admin_setting_configtextarea(
    'notificationtype_enrollment/message_inprogress',
    get_string('message_inprogress', 'notificationtype_enrollment'),
    get_string('message_inprogress_desc', 'notificationtype_enrollment'),
    ""
));

$settings->add(new admin_setting_configtext(
    'notificationtype_enrollment/message_infuture_subject',
    get_string('message_infuture_subject', 'notificationtype_enrollment'),
    "",
    ""
));

$settings->add(new admin_setting_configtextarea(
    'notificationtype_enrollment/message_infuture',
    get_string('message_infuture', 'notificationtype_enrollment'),
    get_string('message_infuture_desc', 'notificationtype_enrollment'),
    ""
));