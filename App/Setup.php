<?php
declare(strict_types=1);
namespace WrOOP;

class Setup {
    private $rest_fields;

    public function __construct() {
        new Setup\Activation();
        new Setup\Enqueues();
        new Setup\Deactivation();
        $this->rest_fields = ['skills', 'candidate', 'wr_date'];
        add_action('init', [$this, 'wr_register_custom_post_type']);
        add_action('init', [$this, 'wr_add_job_metas']);
        add_action( 'rest_api_init', [$this, 'wr_register_custom_rest_fields']);
        add_action('init', [$this, 'wr_register_blocks']);
    }

    public function wr_register_custom_post_type(){
        $labels = [
            'name'                  => _x( 'job title', 'Post type general name', 'wp-riders' ),
            'singular_name'         => _x( 'job title', 'Post type singular name', 'wp-riders' ),
            'menu_name'             => _x( 'job titles', 'Admin Menu text', 'wp-riders' ),
            'name_admin_bar'        => _x( 'job title', 'Add New on Toolbar', 'wp-riders' ),
            'add_new'               => __( 'Add New', 'wp-riders' ),
            'add_new_item'          => __( 'Add New job title', 'wp-riders' ),
            'new_item'              => __( 'New job title', 'wp-riders' ),
            'edit_item'             => __( 'Edit job title', 'wp-riders' ),
            'view_item'             => __( 'View job title', 'wp-riders' ),
            'all_items'             => __( 'All job titles', 'wp-riders' ),
            'search_items'          => __( 'Search job title', 'wp-riders' ),
            'parent_item_colon'     => __( 'Parent job title:', 'wp-riders' ),
            'not_found'             => __( 'No job title found.', 'wp-riders' ),
            'not_found_in_trash'    => __( 'No job title found in Trash.', 'wp-riders' ),
            'featured_image'        => _x( 'job title Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'wp-riders' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'wp-riders' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'wp-riders' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'wp-riders' ),
            'archives'              => _x( 'job title archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'wp-riders' ),
            'insert_into_item'      => _x( 'Insert into job title', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'wp-riders' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this job title', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'wp-riders' ),
            'filter_items_list'     => _x( 'Filter job titles list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'wp-riders' ),
            'items_list_navigation' => _x( 'job title list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'wp-riders' ),
            'items_list'            => _x( 'job title list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'wp-riders' ),
        
        ];
            
        $args                       =  [
            'labels'                =>  $labels,
            'description'           =>  'A custom post type for job title',
            'menu_icon'             => 'dashicons-businessperson',
            'public'                =>  true,
            'publicly_queryable'    =>  true,
            'show_ui'               =>  true,
            'show_in_menu'          =>  true,
            'query_var'             =>  true,
            'rewrite'               =>  array( 'slug' => 'job title' ),
            'capability_type'       =>  'post',
            'has_archive'           =>  true,
            'hierarchical'          =>  false,
            'menu_position'         =>  1,
            'supports'              =>  [ 'title' ],
            'taxonomies'            =>  [ 'category', 'post_tag' ],
            'show_in_rest'          =>  true
        ];
     
        register_post_type( 'wr-job-title', $args );

    }

    public function wr_add_job_metas(){
        $entry_metas = [
            'skills'    => 'A json based array to be updated',
            'candidate' => 'The name of the candidate',
            'wr_date'   => 'The entry date of the application'
        ];
    
        foreach($entry_metas as $meta_key => $description){
            register_post_meta('wr-job-title', $meta_key, [
                'type' => 'string',
                'description' => $description,
                'default' => '',
                'show_in_rest' => true
              ]);
        }  
    }

    public function wr_register_custom_rest_fields() {
        foreach($this->rest_fields as $meta_key){
            if(isset($meta_key)){
                register_rest_field(
                    'wr-job-title',
                    $meta_key,
                    [
                        'get_callback' => function( $post_arr ) use ($meta_key) {
                            return get_post_meta( $post_arr['id'], $meta_key, true );
                        },
                        'update_callback' => function( $value, $post_obj ) use ($meta_key) {
                            return update_post_meta( $post_obj->ID, $meta_key, $meta_key );
                        },
                        'schema' => [
                            'type' => 'string',
                            'description' => 'A json based array to be updated',
                            'context' => ['view', 'edit'],
                        ]
                    ]
                );
            }
            
        }
    }

    public function wr_register_blocks(){
        $blocks = [
            [ 'name' => 'job-application' ],
            [ 'name' => 'wr-select-form', 'options' => [
                'render_callback' => 'wr_select_form'
              ]],
              [ 'name' => 'wr-job-table', 'options' => [
                'render_callback' => 'wr_job_table'
              ]],
              [ 'name' => 'wr-application-form', 'options' => [
                'render_callback' => 'wr_application_form'
              ]]
        ];
        foreach($blocks as $block) {
          register_block_type(
            WR_OPP_PLUGIN_DIR . 'build/blocks/' . $block['name'],
            isset($block['options']) ? $block['options'] : []
          );
        }
    }
}
