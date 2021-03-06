<?php

// Add the command to the wp-cli
WP_CLI::addCommand('theme', 'ThemeCommand');

/**
 * Implement theme command
 *
 * @package wp-cli
 * @subpackage commands/internals
 * @author Andreas Creten
 */
class ThemeCommand extends WP_CLI_Command {
	/**
	 * Get the status of all themes
	 *
	 * @param string $args
	 * @return void
	 **/
	public function status($args = array()) {
		// Get the list of themes
		$themes = get_themes();

		// Print the header
		WP_CLI::line('Installed themes:');

		$theme_name = get_current_theme();

		foreach ($themes as $key => $theme) {
			$line = WP_CLI::get_update_status( $theme['Stylesheet'], 'update_themes' );

			if ( $theme['Name'] == $theme_name )
				$line .= '%gA';
			else
				$line .= 'I';

			$line .=  ' ' . $theme['Stylesheet'].'%n';

			WP_CLI::line( $line );
		}

		// Print the footer
		WP_CLI::line();

		$legend = array(
			'I' => 'Inactive',
			'%gA' => 'Active',
		);

		WP_CLI::legend( $legend );
	}

	/**
	 * Get theme details
	 *
	 * @param string $args
	 * @return void
	 **/
	public function details($args = array()) {
		// Get the info of the theme
		$details = get_theme_data(WP_CONTENT_DIR.'/themes/'.$args[0].'/style.css');

		// Get the current theme
		$theme_name = get_current_theme();

		WP_CLI::line('Theme %2'.$details['Name'].'%n details:');
		WP_CLI::line('    Active: '.((int) ($details['Name'] == $theme_name)));
		WP_CLI::line('    Version: '.$details['Version']);
		WP_CLI::line('    Author: '.strip_tags($details['Author']));
		//WP_CLI::line('    Description: '.strip_tags($details['Description']));
	}

	/**
	 * Activate a theme
	 *
	 * @param string $args
	 * @return void
	 **/
	public function activate($args = array()) {
		WP_CLI::warning('This command is not ready yet!');

		// Get the info of the theme
		$details = get_theme_data(WP_CONTENT_DIR.'/themes/'.$args[0].'/style.css');

		// Switch to the theme
		switch_theme($args[0], WP_CONTENT_DIR.'/themes/'.$args[0].'/style.css');

		// Get the current theme
		$theme_name = get_current_theme();
	}

	/**
	 * Help function for this command
	 *
	 * @param string $args
	 * @return void
	 */
	public function help($args = array()) {
		WP_CLI::line('Example usage:');
		WP_CLI::line('    wp theme status');
		WP_CLI::line('    wp theme details <theme-name>');
		WP_CLI::line('');
		WP_CLI::line('%9--- DETAILS ---%n');
		WP_CLI::line('');
		WP_CLI::line('Get a status of the installed themes:');
		WP_CLI::line('    wp theme status');
		WP_CLI::line('');
		WP_CLI::line('Get the details for a theme:');
		WP_CLI::line('    wp theme details <theme-name>');
	}
}
