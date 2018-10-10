<?php

if (isset($_POST['dp-downloader-status'])) {
    if ($_POST['dp-download-status'] == 1) {
        $waktu = date("dmy-His"); // create folder
        update_option('dp-download-status', '1');
        update_option('dp-download-dir', "$waktu");
        update_option('dp-download-keywords', $_POST['dp-download-keywords']);
        update_option('dp-download-total', $_POST['dp-download-total']);
        update_option('dp-post-title-g', $_POST['dp-post-title-g']);
        update_option('dp-kategori-g', $_POST['dp-kategori-g']);
        update_option('dp-multi-wallpapers-g', $_POST['dp-multi-wallpapers-g']);
        update_option('dp-keyword-as-title', $_POST['dp-keyword-as-title']);
        update_option('se-google-ukuran', $_POST['se-google-ukuran']);
		update_option('se-google-rasio', $_POST['se-google-rasio']);
		update_option('se-google-waktu', $_POST['se-google-waktu']);
		update_option('se-google-warna', $_POST['se-google-warna']);
        echo '<meta http-equiv="refresh" content="0">'; // refresh browser
        if (! wp_next_scheduled ( 'dp_download_keywords' )) { // do the download process using wp cron
            wp_schedule_single_event( time() + 10, 'dp_download_keywords' );
        } else {
            wp_clear_scheduled_hook( 'dp_download_keywords' );
        }
    } else if ($_POST['dp-download-status'] == 0) {
        update_option('dp-download-status', '0');
        echo '<meta http-equiv="refresh" content="0">'; // refresh browser
        // remove wallpapers.txt & current canceled wallpaper directory
        $uploadDir = wp_upload_dir()['basedir'];
        if (file_exists("$uploadDir/wallpapers.txt")) {
            unlink("$uploadDir/wallpapers.txt");
        }
        $wallDir = get_option('dp-download-dir');
        if (file_exists("$uploadDir/$wallDir/")) {
            array_map('unlink', glob("$uploadDir/$wallDir/*.*"));
			rmdir("$uploadDir/$wallDir/");
		}
    }
}
