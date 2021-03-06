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

namespace notificationtype_course_started\task;

use context_course;
use \notificationtype_course_started\course_started_notification;

defined('MOODLE_INTERNAL') || die();

class course_started_teacher extends \core\task\scheduled_task
{

    public function get_name()
    {
        return get_string('messageprovider:teacher', 'notificationtype_course_started');
    }

    public function execute()
    {
        global $DB;
        $start = $this->get_last_run_time();
        $end = time();
        mtrace('Kurzusok keresese amik ebben az idointervallumban indultak ' . date('Y-m-d H:i:s', $start) . " - " . date('Y-m-d H:i:s', $end));
        $courses = $DB->get_records_sql("SELECT * FROM {course} WHERE startdate BETWEEN ? AND ? AND visible = ?", [
            $start, $end, 1
        ]);
        if (count($courses) == 0) {
            mtrace("Nincs egy kurzus sem ami indult volna es lathato.");
        } else {
            mtrace("Ennyi kurzus indult el: " . count($courses));
            foreach($courses as $course) {
                mtrace("Kurzus kivalasztasa: " . $course->fullname);
                $coursecontext = context_course::instance($course->id);

                $users = get_enrolled_users($coursecontext, 'mod/quiz:viewreports');
                foreach ($users as $user) {
                    mtrace("Tanári értesítés küldése: " . $user->username);
                    $notify = new course_started_notification($course, $user, 'teacher');
                    $notify->notify();
                }

            }
        }

    }

}