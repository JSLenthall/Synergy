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
                                                                                                                                    
// This is used for performance, we don't need to know about these settings on every page in Moodle, only when                      
// we are looking at the admin settings pages.                                                                                      
if ($ADMIN->fulltree) {                                                                                                             
                                                                                                                                    
    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.                         
    $settings = new theme_boost_admin_settingspage_tabs('themesettingsynergylearning', get_string('configtitle', 'theme_synergylearning'));             
                                                                                                                                    
    // Each page is a tab - the first is the "General" tab.                                                                         
    $page = new admin_settingpage('theme_synergylearning_general', get_string('generalsettings', 'theme_synergylearning'));                             
                                                                                                                                    
    // Replicate the preset setting from boost.                                                                                     
    $name = 'theme_synergylearning/preset';                                                                                                   
    $title = get_string('preset', 'theme_synergylearning');                                                                                   
    $description = get_string('preset_desc', 'theme_synergylearning');                                                                        
    $default = 'default.scss';                                                                                                      
                                                                                                                                    
    // We list files in our own file area to add to the drop down. We will provide our own function to                              
    // load all the presets from the correct paths.                                                                                 
    $context = context_system::instance();                                                                                          
    $fs = get_file_storage();                                                                                                       
    $files = $fs->get_area_files($context->id, 'theme_synergylearning', 'preset', 0, 'itemid, filepath, filename', false);                    
                                                                                                                                    
    $choices = [];                                                                                                                  
    foreach ($files as $file) {                                                                                                     
        $choices[$file->get_filename()] = $file->get_filename();                                                                    
    }                                                                                                                               
    // These are the built in presets from Boost.                                                                                   
    $choices['default.scss'] = 'default.scss';                                                                                      
    $choices['plain.scss'] = 'plain.scss';                                                                                          
                                                                                                                                    
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);                                     
    $setting->set_updatedcallback('theme_reset_all_caches');                                                                        
    $page->add($setting);                                                                                                           
                                                                                                                                    
    // Preset files setting.                                                                                                        
    $name = 'theme_synergylearning/presetfiles';                                                                                              
    $title = get_string('presetfiles','theme_synergylearning');                                                                               
    $description = get_string('presetfiles_desc', 'theme_synergylearning');                                                                   
                                                                                                                                    
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,                                         
        array('maxfiles' => 20, 'accepted_types' => array('.scss')));                                                               
    $page->add($setting);     

    // Variable $brand-color.                                                                                                       
    $name = 'theme_synergylearning/brandcolor';                                                                                               
    $title = get_string('brandcolor', 'theme_synergylearning');                                                                               
    $description = get_string('brandcolor_desc', 'theme_synergylearning');                                                                    
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#3cd264');                                               
    $setting->set_updatedcallback('theme_reset_all_caches');                                                                        
    $page->add($setting);     

    // Footer logo image setting.                                                                                               
    $name = 'theme_synergylearning/footerlogo';                                                                                     
    $title = get_string('footerlogo', 'theme_synergylearning');                                                                     
    $description = get_string('footerlogo_desc', 'theme_synergylearning');                                                          
    // This creates the new setting.                                                                                                
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footerlogo');                             
    // This means that theme caches will automatically be cleared when this setting is changed.                                     
    $setting->set_updatedcallback('theme_reset_all_caches');                                           
    // We always have to add the setting to a page for it to have any effect.                                                       
    $page->add($setting);      

    // Footer copyright text setting.                                                                                               
    $name = 'theme_synergylearning/footercopyright';                                                                                     
    $title = get_string('footercopyright', 'theme_synergylearning');                                                                     
    $description = get_string('footercopyright_desc', 'theme_synergylearning');                                                          
    // This creates the new setting.                                                                                                
    $setting = new admin_setting_configtext($name, $title, $description, '');                             
    // This means that theme caches will automatically be cleared when this setting is changed.                                     
    $setting->set_updatedcallback('theme_reset_all_caches');                                                                        
    // We always have to add the setting to a page for it to have any effect.                                                       
    $page->add($setting);  
                                                                                                                                    
    // Must add the page after definiting all the settings!                                                                         
    $settings->add($page);                                                                                                          
                                                                                                                                    
    // Advanced settings.                                                                                                           
    $page = new admin_settingpage('theme_synergylearning_advanced', get_string('advancedsettings', 'theme_synergylearning'));                           
                                                                                                                                    
    // Raw SCSS to include before the content.                                                                                      
    $setting = new admin_setting_configtextarea('theme_synergylearning/scsspre',                                                              
        get_string('rawscsspre', 'theme_synergylearning'), get_string('rawscsspre_desc', 'theme_synergylearning'), '', PARAM_RAW);                      
    $setting->set_updatedcallback('theme_reset_all_caches');                                                                        
    $page->add($setting);                                                                                                           
                                                                                                                                    
    // Raw SCSS to include after the content.                                                                                       
    $setting = new admin_setting_configtextarea('theme_synergylearning/scss', get_string('rawscss', 'theme_synergylearning'),                           
        get_string('rawscss_desc', 'theme_synergylearning'), '', PARAM_RAW);                                                                  
    $setting->set_updatedcallback('theme_reset_all_caches');                                                                        
    $page->add($setting);                                                                                                           
                                                                                                                                    
    $settings->add($page);                                                                                                        
}

