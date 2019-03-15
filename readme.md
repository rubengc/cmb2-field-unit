CMB2 Field Type: Unit
==================

Custom field for [CMB2](https://github.com/CMB2/CMB2) to store a unit values (font size, line height, etc).

![example](example.gif)

## Examples

```php
add_action( 'cmb2_admin_init', 'cmb2_unit_metabox' );
function cmb2_unit_metabox() {

	$prefix = 'your_prefix_demo_';

	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Unit Metabox', 'cmb2' ),
		'object_types'  => array( 'page', 'post' ), // Post type
	) );

	$cmb_demo->add_field( array(
		'name'          => __( 'Default field', 'cmb2' ),
		'desc'          => __( 'Field description (optional)', 'cmb2' ),
		'id'            => $prefix . 'unit',
		'type'          => 'unit',
		// Custom units (units by default are 'px', 'em' and 'rem'
		'units'     => array(
			'px' => 'px',
			'em' => 'em',
		)
	) );

}
```

## Retrieve the field value

```php
    $post_meta = get_post_meta( get_the_ID(), 'your_field_id', false );
    
    $value = isset( $post_meta['value'] ) ? $post_meta['value'] : 0';
    $unit = isset( $post_meta['unit'] ) ? $post_meta['unit'] : 'px';
    
    echo 'font-size: ' . $value . $unit . ';';
```

## Changelog

### 1.0.0
* Initial commit
