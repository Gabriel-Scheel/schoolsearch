<?php

class theme
{

	public $baseDir = ''; 

	function __construct()
	{
		$this->baseDir = get_template_directory_uri();


		$this->registerPostTypes();
		$this->includeModules();



		add_filter( 'rwmb_meta_boxes', array($this, 'loadMetaBoxes') );

		add_action('wp_ajax_score_search', array($this,'score_search'));
		add_action('wp_enqueue_scripts', array($this, 'getScripts'));
	}


	//Retrieve the config files from the post types directory
	//and load our post types.
	function registerPostTypes()
	{

		$postTypeFiles = scandir($this->baseDir .'/configs/posttypes/');
		$postTypes = array();


		foreach ($postTypeFiles as $pType) {
			if (strpos($pType, 'php') > -1) {
				$postTypes[str_replace('.php','', $pType)] = require_once($this->baseDir . '/configs/posttypes/' . $pType);
			}

		}

		foreach ($postTypes as $key => $postType) {
			register_post_type($key, $postType);
		}

	}


	//Loads required modules by checking the modules folder.
	//Looks for each folder in the modules folder, it opens that
	//folder and looks for a php file with the same name as the 
	//folder to load.
	function includeModules()
	{
		$moduleFiles = scandir($this->baseDir.'/modules/');

		foreach($moduleFiles as $mFile)
		{
			if (str_replace('.', '', $mFile) == '')
			{
				continue;
			}

			try
			{
				require_once($this->baseDir.'/modules/'.$mFile.'/'.$mFile.'.php');
			}
			catch (Exception $err)
			{
				error_log($err->getMessage());
			}
		}
	}

	function loadMetaBoxes()
	{

		$metaBoxFiles = scandir($this->baseDir.'/configs/metaboxes/');
		$metaBoxes = array();

		foreach ($metaBoxFiles as $mbFile)
		{
			if (strpos($mbFile, 'php') !== false)
			{
				$metaBoxes = array_merge($metaBoxes, require_once($this->baseDir.'/configs/metaboxes/'.$mbFile));
			}
		}

		return $metaBoxes;

	}


	//Get schools that the person could apply for.
	function score_search() {
		
		$score = 0;

		//If we don't have a score or we got passed bad data,
		//fail out with an empty set.
		if ($_GET['score'] != null)
		{
			$score = $_GET['score'];
			if (is_numeric($score) == false)
			{
				echo '{}';
				die();
			}
		}



		//Schools that the score is good enough for.
		$args = array(
			'post_type' => 'Schools',
			'posts_per_page' => '-1',
			'meta_key' => 'schools_score_min',
			'meta_query' => array(
				array(
					'key' => 'schools_score_min',
					'value' => $score,
					'compare' => '<='
				)
			),
			'orderby' => 'schools_score_min',
			'order' => 'ASC'
		);

		$schools = new WP_Query($args);
		$schools = $schools->get_posts();

		//Dump em out.
		echo json_encode($schools);
		die();

	}

	function getScripts()
	{
		wp_enqueue_script( 'jQuery', $this->baseDir.'/assets/js/jquery.min.js');
	}

	


}

