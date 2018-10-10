<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://devtey.com/
 * @since      1.0.0
 *
 * @package    Devtey_Poster
 * @subpackage Devtey_Poster/admin/partials
 */
?>
<div class="dp-container">
    <h2 class="devtey-title">Wallpaper Uploader</h2>
    <hr>
    <?php
    session_unset(); // unset all session
    if (!current_user_can('upload_files'))
        wp_die(__('Sorry, you are not allowed to upload files.'));
            
    wp_enqueue_script('plupload-handlers');

    $post_id = 0;
    if ( isset( $_REQUEST['post_id'] ) ) {
        $post_id = absint( $_REQUEST['post_id'] );
        if ( ! get_post( $post_id ) || ! current_user_can( 'edit_post', $post_id ) )
            $post_id = 0;
    }

    $form_class = 'media-upload-form type-form validate';

    ?>
    <div class="wrap">
        <form id="settingpost" method="post" action="options.php">
            <?php settings_fields( 'dp-poster-settings' ); ?>
            <?php do_settings_sections( 'dp-poster-settings' ); ?>
            
            <label for="post-title" class="devtey-label-title">Format Judul</label>
            <input name="dp-post-title-m" type="text" id="post-title" placeholder="Contoh: Wallpaper {{file_name}} Free Download" class="devtey-form" value="<?php echo esc_attr( get_option('dp-post-title-m') ); ?>">
            
            <label for="kategori" class="devtey-label-title">Pilih Kategori</label>
            <select id="kategori" name="dp-kategori-m" class="devtey-form">
            <?php
                $args = array('hide_empty' => false);
                $categories = get_categories( $args );
                $stored_category_id = esc_attr( get_option('dp-kategori-m') );
                foreach ( $categories as $category ) { 
                    $selected = ( $stored_category_id ==  $category->term_id  ) ? 'selected' : ''; ?>
                    <option name="kategories[option_one]" value="<?php echo $category->term_id ?>" <?php echo $selected ?>><?php echo $category->name ?></option>
                    <?php
                }
            ?>
            </select>

            <div class="devtey-toggle">
                <label class="switch">
                    <input type="checkbox" name="dp-multi-wallpapers-m" value="1" <?php checked( get_option('dp-multi-wallpapers-m') ); ?>>
                    <span class="slider"></span>
                </label>
                <label class="desc">
                    <span class="title devtey-label-title">Banyak Wallpaper dalam satu post?</span>
                    <span class="desc">(Jika diaktifkan, satu posting akan berisikan banyak wallpaper/gallery.)</span>
                </label>
            </div>
            <div>
                <input type="submit" value="Upload" class="button button-primary aktif" onclick="putCookie()">
            </div>
        </form>
        <!-- tampilkan uploader -->
        <div id="uploadfields" style="display:none;">
        <p>Upload wallpapernya di sini...</p>
        <form enctype="multipart/form-data" method="post" action="" class="<?php echo esc_attr( $form_class ); ?>" id="file-form">
            <?php dp_uploader(); ?>
            <script type="text/javascript">
            var post_id = <?php echo $post_id; ?>, shortform = 3;
            </script>
            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
            <div id="media-items" class="hide-if-no-js"></div>
        </form>
        <!-- end tampilkan uploader -->
        </div>
        <script>
            function setCookie(name, value) {
                document.cookie=name + "=" + value;
            }
            function putCookie(){
                setCookie("uploadwallform", "tampil");
                return true;
            }
            function getCookie(name) {
                var value = "; " + document.cookie;
                var parts = value.split("; " + name + "=");
                if (parts.length == 2) return parts.pop().split(";").shift();
            }
            var uploadwallform = getCookie("uploadwallform");
            if (uploadwallform === 'tampil') {
                document.getElementById("uploadfields").style.display = "block";
                document.getElementById("settingpost").style.display = "none";
                window.onbeforeunload = function(e) {
                    document.cookie = "uploadwallform=teguh";
                };
            } else {
                document.getElementById("uploadfields").style.display = "none";
                document.getElementById("settingpost").style.display = "block";
            }
        </script>
        
    </div>

</div>