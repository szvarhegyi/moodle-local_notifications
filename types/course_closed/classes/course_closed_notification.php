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

namespace notificationtype_course_started;


use core_user;
use \local_notifications\notification;
use \local_notifications\notification_type;

class course_closed_notification extends notification implements notification_type {

    public function getComponent()
    {
        return "notificationtype_course_closed";
    }

    public function getName()
    {
        return $this->role;
    }

    public function getSubject()
    {
        return $this->compile(get_config('notificationtype_course_closed', $this->role . '_subject'));
    }

    public function getMessage()
    {
        return $this->compile(get_config('notificationtype_course_closed', $this->role . '_content'));
    }

}