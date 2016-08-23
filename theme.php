<?php

class theme
{

	public $baseDir = ''; 

	function __construct()
	{
		$this->baseDir = get_template_directory();


		$this->registerPostTypes();
		$this->includeModules();


		add_filter( 'rwmb_meta_boxes', array($this, 'loadMetaBoxes') );

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
				var_dump($metaBoxes);
			}
		}
		return $metaBoxes;
	}

}

