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
$class_name = 'wp-block-random';
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
<div id="<?php echo esc_attr( $block_id ); ?>" class="page-header has-image-opacity has-post-thumbnail <?php echo esc_attr( $class_name ); ?>">

<div class="post-thumbnail">
		<?php
			echo wp_get_attachment_image( $images[ $rand ]['image'], 'full' );
		?>
	 <?php if ( ! empty( $images[ $rand ]['headline'] ) ) { ?>

		<div class="entry-title"><h1>
			<?php
			echo wp_kses_post( $images[ $rand ]['headline'] );
			?>
			</h1>
		</div>
	<?php } ?>
</div>
		<?php $caption = wp_get_attachment_caption( $images[ $rand ]['image'] ); ?>
		<?php if ( ! empty( $caption ) ) { ?>
		<div class="image-caption"><?php echo esc_html( $caption ); ?></div>
		<?php } ?>
		<div class="page-header-inner">
		<InnerBlocks />
	</div>

</div>
