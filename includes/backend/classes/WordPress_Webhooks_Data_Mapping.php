<?php

/**
 * WordPress_Webhooks_Data_Mapping Class
 *
 * This class contains all of the available data mapping functions
 *
 * @since 2.0.0
 */

/**
 * The log class of the plugin.
 *
 * @since 2.0.0
 * @package WW
 * @author Pullbytes <info@pullbytes.com>
 */
class WordPress_Webhooks_Data_Mapping {

	private $logs_active = null;

	/**
	 * Init everything 
	 */
	public function __construct() {

		$this->logs_active = get_option( 'ww_activate_data_mapping' );
		$this->data_mapping_table_data = wordpress_webhooks()->settings->get_data_mapping_table_data();
		$this->cache_table_exists = null;
		$this->cache_data_mapping = array();
		$this->cache_data_mapping_count = 0;
		$this->setup_data_mapping_table();

	}

	/**
	 * Wether the Data Mapping feature is active or not
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
	 * Initialize the data mappnig tables
	 *
	 * @return void
	 */
	private function setup_data_mapping_table(){

		if( ! $this->is_active() ){
			return;
		}

		if( $this->cache_table_exists !== null ){
			return $this->cache_table_exists;
		}

		if( ! wordpress_webhooks()->sql->table_exists( $this->data_mapping_table_data['table_name'] ) ){
			wordpress_webhooks()->sql->run_dbdelta( $this->data_mapping_table_data['sql_create_table'] );
			$this->cache_table_exists = true;
		}

	}

	/**
	 * Hanler function of mapping the new values
	 * to the actual data
	 *
	 * @param mixed $data - array of all currently set values
	 * @param array $template - an array of all currently available data mapping templates
	 * @param string $webhook_type - Wether it is a trigger or an action
	 * @return array - the data array
	 */
	public function map_data_to_template( $data, $template, $webhook_type ){

		$this->precached_data_mapping_data = $data;
		$this->precached_data_mapping_type = $webhook_type;

		//backwards compatibility
		if( ! isset( $template['template_data'] ) ){
			$temp_data = array(
				'template_data' => $template,
				'template_settings' => array(),
			);
			$template = $temp_data;
		}

		if( ! isset( $template['template_settings'] ) ){
			$template['template_settings'] = array();
		}

		foreach( $template['template_data'] as $row ){

			//Avoid empty singles
			if( empty( $row['singles'] ) ){
				continue;
			}

			switch( $webhook_type ){
				case 'trigger':
					$current_value = $this->get_current_array_value( $data, $row['singles'] );

					if( is_string( $current_value ) ){
						$data[ $row['new_key'] ] = $this->validate_mapping_tags( $current_value, (object) $data );
					} else {
						$data[ $row['new_key'] ] = $current_value;
					}
					
				break;
				case 'action':

					$current_value = $this->get_current_array_value( $data['content'], $row['singles'] );

					if( is_string( $current_value ) ){
						$validated_value = $this->validate_mapping_tags( $current_value, $data['content'] );
					} else {
						$validated_value = $current_value;
					}
					
					if( is_array( $data['content'] ) ){
						$data['content'][ $row['new_key'] ] = $validated_value;
					} else {
						$data['content']->{$row['new_key']} = $validated_value;
					}
					
				break;
			}

			$this->precached_data_mapping_data = $data;
			
		}

		foreach( $template['template_settings'] as $setting_name => $setting_val ){

			if( $setting_name === 'ww_data_mapping_whitelist_payload' && ! empty( $setting_val ) ){

				switch( $webhook_type ){
					case 'trigger':
						
						if( $setting_val === 'whitelist' ){

							$whitelisted_data = array();

							foreach( $template['template_data'] as $row ){
								if( isset( $data[ $row['new_key'] ] ) ){
									$whitelisted_data[ $row['new_key'] ] = $data[ $row['new_key'] ];
								}
							}
			
							$data = $whitelisted_data;

						} elseif( $setting_val === 'blacklist' ) {

							$blacklisted_data = $data;

							foreach( $template['template_data'] as $row ){
								if( isset( $data[ $row['new_key'] ] ) ){
									unset( $blacklisted_data[ $row['new_key'] ] );
								}
							}
			
							$data = $blacklisted_data;

						}
						

					break;
					case 'action':

						if( $setting_val === 'whitelist' ){

							if( is_array( $data['content'] ) ){
								$whitelisted_data = array();
							} else {
								$whitelisted_data = new stdClass();
							}
			
							foreach( $template['template_data'] as $row ){
			
								if( is_array( $data['content'] ) ){
									if( isset( $data['content'][ $row['new_key'] ] ) ){
										$whitelisted_data[ $row['new_key'] ] = $data['content'][ $row['new_key'] ];
									}
								} else {
									if( isset( $data['content']->{$row['new_key']} ) ){
										$whitelisted_data->{$row['new_key']} = $data['content']->{$row['new_key']};
									}
								}
								
							}
			
							$data['content'] = $whitelisted_data;

						} elseif( $setting_val === 'blacklist' ) {

							$blacklisted_data = $data;
			
							foreach( $template['template_data'] as $row ){
			
								if( is_array( $data['content'] ) ){
									if( isset( $data['content'][ $row['new_key'] ] ) ){
										unset( $blacklisted_data[ $row['new_key'] ] );
									}
								} else {
									if( isset( $data['content']->{$row['new_key']} ) ){
										unset( $blacklisted_data->{$row['new_key']} );
									}
								}
								
							}
			
							$data['content'] = $blacklisted_data;

						}
						
					break;
				}
				
			}

		}

		return $data;
	}

	/**
	 * The core function of mapping single values
	 *
	 * @param mixed $data - the whole data construct
	 * @param mixed $singles - the valuedsof the current iteration
	 * @return void
	 */
	public function get_current_array_value( $data, $singles ){
		$return = false;
		$fallback_value = null;
		$convertion_type = null;
		$unserialize = false;
		$json_encode = false;
		$serialize = false;
		$is_value = false;

		foreach( $singles as $key => $single ){	

			//Prefilter data on value conversion to keep track of variables
			if( is_string( $single ) && isset( $this->precached_data_mapping_type ) && isset( $this->precached_data_mapping_data ) ){
				if( $this->precached_data_mapping_type === 'trigger' ){
					$single = $this->validate_mapping_tags( $single, (object) $this->precached_data_mapping_data );
				} else {
					$single = $this->validate_mapping_tags( $single, $this->precached_data_mapping_data['content'] );
				}
			}

			//Follow the new notation since 3.0.6
			if( wordpress_webhooks()->helpers->is_json( $single ) ){

				$single_data = json_decode( $single, true );

				if( isset( $single_data['value'] ) ){
					$single_value = $single_data['value'];
				}

				if( isset( $single_data['settings'] ) ){
					foreach( $single_data['settings'] as $setting_name => $setting_value ){

						if( $setting_name === 'ww_data_mapping_fallback_value' && !empty( $setting_value ) ){
							$fallback_value = $setting_value;

						}
						
						if( $setting_name === 'ww_data_mapping_value_type' ){
							if( $setting_value === 'data_value' ){
								
								//Keep it backwards compatible
								//It is possible that with previously conerted, old mapping templates, the ident is saved within the value field
								$integer = 'wpwhval:';
								if( is_string( $single_value ) && substr( $single_value , 0, strlen( $integer ) ) !== $integer ){
									$single_value = 'wpwhval:' . $single_value;
								}

							}
						}

						if( $setting_name === 'ww_data_mapping_convert_data' && ! empty(  $setting_value ) && $setting_value !== 'none' ){
							$convertion_type = $setting_value;
						}

						if( $setting_name === 'ww_data_mapping_decode_data' && !empty(  $setting_value ) && $setting_value !== 'none' ){

							if( $setting_value === 'json_decode' ){
								//Keep it backwards compatible
								//It is possible that with previously conerted, old mapping templates, the ident is saved within the value field
								$integer = 'wpwhjson_decode:';
								if( is_string( $single_value ) && substr( $single_value , 0, strlen( $integer ) ) !== $integer ){
									$single_value = 'wpwhjson_decode:' . $single_value;
								}
							} elseif( $setting_value === 'unserialize' ){
								$unserialize = true;
							} elseif( $setting_value === 'json_encode' ){
								$json_encode = true;
							} elseif( $setting_value === 'serialize' ){
								$serialize = true;
							}

						}

					}
				}

			} else {
				$single_value = $single;
			}

			//Validate data mapping value
			$integer = 'wpwhint:';
			if( is_string( $single_value ) && strpos( $single_value, $integer ) !== FALSE ){
				$single_value = intval( str_replace( $integer, '', $single_value ) );
			}

			//Validate data mapping value to an actual value
			$rl_value = 'wpwhval:';
			if( is_string( $single_value ) && strpos( $single_value, $rl_value ) !== FALSE ){
				$is_value = true;
				$single_value = str_replace( $rl_value, '', $single_value );

				if( empty( $single_value ) && $fallback_value !== null ){
					$single_value = $fallback_value;
				}

				if( $convertion_type !== null ){
					$data = $this->convert_variable_type( $single_value, $convertion_type );
				} else {
					$data = wordpress_webhooks()->helpers->get_original_data_format( $single_value );
				}

				//re-apply the formatted data as well to the single value since it is a value in the first place
				$single_value = $data;
			}	

			//Validate data mapping value to an actual value
			$rl_value = 'wpwhjson_decode:';
			$json_decode = false;
			if( is_string( $single_value ) && strpos( $single_value, $rl_value ) !== FALSE ){
				
				$json_decode = true;
				$single_value = str_replace( $rl_value, '', $single_value );

				//Make sure we also validate the data in case the data is a value
				if( $is_value ){
					$data = str_replace( $rl_value, '', $data );
				}
			}

			if( $convertion_type !== null ){
				$single_value = $this->convert_variable_type( $single_value, $convertion_type );
			}

			if( is_object( $data ) && ! $is_value ){

				if( isset( $data->$single_value ) ){
					unset( $singles[ $key ] );
	
					if( $json_encode ){
						//encode the given data using json_encode()
						$return = json_encode( $data->$single_value );
					} elseif( $serialize ){
						//serialize the given data using maybe_serialize()
						$return = maybe_serialize( $data->$single_value );
					} else {
						if( count( $singles ) > 0 ){
							$return = call_user_func( array( $this, 'get_current_array_value' ), $data->$single_value, $singles );
						} else {
							$return = $data->$single_value;
						}
					}
					
				} elseif( $fallback_value !== null && isset( $data->$fallback_value ) ){
					unset( $singles[ $key ] );
	
					if( $json_encode ){
						//encode the given data using json_encode()
						$return = json_encode( $data->$fallback_value );
					} elseif( $serialize ){
						//serialize the given data using maybe_serialize()
						$return = maybe_serialize( $data->$fallback_value );
					} else {
						if( count( $singles ) > 0 ){
							$return = call_user_func( array( $this, 'get_current_array_value' ), $data->$fallback_value, $singles );
						} else {
							$return = $data->$fallback_value;
						}
					}
					
				}

			} elseif( is_array( $data ) && ! $is_value ){

				if( isset( $data[ $single_value ] ) ){
					unset( $singles[ $key ] );

					if( $json_encode ){
						//encode the given data using json_encode()
						$return = json_encode( $data[ $single_value ] );
					} elseif( $serialize ){
						//serialize the given data using maybe_serialize()
						$return = maybe_serialize( $data[ $single_value ] );
					} else {
						if( count( $singles ) > 0 ){
							$return = call_user_func( array( $this, 'get_current_array_value' ), $data[ $single_value ], $singles );
						} else {
							$return = $data[ $single_value ];
						}
					}
					
				} elseif( $fallback_value !== null && isset( $data[ $fallback_value ] ) ){
					unset( $singles[ $key ] );
	
					if( $json_encode ){
						//encode the given data using json_encode()
						$return = json_encode( $data[ $fallback_value ] );
					} elseif( $serialize ){
						//serialize the given data using maybe_serialize()
						$return = maybe_serialize( $data[ $fallback_value ] );
					} else {
						if( count( $singles ) > 0 ){
							$return = call_user_func( array( $this, 'get_current_array_value' ), $data[ $fallback_value ], $singles );
						} else {
							$return = $data[ $fallback_value ];
						}
					}
					
				}

			} else {
				$singles = array(); //reset to make sure we signalize a value

				if( $json_encode ){
					//encode the given data using json_encode()
					$return = json_encode( $data );
				} elseif( $serialize ){
					//serialize the given data using maybe_serialize()
					$return = maybe_serialize( $data );
				} else {
					$return = $data;
				}
			}
				
			//reload json array construct as a temporary item to iterate through it as well
			if( $json_decode && is_string( $return ) && wordpress_webhooks()->helpers->is_json( $return ) ){
				if( count( $singles ) > 0 ){
					$json_array = json_decode( $return, true );
					$return = call_user_func( array( $this, 'get_current_array_value' ), $json_array, $singles );
				} else {
					$return = json_decode( $return, true );
				}
			}

			//reload json array construct as a temporary item to iterate through it as well
			if( $unserialize && is_string( $return ) ){
				if( count( $singles ) > 0 ){
					$unserialized_data = maybe_unserialize( $return, true );
					$return = call_user_func( array( $this, 'get_current_array_value' ), $unserialized_data, $singles );
				} else {
					$return = maybe_unserialize( $return, true );
				}
			}

			break;

		}

		return $return;
	}

	/**
	 * Get the data mapping template/S
	 *
	 * @param string $template
	 * @return array - an array of the data mapping settings
	 */
	public function get_data_mapping( $template = 'all' ){
		if( ! $this->is_active() ){
			return false;
		}

		if( ! is_numeric( $template ) && $template !== 'all' ){
			return false;
		}

		if( ! empty( $this->cache_data_mapping ) ){

			if( $template !== 'all' ){
				if( isset( $this->cache_data_mapping[ $template ] ) ){
					return $this->cache_data_mapping[ $template ];
				} else {
					return false;
				}
			} else {
				return $this->cache_data_mapping;
			}

		}

		$this->setup_data_mapping_table();

		$sql = 'SELECT * FROM {prefix}' . $this->data_mapping_table_data['table_name'] . ' ORDER BY name ASC;';

		$data = wordpress_webhooks()->sql->run($sql);

		$validated_data = array();
		if( ! empty( $data ) && is_array( $data ) ){
			foreach( $data as $single ){
				if( ! empty( $single->id ) ){
					$validated_data[ $single->id ] = $single;
				}
			}
		}

		$this->cache_data_mapping = $validated_data;

		if( $template !== 'all' ){
			if( isset( $this->cache_data_mapping[ $template ] ) ){
				return $this->cache_data_mapping[ $template ];
			} else {
				return false;
			}
		} else {
			return $this->cache_data_mapping;
		}
	}

	/**
	 * Helper function to flatten data mapping specific data
	 *
	 * @param mixed $data - the data value that needs to be flattened
	 * @return mixed - the flattened value
	 */
	public function flatten_data_mapping_data( $data ){
		$flattened = array();

		foreach( $data as $id => $sdata ){
			$flattened[ $id ] = $sdata->name;
		}

		return $flattened;
	}

	/**
	 * Validate the dynamic mapping tags
	 *
	 * @param string $value - the value of the given entry
	 * @param array $data - the globally available data (can be partially validated)
	 * @return mixed - the validated value
	 */
	public function validate_mapping_tags( $value, $data ){
		$validated = $value;

		preg_match_all('/((?<=\{:)(.*?)(?=:\}))/is', $value, $match);

		if( ! empty( $match ) && is_array( $match ) && isset( $match[0] ) && is_array( $match[0] ) ){
			
			foreach( $match[0] as $sd ){
				if( is_object( $data ) && isset( $data->{$sd} ) ){

					//run validation
					$validated = str_replace( '{:' . $sd . ':}', $data->{$sd}, $validated );
				}
			}
		}

		return $validated;
	}

	/**
	 * Delete a dapa mapping template
	 *
	 * @param ind $id - the id of the data mapping template
	 * @return bool - True if deletion was succesful, false if not
	 */
	public function delete_dm_template( $id ){
		if( ! $this->is_active() ){
			return false;
		}

		$id = intval( $id );

		if( ! $this->get_data_mapping( $id ) ){
			return false;
		}

		$sql = 'DELETE FROM {prefix}' . $this->data_mapping_table_data['table_name'] . ' WHERE id = ' . $id . ';';
		wordpress_webhooks()->sql->run($sql);

		return true;

	}

	/**
	 * Get a global count of all data mappig templates
	 *
	 * @return mixed - int if count is available, false if not
	 */
	public function get_dm_count(){
		if( ! $this->is_active() ){
			return false;
		}

		if( ! empty( $this->cache_data_mapping_count ) ){
			return intval( $this->cache_data_mapping_count );
		}

		$this->setup_data_mapping_table();

		$sql = 'SELECT COUNT(*) FROM {prefix}' . $this->data_mapping_table_data['table_name'] . ';';
		$data = wordpress_webhooks()->sql->run($sql);

		if( is_array( $data ) && ! empty( $data ) ){
			$this->cache_data_mapping_count = $data;
			return intval( $data[0]->{"COUNT(*)"} );
		} else {
			return false;
		}

	}

	/**
	 * Add a data mapping template
	 *
	 * @param string $name - the name of the data mapping template
	 * @return bool - True if the creation was successful, false if not
	 */
	public function add_template( $name ){
		if( ! $this->is_active() ){
			return false;
		}

		$sql_vals = array(
			'name' => $name,
			'log_time' => date( 'Y-m-d H:i:s' )
		);

		$sql_keys = '';
		$sql_values = '';
		foreach( $sql_vals as $key => $single ){

			$sql_keys .= esc_sql( $key ) . ', ';
			$sql_values .= '"' . $single . '", ';

		}

		$sql = 'INSERT INTO {prefix}' . $this->data_mapping_table_data['table_name'] . ' (' . trim($sql_keys, ', ') . ') VALUES (' . trim($sql_values, ', ') . ');';
		wordpress_webhooks()->sql->run($sql);

		return true;

	}

	/**
	 * Update an existing data mapping template
	 *
	 * @param int $id - the template id
	 * @param array $data - the new template data
	 * @return bool - True if update was successful, false if not
	 */
	public function update_template( $id, $data ){
		if( ! $this->is_active() ){
			return false;
		}

		$id = intval( $id );

		if( ! $this->get_data_mapping( $id ) ){
			return false;
		}

		$sql_vals = array();

		if( isset( $data['name'] ) ){
			$sql_vals['name'] = sanitize_title( $data['name'] );
		}

		if( isset( $data['template'] ) ){
			$sql_vals['template'] = base64_encode( $data['template'] );
		}

		if( empty( $sql_vals ) ){
			return false;
		}

		$sql_string = '';
		foreach( $sql_vals as $key => $single ){

			$sql_string .= $key . ' = "' . $single . '", ';

		}
		$sql_string = trim( $sql_string, ', ' );

		$sql = 'UPDATE {prefix}' . $this->data_mapping_table_data['table_name'] . ' SET ' . $sql_string . ' WHERE id = ' . $id . ';';
		wordpress_webhooks()->sql->run($sql);

		return true;

	}

	/**
	 * Delete the whole data mapping table
	 *
	 * @return bool - wether the deletion was successful or not
	 */
	public function delete_table(){
		if( ! $this->is_active() ){
			return false;
		}

		$check = true;
		if( wordpress_webhooks()->sql->table_exists( $this->data_mapping_table_data['table_name'] ) ){
			$check = wordpress_webhooks()->sql->run( $this->data_mapping_table_data['sql_drop_table'] );
		}

		return $check;
	}

	public function convert_variable_type( $string, $type ){
		
		switch( $type ){
			case 'bool':
				$string = boolval( $string );
			break;
			case 'null':
				$string = null;
			break;
			case 'float':
				$string = floatval( $string );
			break;
			case 'integer':
				$string = intval( $string );
			break;
			case 'string':
				$string = strval( $string );
			break;
		}

		return $string;
	}

}
