/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';

/**
 * Add the attributes needed for button icons.
 *
 * @since 0.1.0
 * @param {Object} settings
 */
function addAttributes( settings ) {

	const additionnalsAttributes = {
        "blockAttributes": {
            "type": "array",
            "default": []
        }
	};

	const newSettings = {
		...settings,
		attributes: {
			...settings.attributes,
			...additionnalsAttributes,
		},
	};

	return newSettings;
}

addFilter(
	'blocks.registerBlockType',
	'block-attributes/add-attributes',
	addAttributes
);