<?php

/**
 * The admin-specific public functionality of the plugin.
 *
 * @package SFLD Simple Features
 */

namespace SFLD\includes\admin\pages\settings;

class SFLD_Simple_Main_Form
{

  public function sfld_simple_main_form_init(): void
  {
    // If plugin settings don't exist, then create them
    if (false == get_option('sfld_main_settings')) {
      add_option('sfld_main_settings');
    }

    // Define (at least) one section for our fields
    add_settings_section(
      // Unique identifier for the section
      'sfld_main_settings_section',
      // Section Title
      __('Plugin settings section', 'sfldsimple'),
      // Callback for an optional description
      [$this, 'sfld_main_settings_section_callback'],
      // Admin page to add section to
      'sfld-simple'
    );

    // Checkbox Field 1
    add_settings_field(
      'sfld_main_settings_checkbox1',
      __('Remove all professors and course:', 'sfldsimple'),
      [$this, 'sfld_main_settings_cpt_checkbox_callback'],
      'sfld-simple',
      'sfld_main_settings_section',
      [
        'label' => '*Leave unchecked to preserve data for later use.'
      ]
    );

    // Checkbox Field 2
    add_settings_field(
      'sfld_main_settings_checkbox2',
      __('Remove all categories and tags:', 'sfldsimple'),
      [$this, 'sfld_main_settings_taxonomies_checkbox_callback'],
      'sfld-simple',
      'sfld_main_settings_section',
      [
        'label' => '*'
      ]
    );

    // Checkbox Field 3
    add_settings_field(
      'sfld_main_settings_checkbox3',
      __('Remove data from the database:', 'sfldsimple'),
      [$this, 'sfld_main_settings_database_checkbox_callback'],
      'sfld-simple',
      'sfld_main_settings_section',
      [
        'label' => '*'
      ]
    );

    // Checkbox Field 4
    add_settings_field(
      'sfld_main_settings_checkbox4',
      __('Remove all options data:', 'sfldsimple'),
      [$this, 'sfld_main_settings_checkbox_callback'],
      'sfld-simple',
      'sfld_main_settings_section',
      [
        'label' => '*'
      ]
    );


    register_setting(
      'sfld_main_settings',
      'sfld_main_settings'
    );
  }


  public function sfld_main_settings_section_callback(): void
  {
    esc_html_e('By cheking the settings options you will erase all data upon removing the plugin!', 'sfldsimple');
  }  
  
  public function sfld_main_settings_cpt_checkbox_callback($args): void
  {
    $options = get_option('sfld_main_settings');

    $checkbox = '';
    if (isset($options['checkbox-cpt'])) {
      $checkbox = esc_html($options['checkbox-cpt']);
    }

    $html = '<input type="checkbox" id="sfld_main_settings_checkbox" name="sfld_main_settings[checkbox-cpt]" value="1"' . checked(1, $checkbox, false) . '/>';
    $html .= '&nbsp;';
    $html .= '<label for="sfld_main_settings_checkbox">' . $args['label'] . '</label>';

    echo $html;
  }

  public function sfld_main_settings_taxonomies_checkbox_callback($args): void
  {
    $options = get_option('sfld_main_settings');

    $checkbox = '';
    if (isset($options['checkbox-taxonomies'])) {
      $checkbox = esc_html($options['checkbox-taxonomies']);
    }

    $html = '<input type="checkbox" id="sfld_main_settings_checkbox" name="sfld_main_settings[checkbox-taxonomies]" value="1"' . checked(1, $checkbox, false) . '/>';
    $html .= '&nbsp;';
    $html .= '<label for="sfld_main_settings_checkbox">' . $args['label'] . '</label>';

    echo $html;
  }

  public function sfld_main_settings_database_checkbox_callback($args): void
  {
    $options = get_option('sfld_main_settings');

    $checkbox = '';
    if (isset($options['checkbox-database'])) {
      $checkbox = esc_html($options['checkbox-database']);
    }

    $html = '<input type="checkbox" id="sfld_main_settings_checkbox" name="sfld_main_settings[checkbox-database]" value="1"' . checked(1, $checkbox, false) . '/>';
    $html .= '&nbsp;';
    $html .= '<label for="sfld_main_settings_checkbox">' . $args['label'] . '</label>';

    echo $html;
  }

  public function sfld_main_settings_checkbox_callback($args): void
  {
    $options = get_option('sfld_main_settings');

    $checkbox = '';
    if (isset($options['checkbox-settings'])) {
      $checkbox = esc_html($options['checkbox-settings']);
    }

    $html = '<input type="checkbox" id="sfld_main_settings_checkbox" name="sfld_main_settings[checkbox-settings]" value="1"' . checked(1, $checkbox, false) . '/>';
    $html .= '&nbsp;';
    $html .= '<label for="sfld_main_settings_checkbox">' . $args['label'] . '</label>';

    echo $html;
  }
}
