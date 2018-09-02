<?php
if( defined('WP_CLI') && WP_CLI && ! class_exists('Private_Files_Command') ):

	/**
	 * Lists, moves, removes files in subdirectories of uploaded/private.
	 */
	class Private_Files_Command extends WP_CLI_Command {
		/**
		 * List files in all subdirectories of uploads/private.
		 *
		 * ## EXAMPLES
		 *
		 *     wp private-files list
		 *
		 * @subcommand list
		 */
		function _list( $args, $assoc_args ) {
			$path = WP_CONTENT_DIR . '/uploads/private';
			$files = [];
			foreach ( $this->_glob_recursive( $path .'/*') as $file ){
				if( is_dir( $file )) {
					continue;
				}
				$parts = explode( '/', str_replace( $path . '/', '', $file ));
				if( count( $parts ) != 2 ){
					continue;
				}
				$files[] = $parts[0] . ',' . $parts[1] . ',' . filesize( $file ) . ',' . filemtime( $file );
			}
			echo implode( ";\n", $files ).";\n";
		}
		/**
		 * Recursive glob.
		 *
		 * @param $pattern
		 * @param int $flags
		 *
		 * @see https://stackoverflow.com/questions/12109042/php-get-file-listing-including-sub-directories
		 *
		 * @return array
		 */
		private function _glob_recursive($pattern, $flags = 0){
			$files = glob( $pattern, $flags );
			foreach ( glob( dirname( $pattern ) . '/*', GLOB_ONLYDIR | GLOB_NOSORT ) as $dir ) {
				$files = array_merge( $files, $this->_glob_recursive( $dir . '/' . basename( $pattern ), $flags ) );
			}
			return $files;
		}
		/**
		 * Move file from one of subdirectory of uploads/private directory to some other subdirectory.
		 *
		 * ## OPTIONS
		 *
		 * <file>
		 * : The relative path and file name
		 *
		 * <destination>
		 * : Name of a subdirectory to move file to
		 *
		 * ---
		 * default: success
		 * options:
		 *   - uploaded
		 *   - processed
		 *   - failed
		 *
		 * ## EXAMPLES
		 *
		 *     wp private-files move uploaded/20180825-201500.json processed
		 *
		 * @subcommand move
		 */
		function _move( $args, $assoc_args ) {
			list( $file, $destination ) = $args;
			do {
				if( !$file || !$destination ) {
					break;
				}
				if( !in_array( $destination, ['uploaded', 'processed', 'failed'] )) {
					WP_CLI::error( "Invalid destination: \"{$destination}\"! Allowed values include: uploaded | processed | failed." );
					break;
				}
				$dir  = WP_CONTENT_DIR . '/uploads/private';
				$path = "{$dir}/{$file}";
				if ( ! file_exists( $path ) ) {
					WP_CLI::error( "File does not exist: \"{$path}\"!" );
				}
				$new_path = preg_replace( '/(.*\/uploads\/private\/)(uploaded|processed|failed)(\/.*)/', "$1{$destination}$3", $path );
				$short_path     = str_replace( $dir.'/', '', $path );
				$short_new_path = str_replace( $dir.'/', '', $new_path );
				if( rename( $path, $new_path )){
					WP_CLI::success( "File moved from \"{$short_path}\" to \"{$short_new_path}\"." );
				} else {
					WP_CLI::error( "File could not be moved from \"{$short_path}\" to \"{$short_new_path}\"!" );
				}
			} while ( false );
		}
		/**
		 * Remove specified file from one of the subdirectories of uploads/private directory.
		 *
		 * ## OPTIONS
		 *
		 * <file>
		 * : The relative path and file name to remove
		 *
		 * ## EXAMPLES
		 *
		 *     wp private-files remove uploaded/20180825-201500.json
		 *
		 * @subcommand remove
		 */
		function _remove( $args, $assoc_args ) {
			list( $file ) = $args;
			do {
				if( !$file ) {
					break;
				}
				$dir  = WP_CONTENT_DIR . '/uploads/private';
				$path = "{$dir}/{$file}";
				if ( ! file_exists( $path ) ) {
					WP_CLI::error( "File does not exist: \"{$path}\"!" );
				}
				$short_path     = str_replace( $dir.'/', '', $path );
				if( unlink( $path )){
					WP_CLI::success( "File removed: \"{$short_path}\"." );
				} else {
					WP_CLI::error( "File could not be removed: \"{$short_path}\"!" );
				}
			} while ( false );
		}
	}

endif;