/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { InspectorControls } from '@wordpress/block-editor';
import {
	Button,
	PanelBody,
	PanelRow,
	__experimentalInputControl as InputControl,
	__experimentalHStack as HStack,
	__experimentalVStack as VStack,
} from '@wordpress/components';

/**
 * Filter the BlockEdit object and add icon inspector controls to button blocks.
 *
 * @since 0.1.0
 * @param {Object} BlockEdit
 */
function addInspectorControls( BlockEdit ) {
	return ( props ) => {

		const { attributes, setAttributes } = props;
		const { blockAttributes } = attributes ;

		const addAttribute = () => {
			setAttributes({
				blockAttributes : [
					...blockAttributes,
					{
						name  : "",
						value : "",
					},
				],
			});
		};

		const removeAttribute = (index) => {
			setAttributes({
				blockAttributes: blockAttributes.filter((_, i) => i !== index),
			});
		};

		return (
			<>
				<BlockEdit { ...props } />
				<InspectorControls group="settings">
					<PanelBody
						title={ __( 'Attributes', 'block-attributes' ) }
						className="block-attributes-settings"
						initialOpen={ false }
					>
						<PanelRow>

							<VStack spacing="4">

								<div className="block-attributes-settings__introduction">
									<p>
										{__(
											"Add HTML attributes to this block.",
											"block-attributes"
										)}
									</p>
									<Button
										variant="link"
										href="https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Global_attributes"
									>
										{__("Learn more about global attributes on the MDN Web Docs.", "block-attributes")}
									</Button>
								</div>

								<ul className="block-attributes-settings__list">
								{ blockAttributes.map( ( attr, index) => (

									<li className="block-attributes-settings__list-item">
											<HStack alignment="top" spacing="2">
												<InputControl
													__next40pxDefaultSize
													className="block-attributes-settings__input"
													label={__("Name", "block-attributes")}
													value={attr.name}
													size="compact"
													onChange={(value) => {
														const newAttributes = [
															...blockAttributes,
														];
														newAttributes[index] = {
															...attr,
															name: value,
														};
														setAttributes({
															blockAttributes: newAttributes,
														});
													}}
													/>
												<InputControl
													__next40pxDefaultSize
													className="block-attributes-settings__input"
													label={__("Value", "block-attributes")}
													value={attr.value}
													size="compact"
													onChange={(value) => {
														const newAttributes = [
															...blockAttributes,
														];
														newAttributes[index] = {
															...attr,
															value: value,
														};
														setAttributes({
															blockAttributes: newAttributes,
														});
													}}
													/>
											</HStack>

											<Button
												isDestructive
												variant="link"
												onClick={() =>
													removeAttribute(index)
												}
												className="block-attributes-settings__button--remove"
											>
												{__("Remove Attribute", "block-attributes")}
											</Button>
									</li>
								))}
								</ul>

							<div>
								<Button
									variant="secondary"
									size="compact"
									iconSize="14"
									onClick={addAttribute}
									icon="plus"
								>
									{__("Add Attribute", "block-attributes")}
								</Button>
							</div>
							</VStack>

						</PanelRow>
					</PanelBody>
				</InspectorControls>
			</>
		);
	};
}

addFilter(
	'editor.BlockEdit',
	'block-attributes/add-inspector-controls',
	addInspectorControls
);