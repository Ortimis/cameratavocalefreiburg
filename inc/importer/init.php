<?php

/**
 * Inlcude importer files
 */
require_once get_template_directory() . '/inc/importer/includes/themes-kingdom-importer.php' ;

class Eveny_Theme_Demo_Data_Import extends Themes_Kingdom_Theme_Demo_Data_Importer {

	private static $instance;

	public $widget_import_results;

	public $theme_option_name = 'theme_mods_eveny';
	public $main_menu_name    = 'menu';
	public $social_menu_name  = 'soc';
	public $home_page_name    = 'Home';
	public $posts_page_name   = 'News &amp; Updates';

	public function __construct() {

		$this->demo_files_path = dirname( __FILE__ ) . '/demo-files/';

		self::$instance = $this;
		parent::__construct();

	}

}

new Eveny_Theme_Demo_Data_Import;