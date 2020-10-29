<?php 

function get_content_fields(){
    global $alsp_instance;
    $content_fields = $alsp_instance->content_fields->content_fields_array;
    
    return $content_fields;
}
function get_content_field_for_selection(){

    $content_fields = get_content_fields();
    $content_selections = [];
    foreach( $content_fields as $key=>$content ){
        if( $content->selection_items ){
            $content_selections[$key] = $content;
        }
    }
    return $content_selections;
}
function get_content_field_for_selection_dropdown($taxwraps, $post_type = 'alsp_listing', $labels = true, $names = false, $values = array()){

    if( $post_type == 'alsp_listing' ){
        $content_fields 	= get_content_field_for_selection();
        foreach( $content_fields as $id=>$content ){     
       
            $selects 			= array();

            $content_tax = '<div class="dynamic_embed_options_taxonomy_container">' . ( $labels ? '<label class="dynamic_embed_options_taxonomy_label">' . $content->name . ': </label>' : '' ) . '<span class="dynamic_embed_options_taxonomy_wrap">';

            $select	= '<select class="dynamic_embed_options_taxonomy check-for-posts" ' . ( $names ? 'name="mailster_data[autoresponder]['.$content->slug.'][]"' : '' ) . '>';
            $select .= '<option value="-1" >' . sprintf( esc_html__( 'any %s', 'mailster' ), $content->name ) . '</option>';
            foreach( $content->selection_items as $meta_id=>$item ){	
                // $value   = "_content_field_{$meta_id}";
                $value   = "{$meta_id}";
                $select .= '<option value="'.$value.'" ' . selected( $value, $term, false ) . '>' . $item . '</option>';
            }				
            $select	.= '</select>';

            $selects[]		= $select;

            $content_tax .= implode( ' ' . esc_html__( 'or', 'mailster' ) . ' ', $selects );
    
            $content_tax .= '</span><div class="mailster-list-operator"><span class="operator-and">' . esc_html__( 'and', 'mailster' ) . '</span></div></div>';
    
            $taxwraps[] = $content_tax;
        }
    }
    return $taxwraps;

}
function implode_term_ids_and_meta_args( $term_ids = array(), $post_type = "alsp_listing"){
    if( empty( $term_ids ) || $post_type != 'alsp_listing' ) return false;
    $term_ids = $term_ids;
    // $term_ids = explode( ";", $term_ids );
    $taxonomies = get_object_taxonomies( $post_type, 'names' );
    update_option( 'check_post_term_ids_before', $term_ids, 'no' );

    $meta     = [];
    for( $i = 0; $i <=count( $term_ids ); $i++ ){
        if( !array_key_exists( $i, $taxonomies )  ){
            $meta[] = explode( ',', $term_ids[$i] );
            unset( $term_ids[$i] );
        }
    }
    $content_fields = get_content_field_for_selection();
    if( !empty( $meta ) ){
        // $meta = count( $meta ) == 1 : $meta 
        if( count( $meta ) == 1 ) $meta[] = "";
        $meta = array_combine( array_keys( $content_fields ), $meta );
    }

    update_option( 'check_post_content_field_meta', $meta, 'no' );
    update_option( 'check_post_term_ids_after', $term_ids, 'no' );
    // check_post_content_field_meta
    // check_ajax_check_for_posts_args
    $args = get_meta_args_for_newsletter( $meta );
    // update_option( 'news_args_me', $args, 'yes' );

    return [ $term_ids, $args];
   
}
function get_meta_args_for_newsletter( $meta ){
    if( empty( $meta ) ) return [];
    $args       = [];
    
    foreach( $meta as $content_key => $vals ){
        $meta_key   = "_content_field_{$content_key}";
        if( is_array( $vals ) && count( $vals ) > 1 ){
            
            $arr_meta = array( 'relation' => 'OR', );
                foreach( $vals as $val ){
                    $arr_meta[] = array(
                        'key'     => $meta_key,
                        'value'   => $val,
                        'compare' => '='
                    );
                }
            $args[] = $arr_meta;
        }else{
            
            $arr_meta = array(
                'key'     => $meta_key,
                'value'   => $vals[0],
                'compare' => '='
            );
            if( $vals[0] )
                $args[] = $arr_meta;
        }
    }

    return ['meta_query'=> $args,'suppress_filters' => 0 ];
}

function checking_my_changes( $debug = false ){
    $check_meta      = get_option( 'check_post_content_field_meta' );
    $check_terms_b   = get_option( 'check_post_term_ids_before' );
    $check_terms_a   = get_option( 'check_post_term_ids_after' );
    $check_args      = get_option( 'check_ajax_check_for_posts_args' );
    $get_hits        = get_option( 'get_hits' );
    $check_dynamic   = get_option( 'check_for_replace_dynamic' );
    $modules         = get_option( 'modules ' );
    $select_box_html = implode('<label class="dynamic_embed_options_taxonomy_label">&nbsp;</label>',
        get_content_field_for_selection_dropdown([])
    );

    $return = [ 
        'meta_ids'           => $check_meta, 
        'check_terms_b'      => $check_terms_b, 
        'check_terms_a'      => $check_terms_a, 
        'check_args_in_ajax' => $check_args, 
        'get_hits'           => $get_hits, 
        'check_dynamic'           => $check_dynamic, 
        'modules'            => $modules,    
        'select_box_html'    => $select_box_html 
    ];
    if( !$debug ) unset( $return['select_box_html'] );
        // array_pop( $return );
    return $return;
}

function _implode_term_ids_and_meta_ids( $term_ids = null ){
    
    $term_ids = $term_ids ?? ';;;;2,1;21';
    $term_ids = explode( ";", $term_ids );
    $taxonomies = get_object_taxonomies( 'alsp_listing', 'names' );
    $meta     = [];
    for( $i = 0; $i <=count( $term_ids ); $i++ ){
        if( !array_key_exists( $i, $taxonomies )  ){
            $meta[] = explode( ',', $term_ids[$i] );
            unset( $term_ids[$i] );
        }
    }
    $content_fields = get_content_field_for_selection();
    if( !empty( $meta ) )
        $meta = array_combine( array_keys( $content_fields ), $meta );

    return ['term_ids'=> $term_ids, 'meta_ids'=> $meta];
   
}
add_action( 'wp_footer', function(){
    
    $term_ids =  ';;;;2,1;21';
    $term_ids = explode( ";", $term_ids );
    $term_and_meta = _implode_term_ids_and_meta_ids();
    // output( $term_and_meta );
    // list( $terms, $args ) = implode_term_ids_and_meta_args( $term_ids );
    $my_checker = checking_my_changes();
    // output( $my_checker['check_dynamic'] );
    $content = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut placeat amet suscipit ut [alsp_listing_title:-3;;;;;1,3;88] libero tenetur id, porro ullam quidem, deleniti, assumenda eius officia {alsp_listing_title:-4;;;;;1,3;88} unde quasi ipsam ab fugiat minima. Perspiciatis.";
    // output( do_shortcode( $content ) );
    // output( strpos( $content, '{' )  );
        $modules = get_option( 'modules' );
        foreach ( $modules[0] as $i => $html ) {

            $search         = $modules[0][ $i ];
            $tag            = $modules[1][ $i ];
            $post_type      = $modules[2][ $i ];
            $post_or_offset = $modules[4][ $i ];
            $type           = $modules[3][ $i ];
            $term_ids       = ! empty( $modules[6][ $i ] ) ? explode( ';', trim( $modules[6][ $i ] ) ) : array();

            // output( $search );
            // output( $tag );
            // output( $post_type );
            // output( $post_or_offset );
            // output( $type );
            // output( $term_ids );
        }

    $pts = mailster( 'helper' )->get_dynamic_post_types();
    $pts = implode( '|', $pts );
    $count = preg_match_all( '#\{(!)?((' . $pts . ')_([^}]+):(-|~)?([\d]+)(;([0-9;,-]+))?)\}#i', "{alsp_listing_title:-3;;;;;1,3;88}{alsp_listing_title:-4;;;;;1,3;88}", $hits );
    // output( $count );
    // output( $hits );
} );
function output($ary){
    echo "<pre>";
    print_r( $ary );
    echo "</pre>";
}

function my_add_option( $name, $val ){
    $option_name = $name ;
    $new_value = $val;
    
    if ( get_option( $option_name ) !== false ) {
    
        // The option already exists, so update it.
        update_option( $option_name, $new_value );
    
    } else {
    
        // The option hasn't been created yet, so add it with $autoload set to 'no'.
        $deprecated = null;
        $autoload = 'no';
        add_option( $option_name, $new_value, $deprecated, $autoload );
    }
}

add_action( 'admin_footer', function(){
    if ( get_option( 'nhs_has_content' ) !== false ) {    
        // The option already exists, so update it.
        output( get_option( 'nhs_has_content' ) );  
    }
    if ( get_option( 'nhs_not_has_content' ) !== false ) {    
        // The option already exists, so update it.
        output( get_option( 'nhs_not_has_content' ) );  
    }
} );