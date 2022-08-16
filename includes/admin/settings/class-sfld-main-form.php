<?php defined('WPINC') or die();

/**
 * The admin-specific public functionality of the plugin.
 *
 * @package SFLD Simple Features
 */

namespace SFLD\Includes\Admin\settings;

use SFLD\Includes\Abstracts\SFLD_Singleton;

if (!class_exists('SFLD_Main_Form', false)) : class SFLD_Main_Form extends SFLD_Singleton
  {
    /**
     * Protected class constructor to prevent direct object creation
     *
     */
    protected function __construct()
    {
    }

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
        'sfld_settings'
      );

      // Checkbox Field for Ajax Infinite Scrolling
      add_settings_field(
        'sfld_main_settings_checkbox_ajax',
        __('Infinite scroll for courses archive:', 'sfldsimple'),
        [$this, 'sfld_main_settings_ajax_checkbox_callback'],
        'sfld_settings',
        'sfld_main_settings_section',
        [
          'label' => '*Check to enable.'
        ]
      );

      // Checkbox Field for CPT
      add_settings_field(
        'sfld_main_settings_checkbox_cpt',
        __('Remove all professors and course:', 'sfldsimple'),
        [$this, 'sfld_main_settings_cpt_checkbox_callback'],
        'sfld_settings',
        'sfld_main_settings_section',
        [
          'label' => '*Leave unchecked to preserve data for later use.'
        ]
      );

      // Checkbox Field for Taxonomies
      add_settings_field(
        'sfld_main_settings_checkbox_taxonomies',
        __('Remove all categories and tags:', 'sfldsimple'),
        [$this, 'sfld_main_settings_taxonomies_checkbox_callback'],
        'sfld_settings',
        'sfld_main_settings_section',
        [
          'label' => '*Leave unchecked to preserve data for later use.'
        ]
      );

      // Checkbox Field for Database Table
      add_settings_field(
        'sfld_main_settings_database',
        __('Remove data from the database:', 'sfldsimple'),
        [$this, 'sfld_main_settings_database_checkbox_callback'],
        'sfld_settings',
        'sfld_main_settings_section',
        [
          'label' => '*Leave unchecked to preserve data for later use.'
        ]
      );

      // Checkbox Field for Options Data
      add_settings_field(
        'sfld_main_settings_checkbox4',
        __('Remove all options data:', 'sfldsimple'),
        [$this, 'sfld_main_settings_options_checkbox_callback'],
        'sfld_settings',
        'sfld_main_settings_section',
        [
          'label' => '*Leave unchecked to preserve data for later use.'
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

    public function sfld_main_settings_ajax_checkbox_callback($args): void
    {
      $options = get_option('sfld_main_settings');

      $checkbox = '';
      if (isset($options['checkbox-ajax'])) {
        $checkbox = esc_html($options['checkbox-ajax']);
      }

      $html = '<input type="checkbox" id="sfld_main_settings_checkbox" name="sfld_main_settings[checkbox-ajax]" value="1"' . checked(1, $checkbox, false) . '/>';
      $html .= '&nbsp;';
      $html .= '<label for="sfld_main_settings_checkbox">' . $args['label'] . '</label>';

      echo $html;
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

    public function sfld_main_settings_options_checkbox_callback($args): void
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
endif;
