<?php
/**
 * @package      CMB2\Field_Unit
 * @author       Ruben Garcia <rubengcdev@gmail.com>
 * @copyright    Copyright (c) Ruben Garcia <rubengcdev@gmail.com>
 *
 * Plugin Name: CMB2 Field Type: Unit
 * Plugin URI: https://github.com/rubengc/cmb2-field-unit
 * GitHub Plugin URI: https://github.com/rubengc/cmb2-field-unit
 * Description: CMB2 field type to setup unit values (font size, line height, etc).
 * Version: 1.0.0
 * Author: Ruben Garcia <rubengcdev@gmail.com>
 * Author URI: https://gamipress.com/
 * License: GPLv2+
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'CMB2_Field_Unit' ) ) {

    /**
     * Class CMB2_Field_Unit
     */
    class CMB2_Field_Unit {

        /**
         * Current version number
         */
        const VERSION = '1.0.1';

        /**
         * Initialize the plugin by hooking into CMB2
         */
        public function __construct() {
            add_action( 'admin_enqueue_scripts', array( $this, 'setup_admin_scripts' ) );
            add_action( 'cmb2_render_unit', array( $this, 'render' ), 10, 5 );
        }

        /**
         * Render field
         */
        public function render( $field, $value, $object_id, $object_type, $field_type ) {
            ?>

            <div class="cmb2-unit">

                <div class="cmb2-unit-field cmb2-unit-field-value">
                    <?php echo $field_type->input( array(
                        'name'    => $field_type->_name() . '[value]',
                        'desc'    => '',
                        'id'      => $field_type->_id() . '_value',
                        'class' => 'cmb2-text-small cmb2-unit-input',
                        'type'    => 'number',
                        'pattern' => '\d*',
                        'value' => ( ( isset( $value['value'] ) ) ? $value['value'] : '' ),
                    ) ); ?>
                </div>

                <div class="cmb2-unit-field cmb2-unit-field-unit">
                    <?php
                    $unit_options = array(
                        'px' => 'px',
                        'em' => 'em',
                        'rem' => 'rem',
                    );

                    if( is_array( $field->args( 'units' ) ) ) {
                        $unit_options = $field->args( 'units' );
                    }

                    echo $field_type->select( array(
                        'name'    => $field_type->_name() . '[unit]',
                        'desc'    => '',
                        'id'      => $field_type->_id() . '_unit',
                        'class' => 'cmb2-unit-select',
                        'options' => $this->build_options_string( $field_type, $unit_options, ( ( isset( $value['unit'] ) ) ? $value['unit'] : '' ) ),
                    ) );
                    ?>
                </div>

            </div>

            <?php
            $field_type->_desc( true, true );
        }

        private function build_options_string( $field_type, $options, $value ) {
            $options_string = '';

            foreach( $options as $val => $label) {
                $options_string .= '<option value="' . $val . '" ' . selected( $value, $val, false ) . '>' . $label . '</option>';
            }

            return $options_string;
        }

        /**
         * Enqueue scripts and styles
         */
        public function setup_admin_scripts() {
            wp_register_script( 'cmb-unit', plugins_url( 'js/unit.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );

            wp_enqueue_script( 'cmb-unit' );

            wp_register_style( 'cmb-unit', plugins_url( 'css/unit.css', __FILE__ ), array(), self::VERSION );

            wp_enqueue_style( 'cmb-unit' );

        }

    }

    $cmb2_field_unit = new CMB2_Field_Unit();

}
