<?php 
add_action('widgets_init', 'alsp_register_bids_widget');
function alsp_register_bids_widget() {
	register_widget('alsp_bids_widget');
}

class alsp_bids_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'alsp_bids_widget',
			__('ALSP - Bids', 'ALSP'),
			array('description' => __( 'ALSP Bids', 'ALSP'),)
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
	}

	public function widget($args, $instance) {
		global $alsp_instance;

		if (!$instance['visibility'] || !empty($alsp_instance->public_controls)) {
			$title = apply_filters('widget_title', $instance['title']);
			
			//if ($listing_id)
				alsp_renderTemplate('alsp-widgets/bids_widget.tpl.php', array('args' => $args, 'title' => $title,));
		}
	}
	
	public function form($instance) {
		$defaults = array('title' => __('Offers', 'ALSP'), 'visibility' => 1);
		$instance = wp_parse_args((array) $instance, $defaults);
		
		alsp_renderTemplate('alsp-widgets/bids_widget_options.tpl.php', array('widget' => $this, 'instance' => $instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['visibility'] = (!empty($new_instance['visibility'])) ? strip_tags($new_instance['visibility']) : '';
	
		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
		
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}

}

add_action('widgets_init', 'alsp_register_map_widget');
function alsp_register_map_widget() {
	register_widget('alsp_map_widget');
}

class alsp_map_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'alsp_map_widget',
			__('ALSP - Map', 'ALSP'),
			array('description' => __( 'ALSP Advert Map', 'ALSP'),)
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
	}

	public function widget($args, $instance) {
		global $alsp_instance;

		if (!$instance['visibility'] || !empty($alsp_instance->public_controls)) {
			$title = apply_filters('widget_title', $instance['title']);
			
			//if ($listing_id)
				alsp_renderTemplate('alsp-widgets/map_widget.tpl.php', array('height' => 220, 'args' => $args, 'title' => $title,));
		}
	}
	
	public function form($instance) {
		$defaults = array('title' => __('Map View', 'ALSP'), 'visibility' => 1);
		$instance = wp_parse_args((array) $instance, $defaults);
		
		alsp_renderTemplate('alsp-widgets/map_widget_options.tpl.php', array('widget' => $this, 'instance' => $instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['visibility'] = 1;
	
		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
		
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}

}

add_action('widgets_init', 'alsp_register_resurva_widget');
function alsp_register_resurva_widget() {
	register_widget('alsp_resurva_widget');
}

class alsp_resurva_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'alsp_resurva_widget',
			__('ALSP - Resurva Booking', 'ALSP'),
			array('description' => __( 'ALSP Resurva Booking', 'ALSP'),)
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
	}

	public function widget($args, $instance) {
		global $alsp_instance;

		if (!$instance['visibility'] || !empty($alsp_instance->public_controls)) {
			$title = apply_filters('widget_title', $instance['title']);
			
			//if ($listing_id)
				alsp_renderTemplate('alsp-widgets/resurva_widget.tpl.php', array('args' => $args, 'title' => $title,));
		}
	}
	
	public function form($instance) {
		$defaults = array('title' => __('Resurva Booking', 'ALSP'), 'visibility' => 1);
		$instance = wp_parse_args((array) $instance, $defaults);
		
		alsp_renderTemplate('alsp-widgets/resurva_widget_options.tpl.php', array('widget' => $this, 'instance' => $instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['visibility'] = 1;
	
		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
		
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}

}

add_action('widgets_init', 'alsp_register_social_widget');
function alsp_register_social_widget() {
	register_widget('alsp_social_widget');
}

class alsp_social_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'alsp_social_widget',
			__('ALSP - Social', 'ALSP'),
			array('description' => __( 'Social services', 'ALSP'))
		);
		
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
		//add_action('wp_head', array($this, 'enqueue_dynamic_css'), 9999);
	}

	public function widget($args, $instance) {
		global $alsp_instance;
		
		if (!$instance['visibility'] || !empty($alsp_instance->public_controls)) {
			$title = apply_filters('widget_title', $instance['title']);
	
			alsp_renderTemplate('alsp-widgets/social_widget.tpl.php', array('args' => $args, 'title' => $title, 'instance' => $instance));
		}
	}
	
	public function form($instance) {
		$defaults = array(
				'title' => __('Social accounts', 'ALSP'),
				'facebook' => 'http://www.facebook.com/',
				'is_facebook' => 1,
				'twitter' => 'http://twitter.com/',
				'is_twitter' => 1,
				'google' => 'http://www.google.com/',
				'is_google' => 1,
				'linkedin' => 'http://www.linkedin.com/',
				'is_linkedin' => 1,
				'youtube' => 'http://www.youtube.com/',
				'is_youtube' => 1,
				'rss' => esc_url(add_query_arg('post_type', ALSP_POST_TYPE, site_url('feed'))),
				'is_rss' => 1,
				'visibility' => 1,
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		
		alsp_renderTemplate('alsp-widgets/social_widget_options.tpl.php', array('widget' => $this, 'instance' => $instance));
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['facebook'] = (!empty($new_instance['facebook'])) ? strip_tags($new_instance['facebook']) : '';
		$instance['is_facebook'] = (!empty($new_instance['is_facebook'])) ? strip_tags($new_instance['is_facebook']) : '';
		$instance['twitter'] = (!empty($new_instance['twitter'])) ? strip_tags($new_instance['twitter']) : '';
		$instance['is_twitter'] = (!empty($new_instance['is_twitter'])) ? strip_tags($new_instance['is_twitter']) : '';
		$instance['google'] = (!empty($new_instance['google'])) ? strip_tags($new_instance['google']) : '';
		$instance['is_google'] = (!empty($new_instance['is_google'])) ? strip_tags($new_instance['is_google']) : '';
		$instance['linkedin'] = (!empty($new_instance['linkedin'])) ? strip_tags($new_instance['linkedin']) : '';
		$instance['is_linkedin'] = (!empty($new_instance['is_linkedin'])) ? strip_tags($new_instance['is_linkedin']) : '';
		$instance['youtube'] = (!empty($new_instance['youtube'])) ? strip_tags($new_instance['youtube']) : '';
		$instance['is_youtube'] = (!empty($new_instance['is_youtube'])) ? strip_tags($new_instance['is_youtube']) : '';
		$instance['rss'] = (!empty($new_instance['rss'])) ? strip_tags($new_instance['rss']) : '';
		$instance['is_rss'] = (!empty($new_instance['is_rss'])) ? strip_tags($new_instance['is_rss']) : '';
		$instance['visibility'] = (!empty($new_instance['visibility'])) ? strip_tags($new_instance['visibility']) : '';
	
		return $instance;
	}
	
	public function wp_enqueue_scripts() {
		$widget_options_all = get_option($this->option_name);
		if (isset($widget_options_all[$this->number])) {
			$current_widget_options = $widget_options_all[$this->number];
			if (is_active_widget(false, false, $this->id_base, true) && !$current_widget_options['visibility']) {
				global $alsp_instance, $alsp_fsubmit_instance, $alsp_payments_instance, $alsp_ratings_instance;
		
				$alsp_instance->enqueue_scripts_styles(true);
				if ($alsp_fsubmit_instance)
					$alsp_fsubmit_instance->enqueue_scripts_styles(true);
				if ($alsp_payments_instance)
					$alsp_payments_instance->enqueue_scripts_styles(true);
				if ($alsp_ratings_instance)
					$alsp_ratings_instance->enqueue_scripts_styles(true);
			}
		}
	}
}

?>