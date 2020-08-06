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


use core_user;
use \local_notifications\notification;

class course_enrollment_notification extends notification {

    public $isInProgress = true;

    public function setCourseStartInTheFuture() {
        $this->isInProgress = false;
    }

    public function notify() {
        global $CFG, $DB;

        if($this->isInProgress) {
            $this->role = 'inprogress';
        } else {
            $this->role = 'infuture';
        }

        $data = new \stdClass();
        $data->fullname = fullname($this->user);
        $data->coursename = $this->course->fullname;
        $data->coursestart = date('Y-m-d H:i:s', $this->course->startdate);
        $data->courselink = $CFG->wwwroot . "/course/view.php?id=" . $this->course->id;
        $data->forumlink = $this->get_forum_link();
        $data->teachermails = $this->get_teacher_mail_addresses();

        //Tanárok e-mail címe



        $eventdata = new \core\message\message();
        $eventdata->courseid = 1;
        $eventdata->component = 'notificationtype_enrollment';
        $eventdata->name = $this->role;
        $eventdata->notification = 1;

        $eventdata->userfrom = core_user::get_noreply_user();
        $eventdata->userto = $this->user;
        $eventdata->subject = get_string('courseenrollment_' . $this->role . '_subject', 'notificationtype_enrollment', $data);

        $eventdata->fullmessage = get_string('courseenrollment_' . $this->role . '_content', 'notificationtype_enrollment', $data);
        $eventdata->fullmessageformat = FORMAT_PLAIN;
        $eventdata->fullmessagehtml   = '';

        $eventdata->smallmessage      = '';

        message_send($eventdata);

    }

}