<?php

// 1. format title
require_once('dp-functions.php');
$_fmt_title = get_option('dp-post-title-g');
$_fmt = array($_fmt_title);
$path_parts = pathinfo($image_url);
$nama = $path_parts['filename']; // dapatkan nama file tanpa extension
$_file_name = preg_replace('/[^a-zA-Z_]/', '', $nama); // hapus char selain a-z dan _
$_file_name = str_replace("_"," ", $_file_name);

if ($_fmt[0] != '') {
    $_format_title = get_string_between($_fmt_title, '{{', '}}');
    $format_title = explode("{{{$_format_title}}}", $_fmt_title);
    $title = $format_title[0] . $_file_name . $format_title[1];
} else {
    $title = $_file_name;
}
// spintax
$title = dp_spintax($title);
// end spintax
// 2. kategori
$kategori = get_option('dp-kategori-g');
// 3. auto tag
if (get_option('dp-auto-tag') == 1) {
    $tags = explode(' ', $_file_name);
} else {
    $tags = array(0);
}
// 4. capitalize title
if (get_option('dp-cap-judul') == 1) {
    $title = ucwords($title);
}

// create parent post
// $my_post = array(
//     'post_author' => 1,
//     'post_category' => array($kategori),
//     'post_title' => $title,
//     'tags_input' => $tags
// );
// $post_id = wp_insert_post( $my_post );
$nama_file = explode("_", $nama_file);
$nama_file = array_slice($nama_file, 0, -1); // ambil kecuali item terakhir
$nama_file = implode("_", $nama_file);
if (!isset($_SESSION['key_id'])) { // jika belum ada post, berarti ini upload pertama => bikin post
    $my_post_data = array(
        'post_category' => array($kategori),
        'post_title' => $title,
        'tags_input' => $tags
    );
    
    $post_id = wp_insert_post( $my_post_data );
    $_SESSION['post_id'] = $post_id;
    $_SESSION['key_id'] = $nama_file;
}
if ($nama_file != $_SESSION['key_id']) { // jika _id (nomer unik gambar untuk pembeda id post) berbeda dengan sessi, bikin post lagi
    $my_post_data = array(
        'post_category' => array($kategori),
        'post_title' => $title,
        'tags_input' => $tags
    );
    
    $post_id = wp_insert_post( $my_post_data );
    $_SESSION['post_id'] = $post_id;
    $_SESSION['key_id'] = $nama_file;
}

// Check the type of file. We'll use this as the 'post_mime_type'.
$filetype = wp_check_filetype( basename( $image_url ), null );
// Get the path to the upload directory.
$wp_upload_dir = wp_upload_dir()['url'];
// Prepare an array of post data for the attachment.
$attachment = array(
    'guid'           => $wp_upload_dir.'/'.$namaFolder.'/'.$wallpaperData[0],
    'post_mime_type' => $filetype['type'],
    'post_title'     => $_file_name,
    'post_content'   => '',
    'post_status'    => 'inherit'
);
// Insert the attachment.
$attach_id = wp_insert_attachment( $attachment, $image_url, $_SESSION['post_id'] );

// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
require_once( ABSPATH . 'wp-admin/includes/image.php' );

// Generate the metadata for the attachment, and update the database record.
$attach_data = wp_generate_attachment_metadata( $attach_id, $image_url );
wp_update_attachment_metadata( $attach_id, $attach_data );

// set featured
if (get_option('dp-featured-image') == 1) {
    set_post_thumbnail( $_SESSION['post_id'], $attach_id );
}

// update post auto description
$post_data = get_post($_SESSION['post_id']);
$attch_data = get_post($attach_id);
if (get_option('dp-auto-desc') == 1) {
    include_once 'dp-deskripsi.php';
    $_kontent = desc_format(get_option('dp-desc-text'), $post_data, $attch_data);
    // spintax
    $_kontent = dp_spintax($_kontent);
    // end spintax

    wp_update_post( array(
        'ID' => $_SESSION['post_id'],
        'post_content' => $_kontent
    ) );
} else {
    $_kontent = do_shortcode("[dpgallery id={$_SESSION['post_id']}]");;

    wp_update_post( array(
        'ID' => $_SESSION['post_id'],
        'post_content' => $_kontent
    ) );
}