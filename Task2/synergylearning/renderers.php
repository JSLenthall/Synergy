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
 * Synergy Learning Task 2
 *
 * @package    theme_synergylearning
 * @copyright  2024 Synergry Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.                                                               
defined('MOODLE_INTERNAL') || die();     

require_once($CFG->dirroot . '/course/renderer.php');                                                                    

class theme_synergylearning_core_renderer extends \theme_boost\output\core_renderer {

	public function has_footer_logo() {
        return !empty(get_config('theme_synergylearning', 'footerlogo')) || !empty(get_config('core_admin', 'logocompact'));        
	 }

	public function get_footer_logo_src() {
	    Global $OUTPUT;
	    $theme_name = 'theme_synergylearning';
	    $component_name = 'footerlogo';
        $theme_logo = get_config($theme_name, $component_name);
        return !empty($theme_logo) ? $OUTPUT->image_url($component_name, $theme_name) : $this->get_compact_logo_url(); 
    }

	public function has_footer_copyright() {
        return (!empty(get_config('theme_synergylearning', 'footercopyright')));        
	 }

	public function get_footer_copyright() {
        return get_config('theme_synergylearning', 'footercopyright');
    }

    public function has_theme_footer_addittion() {
        return $this->has_footer_logo() || $this->has_footer_copyright();   
	}
}