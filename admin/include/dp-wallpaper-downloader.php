<?php

if (isset($_POST['dp-downloader-status'])) {
    if ($_POST['dp-download-status'] == 1) {
        update_option('dp-download-status', '1');
        update_option('dp-download-keywords', $_POST['dp-keywords']);
        update_option('dp-download-total', $_POST['dp-download-perkeyword']);
        echo '<meta http-equiv="refresh" content="0">'; // refresh browser
        if (! wp_next_scheduled ( 'dp_download_keywords' )) { // do the download process using wp cron
            wp_schedule_single_event( time(), 'dp_download_keywords' );
        }
    } else if ($_POST['dp-download-status'] == 0) {
        update_option('dp-download-status', '0');
        update_option('dp-download-keywords', '');
        update_option('dp-download-total', '');
        echo '<meta http-equiv="refresh" content="0">'; // refresh browser
        // remove wallpapers.txt & current canceled wallpaper directory
        $uploadDir = wp_upload_dir()['basedir'];
        @unlink("$uploadDir/wallpapers.txt");
        $wallDir = get_option('dp-download-dir');
        if (file_exists("$uploadDir/$wallDir/")) {
            array_map('unlink', glob("$uploadDir/$wallDir/*.*"));
			rmdir("$uploadDir/$wallDir/");
		}
    }
}
