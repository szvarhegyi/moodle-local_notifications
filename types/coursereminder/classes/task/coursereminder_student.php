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

namespace notificationtype_coursereminder\task;

use context_course;
use notificationtype_coursereminder\coursereminder_notification;

defined('MOODLE_INTERNAL') || die();

class coursereminder_student extends \core\task\scheduled_task
{

    public function get_name()
    {
        return get_string('messageprovider:student', 'notificationtype_coursereminder');
    }

    public function hasCompletionCriteria($courseid) {
        global $DB;

        $count = $DB->count_records('course_completion_criteria', ['course' => $courseid]);

        if($count > 0)
            return true;

        return false;

    }

    public function userIsCompletedTheCourse($courseid, $userid) {
        global $DB;

        $entry = $DB->get_record('course_completions', ['course' => $courseid, 'userid' => $userid]);
        if($entry) {

            if (!is_null($entry->timecompleted)) {
                return true;
            }

        }

        return false;
    }

    public function execute()
    {
        global $DB;
        mtrace("Kurzus lezárás előtti emlékeztető");

        //Van egyedi mező?
        $field = $DB->get_record('customfield_field', ['shortname' => 'notification_remind_datetime']);

        if($field) {

            $start = strtotime(date('Y-m-d 00:00:00'));
            $end = strtotime(date('Y-m-d 23:59:59'));
            mtrace('Kurzusok keresese amiknel ebben az intervallumban kell ertesitest kuldeni ' . date('Y-m-d H:i:s', $start) . " - " . date('Y-m-d H:i:s', $end));

            $entries = $DB->get_records_sql('SELECT c.* FROM {customfield_data} cd LEFT JOIN {course} c ON c.id = cd.instanceid WHERE
                                        cd.fieldid = ? AND cd.value BETWEEN ? AND ?', [
                                            $field->id,
                                            $start,
                                            $end
            ]);
            if (count($entries) > 0) {

                mtrace("Ennyi kurzus eseten kell ertesitest kuldeni: " . count($entries));
                foreach($entries as $course) {
                    mtrace("Kurzus kivalasztasa: " . $course->fullname);

                    //Van kurzusteljesítési feltétel? Ha nincs akkor ennyi
                    if($this->hasCompletionCriteria($course->id)) {

                        $coursecontext = context_course::instance($course->id);
                        $users = get_enrolled_users($coursecontext, 'mod/quiz:attempt');
                        foreach ($users as $user) {
                            if(!$this->userIsCompletedTheCourse($course->id, $user->id)) {
                                mtrace("Értesítés küldése: " . $user->username);
                                $notify = new coursereminder_notification($course, $user, 'student');
                                $notify->notify();
                            }
                        }

                    } else {
                        mtrace('Nincs teljesítési feltétel beállítva, ezért nem küldd értesítést a rendszer.');
                    }


                }

            } else {
                mtrace("Nincs olyan kurzus, amiben be lenne állítva");
            }

        } else {
            mtrace("Nincs notification_remind_datetime mező ezért nem keresem.");
        }

    }


}