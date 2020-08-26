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

defined('MOODLE_INTERNAL') || die();

if ( $hassiteconfig ){

    $settings = new admin_settingpage( 'local_notifications', get_string('pluginname', 'local_notifications') );
    $ADMIN->add( 'localplugins', $settings );

    $noreply = core_user::get_support_user();

    $settings->add(new admin_setting_heading('basic', 'Általános beállítások', 'Ide kerülnek az olyan beállítások, amit mindegyik telepített értesítő modul használhat.'));
    $settings->add(new admin_setting_configtext('local_notifications/default_teacher_email_address', 'Tanár e-mail címe',
        'Amennyiben egy kurzushoz nincs hozzárendelve tanár, de az értesítő levélben az elérhetőge szerepelne, akkor ez az e-mail cím lesz feltüntetve.',
    $noreply->email));

    $settings->add(new admin_setting_configtext('local_notifications/default_forum_link', 'Fórum elérése',
        'Amennyiben egy kurzusban nincs fórum típusú tevékenységi forma, de az értesítő levélben az elérhetőge szerepelne, 
        akkor ez a link lesz feltüntetve.',
        $CFG->wwwroot));



    // include the settings of types subplugins
    $types = core_component::get_plugin_list('notificationtype');

    foreach ($types as $type => $path) {
        if (file_exists($settingsfile = $path . '/settings.php')) {
//            $settings->add(new admin_setting_heading('notificationtypesetting' . $type,
//                get_string('subplugintype_notificationtype_plural', 'local_notifications') . ' - ' .
//                get_string('pluginname', 'notificationtype_' . $type), '**Elérhető változók**
//
//Egyedi mezők:
//
//    $teachermails => Oktatók e-mail címe
//
//Kurzussal kapcsolatban:
//
//    $course_fullame => Kurzus teljes neve, $course_shortname => Kurzus rövid neve
//    $course_idnumber => Kurzus azonosítója
//    $course_startdate_formatted => Kurzus kezdésének dátuma és időpontja
//    $course_enddate_formatted => Kurzus befejezésének dátuma és időpontja
//    $course_link => Kurzus HTTP linkje
//    $course_course_forum_link => Kurzus fórumja
//
//Felhasználóval kapcsolatban:
//
//    $user_username => Felhasználónév
//    $user_firstname => Keresztnév
//    $user_lastname => Vezetéknév
//    $user_fullname => Teljes neve
//    $user_email => E-mail címe
//    $user_department => Department
//    $user_address => Cím
//    $user_city => Város
//    $user_country => Ország'));
            include($settingsfile);
        }
    }

}