# Block Attributes

[![Test with WordPress Playground](https://img.shields.io/badge/Test%20with-WordPress%20Playground-0073aa?style=for-the-badge&logo=wordpress&logoColor=white)](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/maxpertici/block-attributes/refs/heads/main/blueprint.json)

A WordPress plugin that allows you to add custom HTML attributes to all Gutenberg blocks.

## Description

Block Attributes is a WordPress plugin that extends the Gutenberg editor by allowing users to add custom HTML attributes to any block. This functionality is particularly useful for:

- Adding `data-*` attributes for custom JavaScript integrations
- Setting ARIA accessibility attributes
- Customizing block behavior with standard HTML attributes

## Features

- **Intuitive User Interface**: Integrated inspector panel in the Gutenberg editor
- **Security**: Attribute validation according to global HTML standards
- **data-x Attributes Support**: Full support for custom data attributes
- **Accessibility**: ARIA attributes support
- **Flexibility**: Works with all Gutenberg block types

## Usage

1. **Edit a page or post** in the Gutenberg editor
2. **Select a block** you want to customize
3. **Open the inspector panel** (right sidebar)
4. **Find the "Attributes" section** in the block settings
5. **Click "Add Attribute"** to add a new attribute
6. **Enter the name and value** of the attribute
7. **Save** your content

## Security

The plugin validates all attributes according to WordPress global HTML standards. Only allowed attributes are applied to the final markup:

- Standard global HTML attributes
- `data-*` attributes with format validation
- Filtering and escaping of all values

