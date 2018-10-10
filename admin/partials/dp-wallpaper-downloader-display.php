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
    <h2 class="devtey-title">Wallpaper Grabber</h2>
    <?php if (get_option('dp-download-status') == 1) { ?>
    <div class="devtey-label-title">Download status: <span class="dp-scheduler-status dp-aktif" style="padding:2px;">on</span></div>
    <hr>
    <p>Proses download sedang berlangsung, silakan tunggu sampai selesai. :) Waktu yang dibutuhkan untuk download, bergantung pada jumlah keyword dan jumlah wallpaper</p>
    <form method="post" class="dp-form">
        <div class="submit">
            <input type="hidden" name="dp-download-status" value="0">
            <input name="dp-downloader-status" type="submit" value="Batalkan Download" class="button non-aktif">
        </div>
    </form>
    <?php } else { ?>
    <div class="devtey-label-title">Download status: <span class="dp-scheduler-status dp-nonaktif" style="padding:2px;">off</span></div>
    <hr>
    <form method="post" class="dp-form">
        <!-- post title -->
        <label for="dp-post-title-g" class="devtey-label-title">Format judul</label>
        <input name="dp-post-title-g" type="text" id="dp-post-title-g" placeholder="Contoh: Wallpaper {{file_name}} Free Download" class="devtey-form" value="<?php echo esc_attr( get_option('dp-post-title-g') ); ?>">
        <!-- end post title -->
        <!-- post kategori -->
        <label for="dp-kategori-g" class="devtey-label-title">Pilih kategori</label>
        <select id="dp-kategori-g" name="dp-kategori-g" class="devtey-form">
            <?php
                $args = array('hide_empty' => false);
                $categories = get_categories( $args );
                $stored_category_id = esc_attr( get_option('dp-kategori-g') );
                foreach ( $categories as $category ) { 
                    $selected = ( $stored_category_id ==  $category->term_id  ) ? 'selected' : ''; ?>
                    <option name="kategories[option_one]" value="<?php echo $category->term_id ?>" <?php echo $selected ?>><?php echo $category->name ?></option>
                    <?php
                }
            ?>
        </select>
        <!-- end post kategori -->
        <!-- multi post support -->
        <div class="devtey-toggle">
            <label class="switch">
                <input type="checkbox" id="dp-multi-wallpapers-g" name="dp-multi-wallpapers-g" value="1" <?php checked( get_option('dp-multi-wallpapers-g') ); ?>>
                <span class="slider"></span>
            </label>
            <label class="desc">
                <span class="title devtey-label-title">Banyak wallpaper dalam satu post?</span>
                <span class="desc">(Jika diaktifkan, satu posting akan berisikan banyak wallpaper/gallery.)</span>
            </label>
        </div>
        <!-- end multi post support -->
        <!-- keyword as wallpaper title -->
        <div class="devtey-toggle">
            <label class="switch">
                <input type="checkbox" id="dp-keyword-as-title" name="dp-keyword-as-title" value="1" <?php checked( get_option('dp-keyword-as-title') ); ?>>
                <span class="slider"></span>
            </label>
            <label class="desc">
                <span class="title devtey-label-title">Keyword as image title?</span>
                <span class="desc">(Jika diaktifkan, nama gambar wallpaper (file_name) akan sama dengan keyword yang Anda masukkan.)</span>
            </label>
        </div>
        <!-- end keyword as wallpaper title -->
        <hr style="border: 1px !important;border-top: 1px solid #bbb !important;">
        <label for="post-title" class="devtey-label-title">Keywords</label>
        <textarea name="dp-download-keywords" id="dp-download-keywords" placeholder="Masukkan keywords perbaris" class="devtey-form" rows="4" cols="50"><?php echo esc_attr( $_POST['dp-download-keywords']); ?></textarea>
        <label for="dp-download-total" class="devtey-label-title">Limit wallpaper per keyword</label>
        <input name="dp-download-total" id="dp-download-total" placeholder="Masukkan berapa jumlah wallpaper yang ingin didownload per-keywordnya." class="devtey-form" value="<?php echo esc_attr( $_POST['dp-download-total']); ?>" />
        
        <!-- penelusuran lanjutan -->
        <div style="width:100%;">
            <label for="se-google-ukuran" class="devtey-label-title"  style="display:inline-block;width:20%;margin-top:-10px;">Ukuran gambar:</label>
            <select id="se-google-ukuran" name="se-google-ukuran" class="devtey-form"  style="display:inline-block;width:40%;">
                <option name="ukuran-1" value="" <?php echo $selected ?>>ukuran berapa pun</option>
                <option name="ukuran-2" value="isz:lt,islt:svga" <?php echo $selected ?>>lebih dari 800x600</option>
                <option name="ukuran-3" value="isz:lt,islt:xga" <?php echo $selected ?>>lebih dari 1024x768</option>
                <option name="ukuran-4" value="isz:lt,islt:2mp" <?php echo $selected ?>>lebih dari 2MP</option>
            </select>
            <p  style="display:inline-block;width:30%;margin-top:-10px;">Cari gambar dalam ukuran apa pun yang Anda butuhkan.</p>
        </div>
        <div style="width:100%;">
            <label for="se-google-rasio" class="devtey-label-title"  style="display:inline-block;width:20%;margin-top:-10px;">Rasio tinggi lebar:</label>
            <select id="se-google-rasio" name="se-google-rasio" class="devtey-form"  style="display:inline-block;width:40%;">
                <option name="rasio-1" value="" <?php echo $selected ?>>rasio apa pun</option>
                <option name="rasio-2" value="iar:t" <?php echo $selected ?>>tinggi</option>
                <option name="rasio-3" value="iar:s" <?php echo $selected ?>>persegi</option>
                <option name="rasio-4" value="iar:w" <?php echo $selected ?>>lebar</option>
                <option name="rasio-5" value="iar:xw" <?php echo $selected ?>>ekstra lebar</option>
            </select>
            <p  style="display:inline-block;width:30%;margin-top:-10px;">Tentukan bentuk gambar.</p>
        </div>
        <div style="width:100%;">
            <label for="se-google-waktu" class="devtey-label-title"  style="display:inline-block;width:20%;margin-top:-10px;">Waktu:</label>
            <select id="se-google-waktu" name="se-google-waktu" class="devtey-form"  style="display:inline-block;width:40%;">
                <option name="waktu-1" value="" <?php echo $selected ?>>sembarang waktu</option>
                <option name="waktu-2" value="qdr:d" <?php echo $selected ?>>24 jam terakhir</option>
                <option name="waktu-3" value="qdr:w" <?php echo $selected ?>>seminggu terakhir</option>
                <option name="waktu-4" value="qdr:m" <?php echo $selected ?>>sebulan terakhir</option>
                <option name="waktu-5" value="qdr:y" <?php echo $selected ?>>setahun terakhir</option>
            </select>
            <p  style="display:inline-block;width:30%;margin-top:-10px;">Rentang waktu hasil gambar yang dicari.</p>
        </div>
        <div style="width:100%;">
            <label for="se-google-warna" class="devtey-label-title"  style="display:inline-block;width:20%;margin-top:-10px;">Warna dalam gambar:</label>
            <span style="display:inline-block;width:40%;margin-right:3px;margin-top:10px;">	
                <input type="radio" name="se-google-warna" id="warna-1" value="ic:color" checked="checked"/>
                <label for="warna-1" style="margin-right:15px;">berwarna</label>	
                <input type="radio" name="se-google-warna" id="warna-2" value="ic:gray"/>
                <label for="warna-2" style="margin-right:15px;">hitam & putih</label>
            </span>
            <p  style="display:inline-block;width:30%;margin-top:-10px;">Cari gambar dengan warna pilihan Anda.</p>
        </div>
        <!-- end penelusuran lanjutan -->
        <hr style="border: 1px !important;border-top: 1px solid #bbb !important;">
        <p>Wallpaper akan tersimpan di <span style="font-weight: bold;"><?php echo wp_upload_dir()['basedir']; ?>/DDMMYY/</span>. Proses download akan selesai ketika <strong><em>Download status</em></strong> menjadi <span class="dp-scheduler-status dp-nonaktif" style="padding:2px;">off</span>.</p>
        <div class="submit">
            <input type="hidden" name="dp-download-status" value="1">
            <input name="dp-downloader-status" type="submit" value="Download" class="button button-primary aktif">
        </div>
    </form>
    <?php } ?>

    <script>
        // var multiWallpaper = document.getElementById("dp-multi-wallpapers-g");
        // var keyAsTitle = document.getElementById("dp-keyword-as-title");
        var multiWallpaper = document.querySelector("#dp-multi-wallpapers-g");
        var keyAsTitle = document.querySelector("#dp-keyword-as-title");

        multiWallpaper.addEventListener("click", function onclick(event) { // saat pertama kali multi wall diklik, aktifkan key as title juga
			keyAsTitle.checked = true;
            keyAsTitle.disabled = true;
		});
        multiWallpaper.addEventListener("click", function onclick(event) { // matikan disable klik pada key as title jika multiwall tidak aktif.
            if (multiWallpaper.checked == false){
                keyAsTitle.disabled = false;
            }			
		});

    </script>
</div>