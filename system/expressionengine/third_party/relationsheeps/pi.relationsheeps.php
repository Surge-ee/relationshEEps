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
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}

	/*
	* filter_id_array
	* flatten the array EE gives back so it contains ONLY the entry ids
	*/
	private function filter_id_array($item)
	{
		return $item['entry_id'];
	}

	/*
	*	findParentIds function
	*	@param $channel_parent channel for the parent channel
	*	@param $channel_child channel for the child
	*	@param $field the field we are searching with
	*	@param $value the search value for for the field
	*	@return array of entry parent_ids that are related to the search requirements
	*/

	private function findParentIds($channel_parent, $channel_child, $field, $value)
	{

		// Welcome to query hell

		// Query to find id of the related channel
		$child_channel_id = $this->EE->db->select('channel_id')
			->from('channels')
			->where('channel_name', $channel_child)
			->get()->row('channel_id');

		// Do the same thing for the parent
		$parent_channel_id = $this->EE->db->select('channel_id')
			->from('channels')
			->where('channel_name', $channel_parent)
			->get()->row('channel_id');

		// Find the field_id from related field to search in
		$field_id = $this->EE->db->select('field_id')
			->from('channel_fields')
			->where('field_name', $field)
			->get()->row('field_id');

		// Now search the field for the value we're looking for
		$matching_child_ids = $this->EE->db->select('entry_id')
			->from('channel_data')
			->where('channel_id', $child_channel_id)
			->where("field_id_$field_id", $value)
			->get()->result_array();

		// Finally we can find the parent ids of related entires that match our terms
		$entry_ids = $this->EE->db->select('entry_id')
			->from('relationships')
			->join('channel_data', 'channel_data.entry_id = relationships.parent_id', 'left')
			->where_in('child_id', $matching_child_ids[0])
			->where('channel_data.channel_id', $parent_channel_id)
			->get()->result_array();

		$entry_ids = array_map(array($this, 'filter_id_array'), $entry_ids);

		return $entry_ids;

	}

	/*
	*	doQuery function
	*	@param $channel_parent channel for the parent channel
	*	@param $channel_child channel for the child
	*	@param $field the field we are searching with
	*	@param $value the search value for for the field
	*	@return entries found from the database that match the search params
	*/

	private function run_search($channel_parent, $channel_child, $field, $value)
	{ 
		// We need to pull the channel module from EE core to do this
		$mod_path = PATH_MOD."/channel/mod.channel.php";

		// check to see if the class has already been loaded
		if(!class_exists('channel'))
		{
			require_once $mod_path;
		}

		$channel = new Channel();

		// search for ids of the related sheep! (entries)
		$ids = $this->findParentIds($channel_parent, $channel_child, $field, $value);

		// grab the data for these entries
		$this->EE->TMPL->tagparams['entry_id'] = implode('|', $ids);

		$return_data = $channel->entries();

		return $return_data;
	}

	/*
	*	herd function
	*	Parses tag parameters for use in the search of entries
	*	Tag parameters are: flock, related, field, value, and limit
	*/

	public function herd()
	{
		// Fetch the tag parameters we need to search for the entires

		/* 
		*	The parent channel short name
		*/
		$channel = trim(ee()->TMPL->fetch_param('flock'));

		/*
		*	The child channel short name
		*/
		$child = trim(ee()->TMPL->fetch_param('related'));

		/*
		*	Short name of the field to search with
		*/
		$field = trim(ee()->TMPL->fetch_param('field'));

		/*
		*	The value of the field to search for
		*/
		$value = trim(ee()->TMPL->fetch_param('value'));


		/*
		* Verify we have all the required parameters
		*/
		if($channel == '' || $child == '' || $value == '' || $field == '')
		{
			return false;
		}

		/*
		* Let's herd the sheep together...
		* (Execute a search)
		*/
		$this->EE->TMPL->log_item("$channel + $child + $value + $field");

		$results = $this->run_search($channel, $child, $field, $value);

		if(!$results)
		{
			return false;
		} 
		else 
		{
			return $results;
		}

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