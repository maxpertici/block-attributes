<?php

namespace MXP\BlockAttributes\Core ;

use MXP\BlockAttributes\Core\Plugin;

final class App extends Plugin {


	/**
	 * Load the plugin
	 *
	 * @return void
	 */
	public function load(): void {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Init the plugin
	 *
	 * @return void
	 */
	public function init(): void {
		add_action('init', [ $this, 'loadTranslations' ] );
		add_action('enqueue_block_editor_assets', [ $this, 'editorEnqueues' ] );
		add_filter( 'render_block', [ $this, 'add_attributes_on_block_markup' ] , 20, 2 );
	}


	/**
	 * Get Translations
	 *
	 * @return void
	 */
	public function loadTranslations(): void {
		$locale = get_user_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'block-attributes' );
		load_textdomain( 'block-attributes', WP_LANG_DIR . '/plugins/block-attributes-' . $locale . '.mo' );
		load_plugin_textdomain( 'block-attributes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}


	/**
	 * Get Global Attributes
	 *
	 * @return array
	 */
	function global_attributes(): array {

		$global_attributes = _wp_add_global_attributes( [] ) ;
		$global_attributes = apply_filters( 'mxp/block_attributes/global_attributes',  $global_attributes );

		return $global_attributes ;
	}


	/**
	 * Enqueue Aria Attributes scripts for the editor
	 *
	 * @return void
	 */
	public function editorEnqueues(): void {

		$asset_file_path = untrailingslashit( $this->directoryPath ) . '/dist/block-attributes.asset.php';
		
		if( ! file_exists( $asset_file_path ) ) {
			return;
		}

		$asset_file  = include $asset_file_path ;
	

		wp_enqueue_script(
			'block-attributes-editor-script',
			untrailingslashit( $this->pluginUrl ) . '/dist/block-attributes.js',
			$asset_file['dependencies'],
			$asset_file['version']
		);
	
		wp_set_script_translations(
			'block-attributes-editor-script',
			'block-attributes',
			untrailingslashit( $this->directoryPath ) . '/languages'
		);
	
		wp_enqueue_style(
			'block-attributes-editor-styles',
			untrailingslashit( $this->pluginUrl ) . '/dist/block-attributes.css'
		);
	}

    /**
     * Modify supported blocks and add custom attributes.
     *
     * @param string $block_content The normal block HTML that would be sent to the screen.
     * @param array  $block An array of data about the block, and the way the user configured it.
	 * @return string The modified block HTML.
     */
    function add_attributes_on_block_markup( $block_content, $block ): string {

        $aria_attributes = $block['attrs']['blockAttributes'] ?? [];
        if ( empty( $aria_attributes ) ) {
            return $block_content;
        }

        $markup = new \WP_HTML_Tag_Processor( $block_content );
        $markup->next_tag() ;

        $global_attributes = $this->global_attributes();

        foreach ( $aria_attributes as [ 'name' => $name, 'value' => $value ] ) {

            $is_valide_attribute = false ;
            $name_low = strtolower( $name );

            if( str_starts_with( $name_low, 'data-' ) && ! empty( $global_attributes['data-*'] ) && preg_match( '/^data-[a-z0-9_-]+$/', $name_low, $match )
            ){
                $is_valide_attribute = true ;
            }

            if( ! $is_valide_attribute && array_key_exists( $name, $global_attributes ) ){
                $is_valide_attribute = true ;
            }

            if( empty( $name ) || ! $is_valide_attribute ){
                continue;
            }
            
            $markup->set_attribute( esc_html( $name_low ), esc_attr( $value ) );
        } 

        return $markup->get_updated_html();
    }

}