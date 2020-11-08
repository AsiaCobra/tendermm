<?php
show_admin_bar(false);
include 'class-meta-rss-feed.php';
include 'function-for-newsletter.php';

//Sorting tender_field 
add_action('wp_footer',function(){
    global $wp_scripts, $wp_styles;

    output($wp_scripts->queue);
    output($wp_styles->queue);
    ?>
    <style>
        .pacz-header-toolbar .pacz-grid{
            overflow:visible;
        }
    </style>
    <script id="blabla">
        
        const union_ministry = { wrapper:$('.mailster-union_ministry-wrapper'), name:'union_ministry', value:'All Ministries', require:false }; const regional_gov = { wrapper:$('.mailster-regional-government-wrapper'), name:'regional-government', value:'All States/Regions Government Offices', require:false };

        $(window).on('load',function(){  $('form.mailster-form').find('select').select2(); hide_form_field(); $("select[name='field_tender_field'],select[name='alsp-field-input-92[]']").select2({ sorter:function(results){ return results.sort(function(a, b) { if ( a.text < b.text ){ return -1; } if ( a.text > b.text ){ return 1; } return 0; }); }});
            $('select[name="organizations"]').on('change',function(){ hide_form_field(); if( this.value == 'Regional Government' ) subscribe_form_control(regional_gov); if( this.value == 'Union Ministry' ) subscribe_form_control(union_ministry); })
            var Lswitch = $(".ubermenu-wpml-ls-first-item.ubermenu-wpml-ls-last-item").find("a");
            if( Lswitch.length > 0 ){

                if( Lswitch.attr('title')  == "English" ){
                    let LURL = Lswitch.attr('href');
                    LURL = LURL.replace("/en/all-listings/","/en/all-listing/");
                    console.log( LURL );
                    Lswitch.attr('href',LURL);
                }else{
                    let LURL =Lswitch.attr('href');
                    LURL = LURL.replace("/all-listing/","/all-listings/");
                    console.log( LURL );
                    Lswitch.attr('href',LURL);
                }
            }
          

        });
        function subscribe_form_control(wrapper){ wrapper.wrapper.show().find('select'); }
       function hide_form_field(){ let union2 = union_ministry.wrapper.hide().find('select'); if( union2.val() != union_ministry.value ){ union2.val(union_ministry.value).trigger('change'); } let regional2 =regional_gov.wrapper.hide().find('select'); if( regional2.val() != regional_gov.value ){ regional2.val(regional_gov.value).trigger('change'); } }
       function hide_form_field(){ let union2 = union_ministry.wrapper.hide().find('select'); if( union2.val() != union_ministry.value ){ union2.val(union_ministry.value).trigger('change'); } let regional2 =regional_gov.wrapper.hide().find('select'); if( regional2.val() != regional_gov.value ){ regional2.val(regional_gov.value).trigger('change'); } }
       var strPh = jQuery('.alsp-field-content').find('meta').attr('content');
       jQuery('.alsp-field-content.field-phone-content').find('a').text(strPh);
       console.log("<?Php echo home_url(); ?>");
         jQuery(document).ready(function(){
          $('.slider-home').slick({lazyLoad: 'ondemand',    infinite: true})
         /**
          * Image Lazyload 
          */
          $("img.lazyload").lazyload({ event: "scrollstop", })
          $("img.lazyload").lazyload();
       })
       $(document).on('appear',function(e){
         console.log(e)
       })
    </script>
    <?php
},10000);

add_filter( 'show_admin_bar', '__return_false' );
function remove_scripts(){
    // global $wp_scripts;
    $remove = array(
      'bootstrap',
      // 'wpb_composer_front_js',
      'wp-embed',
      'alsp_applications',
      'wp-sanitize',
      'jquery-ui-tabs',
      // 'jquery-ui-position',
      // 'jquery-ui-widget',
      // 'jquery-ui-core',
    );
    $remove_styles = array(
      'js_composer_front',
      'wp-block-library',
      'rs-plugin-settings-css',
      'difp-style',
      'alsp_fsubmit',
      'alsp_locations',
      'alsp_category',
      'alsp_listings',
      // 'alsp-search',
      'alsp_frontend',
      'embedded_css',
      'dhvc-form',
      'single-listing',
      // 'bootstrap',
      'pacz-fonticon-custom',
      // 'classiadspro-style',
      'pacz-blog',
      // 'pacz-blog',
      'pacz-common-shortcode',
      // 'pacz-styles-default',
      'ubermenu-white',
      'alsp_listings_slider',
      'difp-common-style',
      'dhvc-form-font-awesome',
      'ubermenu-font-awesome-all',
      // 'theme-dynamic-styles',
      // 'theme-options',
    );
    foreach($remove as $script){
      wp_deregister_script($script);
      wp_dequeue_script($script);
    }
    foreach($remove_styles as $script){
      // wp_deregister_style($script);
      // wp_dequeue_style($script);
    }
  
}
function digit_disable_scripts(){
  $remove_scripts = array(
      'pacz-triger',
      'select2-full',
      'libphonenumber-mobile',
      'firebase',
      'firebase-auth',
      'scrollTo',
      'digits-main-script',
      'digits-login-script',
      // 'pacz-theme-plugins',
  );
  $remove_styles = array(
      'digits-login-style',
      'digits-style',
      'google-roboto-regular',
  
  );
  if(!isset($_REQUEST['login'])){

    foreach($remove_scripts as $script){
        // wp_deregister_script($script);
        wp_dequeue_script($script);
    }
    foreach($remove_styles as $script){
        // wp_deregister_script($script);
        wp_dequeue_style($script);
    }
  }
}
if(is_home() ){
  function dig_custom_modal_temp(){

  }
}
// add_action('wp_header','remove_scripts',100);
// add_action('init','remove_scripts',100);
// add_action('wp_print_scripts','remove_scripts',100);

add_action('login_enqueue_scripts','remove_scripts');
add_action('wp_enqueue_scripts','remove_scripts',1000);
add_action('wp_enqueue_scripts','digit_disable_scripts',99999);

function remove_js_composer_front_css(){
  wp_deregister_style('js_composer_front');
  wp_dequeue_style('js_composer_front');
}
add_action('template_redirect','remove_js_composer_front_css',PHP_INT_MAX - 1);
add_action('wp_enqueue_scripts','remove_js_composer_front_css',PHP_INT_MAX - 1);

function remove_home_all_css(){
  global $wp_styles;
  if(is_home()){
    foreach( $wp_styles->queue as $style ) {
        wp_dequeue_style($wp_styles->registered[$style]->handle);
    }
  }
}
add_action('wp_print_styles', 'remove_home_all_css', PHP_INT_MAX - 1);
add_action('wp_print_styles', 'home_css', PHP_INT_MAX);
function home_css(){
  wp_enqueue_style('home-style', get_stylesheet_directory_uri().'/css/styled-home.min.css');
  // wp_enqueue_style('theme-options', get_stylesheet_directory_uri().'/css/theme-option.css');
}
// add_action('vc_base_register_front_js','remove_scripts',120);
function montserrat_remove_google_fonts() {

  // wp_enqueue_style('pure-styles', get_stylesheet_directory_uri().'/styles.pure.css');
  wp_enqueue_script('jquery.scrolltop', get_stylesheet_directory_uri().'/js/jquery.scrolltop.js',array('jquery'),'','');
  wp_enqueue_script('child-lazyload', get_stylesheet_directory_uri().'/js/jquery.lazyload.min.js',array('jquery'),'','');
}
// add_action('wp_print_styles','montserrat_remove_google_fonts',200);
add_action('wp_enqueue_scripts', 'montserrat_remove_google_fonts', 100);

/*
* Create Header Logo
******/
// remove_action( 'header_logo', 'pacz_header_logo' );
// remove_action( 'header_mobile_logo', 'pacz_header_mobile_logo' );
// add_action( 'header_logo', 'pacz_header_logo' );
// add_action( 'header_mobile_logo', 'pacz_header_mobile_logo' );
if ( !function_exists( 'pacz_header_logo' ) ) {
	function paczheader_logo() {

		global $pacz_settings,$allowedtags;
		$logo = isset($pacz_settings['logo']['url']) ? $pacz_settings['logo']['url'] : '';
		$logo_retina = isset($pacz_settings['logo-retina']['url']) ? $pacz_settings['logo-retina']['url'] : '';
		$mobile_logo = isset($pacz_settings['mobile-logo']['url']) ? $pacz_settings['mobile-logo']['url'] : '';
		$mobile_logo_retina = isset($pacz_settings['mobile-logo-retina']['url']) ? $pacz_settings['mobile-logo-retina']['url'] : '';

		$post_id = global_get_post_id();

		if($post_id) {

			$enable = get_post_meta($post_id, '_custom_bg', true );

			if($enable == 'true') {
				$logo_meta = get_post_meta($post_id, 'logo', true );
				$logo_retina_meta = get_post_meta($post_id, 'logo_retina', true );
				$logo_mobile_meta = get_post_meta($post_id, 'responsive_logo', true );
				$logo_mobile_retina_meta = get_post_meta($post_id, 'responsive_logo_retina', true );

				$logo = (isset($logo_meta) && !empty($logo_meta)) ? $logo_meta : $logo;
				$logo_retina = (isset($logo_retina_meta) && !empty($logo_retina_meta)) ? $logo_retina_meta : $logo_retina;
				$mobile_logo = (isset($logo_mobile_meta) && !empty($logo_mobile_meta)) ? $logo_mobile_meta : $mobile_logo;
				$mobile_logo_retina = (isset($logo_mobile_retina_meta) && !empty($logo_mobile_retina_meta)) ? $logo_mobile_retina_meta : $mobile_logo_retina;
			}
		}

		//$mobile_logo_csss = (!empty($mobile_logo)) ? 'mobile-menu-exists' : '';

		$output = '<li class="pacz-header-logo">';
		$output .= '<a href="'.esc_url(home_url( '/' )).'" title="'.get_bloginfo( 'name' ).'">';

		if ( !empty( $logo ) ) {
			$output .= '<img data-id="1" alt="'.get_bloginfo( 'name' ).'" class="pacz-dark-logo" src="'.$logo.'" data-original="'.$logo.'" data-retina-src="'.$logo_retina.'" />';
		} else {
			$output .= '<img data-id="1" alt="'.get_bloginfo( 'name' ).'" class="pacz-dark-logo lazyload" data-original="'.PACZ_THEME_IMAGES.'/classiadspro-logo.png" data-retina-src="'.PACZ_THEME_IMAGES.'/classiadspro-logo-2x.png" />';
        }
        $output .= "<h1 class='c-title'>".get_bloginfo( 'description' )."</h1>";
		$output .= '</a></li>';
       

		echo wp_kses_post($output);

	  
	}  
}

if ( !function_exists( 'pacz_header_mobile_logo' ) ) {
	function pacz_header_mobile_logo() {

		global $pacz_settings,$allowedtags;
		$mobile_logo = isset($pacz_settings['mobile-logo']['url']) ? $pacz_settings['mobile-logo']['url'] : '';
		$mobile_logo_retina = isset($pacz_settings['mobile-logo-retina']['url']) ? $pacz_settings['mobile-logo-retina']['url'] : '';

		$post_id = global_get_post_id();

		if($post_id) {

			$enable = get_post_meta($post_id, '_custom_bg', true );

			if($enable == 'true') {
				$logo_mobile_meta = get_post_meta($post_id, 'responsive_logo', true );
				$logo_mobile_retina_meta = get_post_meta($post_id, 'responsive_logo_retina', true );
				
				$mobile_logo = (isset($logo_mobile_meta) && !empty($logo_mobile_meta)) ? $logo_mobile_meta : $mobile_logo;
				$mobile_logo_retina = (isset($logo_mobile_retina_meta) && !empty($logo_mobile_retina_meta)) ? $logo_mobile_retina_meta : $mobile_logo_retina;
			}
		}

		$mobile_logo_csss = (!empty($mobile_logo)) ? 'mobile-menu-exists' : '';

		$output = '';
		$output .= '<a href="'.esc_url(home_url( '/' )).'" title="'.get_bloginfo( 'name' ).'">';

		if ( !empty( $mobile_logo) ) {
			$output .= '<img alt="'.get_bloginfo( 'name' ).'" class="pacz-mobile-logo lazyload" data-original="'.$mobile_logo.'" data-retina-src="'.$mobile_logo_retina.'" />';
        }
        $output .= "<h1 class='c-title'>".get_bloginfo( 'description' )."</h1>";
		$output .= '</a>';
        
		echo wp_kses_post($output);
        
	}
}

/***************************************/



add_filter('digits_login_redirect','digits_login_redirect',200,1);

function digits_login_redirect(){
    return home_url('/my-dashboard');
}

  // set a variable to make it easy to enable and disable the purifycss feature
  // while testing, just append this parameter to your url: http://www.yourwebsite.com/?purifytest
  $purifyCssEnabled = array_key_exists('cleanCss',$_GET);

  // when you're done, set the variable to true - you will be able to disable it anytime with just one change
  // $purifyCssEnabled = true;
    
function dequeue_all_styles() {
    global $wp_styles;
    foreach( $wp_styles->queue as $style ) {
        wp_dequeue_style($wp_styles->registered[$style]->handle);
    }
}
    
function enqueue_pure_styles() {
  // wp_enqueue_style('theme-options', get_stylesheet_directory_uri().'/css/theme-option.css');
  wp_enqueue_style('pure-styles', get_stylesheet_directory_uri().'/styles.pure.css');
}
    /* Remove inline <style> blocks. */
function start_html_buffer() {
    // buffer output html
    ob_start();
}
function end_html_buffer() {
    // get buffered HTML
    $wpHTML = ob_get_clean();

    // remove <style> blocks using regular expression
    $wpHTML = preg_replace("/<style[^>]*>[^<]*<\/style>/m",'', $wpHTML);

    echo $wpHTML;
}


// add_action('wp_enqueue_scripts', 'dequeue_all_styles', PHP_INT_MAX - 1);
// add_action('template_redirect', 'dequeue_all_styles', PHP_INT_MAX - 1);
// add_action('wp_print_styles', 'enqueue_pure_styles', PHP_INT_MAX - 1);
if ($purifyCssEnabled) {
    // this will remove all enqueued styles in head
    add_action('wp_print_styles', 'dequeue_all_styles', PHP_INT_MAX - 1);
    // enqueue our purified css file
    add_action('wp_print_styles', 'enqueue_pure_styles', PHP_INT_MAX);
    
    add_action('template_redirect', 'start_html_buffer', 0); // wp hook just before the template is loaded
    add_action('wp_footer', 'end_html_buffer', PHP_INT_MAX); // wp hook after wp_footer()
        // if there are any plugins that print styles in body (like Elementor),
        // you'll need to remove them as well
        // add_action('elementor/frontend/after_enqueue_styles', 'dequeue_all_styles',PHP_INT_MAX);
}


add_action( 'admin_head',function(){
	wp_enqueue_script ( "jquery" );
	?>
	<script>
	var level_listingtypes = {level_listingtypes_array :{}};
</script>
<?php
} );
//NGO & Company Post List
add_shortcode( 'company-ngo-post-list', 'wpc_shortcode_company_ngo_post_list' );
function wpc_shortcode_company_ngo_post_list() {
    $cncat_args = array(
        'orderby'       => 'date', 
        'order'         => 'DESC',
        'hide_empty'    => true, 
    );
    $cnterms = get_terms("'taxonomy' => array( 'company-mm', 'ngo-ingo-mm')", $cncat_args);

    $cntax_post_args = array(
          'post_type' => 'alsp_listing',
          'posts_per_page' => 10,
          'orderby'       => 'date',
          'order' => 'DESC',
          'tax_query' => array(
                array(
                     'taxonomy' => 'alsp-category',
                     'field' => 'slug',
                     'terms' => ['company-mm','ngo-ingo-mm'],
                )
           )
    );

    $cntax_post_qry = new WP_Query($cntax_post_args);
    echo "<div style='height:300px;overflow:auto'><ul style='list-style-type:none'>";
    if($cntax_post_qry->have_posts()) :
       
         while($cntax_post_qry->have_posts()) :
                $cntax_post_qry->the_post();
            echo "<li style='padding-top:10px;padding-left:10px;padding-bottom:10px;background:#fffaff; margin:2px;'>";
                the_title('<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>');
                echo "</li>";

          endwhile;
    endif;
    echo "</ul></div>";
} //end foreach loop
?>
<?php wp_reset_postdata(); ?>

<?php
/*NotIn NGO & Company Post List*/
add_shortcode( 'Not-company-ngo-post-list', 'wpc_shortcode_not_company_ngo_post_list' );
function wpc_shortcode_not_company_ngo_post_list() {
  $cat_args = array(
      'orderby'       => 'date', 
      'order'         => 'DESC',
      'hide_empty'    => true, 
  );
  $terms = get_terms("'taxonomy' => array(
          'company-mm',
          'ngo-ingo-mm')", $cat_args);

    $tax_post_args = array(
          'post_type' => 'alsp_listing',
          'posts_per_page' => 10,
          'orderby'       => 'date',
          'order' => 'DESC',
          'tax_query' => array(
                array(
                     'taxonomy' => 'alsp-category',
                     'field' => 'slug',
                     'terms' => ['company-mm','ngo-ingo-mm'],
                     'operator' => 'NOT IN',
                )
           )
    );

    $tax_post_qry = new WP_Query($tax_post_args);
    echo "<div style='height:300px;overflow:auto'><ul style='list-style-type:none'>";
    if($tax_post_qry->have_posts()) :
       
         while($tax_post_qry->have_posts()) :
                $tax_post_qry->the_post();
            echo "<li style='padding-top:10px;padding-left:10px;padding-bottom:10px;background:#fffaff; margin:2px;'>";
                the_title('<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>');
                echo "</li>";

          endwhile;
    endif;
    echo "</ul></div>";
} //end foreach loop
//NOTNGO End
//slider start
// add_shortcode( 'home-page-slider', 'wpc_shortcode_home_page_slider' );
add_shortcode( 'home-page-slider', 'home_page_slider' );

function home_page_slider(){
  echo '<div class="slider-home">
    <div class=""><img data-sizes="100vw" data-srcset="/wp-content/uploads/2020/09/Ads-4-MMTender-Banner.jpg" data-lazy="/wp-content/uploads/2020/09/Ads-4-MMTender-Banner.jpg" alt=""></div>
    <div class=""><img data-sizes="100vw" data-srcset="/wp-content/uploads/2020/09/Ads-Slidder-010.jpg" data-lazy="/wp-content/uploads/2020/09/Ads-Slidder-010.jpg" alt=""></div>
  </div>';

}
function wpc_shortcode_home_page_slider() {
    echo "<rs-module-wrap id='rev_slider_14_1_wrapper' data-alias='blur-effect-slider' data-source='gallery' style='background:#2d3032;padding:0;margin:0px auto;margin-top:0;margin-bottom:0;'>";
       echo " <rs-module id='rev_slider_14_1' style='display:none;' data-version='6.2.2'>";
           echo "<rs-slides>
                <rs-slide data-key='rs-41' data-title='One' data-thumb='https://mmtender.com/wp-content/uploads/2020/09/Ads-Slidder-010-100x50.jpg' data-anim='ei:d;eo:d;s:d;r:0;t:fadethroughtransparent;sl:d;' data-firstanim='t:fade;sl:7;'>
                <img src='//mmtender.com/wp-content/uploads/2020/09/Ads-Slidder-010.jpg' title='Ads Slidder 010' width='1500' height='437' data-parallax='6' class='rev-slidebg' data-no-retina>
    <!---->           </rs-slide>
                <rs-slide data-key='rs-43' data-title='Three' data-thumb='//mmtender.com/wp-content/uploads/2020/09/Ads-4-MMTender-Banner-100x50.jpg' data-anim='ei:d;eo:d;s:d;r:0;t:fadethroughtransparent;sl:d;'>
                <img src='//mmtender.com/wp-content/uploads/2020/09/Ads-4-MMTender-Banner.jpg' title='Ads 4 MMTender Banner' width='3244' height='945' data-parallax='6' class='rev-slidebg' data-no-retina>
      <!---->           </rs-slide>
            </rs-slides>";
           echo " <rs-static-layers><!--
          --></rs-static-layers>
          <rs-progress style='height: 10px; background: rgba(255,255,255,0.25);'></rs-progress>";
       echo " </rs-module>";
       echo " <script type='text/javascript'>
          setREVStartSize({c: 'rev_slider_14_1',rl:[1240,1024,778,480],el:[368,268,480,480],gw:[1520,1024,1037,1034],gh:[368,268,480,480],type:'standard',justify:'',layout:'fullwidth',mh:'0'});
          var revapi14,
            tpj;
          jQuery(function() {
            tpj = jQuery;
            if(tpj('#rev_slider_14_1').revolution == undefined){
              revslider_showDoubleJqueryError('#rev_slider_14_1');
            }else{
              revapi14 = tpj('#rev_slider_14_1').show().revolution({
                jsFileLocation:'//mmtender.com/wp-content/plugins/revslider/public/assets/js/',
                sliderLayout:'fullwidth',
                duration:'5000ms',
                visibilityLevels:'1240,1024,778,480',
                gridwidth:'1520,1024,1037,1034',
                gridheight:'368,268,480,480',
                spinner:'spinner3',
                editorheight:'368,268,480,480',
                responsiveLevels:'1240,1024,778,480',
                navigation: {
                  keyboard_direction:'vertical',
                  mouseScrollNavigation:false,
                  onHoverStop:false,
                  touch: {
                    touchenabled:true
                  },
                  bullets: {
                    enable:true,
                    tmp:'<span class=\'tp-bullet-image\'></span>',
                    style:'hebe',
                    v_offset:40
                  }
                },
                parallax: {
                  levels:[5,10,15,20,25,30,35,40,45,46,47,48,49,50,51,55],
                  type:'scroll',
                  origo:'slidercenter'
                },
                scrolleffect: {
                  set:true,
                  maxblur:20,
                  slide:true,
                  direction:'top',
                  multiplicator:2,
                  multiplicator_layers:2,
                  tilt:10
                },
                fallbacks: {
                  allowHTML5AutoPlayOnAndroid:true
                },
              });
            }
            
          });
        </script>";
        
     
        echo "<script>
          var htmlDivCss = unescape('%0A%23rev_slider_14_1_wrapper%20.hebe.tp-bullets%3Abefore%20%7B%0A%20%20content%3A%27%20%27%3B%0A%20%20position%3Aabsolute%3B%0A%20%20width%3A100%25%3B%0A%20%20height%3A100%25%3B%0A%20%20background%3Atransparent%3B%0A%20%20padding%3A10px%3B%0A%20%20margin-left%3A-10px%3Bmargin-top%3A-10px%3B%0A%20%20box-sizing%3Acontent-box%3B%0A%7D%0A%0A%23rev_slider_14_1_wrapper%20.hebe%20.tp-bullet%20%7B%0A%20%20width%3A3px%3B%0A%20%20height%3A3px%3B%0A%20%20position%3Aabsolute%3B%0A%20%20background%3A%23ffffff%3B%20%20%0A%20%20cursor%3A%20pointer%3B%0A%20%20border%3A5px%20solid%20%23000000%3B%0A%20%20border-radius%3A50%25%3B%0A%20%20box-sizing%3Acontent-box%3B%0A%20%20-webkit-perspective%3A400%3B%0A%20%20perspective%3A400%3B%0A%20%20-webkit-transform%3Atranslatez%280.01px%29%3B%0A%20%20transform%3Atranslatez%280.01px%29%3B%0A%20%20%20transition%3Aall%200.3s%3B%0A%7D%0A%23rev_slider_14_1_wrapper%20.hebe%20.tp-bullet%3Ahover%2C%0A%23rev_slider_14_1_wrapper%20.hebe%20.tp-bullet.selected%20%7B%0A%20%20background%3A%23000000%3B%0A%20%20border-color%3A%23ffffff%3B%0A%7D%0A%0A%23rev_slider_14_1_wrapper%20.hebe%20.tp-bullet-image%20%7B%0A%20%20position%3Aabsolute%3B%0A%20%20width%3A70px%3B%0A%20%20height%3A70px%3B%0A%20%20background-position%3Acenter%20center%3B%0A%20%20background-size%3Acover%3B%0A%20%20visibility%3Ahidden%3B%0A%20%20opacity%3A0%3B%0A%20%20bottom%3A3px%3B%0A%20%20transition%3Aall%200.3s%3B%0A%20%20-webkit-transform-style%3Aflat%3B%0A%20%20transform-style%3Aflat%3B%0A%20%20perspective%3A600%3B%0A%20%20-webkit-perspective%3A600%3B%0A%20%20transform%3A%20scale%280%29%20translateX%28-50%25%29%20translateY%280%25%29%3B%0A%20%20-webkit-transform%3A%20scale%280%29%20translateX%28-50%25%29%20translateY%280%25%29%3B%0A%20%20transform-origin%3A0%25%20100%25%3B%0A%20%20-webkit-transform-origin%3A0%25%20100%25%3B%0A%20%20margin-bottom%3A15px%3B%0A%20border-radius%3A6px%3B%0A%7D%0A%23rev_slider_14_1_wrapper%20.hebe%20.tp-bullet%3Ahover%20.tp-bullet-image%20%7B%0A%20%20display%3Ablock%3B%0A%20%20opacity%3A1%3B%0A%20%20transform%3A%20scale%281%29%20translateX%28-50%25%29%20translateY%280%25%29%3B%0A%20%20-webkit-transform%3A%20scale%281%29%20translateX%28-50%25%29%20translateY%280%25%29%3B%0A%20%20visibility%3Avisible%3B%0A%7D%0A%0A%0A%2F%2A%20VERTICAL%20%2A%2F%0A%0A%23rev_slider_14_1_wrapper%20.hebe.nav-dir-vertical%20.tp-bullet-image%20%7B%0A%20%20bottom%3Aauto%3B%0A%20%20margin-right%3A15px%3B%0A%20%20margin-bottom%3A0px%3B%0A%20%20right%3A3px%3B%0A%20%20transform%3A%20scale%280%29%20translateX%280px%29%20translateY%28-50%25%29%3B%0A%20%20-webkit-transform%3A%20scale%280%29%20translateX%280px%29%20translateY%28-50%25%29%3B%0A%20%20transform-origin%3A100%25%200%25%3B%0A%20%20-webkit-transform-origin%3A100%25%200%25%3B%0A%7D%0A%0A%23rev_slider_14_1_wrapper%20.hebe.nav-dir-vertical%20.tp-bullet%3Ahover%20.tp-bullet-image%20%7B%0A%20%20transform%3A%20scale%281%29%20translateX%280px%29%20translateY%28-50%25%29%3B%0A%20%20-webkit-transform%3A%20scale%281%29%20translateX%280px%29%20translateY%28-50%25%29%3B%0A%7D%0A%0A%2F%2A%20VERTICAL%20LEFT%20%2A%2F%0A%0A%23rev_slider_14_1_wrapper%20.hebe.nav-dir-vertical.nav-pos-hor-left%20.tp-bullet-image%20%7B%0A%20%20bottom%3Aauto%3B%0A%20%20margin-left%3A15px%3B%0A%20%20margin-bottom%3A0px%3B%0A%20%20left%3A3px%3B%0A%20%20transform%3A%20scale%280%29%20translateX%280px%29%20translateY%28-50%25%29%3B%0A%20%20-webkit-transform%3A%20scale%280%29%20translateX%280px%29%20translateY%28-50%25%29%3B%0A%20%20transform-origin%3A0%25%200%25%3B%0A%20%20-webkit-transform-origin%3A0%25%200%25%3B%0A%7D%0A%0A%23rev_slider_14_1_wrapper%20.hebe.nav-dir-vertical.nav-pos-hor-left%20.tp-bullet%3Ahover%20.tp-bullet-image%20%7B%0A%20%20transform%3A%20scale%281%29%20translateX%280px%29%20translateY%28-50%25%29%3B%0A%20%20-webkit-transform%3A%20scale%281%29%20translateX%280px%29%20translateY%28-50%25%29%3B%0A%7D%0A%0A%2F%2A%20HORIZONTAL%20TOP%20%2A%2F%0A%23rev_slider_14_1_wrapper%20.hebe.nav-pos-ver-top.nav-dir-horizontal%20.tp-bullet-image%20%7B%0A%20%20bottom%3Aauto%3B%0A%20%20top%3A3px%3B%0A%20%20transform%3A%20scale%280%29%20translateX%28-50%25%29%20translateY%280%25%29%3B%0A%20%20-webkit-transform%3A%20scale%280%29%20translateX%28-50%25%29%20translateY%280%25%29%3B%0A%20%20transform-origin%3A0%25%200%25%3B%0A%20%20-webkit-transform-origin%3A0%25%200%25%3B%0A%20%20margin-top%3A15px%3B%0A%20%20margin-bottom%3A0px%3B%20%20%0A%7D%0A%23rev_slider_14_1_wrapper%20.hebe.nav-pos-ver-top.nav-dir-horizontal%20.tp-bullet%3Ahover%20.tp-bullet-image%20%7B%0A%20%20transform%3A%20scale%281%29%20translateX%28-50%25%29%20translateY%280%25%29%3B%0A%20%20-webkit-transform%3A%20scale%281%29%20translateX%28-50%25%29%20translateY%280%25%29%3B%0A%7D%0A');
          var htmlDiv = document.getElementById('rs-plugin-settings-inline-css');
          if(htmlDiv) {
            htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
          }else{
            var htmlDiv = document.createElement('div');
            htmlDiv.innerHTML = '<style>' + htmlDivCss + '</style>';
            document.getElementsByTagName('head')[0].appendChild(htmlDiv.childNodes[0]);
          }
        </script>";
   
      echo "</rs-module-wrap>";
}
//Slider End