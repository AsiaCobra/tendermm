<?php 



class CustomRssFeed{



    protected $content_fields = [];



    protected $fields_parametars = [];

    protected $meta_queries        = [];



    public function __construct(){

        global $alsp_instance;

            $content_fields = $alsp_instance->content_fields->content_fields_array;

            foreach($content_fields as $key=>$content){



                $this->content_fields[$content->slug] = $content->selection_items;

                $this->fields_parametars[$content->slug] = $content->id; 

            }

            add_filter('pre_get_posts',[$this,'post_meta_feed_filter']);



    }



    public function post_meta_feed_filter($query){

        if ($query->is_feed) {

            $meta_value = $_REQUEST['tender_field'];

            $meta_key = '_content_field_92';

            // var_dump($meta_value);

            if(isset($_REQUEST['tender_field'])){
                    $query->set('meta_key','_content_field_92');

            $query->set('meta_value',$_GET['tender_field']);
            $query->set('meta_compare','=');
                //  $query->set('meta_query',[

                //     [

                //         'meta_key'=>$meta_key,

                //         'meta_value'=>$meta_value,

                //         'compare'=>'='

                //     ]

                // ]);

            } 





            // $this->meta_queries = $this->validate_meta_value();

            // if( count($this->meta_queries) > 0 )

            //     $query->set('meta_query',$this->meta_queries);





            // var_dump($this->content_fields);

            // var_dump($this->fields_parametars);

            

            // $query->set('meta_key','_content_field_92');

            // $query->set('meta_value',$_GET['tender_field']);

            // $query->set('numberposts','-1'); //Don't forget to change the category ID =^o^=

            // $query->set('post_status','public'); 

        }

        return $query;

    }



    public function validate_meta_value(){

        

        $meta_query = [];

        foreach( $this->content_fields as $key=>$content ){

            

            // $data = $content;

            // var_dump($key);

            

            

            if( isset($_GET[$key]) ){

                $field_id = $this->fields_parametars[$key];

                var_dump($field_id);

                $post_meta_key = "_content_field_"+$field_id;

                $meta_value =sanitize_text_field($_GET[$key]);

                var_dump($meta_value);

            



                    $input = preg_quote($meta_value, '~'); // don't forget to quote input string!

                    $result = preg_grep('~' . $input . '~', $content);

                    $value_ids = [];

                    if($result){

                        // var_dump($result);

                        foreach($result as $key=>$val){

    

                            $value_ids[] = $key;

                        }

                        $meta_query[] = [

                            'key'=>$post_meta_key,

                            'value'=>$value_ids,

                            'compare'=>'='

                        ];

                    }else{

                        $meta_query[] = [

                            'key'=>$post_meta_key,

                            'value'=>$meta_value,

                            'compare'=>'='

                        ];

                    }

                



            }

        }

        // var_dump($meta_query);

        return $meta_query;

        // if( count($meta_query) > 0 ) $this->meta_query['meta_query'] = $meta_query;

    }

}

new CustomRssFeed;