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

namespace notificationtype_enrollment;


class user_enrolment_created
{

    public static function execute(\core\event\user_enrolment_created $event) {
        global $DB;
        // courseid | relateduserid
        $course = $DB->get_record('course', ['id' => $event->courseid]);
        $user = $DB->get_record('user', ['id' => $event->relateduserid]);
        $notify = new enrollment_notification($course, $user, 'student');

        if(time() < $course->startdate) {
            $notify->setCourseStartInTheFuture();
        }

        $notify->notify();


    }

}