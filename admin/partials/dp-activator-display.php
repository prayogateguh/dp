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

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="dp-container">
    <h2 class="devtey-title">Devtey Poster <span class="devtey-version">v1.0.2</span></h2>
    <hr>
    <?php
    if (get_option('dp_poster') == 1) { ?>
        <!-- This file should primarily consist of HTML with a little bit of PHP. -->
        <form method="post" action="options.php">
            <?php settings_fields( 'dp-general-settings' ); ?>
            <?php do_settings_sections( 'dp-general-settings' ); ?>

            <div class="devtey-toggle">
                <label class="switch">
                    <input type="checkbox" name="dp-auto-tag" value="1" <?php checked( get_option('dp-auto-tag') ); ?>>
                    <span class="slider"></span>
                </label>
                <label class="desc">
                    <span class="title devtey-label-title">Auto Tag</span>
                    <span class="desc">(Membuat tag otomatis dari file name gambar.)</span>
                </label>
            </div>
            

            <div class="devtey-toggle">
                <label class="switch">
                    <input type="checkbox" name="dp-hapus-exif" value="1" <?php checked( get_option('dp-hapus-exif') ); ?>>
                    <span class="slider"></span>
                </label>
                <label class="desc">
                    <span class="title devtey-label-title">Hapus Exif</span>
                    <span class="desc">(Hapus exif data dari gambar wallpaper yang hendak diupload.)</span>
                </label>
            </div>

            <div class="devtey-toggle">
                <label class="switch">
                    <input type="checkbox" name="dp-cap-judul" value="1" <?php checked( get_option('dp-cap-judul') ); ?>>
                    <span class="slider"></span>
                </label>
                <label class="desc">
                    <span class="title devtey-label-title">Capitalize Judul</span>
                    <span class="desc">(Rapikan judul posting dengan Captizalize Judul.)</span>
                </label>
            </div>

            <div class="devtey-toggle">
                <label class="switch">
                    <input type="checkbox" name="dp-featured-image" value="1" <?php checked( get_option('dp-featured-image') ); ?>>
                    <span class="slider"></span>
                </label>
                <label class="desc">
                    <span class="title devtey-label-title">Set Featured Image</span>
                    <span class="desc">(Jika diaktifkan akan menyetting wallpaper menjadi featured image pada post.)</span>
                </label>
            </div>

            <div class="devtey-toggle">
                <label class="switch">
                    <input id="dp-toggle-desc" type="checkbox" name="dp-auto-desc" onclick="show_desc()" value="1" <?php checked( get_option('dp-auto-desc') ); ?>>
                    <span class="slider"></span>
                </label>
                <label class="desc">
                    <span class="title devtey-label-title">Auto Deskripsi</span>
                    <span class="desc">(Membuat deskripsi otomatis untuk posting)</span>
                </label>
                <div id="desc-text" <?php if (get_option('dp-auto-desc') != 1) { ?>style="display:none;"<?php } ?>>
                    <?php
                        if (isset($_POST['dp-desc-text'])) {
                            update_option('dp-desc-text', stripslashes(wp_filter_post_kses(addslashes($_POST['dp-desc-text']))));
                        }
                    ?>
                    <textarea id="dp-desc-text" name="dp-desc-text" cols="30" rows="10" ><?php echo esc_attr( get_option('dp-desc-text') ); ?></textarea>
                    <input id="show-info" type="checkbox" onclick="show_desc()" value="info">Show Info
                    <div id="desc-info" style="display:none;">
                        <h4>Pilihan tag template: 
                        <span class="desc-tag">
                            {{post_author}}, {{post_title}}, {{post_date}}, {{post_cats}}, {{post_tags}}, 
                            {{attch_img_name}}, {{attch_img_page}}, {{attch_img_loc}}, {{attch_img_res}}, {{attch_img_size}}, {{single_wallpaper}}, {{multi_wallpaper}}
                        </span>
                        </h4>
                        <p style="font-style: italic;color: #666;">Silakan request jika membutuhkan tag yang lain.</p>
                    </div>
                    
                </div>
                <script>
                    // Get the checkbox
                    var checkBox = document.getElementById("dp-toggle-desc");
                    var show_info = document.getElementById("show-info");
                    // Get the output text
                    var text = document.getElementById("desc-text");
                    var info_box = document.getElementById("desc-info");

                    checkBox.addEventListener("click", function onclick(event) { // saat pertama kali multi wall diklik, aktifkan key as title juga
                        text.style.display = "block";
                    });
                    checkBox.addEventListener("click", function onclick(event) { // matikan disable klik pada key as title jika multiwall tidak aktif.
                        if (checkBox.checked == false){
                            text.style.display = "none";
                        }			
                    });                        

                    show_info.addEventListener("click", function onclick(event) { // saat pertama kali multi wall diklik, aktifkan key as title juga
                        info_box.style.display = "block";
                    });
                    show_info.addEventListener("click", function onclick(event) { // matikan disable klik pada key as title jika multiwall tidak aktif.
                        if (show_info.checked == false){
                            info_box.style.display = "none";
                        }			
                    });
                </script>
            </div>

            <div>
                <input type="submit" value="Simpan" class="button button-primary aktif">
            </div>

        </form>
    <?php }
    else if (empty(get_option('dp_poster')) || get_option('dp_poster') != 1) { ?>
        <p>Silakan masukkan kode lisensi untuk mengaktifkan plugin ini. Lisensi telah diberikan ketika kamu membeli Devtey Poster.</p>
        
        <form method="post">
            <label for="dp_key" class="devtey-label-title">Kode Lisensi</label>
            <input name="dp_key" type="text" id="dp_key" placeholder="XXXX-XXXX-XXXX" class="devtey-form" value="<?php echo esc_attr( get_option('dp_key') ); ?>">
            <div>
            <?php
                if (get_option('dp_poster') != 1) { ?>
                <input type="submit" name="dp_on" value="Hidupkan" class="button button-primary aktif" />
                <?php } ?>
            </div>
            <?php if (get_option('dp_poster') == 2) { ?>
                <small>Aktivasi error, silakan cek lisensi Anda.</small>
            <?php } ?>
        </form>
    <?php } ?>
</div>