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
 * @author		DigitalSurgeons
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
	
	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

 Since you did not provide instructions on the form, make sure to put plugin documentation here.
<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.relationsheeps.php */
/* Location: /system/expressionengine/third_party/relationsheeps/pi.relationsheeps.php */