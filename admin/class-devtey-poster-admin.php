<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://devtey.com/
 * @since      1.0.0
 *
 * @package    Devtey_Poster
 * @subpackage Devtey_Poster/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Devtey_Poster
 * @subpackage Devtey_Poster/admin
 * @author     Devtey Inc. <devtey@gmail.com>
 */
class Devtey_Poster_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/devtey-poster-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/devtey-poster-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the Devtey Poster menu on the sidebar
	 * 
	 * @since	1.0.0
	 */
	public function display_admin_page() {
		add_menu_page('Devtey Poster', 'Devtey Poster', 'manage_options', 'devtey-poster', array($this, 'devtey_poster'), 'dashicons-awards', '3.0' );
	}

	/**
	 * Retrieve the devtey poster options.
	 *
	 * @since     1.0.0
	 */
	public function dp_general_settings() {
		// post creator options
		register_setting( 'dp-general-settings', 'dp-auto-tag' );
		register_setting( 'dp-general-settings', 'dp-hapus-exif' );
		register_setting( 'dp-general-settings', 'dp-cap-judul' );
		register_setting( 'dp-general-settings', 'dp-featured-image' );
		register_setting( 'dp-general-settings', 'dp-auto-desc' );
		register_setting( 'dp-general-settings', 'dp-desc-text' );
	}
	public function dp_poster_settings() {
		// post creator options
		register_setting( 'dp-poster-settings', 'dp-kategori-m' );
		register_setting( 'dp-poster-settings', 'dp-post-title-m' );
		register_setting( 'dp-poster-settings', 'dp-multi-wallpapers-m' );
	}
	public function dp_downloader() {
		// downloader status variable
		register_setting( 'dp-download-settings', 'dp-download-status' );
		register_setting( 'dp-download-settings', 'dp-download-keywords' );
		register_setting( 'dp-download-settings', 'dp-download-total' );
		register_setting( 'dp-download-settings', 'dp-download-dir' );
		register_setting( 'dp-download-settings', 'dp-post-title-g' );
		register_setting( 'dp-download-settings', 'dp-kategori-g' );
		register_setting( 'dp-download-settings', 'dp-multi-wallpapers-g' );
		register_setting( 'dp-download-settings', 'se-google-ukuran' );
		register_setting( 'dp-download-settings', 'se-google-rasio' );
		register_setting( 'dp-download-settings', 'se-google-waktu' );
		register_setting( 'dp-download-settings', 'se-google-warna' );
		register_setting( 'dp-download-settings', 'se-google-url' );
	}
	public function dp_scheduler_settings() {
		// post scheduler options
		register_setting( 'dp-scheduler-settings', 'dp-scheduler-status' );
		register_setting( 'dp-scheduler-settings', 'dp-jml-post' );
		register_setting( 'dp-scheduler-settings', 'dp-rtg-post' );
		register_setting( 'dp-scheduler-settings', 'dp-ack-post' );
	}
	public function dp_poster() {
		// dp poster aktif
		register_setting( 'dp-aktif', 'dp-info' );
		register_setting( 'dp-aktif', 'dp-key' );
	}

	/**
	 * Register the layout for the Devtey Poster admin
	 * 
	 * @since	1.0.0
	 */
	
	public function devtey_poster() {
		include_once 'dp-hurungken.php';
		include_once 'dp-pareman.php';
		include_once 'partials/dp-activator-display.php';
	}

	/**
	 * Register the layout for the Devtey Poster admin
	 * 
	 * @since	1.0.0
	 */
	
	public function dp_post_creator() {
		include_once 'include/dp-image-post.php';
		include_once 'partials/dp-poster-display.php';
	}

	/**
	 * Register the layout for the Devtey Wallpaper Downloader
	 * 
	 * @since	1.0.0
	 */
	
	public function dp_wallpaper_downloader() {
		include_once 'partials/dp-wallpaper-downloader-display.php';
		include 'include/dp-wallpaper-downloader.php';
	}

	/**
	 * Display callback for the submenu page.
	 */
	function dp_post_scheduler() { 
		include_once 'partials/dp-scheduler-display.php';
	}

	/**
	 * Display callback for the submenu page.
	 */
	function dp_about() { 
		include_once 'partials/dp-about-display.php';
	}

	/**
	 * Image uploader actions
	 */
	function post_creator( $attach_ID ) {
		if (get_option('dp-multi-wallpapers-m') == 1) {
			include_once 'include/dp-image-multi.php';
		} else {
			include_once 'include/dp-image-single.php';
		}
	}

	function server_creator( $attach_ID ) {
		include 'include/dp-image-server.php';
	}

	/**
	 * Remove image exif & metadata when uploading
	 */
	function set_extension($array)
	{
		$referr = $_SERVER['HTTP_REFERER'];
		$devtey = admin_url("admin.php?page=dp-post-creator");
		if (get_option('dp-add-server') == 1) {
			$add_server = admin_url("upload.php?page=add-from-server");
		} else {
			$add_server = false;
		}
		$grabber = (get_option('dp-download-status') === 1) ? true : false;
		if ($referr != $devtey || $add_server !== false || $grabber !== true) {
			return $array;
		}

		if ( empty($array['file']))
			return false;

		$fileInfo = pathinfo($array['file']);
		$filePath = $fileInfo['dirname'] . '/'.$fileInfo['basename'];
		switch ($fileInfo['extension']) {
			case 'jpg':
				$array['file'] = $this->remove_exif($filePath, 'jpg');
				break;
			case 'png':
				$array['file'] = $this->remove_exif($filePath, 'png');
				break;
		}

		return $array;
	}
	// the function for remove the exif & metadata
	function remove_exif($imagePath, $type)
	{
		if (empty($imagePath) || !is_admin())
			return false;

		if ($type == 'jpg')
			$clearExif = imagecreatefromjpeg($imagePath);
		elseif ($type == 'png')
			$clearExif = imagecreatefrompng($imagePath);
		else
			return $imagePath;

		imagejpeg($clearExif, $imagePath, 80);
		imagedestroy($clearExif);
		return $imagePath;
	}
	function change_graphic_lib($array) {
		return array( 'WP_Image_Editor_Imagick', 'WP_Image_Editor_GD' );
	}

	/**
	 * dp cron scheduler
	 */
	public function dp_rentang($rentang) {
		if (substr_count($rentang,":") == 2) {
			$waktu = explode(":", $rentang);
		} else {
			update_option('dp-rtg-post', '01:00:00');
			$waktu = explode(":", $rentang);
		}
		
		$jam = $waktu[0] * 3600;
		$menit = $waktu[1] * 60;
		$detik = $waktu[2];
		$waktu = (int)($jam + $menit + $detik);
		
        return $waktu;
    }
	function dp_next_schedule($schedules) {    // add custom time when to check for next auto post
        if (get_option('dp-scheduler-status') == 0) return $schedules;
        $timesecs = $this->dp_rentang(get_option('dp-rtg-post'));
        $schedules['dp_schedule'] = array(
            'interval' => $timesecs, 'display' => 'DP Scheduler'
        );
        return $schedules;
	}
	function dp_scheduler() {
		$aps_enabled = get_option('dp-scheduler-status');
        if ($aps_enabled == 0) return;

        $aps_batch = get_option('dp-jml-post');
        $aps_random = get_option('dp-ack-post');
    
        // set up the basic post query
        $args = array(
            'numberposts' => $aps_batch
        );
    
        $args['post_status'] = "draft";
        $args['order'] = "ASC";
		
		if ($aps_random == 1) $args['orderby'] = "rand";
        $results = get_posts($args);
    
        if (!empty($results)) {
            // cycle through results and update
            foreach ($results as $thepost) {
                $update = array();
                $update['ID'] = $thepost->ID;
                $update['post_status'] = 'publish';
                $thetime = date("Y-m-d H:i:s");
                $update['post_date'] = $thetime;
                wp_update_post($update);
            }
        }
        else {
            update_option('dp-scheduler-status', 0);
        }
	}

	/**
	 * Download wallpapers data to wallpapers.txt
	 */
	function dp_download_wallpaper() {
		require 'include/vendor/autoload.php';
		include_once "include/GoogleImageGrabber.php";
		$dpKeywords = nl2br(get_option('dp-download-keywords'));
		$dpKeywords = explode(PHP_EOL, $dpKeywords);
		$gid = new GoogleImageGrabber();

		// $idx = 1;
		$uploadDir = wp_upload_dir()['basedir'];

		$myfile = fopen("$uploadDir/wallpapers.txt", "w") or die("Unable to open file!"); // buat file text untuk nampung data wallpaper
		foreach ($dpKeywords as $keyword) {
			$images = $gid->grab(strip_tags($keyword));

			//var_dump($images);
			$idx = 1;
			foreach ($images as $image) {
				// echo "$idx - ";
				$namafile = $image['title'];
				$filetype = $image['filetype'];
				if ($image['filetype'] == '') { continue; };
				$lokasi = $image['url'];
				// $idx ++;

				// formating
				if (get_option('dp-multi-wallpapers-g') == 1 || get_option('dp-keyword-as-title') == 1) {
					$namafile = preg_replace('/[^\w]/', '_', strip_tags($keyword));
					$namafile = $namafile . "_$idx";
					$namafile = str_replace("__", "_", $namafile);
				} else {
					$namafile = preg_replace("/[^ \w]+/", "", $namafile);
					$namafile = str_replace(" ", "_", $namafile);
				}

				$namafile = strtolower($namafile);

				// save the wallpapers data
				$txt = "$namafile.$filetype>$lokasi\n";
				fwrite($myfile, $txt);
				$idx++;
			}
		}
		fclose($myfile); // tutup file penampung data wallpaper

		if (! wp_next_scheduled ( 'dp_download_keywords' ) && ! wp_next_scheduled ( 'dp_download_schedule' )) { // do the download process using wp cron
			wp_schedule_single_event( time() + 10, 'dp_download_schedule' );
		} else {
            wp_clear_scheduled_hook( 'dp_download_schedule' );
        }
	}

	/**
	 * Wallpaper Download scheduler - run in the background
	 */
	function dp_download_scheduler() {
		$uploadDir = wp_upload_dir()['basedir'];
		$fh = fopen("$uploadDir/wallpapers.txt",'r');
		
		$uploadDir = wp_upload_dir()['path'];
		$namaFolder = get_option('dp-download-dir');
		if (!file_exists("$uploadDir/$namaFolder/")) {
			mkdir("$uploadDir/$namaFolder/", 0777, true);
		}
		
		while ($line = fgets($fh)) {
			$wallpaperData = explode(">", $line);
			$lokasi = trim($wallpaperData[1]); // alamat file eq. https://xyz.com/naruto.jpg
			$lokasi = strtok($lokasi, '?'); // hapus url setelah tanda ?
			$nama_file = trim($wallpaperData[0]); // nama file eq. naruto.jpg
			$headers = get_headers($lokasi, 1);

			if ($headers[0] != 'HTTP/1.1 200 OK') {
				continue;
			}

			if (get_option('dp-download-status') === 0) {
				break;
			}
			
			if ($headers["Content-Length"] != "0" && strpos($nama_file, '.jpg') != false) { // hanya download gambar yang bagus
				exec("nohup wget $lokasi -T 10 -O $uploadDir/$namaFolder/$wallpaperData[0]");
				
				// remove exif
				if (get_option('dp-hapus-exif') == 1) {
					$pathJpg = "$uploadDir/$namaFolder/$wallpaperData[0]"; // original path
					$img = imagecreatefromjpeg ($pathJpg); // create a copy
					imagejpeg ($img, $pathJpg, 80); // remove the exif
					imagedestroy ($img); // destroy the copy
				}

				// file_put_contents("$uploadDir/$namaFolder/$wallpaperData[0]",file_get_contents($lokasi));
				$image_url = "$wp_upload_dir/$namaFolder/$wallpaperData[0]";
				if (get_option('dp-multi-wallpapers-g') == 1) { // jika multi wallpaper diaktifkan, tapi fitur setting keyword as title juga harus diaktifkan.
					include 'include/dp-grabber-postcreatormulti.php';
				} else {
					include 'include/dp-grabber-postcreator.php';
				}
			} else {
				continue;
			}
		}
		fclose($fh);
		update_option('dp-download-status', '0');
		echo '<meta http-equiv="refresh" content="0">'; // refresh browser setelah semua download selesai
	}

	/**
	 * session for create-posts-from-image-upload
	 */
	function start_session() {
		if(session_status() == PHP_SESSION_NONE) {
			session_start();
		}
	}
	function end_session() {
		if(session_status() == PHP_SESSION_ACTIVE) {
			session_destroy();
		}
	}

	public function display_poster_page() {
		add_submenu_page('devtey-poster', 'General Settings', 'General Settings', 'manage_options', 'devtey-poster' );
		add_submenu_page('devtey-poster', 'Wallpaper Uploader', 'Wallpaper Uploader', 'manage_options', 'dp-post-creator', array($this, 'dp_post_creator') );
		add_submenu_page('devtey-poster', 'Wallpaper Grabber', 'Wallpaper Grabber', 'manage_options', 'dp-wallpaper-downloader', array($this, 'dp_wallpaper_downloader') );		
		add_submenu_page('devtey-poster', 'Post Scheduler', 'Post Scheduler', 'manage_options', 'dp-post-scheduler', array($this, 'dp_post_scheduler') );
		add_submenu_page('devtey-poster', 'About', 'About', 'manage_options', 'dp-about', array($this, 'dp_about') );
	}

}
