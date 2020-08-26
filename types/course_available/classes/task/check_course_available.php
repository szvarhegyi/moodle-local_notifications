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

namespace notificationtype_course_available\task;

use context_course;
use \notificationtype_course_available\course_available_notification;

defined('MOODLE_INTERNAL') || die();

class check_course_available extends \core\task\scheduled_task
{

    public function get_name()
    {
        return get_string('messageprovider:notify', 'notificationtype_course_available');
    }

    public function execute()
    {
        global $DB;

        $methods = explode(',', get_config('notificationtype_course_available', 'notification_type'));

        list($insql, $inparams) = $DB->get_in_or_equal($methods);


        $start = $this->get_last_run_time();
        $end = time();
        mtrace('Kurzusok keresese amik ebben az idointervallumban kezdődnek ' . date('Y-m-d H:i:s', $start) . " - " . date('Y-m-d H:i:s', $end));
        $courses = $DB->get_records_sql('SELECT * FROM {course} WHERE startdate >= ? AND startdate <= ? AND visible = ?',
            [$start, $end, 1]);
        foreach($courses as $course) {
//            $DB->set_debug(true);
            list($insql, $inparams) = $DB->get_in_or_equal($methods);
            array_unshift($inparams, $course->id);
            $inparams[] = 0;
            $enrolment = $DB->get_records_sql('SELECT * FROM {enrol} WHERE courseid = ? AND enrol ' . $insql . ' AND status = ?', $inparams);
            if(count($enrolment) > 0) {
                $users = $DB->get_records('user');
                foreach($users as $user) {
                    $notification = new course_available_notification($course, $user, 'notify');
                    $notification->notify();
                }
            }
        }

    }

}