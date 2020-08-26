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
 * Configurable notifications
 *
 * @package     local_notifications
 * @copyright   Várhegyi Szabolcs <sz.varhegyi@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_notifications;

use core_user;

class notification implements notification_type
{

    public $course;
    public $user;
    public $role;
    public $data;

    public function __construct($course, $user, $role = '')
    {
        $this->course = $course;
        $this->user = $user;
        $this->role = $role;
        $this->populateData();
    }

    public function getVariables() {

        return [
            'custom' => [
                'teachermails',
                'user_fullname',
                'course_link',
                'course_forum_link'
            ],
            'course' => [
                'course_fullname',
                'course_shortname',
                'course_idnumber',
                'course_startdate_formatted',
                'course_enddate_formatted'
            ],
            'user' => [
                'user_username',
                'user_firstname',
                'user_lastname',
                'user_email',
                'user_department',
                'user_address',
                'user_city',
                'user_country'
            ]
        ];

    }

    public function populateData() {
        global $CFG;
        $data = new \stdClass();
        foreach($this->course as $key => $val) {
            $k = 'course_' . $key;
            $data->$k = $val;
            $mutator = $k . "_mutator";
            if(method_exists(notification::class, $mutator)) {
                $km = $k . '_formatted';
                $data->$km = self::$mutator($val);
            }
        }

        $data->course_link = $CFG->wwwroot . "/course/view.php?id=" . $this->course->id;
        $data->course_forum_link = $this->get_forum_link();

        foreach($this->user as $key => $val) {
            $k = 'user_' . $key;
            $data->$k = $val;
            $mutator = $k . "_mutator";
            if(method_exists(notification::class, $mutator)) {
                $km = $k . '_formatted';
                $data->$km = self::$mutator($val);
            }
        }

        $data->user_fullname = fullname($this->user);

        $data->teachermails = $this->get_teacher_mail_addresses();

        $this->data = $data;

        $this->extendData();
    }

    public function extendData() {
        //TODO: override this method
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
            return get_config('local_notifications', 'default_forum_link');
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

        if(count($names) == 0) {
            $names[] = get_config('local_notifications', 'default_teacher_email_address');
        }

        return implode($separator, $names);

    }

    public function course_startdate_mutator($value) {
        return userdate($value, '', $this->user->timezone);
    }

    public function course_enddate_mutator($value) {
        return userdate($value, '', $this->user->timezone);
    }

    public function compile($message) {

        foreach($this->data as $key => $val) {

            $message = preg_replace('/\{\s*\$' . $key . '\s*}/', $val, $message);

        }

        return $message;

    }

    public function notify() {
        $eventdata = new \core\message\message();
        $eventdata->courseid = 1;
        $eventdata->component = $this->getComponent();
        $eventdata->name = $this->getName();
        $eventdata->notification = 1;

        $eventdata->userfrom = core_user::get_noreply_user();
        $eventdata->userto = $this->user;
        $eventdata->subject = $this->getSubject();

        $eventdata->fullmessage = $this->getMessage();
        $eventdata->fullmessageformat = FORMAT_PLAIN;
        $eventdata->fullmessagehtml   = '';

        $eventdata->smallmessage      = '';

        message_send($eventdata);
    }

    public function getComponent()
    {
        // TODO: Implement getComponent() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function getSubject()
    {
        // TODO: Implement getSubject() method.
    }

    public function getMessage()
    {
        // TODO: Implement getMessage() method.
    }
}