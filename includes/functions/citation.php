<?php
function citation_metabox(){
    add_meta_box(
                    'citation-wysiwyg-editor',
                    'Citation',
                    'citation_callback',
                    'post'
              );
}
add_action('add_meta_boxes', 'citation_metabox');
 
function citation_callback(){
    global $post;
      $citation_editor = get_post_meta($post->ID, '_citation_editor', true);
      wp_editor( $citation_editor,  '_citation_editor', array() );

}

function citation_save(){
   global $post;
     if(isset($_POST['_citation_editor'])){
         update_post_meta($post->ID, '_citation_editor', $_POST['_citation_editor']);
     }
 }
 add_action( 'save_post', 'citation_save' );

 function shortcode_citation(){
 	add_shortcode( 'mc-citacion', 'citation_handler' );
 }
 add_action('init', 'shortcode_citation');

 function citation_handler( $atts ) {
 	$a = shortcode_atts( array(
 	'post_id' => '',
 	), $atts );
    $post_id=get_the_ID();
    if($a['post_id'])
    $post_id=esc_attr( $a['post_id'] );
 	return get_post_meta($post_id, '_citation_editor', true);
 }