<?php
/*
 * Plugin Name:       Ninja Forms Date Picker Validation
 * Plugin URI:
 * Description:       Adds date range validation to Ninja Forms Date fields.
 * Version:           0.1.0
 * Author:            Brendan Corazzin
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if(!function_exists('Ninja_Forms')) {
    die();
}

require_once plugin_dir_path( __FILE__ ) . 'includes/NFDatepickerValidation.php';

/**
 * Creates the plugin instance.
 *
 * @return void
 */
function run_nf_datepicker_validation() {
  new NFDatepickerValidation();
}

run_nf_datepicker_validation();
