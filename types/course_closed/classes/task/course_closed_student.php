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

namespace notificationtype_course_closed\task;

use context_course;
use \notificationtype_course_closed\course_closed_notification;

defined('MOODLE_INTERNAL') || die();

class course_closed_student extends \core\task\scheduled_task
{

    public function get_name()
    {
        return get_string('messageprovider:courseclosed', 'notificationtype_course_closed');
    }

    public function execute()
    {
        global $DB;
        $start = strtotime(date('Y-m-d 00:00:00'));
        $end = strtotime(date('Y-m-d 23:59:59'));
        mtrace('Kurzusok keresese amik ebben az idointervallumban zarultak ' . date('Y-m-d H:i:s', $start) . " - " . date('Y-m-d H:i:s', $end));
        $courses = $DB->get_records_sql("SELECT * FROM {course} WHERE enddate > ? AND enddate BETWEEN ? AND ? AND visible = ?", [
            0, $start, $end, 1
        ]);
        if (count($courses) == 0) {
            mtrace("Nincs egy kurzus sem ami zarult volna es lathato.");
        } else {
            mtrace("Ennyi kurzus zarult el: " . count($courses));
            foreach($courses as $course) {
                mtrace("Kurzus kivalasztasa: " . $course->fullname);
                $coursecontext = context_course::instance($course->id);
                $users = get_enrolled_users($coursecontext, 'mod/quiz:attempt');
                foreach ($users as $user) {
                    mtrace("Értesítés küldése: " . $user->username);
                    $notify = new course_closed_notification($course, $user, 'student');
                    $notify->notify();
                }

            }
        }

    }

}