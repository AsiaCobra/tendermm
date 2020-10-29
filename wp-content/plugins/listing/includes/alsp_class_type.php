<?php
class alsp_listingtype_manager {
	
	public function __construct() {
		add_action('add_meta_boxes', array($this, 'removeListingTypeMetabox'));
		add_action('add_meta_boxes', array($this, 'addListingTypeMetabox'));
		
		add_filter('manage_' . ALSP_TYPE_TAX . '_custom_column', array($this, 'taxonomy_rows'), 15, 3);
		add_filter('manage_edit-' . ALSP_TYPE_TAX . '_columns',  array($this, 'taxonomy_columns'));
		
		add_action(ALSP_TYPE_TAX . '_add_form_fields', array ( $this, 'add_listingtype_image' ), 10, 2 );
		add_action( 'created_'. ALSP_TYPE_TAX, array ( $this, 'save_listingtype_image' ), 10, 2 );
		add_action( 'edited_'. ALSP_TYPE_TAX, array ( $this, 'update_save_listingtype_image' ));
		add_action(ALSP_TYPE_TAX . '_add_form_fields', array ( $this, 'add_listingtype_svg_image' ), 10, 2 );
		add_action( 'created_'. ALSP_TYPE_TAX, array ( $this, 'save_listingtype_svg_image' ), 10, 2 );
		add_action( 'edited_'. ALSP_TYPE_TAX, array ( $this, 'update_save_listingtype_svg_image' ));
		add_action(ALSP_TYPE_TAX . '_edit_form_fields', array($this, 'select_icon_form'));
		add_action(ALSP_TYPE_TAX . '_edit_form_fields', array($this, 'select_font_icon_form'));
		add_action(ALSP_TYPE_TAX . '_edit_form_fields', array($this, 'select_font_color_form'));
		add_action(ALSP_TYPE_TAX . '_edit_form_fields', array ( $this, 'update_listingtype_image' ), 10, 2 );
		add_action(ALSP_TYPE_TAX . '_edit_form_fields', array ( $this, 'update_listingtype_svg_image' ), 10, 2 );
		
		
		if (alsp_isListingTypeEditPageInAdmin()) {
			add_action('admin_enqueue_scripts', array($this, 'load_wp_media_files' ));
			add_action( 'admin_footer', array ( $this, 'add_script' ) );
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_listingtype_edit_scripts'));
		}
		
		//if ($pagenow == 'edit-tags.php' && isset($_GET['taxonomy']) && $_GET['taxonomy'] == ALSP_TYPE_TAX);
		//add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_listingtype_edit_scripts'));
		add_action('wp_ajax_alsp_select_listingtype_icon_dialog2', array($this, 'select_listingtype_icon_dialog2'));
		add_action('wp_ajax_alsp_select_listingtype_icon_dialog', array($this, 'select_listingtype_icon_dialog'));
		add_action('wp_ajax_alsp_select_listingtype_icon2', array($this, 'select_listingtype_icon2'));
		add_action('wp_ajax_alsp_select_listingtype_icon', array($this, 'select_listingtype_icon'));
		add_action('wp_ajax_alsp_select_listingtype_font_icon', array($this, 'select_listingtype_font_icon'));
		add_action('wp_ajax_alsp_select_listingtype_font_color', array($this, 'select_listingtype_font_color'));
		
		add_filter('manage_' . ALSP_TAGS_TAX . '_custom_column', array($this, 'tags_taxonomy_rows'), 15, 3);
		add_filter('manage_edit-' . ALSP_TAGS_TAX . '_columns',  array($this, 'tags_taxonomy_columns'));

		// 'checked_ontop' for directory listingtype taxonomy must always be false
		add_filter('wp_terms_checklist_args', array($this, 'unset_checked_ontop'), 100);
	}
	
	// remove native locations taxonomy metabox from sidebar
	public function removeListingTypeMetabox() {
		remove_meta_box(ALSP_TYPE_TAX . 'div', ALSP_POST_TYPE, 'side');
	}

	public function addListingTypeMetabox($post_type) {
		if ($post_type == ALSP_POST_TYPE && ($level = alsp_getCurrentListingInAdmin()->level) && ($level->listingtype_number > 0 || $level->unlimited_listingtype)) {
		//if ($post_type == ALSP_POST_TYPE) {
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts_styles'));

			add_meta_box(ALSP_TYPE_TAX,
					__('Listing listing type', 'ALSP'),
					'post_categories_meta_box',
					ALSP_POST_TYPE,
					'normal',
					'high',
					array('taxonomy' => ALSP_TYPE_TAX));
		}
	}
	
	public function unset_checked_ontop($args) {
		if (isset($args['taxonomy']) && $args['taxonomy'] == ALSP_TYPE_TAX)
			$args['checked_ontop'] = false;

		return $args;
	}

	public function validateListingType($level, &$postarr, &$errors) {
		global $alsp_instance;

		if (isset($postarr['tax_input'][ALSP_TYPE_TAX][0]) && $postarr['tax_input'][ALSP_TYPE_TAX][0] == 0)
			unset($postarr['tax_input'][ALSP_TYPE_TAX][0]);

		if (
			$alsp_instance->content_fields->getContentFieldBySlug('listingtype_list')->is_required &&
			(
			!isset($postarr['tax_input'][ALSP_TYPE_TAX]) ||
			!is_array($postarr['tax_input'][ALSP_TYPE_TAX]) ||
			!count($postarr['tax_input'][ALSP_TYPE_TAX])
			)
		)
			$errors[] = __('Select at least one listingtype!', 'ALSP');

		if (isset($postarr['tax_input'][ALSP_TYPE_TAX]) && is_array($postarr['tax_input'][ALSP_TYPE_TAX])) {
			if (!$level->unlimited_listingtype)
				// remove unauthorized listingtype
				$postarr['tax_input'][ALSP_TYPE_TAX] = array_slice($postarr['tax_input'][ALSP_TYPE_TAX], 0, $level->listingtype_number, true);

			if ($level->listingtype && array_diff($postarr['tax_input'][ALSP_TYPE_TAX], $level->listingtype))
				$errors[] = __('Sorry, you can not choose some listingtype for this level!', 'ALSP');

			$post_listingtype_ids = $postarr['tax_input'][ALSP_TYPE_TAX];
		} else
			$post_listingtype_ids = array();

		return $post_listingtype_ids;
	}

	public function validateTags(&$postarr, &$errors) {
		if (isset($postarr[ALSP_TAGS_TAX]) && $postarr[ALSP_TAGS_TAX]) {
			$post_tags_ids = array();
			foreach ($postarr[ALSP_TAGS_TAX] AS $tag) {
				if ($term = term_exists($tag, ALSP_TAGS_TAX)) {
					$post_tags_ids[] = intval($term['term_id']);
				} else {
					if ($newterm = wp_insert_term($tag, ALSP_TAGS_TAX))
						if (!is_wp_error($newterm))
							$post_tags_ids[] = intval($newterm['term_id']);
				}
			}
		} else
			$post_tags_ids = array();

		return $post_tags_ids;
	}
	
	public function tags_taxonomy_columns($original_columns) {
		$new_columns = $original_columns;
		array_splice($new_columns, 1);
		$new_columns['alsp_tags_id'] = __('Tag ID', 'ALSP');
		return array_merge($new_columns, $original_columns);
	}
	
	public function tags_taxonomy_rows($row, $column_name, $term_id) {
		if ($column_name == 'alsp_tags_id') {
			return $row . $term_id;
		}
		return $row;
	}
	
	public function taxonomy_columns($original_columns) {
		$new_columns = $original_columns;
		array_splice($new_columns, 1);
		$new_columns['alsp_listingtype_id'] = __('listing type ID', 'ALSP');
		$new_columns['alsp_listingtype_icon'] = __('Icon and Color', 'ALSP');
		//$new_columns['alsp_listingtype_icon2'] = __('Icon on Post', 'ALSP');
		//if (get_option('alsp_map_fonts_type') == 'icons') {
		//	$new_columns['alsp_font_listingtype_icon'] = __('Font Icon', 'ALSP');
			
		//}
		//$new_columns['alsp_font_listingtype_color'] = __('Font Color', 'ALSP');
		if (isset($original_columns['description']))
			unset($original_columns['description']);
		return array_merge($new_columns, $original_columns);
	}
	
	public function taxonomy_rows($row, $column_name, $term_id) {
		if ($column_name == 'alsp_listingtype_id') {
			$row  = $term_id;
		}
		if ($column_name == 'alsp_listingtype_icon') {
			//return $row . $this->choose_icon_link($term_id).'<br/>'.$this->choose_icon_link2($term_id).'<br/>'.$this->choose_font_icon_link($term_id);
			return $row . $this->select_icons_setting($term_id);
		}
		
		return $row;
	}

	// ListingType Icon
	public function select_icons_setting($term_id) {
		echo '<div class="dropdown show">';
			echo '<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
				echo '<i class="pacz-li-settings"></i>';
				echo esc_html__('options', 'ALSP');
			echo '</a>';

			echo '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
				echo '<div class="dropmenu_item">';
					echo $this->choose_icon_link($term_id);
				echo '</div>';
				echo '<div class="dropmenu_item">';
					echo $this->choose_font_icon_link($term_id);
				echo '</div>';
				echo '<div class="dropmenu_item">';
					echo $this->choose_font_icon_color($term_id);
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
	public function select_icon_form($term) {
		alsp_renderTemplate('alsp-listingtype/select_icon_form.tpl.php', array('term' => $term));
	}
	
	public function choose_icon_link($term_id) {
		$icon_file = $this->getListingTypeIconFile($term_id);
		alsp_renderTemplate('alsp-listingtype/select_icon_link.tpl.php', array('term_id' => $term_id, 'icon_file' => $icon_file));
	}
	
	public function getListingTypeIconFile($term_id) {
		if (($icons = get_option('alsp_listingtype_icons')) && is_array($icons) && isset($icons[$term_id]))
			return $icons[$term_id];
	}
	
	public function select_listingtype_icon_dialog() {
		$listingtype_icons = array();
		
		$listingtype_icons_files = scandir(ALSP_LISTINGTYPE_ICONS_PATH);
		foreach ($listingtype_icons_files AS $file)
			if (is_file(ALSP_LISTINGTYPE_ICONS_PATH . $file) && $file != '.' && $file != '..')
				$listingtype_icons[] = $file;
		
		alsp_renderTemplate('alsp-listingtype/select_icons_dialog.tpl.php', array('listingtype_icons' => $listingtype_icons));
		die();
	}
	
	public function select_listingtype_icon() {
		if (isset($_POST['listingtype_id']) && is_numeric($_POST['listingtype_id'])) {
			$listingtype_id = $_POST['listingtype_id'];
			$icons = get_option('alsp_listingtype_icons');
			if (isset($_POST['icon_file']) && $_POST['icon_file']) {
				$icon_file = $_POST['icon_file'];
				if (is_file(ALSP_LISTINGTYPE_ICONS_PATH . $icon_file)) {
					$icons[$listingtype_id] = $icon_file;
					update_option('alsp_listingtype_icons', $icons);
					echo $listingtype_id;
				}
			} else {
				if (isset($icons[$listingtype_id]))
					unset($icons[$listingtype_id]);
				update_option('alsp_listingtype_icons', $icons);
			}
		}
		die();
	}
	
	// ListingType Font Icon
	public function select_font_icon_form($term) {
		alsp_renderTemplate('alsp-listingtype/select_font_icon_form.tpl.php', array('term' => $term));
	}
	public function choose_font_icon_link($term_id) {
		$icon_name = $this->getListingTypeFontIcon($term_id);
		alsp_renderTemplate('alsp-listingtype/select_font_icon_link.tpl.php', array('term_id' => $term_id, 'icon_name' => $icon_name));
	}
	public function getListingTypeFontIcon($term_id) {
		if (($icons = get_option('alsp_listingtype_font_icons')) && is_array($icons) && isset($icons[$term_id]))
			return $icons[$term_id];
	}
	public function select_listingtype_font_icon() {
		if (isset($_POST['listingtype_id']) && is_numeric($_POST['listingtype_id'])) {
			$listingtype_id = $_POST['listingtype_id'];
			$fonts_icons = get_option('alsp_listingtype_font_icons');
			if (isset($_POST['icon_name']) && $_POST['icon_name']) {
				$icon_name = $_POST['icon_name'];
				if (in_array($icon_name, alsp_get_fa_icons_names())) {
					$fonts_icons[$listingtype_id] = $icon_name;
					update_option('alsp_listingtype_font_icons', $fonts_icons);
					echo $listingtype_id;
				}
			} else {
				if (isset($fonts_icons[$listingtype_id]))
					unset($fonts_icons[$listingtype_id]);
				update_option('alsp_listingtype_font_icons', $fonts_icons);
			}
		}
		die();
	}

	// ListingType Font Color
	public function select_font_color_form($term) {
		alsp_renderTemplate('alsp-listingtype/select_font_color_form.tpl.php', array('term' => $term));
	}
	public function choose_font_icon_color($term_id) {
		$color = $this->getListingTypeFontColor($term_id);
		alsp_renderTemplate('alsp-listingtype/select_font_color_link.tpl.php', array('term_id' => $term_id, 'color' => $color));
	}
	public function getListingTypeFontColor($term_id) {
		if (($colors = get_option('alsp_listingtype_font_colors')) && is_array($colors) && isset($colors[$term_id]))
			return $colors[$term_id];
	}
	public function select_listingtype_font_color() {
		if (isset($_POST['listingtype_id']) && is_numeric($_POST['listingtype_id'])) {
			$listingtype_id = $_POST['listingtype_id'];
			$fonts_colors = get_option('alsp_listingtype_font_colors');
			if (isset($_POST['color']) && $_POST['color']) {
				$color = $_POST['color'];
				$fonts_colors[$listingtype_id] = $color;
				update_option('alsp_listingtype_font_colors', $fonts_colors);
				echo $listingtype_id;
			} else {
				if (isset($fonts_colors[$listingtype_id]))
					unset($fonts_colors[$listingtype_id]);
				update_option('alsp_listingtype_font_colors', $fonts_colors);
			}
		}
		die();
	}
	
	public function admin_enqueue_listingtype_edit_scripts() {
		wp_enqueue_script('alsp_listingtype_edit_scripts');
		wp_localize_script(
				'alsp_listingtype_edit_scripts',
				'listingtype_icons',
				array(
						'listingtype_icons_url' => ALSP_LISTINGTYPE_ICONS_URL,
						'ajax_dialog_title' => __('Select listing type icon', 'ALSP'),
						'ajax_font_dialog_title' => __('Select font Icon', 'ALSP'),
				)
		);
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');
	}
	
	public function admin_enqueue_scripts_styles() {
		wp_enqueue_script('alsp_listingtypes');

		if ($listing = alsp_getCurrentListingInAdmin()) {
			if ($listing->level->unlimited_listingtype)
				$listingtype_number = 'unlimited';
			else 
				$listingtype_number = $listing->level->listingtype_number;

			wp_localize_script(
					'alsp_listingtypes',
					'level_listingtype',
					array(
							'level_listingtype_array' => $listing->level->listingtype,
							'level_listingtype_number' => $listingtype_number,
							'level_listingtype_notice_disallowed' => __('Sorry, you can not choose this listing type for this level!', 'ALSP'),
							'level_listingtype_notice_number' => sprintf(__('Sorry, you can not choose more than %d listing type!', 'ALSP'), $listingtype_number)
					)
			);
		}
	}
	public function add_listingtype_image ( $term_id ) { ?>
	   <div class="form-field term-group">
		 <label for="listingtype-image-id"><?php _e('Background Image only Work on Parent ListingType ', 'ALSP'); ?></label>
		 <input type="hidden" id="listingtype-image-id" name="listingtype-image-id" class="custom_media_url" value="">
		 <div id="listingtype-image-wrapper" style="width:100px;max-height:100px;overflow:hidden;"></div>
		 <p>
		   <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'ALSP' ); ?>" />
		   <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'ALSP' ); ?>" />
		</p> 
	   </div>
	<?php
	}

public function save_listingtype_image ( $term_id, $tt_id ) {
	if( isset( $_POST['listingtype-image-id'] ) && '' !== $_POST['listingtype-image-id'] ){
		$image = $_POST['listingtype-image-id'];
		add_term_meta( $term_id, 'listingtype-image-id', $image, true );
	}
}
 

/*
  * Edit the form field
  * @since 1.0.0
 */
public function update_listingtype_image ( $term, $taxonomy ) { ?>
   <tr class="form-field term-group-wrap">
		<th scope="row">
			<label for="listingtype-image-id"><?php _e( 'Background Image only Work on Parent ListingType ', 'ALSP' ); ?></label>
		</th>
		<td>
			<?php $image_id = get_term_meta ( $term -> term_id, 'listingtype-image-id', true ); ?>
			<input type="hidden" id="listingtype-image-id" name="listingtype-image-id" value="<?php echo $image_id; ?>">
			<div id="listingtype-image-wrapper" style="width:100px;max-height:100px;overflow:hidden;">
				<?php if ( $image_id ) { ?>
					<?php echo wp_get_attachment_image ( $image_id, 'full' ); ?>
				<?php } ?>
			</div>
			<p>
				<input type="button" class="button-secondary ct_tax_media_button button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'ALSP' ); ?>" />
				<input type="button" class="button-secondary ct_tax_media_remove button " id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'ALSP' ); ?>" />
			</p>
		</td>
	</tr>
<?php
}
  /*
 * Update the form field value
 * @since 1.0.0
 */
  public function update_save_listingtype_image ( $term_id) {
   if( isset( $_POST['listingtype-image-id'] ) && '' !== $_POST['listingtype-image-id'] ){
     $image = $_POST['listingtype-image-id'];
     update_term_meta ( $term_id, 'listingtype-image-id', $image );
	 
   } else {
     update_term_meta ( $term_id, 'listingtype-image-id', '' );
   }
   if( isset( $_POST['listingtype-svg-icon-id'] ) && '' !== $_POST['listingtype-svg-icon-id'] ){
     $listingtype_svg_icon = $_POST['listingtype-svg-icon-id'];
     update_term_meta ( $term_id, 'listingtype-svg-icon-id', $listingtype_svg_icon );
	 
   } else {
     update_term_meta ( $term_id, 'listingtype-svg-icon-id', '' );
   }
 }
 /*
  * Svg icon as image
  * @since 5.4.1
 */
 
public function add_listingtype_svg_image ( $term_id ) { ?>
   <div class="form-field term-group listingtype-svg-image-meta">
     <label for="listingtype-svg-image-id"><?php _e('svg image ', 'ALSP'); ?></label>
     <input type="hidden" id="listingtype-svg-image-id" name="listingtype-svg-image-id" class="custom_media_url" value="">
     <div id="listingtype-image-svg-wrapper" style="width:100px;max-height:100px;overflow:hidden;"></div>
     <p>
       <input type="button" class="button-secondary alsp_media_svg_button button" id="alsp_media_svg_button" name="alsp_media_svg_button" value="<?php _e( 'Add Image', 'ALSP' ); ?>" />
         <input type="button" class="button-secondary alsp_media_svg_remove button " id="alsp_media_svg_remove" name="alsp_media_svg_remove" value="<?php _e( 'Remove Image', 'ALSP' ); ?>" />
    </p> 
   </div>
 <?php
 }
 public function save_listingtype_svg_image ( $term_id, $tt_id ) {
   if( isset( $_POST['listingtype-svg-image-id'] ) && '' !== $_POST['listingtype-svg-image-id'] ){
     $image = $_POST['listingtype-svg-image-id'];
     add_term_meta( $term_id, 'listingtype-svg-image-id', $image, true );
   }
 }
 
 public function update_listingtype_svg_image ( $term, $taxonomy ) { ?>
   <tr class="form-field term-group-wrap listingtype-image-meta">
     <th scope="row">
       <label for="listingtype-svg-image-id"><?php _e( 'SVG IMAGE ', 'ALSP' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta ( $term -> term_id, 'listingtype-svg-image-id', true ); ?>
       <input type="hidden" id="listingtype-svg-image-id" name="listingtype-svg-image-id" value="<?php echo $image_id; ?>">
       <div id="listingtype-image-svg-wrapper" style="width:100px;max-height:100px;overflow:hidden;">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_id, 'full' ); ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button-secondary alsp_media_svg_button button" id="alsp_media_svg_button" name="alsp_media_svg_button" value="<?php _e( 'Add Image', 'ALSP' ); ?>" />
         <input type="button" class="button-secondary alsp_media_svg_remove button " id="alsp_media_svg_remove" name="alsp_media_svg_remove" value="<?php _e( 'Remove Image', 'ALSP' ); ?>" />
       </p>
     </td>
	</tr>
 <?php
 }

 // update save svg image icon 
 public function update_save_listingtype_svg_image ( $term_id) {
   if( isset( $_POST['listingtype-svg-image-id'] ) && '' !== $_POST['listingtype-svg-image-id'] ){
     $image = $_POST['listingtype-svg-image-id'];
     update_term_meta ( $term_id, 'listingtype-svg-image-id', $image );
	 
   } else {
     update_term_meta ( $term_id, 'listingtype-svg-image-id', '' );
   }
 }
 public function add_script() {

 ?>
 
   <script>
     jQuery(document).ready( function($) {
       function ct_media_upload(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if ( _custom_media ) {
               $('#listingtype-image-id').val(attachment.id);
               $('#listingtype-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#listingtype-image-wrapper .custom_media_image').attr('src',attachment.sizes.thumbnail.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }
     ct_media_upload('.ct_tax_media_button.button'); 
     $('body').on('click','.ct_tax_media_remove',function(){
       $('#listingtype-image-id').val('');
       $('#listingtype-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
     // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-listingtype-ajax-response
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#listingtype-image-wrapper').html('');
         }
       }
     });
	 
	 // svg image
	 
	 function alsp_svg_media_upload(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if ( _custom_media ) {
               $('#listingtype-svg-image-id').val(attachment.id);
               $('#listingtype-image-svg-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#listingtype-image-svg-wrapper .custom_media_image').attr('src',attachment.sizes.thumbnail.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }
     alsp_svg_media_upload('.alsp_media_svg_button.button'); 
     $('body').on('click','.alsp_media_svg_remove',function(){
       $('#listingtype-svg-image-id').val('');
       $('#listingtype-image-svg-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
     // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-listingtype-ajax-response
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#listingtype-image-svg-wrapper').html('');
         }
       }
     });
	 // svg image end
   });
 </script>
 
 <?php 

 }
 public function load_wp_media_files() {
	wp_enqueue_media();
	}
}


?>