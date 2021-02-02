<?php

/**
 * WordPress_Webhooks_Logs Class
 *
 * This class contains all of the available logging functions
 *
 * @since 1.6.3
 */

/**
 * The log class of the plugin.
 *
 * @since 1.6.3
 * @package WW
 * @author Pullbytes <info@pullbytes.com>
 */
class WordPress_Webhooks_Logs {

	private $logs_active = null;

	/**
	 * WordPress_Webhooks_Logs constructor.
	 */
	public function __construct() {

		$this->logs_active = get_option( 'ww_activate_logs' );
		$this->log_table_data = wordpress_webhooks()->settings->get_log_table_data();
		$this->cache_log = array();
		$this->cache_log_count = 0;
		$this->setup_logging_table();

	}

	/**
	 * Wether the log functionality is active or not
	 *
	 * @return boolean - True if active, false if not
	 */
	public function is_active(){

		if( ! empty( $this->logs_active ) && $this->logs_active == 'yes' ){
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Init the base logging table to the database
	 *
	 * @return void
	 */
	private function setup_logging_table(){

		if( ! $this->is_active() ){
			return;
		}

		if( ! wordpress_webhooks()->sql->table_exists( $this->log_table_data['table_name'] ) ){
			wordpress_webhooks()->sql->run_dbdelta( $this->log_table_data['sql_create_table'] );
		}

	}

	/**
	 * Returns certain items of the logs table
	 *
	 * @param integer $offset
	 * @param integer $limit
	 * @return array - An array of the given log data
	 */
	public function get_log( $offset = 0, $limit = 10 ){
		if( ! $this->is_active() ){
			return false;
		}

		if( ! empty( $this->cache_log ) ){
			return $this->cache_log;
		}

		$this->setup_logging_table();

		$sql = 'SELECT * FROM {prefix}' . $this->log_table_data['table_name'] . ' ORDER BY id DESC LIMIT ' . $limit . ' OFFSET ' . $offset . ';';
		$data = wordpress_webhooks()->sql->run($sql);
		$this->cache_log = $data;

		return $data;
	}

	/**
	 * Count the given log data
	 *
	 * @param integer $offset
	 * @param integer $limit
	 * @return mixed - Integer if log data found, false if not
	 */
	public function get_log_count( $offset = 0, $limit = 10 ){
		if( ! $this->is_active() ){
			return false;
		}

		if( ! empty( $this->cache_log_count ) ){
			return intval( $this->cache_log_count );
		}

		$this->setup_logging_table();

		$sql = 'SELECT COUNT(*) FROM {prefix}' . $this->log_table_data['table_name'] . ';';
		$data = wordpress_webhooks()->sql->run($sql);

		if( is_array( $data ) && ! empty( $data ) ){
			$this->cache_log_count = $data;
			return intval( $data[0]->{"COUNT(*)"} );
		} else {
			return false;
		}

	}


	/**
	 * Add a log data item to the logs
	 *
	 * @param string $msg
	 * @param mixed $data can be everything that should be saved as log data
	 * @return bool - True if the function runs successfully
	 */
	public function add_log( $msg, $data ){
		if( ! $this->is_active() ){
			return false;
		}

		$sql_vals = array(
			'message' => base64_encode( $msg ),
			'content' => ( is_array( $data ) || is_object( $data ) ) ? base64_encode( json_encode( $data ) ) : base64_encode( $data ),
			'log_time' => date( 'Y-m-d H:i:s' )
		);

		// START UPDATE PRODUCT
		$sql_keys = '';
		$sql_values = '';
		foreach( $sql_vals as $key => $single ){

			$sql_keys .= esc_sql( $key ) . ', ';
			$sql_values .= '"' . $single . '", ';

		}

		$sql = 'INSERT INTO {prefix}' . $this->log_table_data['table_name'] . ' (' . trim($sql_keys, ', ') . ') VALUES (' . trim($sql_values, ', ') . ');';
		wordpress_webhooks()->sql->run($sql);

		return true;

	}

	/**
	 * Delete the log data table
	 *
	 * @return bool - True if the log table was deleted successfully
	 */
	public function delete_table(){
		if( ! $this->is_active() ){
			return false;
		}

		$check = true;
		if( wordpress_webhooks()->sql->table_exists( $this->log_table_data['table_name'] ) ){
			$check = wordpress_webhooks()->sql->run( $this->log_table_data['sql_drop_table'] );
		}

		return $check;
	}

	/**
	 * Sanitize the values of a given content array to prevent the log oview from breaking
	 */
	public function sanitize_array_object_values( $array ){

		if( is_array( $array ) ){
			foreach( $array as $key => $val ){
				if( is_string( $val ) ){
					$array[ $key ] = htmlspecialchars( str_replace( '"', '&quot', $val ) );
				} else {
					$array[ $key ] = $this->sanitize_array_object_values( $val );
				}
			}
		} elseif( is_object( $array ) ){
			foreach( $array as $key => $val ){
				if( is_string( $val ) ){
					$array->{$key} = htmlspecialchars( str_replace( '"', '&quot', $val ) );
				} else {
					$array->{$key} = $this->sanitize_array_object_values( $val );
				}
			}
		}

		return $array;

	}

}
