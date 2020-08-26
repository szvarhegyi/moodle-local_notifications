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

$types = core_component::get_plugin_list('enrol');
$notification_types = [];
foreach($types as $name => $path) {
    $notification_types[$name] = get_string('pluginname', 'enrol_' . $name);
}

$settings->add(new admin_setting_heading('notificationtypesetting' . $type,
    get_string('subplugintype_notificationtype_plural', 'local_notifications') . ' - ' .
    get_string('pluginname', 'notificationtype_' . $type), ''));

$select = new admin_setting_configmultiselect(
    'notificationtype_course_available/notification_type',
    'Típusok, amikor értesít',
    'Azokat a beiratkozási módokat válassza ki, amelyik ha elérhető egy kurzusnál, akkor az összes felhasználó értesítést kell, hogy kapjon',
    ['self', 'guest'],
    $notification_types
);

$settings->add($select);


$settings->add(new admin_setting_configtext(
    'notificationtype_course_available/subject',
    get_string('subject', 'notificationtype_course_available'),
    "",
    ""
));

$settings->add(new admin_setting_configtextarea(
    'notificationtype_course_available/content',
    get_string('content', 'notificationtype_course_available'),
    "",
    ""
));