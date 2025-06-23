# ISCED-F field of study

Drupal module providing ISCED-F fields of study as select options.

## Installation

Include the repository in your project's `composer.json` file:

    "repositories": [
        ...
        {
            "type": "vcs",
            "url": "https://github.com/EuropeanUniversityFoundation/isced_field"
        }
    ],

Then you can require the package as usual:

    composer require euf/isced_field

Finally, install the module:

    drush en isced_field

## Usage

The **ISCED-F field of study** field type becomes available in the Field UI under the _Selection list_ category, so it can be added to any fieldable entity like any other field type.

The field widget can be configured to allow all levels of selection (**broad**, **narrow** and **detailed**) or it can require selection at the **detailed** level (deepest).

The available field formatters allow to print the ISCED-F code only or to render the full label, optionally prefixed by the code.

## Validation

ISCED-F codes are validated against the official list, ported to this [PHP library](https://packagist.org/packages/euf/isced) and required in `composer.json`.

## ROADMAP

  - Views integration
