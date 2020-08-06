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

namespace local_notifications;


class notification
{

    public $course;
    public $user;
    public $role;

    public function __construct($course, $user, $role)
    {
        $this->course = $course;
        $this->user = $user;
        $this->role = $role;
    }

    public function get_forum_link() {
        global $CFG, $DB;
        $forum = $DB->get_record_sql("SELECT f.* FROM {course_modules} cm LEFT JOIN {modules} m ON m.id = cm.module
                                            LEFT JOIN {forum} f ON f.id = cm.instance 
                                            WHERE m.name = ? and cm.course = ? and cm.visible = ? LIMIT 0,1",
            ['forum', $this->course->id, 1]);
        if ($forum) {
            return $CFG->wwwroot . "/mod/forum/view.php?id=" . $forum->id;
        } else {
            return "";
        }
    }

    public function get_teacher_mail_addresses($separator = ', ') {

        global $CFG, $DB;
        $coursecontext = \context_course::instance($this->course->id);
        $teachers = get_enrolled_users($coursecontext, 'enrol/manual:enrol');

        $names = [];
        foreach($teachers as $teacher) {
            $names[] = $teacher->email;
        }

        return implode($separator, $names);

    }

}