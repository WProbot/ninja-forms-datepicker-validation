<?php

class NFDatepickerValidation {
  /**
   * @var string
   */
  protected $version;

/**
 * Creates a new instance of the plugin class, assigns version number, and adds hooks.
 *
 * @return void
 */
  public function __construct() {
    $this->version = '0.1.0';
    $this->add_hooks();
  }

/**
 * Adds plugin functions to WordPress hooks.
 *
 * @return void
 */
  private function add_hooks() {
    add_filter('ninja_forms_enqueue_scripts', array($this, 'enqueue_scripts'));
    add_filter('ninja_forms_field_settings', array($this, 'add_field_settings'));
    add_filter('ninja_forms_loaded', array($this, 'replace_date_field_instance'));
  }

/**
 * Enqueue's the plugins JS files.
 *
 * @return void
 */
  public function enqueue_scripts() {
    wp_enqueue_script('nf_datepicker_options', plugin_dir_url(dirname( __FILE__)) . 'js/customDatePicker.js', array('jquery'), $this->get_version(), true);
    wp_enqueue_script('nf_datepicker_validation', plugin_dir_url(dirname( __FILE__)) . 'js/customDatePickerValidation.js', array('jquery'), $this->get_version(), true);
    wp_enqueue_script('nf_enabled_dates', plugin_dir_url(dirname( __FILE__)) . '/js/utils.js', array('jquery'), $this->get_version(), true);
  }

/**
 * Adds the date_range configuration to the Ninja Forms field settings array.
 *
 * @param array $settings
 * @return array $settings
 */
  public function add_field_settings($settings) {
    $settings['date_range'] = array(
      'name' => 'date_range',
      'type' => 'fieldset',
      'label' => __( 'Date Range', 'ninja-forms' ),
      'width' => 'full',
      'group' => 'advanced',
      'settings' => array(
        array(
          'name' => 'date_range_start',
          'type' => 'textbox',
          'label' => __( 'Start Date', 'ninja_forms' ),
          'value' => '',
          'help' => __( 'Enter the first date in the valid date range. Format must be MM/DD/YYYY.', 'ninja-forms' ),
        ),
        array(
          'name' => 'date_range_end',
          'type' => 'textbox',
          'label' => __( 'End Date', 'ninja_forms' ),
          'value' => '',
          'help' => __( 'Enter the last date in the valid date range. Format must be MM/DD/YYYY.', 'ninja-forms' ),
        ),
      )
    );
    return $settings;
  }

/**
 * Removes the year_range fields and adds the date_range fields to the Ninja Forms Date Field object.
 *
 * @return void
 */
  public function replace_date_field_instance() {
    // Remove the year range and replace it with our new date range field
    // Used some reflection hackery to modifiy the date object's setting -
    // there may be a better way to do this, but it's all I could think of ¯\_(ツ)_/¯
    $settings = Ninja_Forms::config( 'FieldSettings' );
    $date_settings = Ninja_Forms()->fields['date']->get_settings();
    $date_settings['date_range'] = $settings['date_range'];
    unset($date_settings['year_range']);
    $nf_date = new NF_Fields_Date();
    $refProperty = new \ReflectionProperty(get_class($nf_date), '_settings');
    $refProperty->setAccessible( true );
    $refProperty->setValue($nf_date, $date_settings);
    Ninja_Forms()->fields['date'] = $nf_date;
  }

/**
 * Getter that returns the plugin's version.
 * 
 * @return string $this->version
 */
  public function get_version() {
    return $this->version;
  }
}
