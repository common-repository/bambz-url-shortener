<?php 
/*
	Plugin Name: BAM.bz Url Shortener
	Version: 1.1512.1
	Plugin URI: http://wordpress.org/plugins/bambz-url-shortener
	Description: "BAM.bz Url Shortener" is a customizable widget that offers your visitors the service of easily shorten an url without leaving your website.
	Author: BAM.bz
	Author URI: https://bam.bz/
*/

add_action( 'widgets_init', 'bambz_url_shortener_init' );

function bambz_url_shortener_init() {
	register_widget('bambz_url_shortener');
}

class bambz_url_shortener extends WP_Widget
{
	public function __construct() {
		$widget_details = array(
			'classname'   => 'bambz_url_shortener',
			'description' => 'Offers your visitors the service of easily shorten an url without leaving your website.'
		);

		parent::__construct('bambz_url_shortener', 'BAM.bz Url Shortener', $widget_details);
	}

	public function form($instance) {
		$title = (array_key_exists('title', $instance))
			? $instance['title']
			: 'Url Shortener Service';

		$css = (array_key_exists('css', $instance))
			? $instance['css']
			: '#bambz-url-shortener form { font-size: 0; }' . "\n" .
				'#bambz-url-shortener input.error { background: #fcc; }' . "\n" .
				'#bambz-url-shortener input.success { background: #cfc; }' . "\n" .
				'#bambz-url-shortener input.marginTop { margin-bottom: 10px; }' . "\n" .
				'#bambz-url-shortener input[type="text"] { font-style: italic; }';

		$html = (array_key_exists('html', $instance))
			? $instance['html']
			: '<ul>' . "\n" .
				'	<li>' . "\n" .
				'		<input name="target" type="url" class="marginTop" pattern="^(http|https):\/\/.*" placeholder="Enter to shorten url." value="http://" required />' . "\n" .
				'	</li>' . "\n" .
				'	<li>' . "\n" .
				'		<input name="url" type="text" class="marginTop" placeholder="Shorten url will appear here." onmouseover="this.onclick()" onclick="this.setSelectionRange(0, this.value.length)" readonly />' . "\n" .
				'	</li>' . "\n" .
				'	<li>' . "\n" .
				'		<input name="shorten" type="submit" value="Shorten!" />' . "\n" .
				'	</li>' . "\n" .
				'</ul>';
		?>

		<p>
			<label for="<?php echo $this->get_field_name('title'); ?>">
				<?php _e('Title:'); ?>
			</label>
			<input
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name( 'title' ); ?>"
				class="widefat"
				type="text"
				value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_name('css'); ?>">
				<?php _e('Stylesheet / CSS:'); ?>
			</label>
			<textarea
				id="<?php echo $this->get_field_id('css'); ?>"
				name="<?php echo $this->get_field_name( 'css' ); ?>"
				rows="7"
				class="widefat"><?php echo esc_attr($css); ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_name('html'); ?>">
				<?php _e('HTML:'); ?>
			</label>
			<textarea
				id="<?php echo $this->get_field_id('html'); ?>"
				name="<?php echo $this->get_field_name( 'html' ); ?>"
				rows="19"
				class="widefat"><?php echo esc_attr($html); ?></textarea>
		</p>

		<?php echo $args['after_widget'];
	}

	public function update($new_instance, $old_instance) {  
		return $new_instance;
	}

	public function widget($args, $instance) { ?>
		<aside id="bambz-url-shortener" class="widget">
			<h2 class="widget-title">
				<a target="_blank" href="https://bam.bz"><?php echo $instance['title'] ?></a>
			</h2>

			<script src="https://bam.bz/js/api.js"></script>
			<script>
				var bam_bz_errormessages = {
					'empty_target'    : '<?php _e('Url must not be empty.'); ?>',
					'invalid_protocol': '<?php _e('Url must start with http(s).'); ?>',
					'internal'        : '<?php _e('Internal error.'); ?>',
					'unexpected'      : '<?php _e('Unexpected error.'); ?>'
				};
			</script>

			<style type="text/css">
				<?php echo $instance['css'] ?>
			</style>

			<form onsubmit="bam_bz_onsubmit(this);return false">
				<?php echo $instance['html'] ?>
			</form>

		</aside>
	<?php }
}
