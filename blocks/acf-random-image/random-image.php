<?php
/**
 * Random Image Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 * @package 1.0
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'rhzm_random-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}


// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wp-block-carkeek-acf-random';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$images = get_field( 'block_random_images' );
if ( empty( $images ) ) {
	return;
}
$rand   = array_rand( $images, 1 );

?>
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">

	
	<?php
		echo wp_get_attachment_image( $images[ $rand ]['image'], 'full' );
	?>
	
		
	<div class="image-inner">
		<InnerBlocks />
	</div>

</div>
