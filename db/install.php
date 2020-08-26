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

function xmldb_local_notifications_install() {
    global $CFG, $DB;

    $handler = \core_customfield\handler::get_handler('core_course', 'course');
    $hasCategory = false;
    $category = null;
    $c = $handler->get_categories_with_fields();
    foreach($c as $a) {
        if ($a->get('name') == "Értesítések") {
            $hasCategory = true;
            $category = \core_customfield\category_controller::create($a->get('id'));
            break;
        }
    }

    if($hasCategory == false) {
        $categoryid = $handler->create_category('Általános értesítések');
        $category = \core_customfield\category_controller::create($categoryid);
    }


    $record = new \stdClass();
    $record->type = "date";
    $record->shortname = "notification_remind_datetime";
    $record->name = "Emlékeztető értesítés ideje";
    $record->description = "";
    $record->descriptionformat = 1;
    $record->configdata = '{"required":"0","uniquevalues":"0","includetime":"0","mindate":0,"maxdate":0,"locked":"0","visibility":"0"}';

    $field = \customfield_date\field_controller::create(0, $record, $category);
    $field->save();

}