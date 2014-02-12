<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * RelationshEEps Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Digital Surgeons
 * @link		http://digitalsurgeons.com
 */

$plugin_info = array(
	'pi_name'		=> 'RelationshEEps',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'DigitalSurgeons',
	'pi_author_url'	=> 'http://digitalsurgeons.com',
	'pi_description'=> 'Search your channel entries with custom values from other channels',
	'pi_usage'		=> Relationsheeps::usage()
);


class Relationsheeps {

	public $return_data;
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}

	/*
	*	doQuery function
	*	@param $field the channel field we want to relate to
	*	@param $value the value of the field we are looking for
	*	@param $channel the channel we are searching for entires in
	*	@return entries found from the database that meatch the search params
	*/

	private function doQuery($field, $value, $channel)
	{

	}

	/*
	*	herd function
	*	Parses tag parameters for use in the search of entries
	*	Tag parameters are: field, flock, and value
	*/

	public function herd()
	{
		// Fetch the tag parameters we need to search for the entires
		$channel = ee()->TMPL->fetch_param('flock');
		$field = ee()->TMPL->fetch_param('field');
		$value = ee()->TMPL->fetch_param('value');
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
		// put documentation here
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.relationsheeps.php */
/* Location: /system/expressionengine/third_party/relationsheeps/pi.relationsheeps.php */