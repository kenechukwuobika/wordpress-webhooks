<?php

/**
 * WordPress_Webhooks_SQL Class
 *
 * This class contains all of the available SQL functions
 *
 * @since 1.6.3
 */

/**
 * The SQL class of the plugin.
 *
 * @since 1.6.3
 * @package WW
 * @author Pullbytes <info@pullbytes.com>
 */
class WordPress_Webhooks_SQL{

	/**
	 * Run certain queries using dbbdelta
	 *
	 * @param string $sql
	 * @return bool - true for success
	 */
	public function run_dbdelta($sql){
		global $wpdb;

		$sql = $this->replace_tags($sql);

		if(empty($sql))
			return false;

		if(!function_exists('dbDelta'))
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($sql);
		$success = empty($wpdb->last_error);

		return $success;
	}

	/**
	 * Run certain SQL Queries
	 *
	 * @param string $sql
	 * @param string $type
	 * @return void
	 */
	public function run($sql, $type = OBJECT){
		global $wpdb;

		$sql = $this->replace_tags($sql);

		if(empty($sql))
			return false;

		$result = $wpdb->get_results($sql, $type);

		return $result;
	}

	/**
	 * Replace generic tags with values
	 *
	 * @param $string - string to fill
	 * @return mixed - filles string
	 */
	public function replace_tags($string){

		if(!is_string($string) || empty($string))
			return false;

		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$prefix = $wpdb->base_prefix;

		$in = array(
			'{charset_collate}',
			'{prefix}'
		);

		$out = array(
			$charset_collate,
			$prefix
		);

		return str_replace($in, $out, $string);

	}

	/**
	 * Checks if a table exists or not
	 *
	 * @param $table_name - the table name
	 * @return bool - true if the table exists
	 */
	public function table_exists($table_name){
		global $wpdb;

		$return = false;
		$prefix = $wpdb->base_prefix;
		$table_name = esc_sql($table_name);

		if(substr($table_name, 0, strlen($prefix)) != $prefix){
			$table_name = $prefix . $table_name;
		}

		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name){
			$return = true;
		}

		return $return;
	}

}