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

namespace notificationtype_coursereminder;


use core_user;
use \local_notifications\notification;

class coursereminder_notification extends notification {

    public $users = [];

    public function setUncompletedUsers($users) {
        $this->users = $users;
    }

    public function notify() {
        global $CFG, $DB;

        $data = new \stdClass();
        $data->fullname = fullname($this->user);
        $data->coursename = $this->course->fullname;
        $data->courselink = $CFG->wwwroot . "/course/view.php?id=" . $this->course->id;
        $data->forumlink = $this->get_forum_link();
        $data->teachermails = $this->get_teacher_mail_addresses();
        $data->courseend = date('Y-m-d H:i:s', $this->course->enddate);
        $data->userlist = "";
        foreach ($this->users as $u) {
            $data->userlist .= fullname($u) . ' (' . $u->email . ')' . PHP_EOL;
        }

        $eventdata = new \core\message\message();
        $eventdata->courseid = 1;
        $eventdata->component = 'notificationtype_coursereminder';
        $eventdata->name = $this->role;
        $eventdata->notification = 1;

        $eventdata->userfrom = core_user::get_noreply_user();
        $eventdata->userto = $this->user;
        $eventdata->subject = get_string('coursereminder_' . $this->role . '_subject', 'notificationtype_coursereminder', $data);

        $eventdata->fullmessage = get_string('coursereminder_' . $this->role . '_content', 'notificationtype_coursereminder', $data);
        $eventdata->fullmessageformat = FORMAT_PLAIN;
        $eventdata->fullmessagehtml   = '';

        $eventdata->smallmessage      = '';

        message_send($eventdata);

    }

}