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



// Load values and assign defaults.
$images = get_field( 'block_random_images' );
if ( empty( $images ) ) {
	return;
}
$rand = array_rand( $images, 1 );

$inner_blocks_template = array(
	array(
		'core/group',
		array(),
		array(),
	),
);
?>

<?php if ( ! $is_preview ) { ?>
	<div
		<?php
		echo wp_kses_data(
			get_block_wrapper_attributes()
		);
		?>
	>
<?php } ?>


	
	<?php
		echo wp_get_attachment_image( $images[ $rand ]['image'], 'full', false, array( 'class' => 'acf-random-image__image' ) );
		$headline = $images[ $rand ]['headline'];
	if ( ! empty( $headline ) ) {
		echo '<h1 class="acf-random-image__headline">' . esc_html( $headline ) . '</h1>';
	}
	?>
	
	<InnerBlocks 
		class="acf-random-image__innerblocks"
		template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>"
	/>

	<?php if ( ! $is_preview ) { ?>
	</div>
<?php } ?>
