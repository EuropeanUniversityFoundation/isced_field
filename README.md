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

## Translation

To merge the module translations with the library translations, run `drush isced-merge`.

_See `isced_field.info.yml` for the translation file pattern to use for your custom translations._

## Views integration

The module provides a Views filter plugin for the ISCED-F field type. It can be exposed to site users as a select list.

The filtering follows a simple logic:

- if the filter value is a broad field, all results with that broad field are displayed;
- if the filter value is a narrow field **not already shown by a broad field filter value**, all results with that broad field are displayed;
- if the filter value is a detailed field, the rule above applies to coverage by broad and narrow fields.

## ROADMAP

  - [Datalist](https://www.drupal.org/project/datalist) integration
