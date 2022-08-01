<?php
/*
Plugin Name: Directory 
Plugin URI: 
Description: 
Author: Talha Hassan 
Version: 0.1
Author URI: 
*/
// Register Custom Post Type
function custom_post_type() {

  $labels = array(
    'name'                  => _x( 'Directories', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Directory', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Directory', 'text_domain' ),
    'name_admin_bar'        => __( 'Directory', 'text_domain' ),
    'archives'              => __( 'Item Archives', 'text_domain' ),
    'attributes'            => __( 'Item Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
    'all_items'             => __( 'All Items', 'text_domain' ),
    'add_new_item'          => __( 'Add New Item', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Item', 'text_domain' ),
    'edit_item'             => __( 'Edit Item', 'text_domain' ),
    'update_item'           => __( 'Update Item', 'text_domain' ),
    'view_item'             => __( 'View Item', 'text_domain' ),
    'view_items'            => __( 'View Items', 'text_domain' ),
    'search_items'          => __( 'Search Item', 'text_domain' ),
    'not_found'             => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
    'featured_image'        => __( 'Featured Image', 'text_domain' ),
    'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
    'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
    'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
    'items_list'            => __( 'Items list', 'text_domain' ),
    'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
    'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
  );
  $args = array(
    'label'                 => __( 'Directory', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'thumbnail' ),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'directory', $args ); //Id of custom post type is directory

}
add_action( 'init', 'custom_post_type', 0 );

// Register Custom Taxonomy
function custom_taxonomy() {

  $labels = array(
    'name'                       => _x( 'Categories', 'Taxonomy General Name', 'text_domain' ),
    'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'text_domain' ),
    'menu_name'                  => __( 'Category', 'text_domain' ),
    'all_items'                  => __( 'All Items', 'text_domain' ),
    'parent_item'                => __( 'Parent Item', 'text_domain' ),
    'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
    'new_item_name'              => __( 'New Item Name', 'text_domain' ),
    'add_new_item'               => __( 'Add New Item', 'text_domain' ),
    'edit_item'                  => __( 'Edit Item', 'text_domain' ),
    'update_item'                => __( 'Update Item', 'text_domain' ),
    'view_item'                  => __( 'View Item', 'text_domain' ),
    'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
    'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
    'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
    'popular_items'              => __( 'Popular Items', 'text_domain' ),
    'search_items'               => __( 'Search Items', 'text_domain' ),
    'not_found'                  => __( 'Not Found', 'text_domain' ),
    'no_terms'                   => __( 'No items', 'text_domain' ),
    'items_list'                 => __( 'Items list', 'text_domain' ),
    'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( 'directory_cat', array( 'directory' ), $args );

}
add_action( 'init', 'custom_taxonomy', 0 );

// Add Shortcode
function display_directory_list( $atts ) {

  // Attributes
  $atts = shortcode_atts(
    array(
      'limit' => '',
    ),
    $atts
  );

  // custom post query
$args = array(
    'post_type'      => 'directory',
    'posts_per_page' => 5,
);
$loop = new WP_Query($args);
while ( $loop->have_posts() ) {
    $loop->the_post();
    ?>
    <div class="entry-content">
      <?php
         if (has_post_thumbnail()){
          the_post_thumbnail();
         }

       ?>
      <?php the_title(); ?>
    </div>
    <?php
}

}
add_shortcode( 'directory_list', 'display_directory_list' );

add_action( 'add_meta_boxes', 'directory_contact_add_meta_box' );
add_action( 'save_post', 'directory_save_contact_email_data' );
add_action( 'save_post', 'directory_save_contact_number_data' );
add_action( 'save_post', 'directory_save_contact_dob_data' );
add_action( 'save_post', 'directory_save_contact_gender_data' );
/* CONTACT META BOXES */

function directory_contact_add_meta_box() {
  add_meta_box( 'contact_email', 'User Email', 'directory_contact_email_callback', 'directory', 'normal' );
  add_meta_box( 'contact_number', 'Contact Number', 'directory_contact_number_callback', 'directory', 'normal' );
  add_meta_box( 'contact_dob', 'Date of Birth', 'directory_contact_dob_callback', 'directory', 'normal' );
  
}

function directory_contact_email_callback( $post ) {
  wp_nonce_field( 'directory_save_contact_email_data', 'directory_contact_email_meta_box_nonce' );
  
  $value = get_post_meta( $post->ID, '_contact_email_value_key', true );
  
  echo '<label for="directory_contact_email_field">User Email Address: </lable>';
  echo '<input type="email" id="directory_contact_email_field" name="directory_contact_email_field" value="' . esc_attr( $value ) . '" size="25" />';
}

function directory_save_contact_email_data( $post_id ) {
  
  if( ! isset( $_POST['directory_contact_email_meta_box_nonce'] ) ){
    return;
  }
  
  if( ! wp_verify_nonce( $_POST['directory_contact_email_meta_box_nonce'], 'directory_save_contact_email_data') ) {
    return;
  }
  
  if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
    return;
  }
  
  if( ! current_user_can( 'edit_post', $post_id ) ) {
    return;
  }
  
  if( ! isset( $_POST['directory_contact_email_field'] ) ) {
    return;
  }
  
  $my_data = sanitize_text_field( $_POST['directory_contact_email_field'] );
  
  update_post_meta( $post_id, '_contact_email_value_key', $my_data );
  
}

//Number Meta Box
function directory_contact_number_callback( $post ) {
  wp_nonce_field( 'directory_save_contact_number_data', 'directory_contact_number_meta_box_nonce' );
  
  $value = get_post_meta( $post->ID, '_contact_number_value_key', true );
  
  echo '<label for="directory_contact_number_field">User Mobile Number: </lable>';
  echo '<input type="tel" id="directory_contact_number_field" pattern ="[0-9]{11}" name="directory_contact_number_field" value="' . esc_attr( $value ) . '" size="25" />';
}

function directory_save_contact_number_data( $post_id ) {
  
  if( ! isset( $_POST['directory_contact_number_meta_box_nonce'] ) ){
    return;
  }
  
  if( ! wp_verify_nonce( $_POST['directory_contact_number_meta_box_nonce'], 'directory_save_contact_number_data') ) {
    return;
  }
  
  if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
    return;
  }
  
  if( ! current_user_can( 'edit_post', $post_id ) ) {
    return;
  }
  
  if( ! isset( $_POST['directory_contact_number_field'] ) ) {
    return;
  }
  
  $my_data = sanitize_text_field( $_POST['directory_contact_number_field'] );
  
  update_post_meta( $post_id, '_contact_number_value_key', $my_data );
  
}

//DOB Meta Box
function directory_contact_dob_callback( $post ) {
  wp_nonce_field( 'directory_save_contact_dob_data', 'directory_contact_dob_meta_box_nonce' );
  
  $value = get_post_meta( $post->ID, '_contact_dob_value_key', true );
  
  echo '<label for="directory_contact_dob_field">Date of Birth: </lable>';
  echo '<input type="date" id="directory_contact_dob_field" name="directory_contact_dob_field" value="' . esc_attr( $value ) . '" size="25" />';
}

function directory_save_contact_dob_data( $post_id ) {
  
  if( ! isset( $_POST['directory_contact_dob_meta_box_nonce'] ) ){
    return;
  }
  
  if( ! wp_verify_nonce( $_POST['directory_contact_dob_meta_box_nonce'], 'directory_save_contact_dob_data') ) {
    return;
  }
  
  if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
    return;
  }
  
  if( ! current_user_can( 'edit_post', $post_id ) ) {
    return;
  }
  
  if( ! isset( $_POST['directory_contact_dob_field'] ) ) {
    return;
  }


  
  $my_data = sanitize_text_field( $_POST['directory_contact_dob_field'] );

  
  update_post_meta( $post_id, '_contact_dob_value_key', $my_data );
  
}
