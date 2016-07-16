# I18n

Internationalization package of the CodeCollab project

[![Build Status](https://travis-ci.org/CodeCollab/I18n.svg?branch=master)](https://travis-ci.org/CodeCollab/I18n) [![MIT License](https://img.shields.io/badge/license-MIT-blue.svg)](mit) [![Latest Stable Version](https://poser.pugx.org/codecollab/i18n/v/stable)](https://packagist.org/packages/codecollab/i18n) [![Total Downloads](https://poser.pugx.org/codecollab/i18n/downloads)](https://packagist.org/packages/codecollab/i18n) [![Latest Unstable Version](https://poser.pugx.org/codecollab/i18n/v/unstable)](https://packagist.org/packages/codecollab/i18n)

## Requirements

PHP7+

## Installation

Include the library in your project using composer:

    {
        "require-dev": {
            "codecollab/i18n": "^1"
        }
    }

## Usage

This library uses simple php files containing an array of translations based on key/value pairs. The array should be named `$texts`.

The filename of the translations should be based on the language it targets, e.g. `en_US.php`. An simple example of translations in a file:

    <?php
    
    $texts = [
        'translation.title'        => 'Translation',
        'translation.description'  => 'This is an example translation.',
        'translation.variable.%'   => 'Copyright %d Some Company',
    ];

To use translations in your application first create an instance of the translation class by passing the directory in which the translation files are and the language to translate to:

    <?php
    
    $translator = new \CodeCollab\I18n\FileTranslator('/path/to/translations', 'en_US');
    
    echo $translator->translate('translation.title'); // Translation
    echo $translator->translate('translation.variable.%', [2015]); // Copyright 2015 Some Company
    
### Exceptions

When a translation file could not be found a `\CodeCollab\I18n\UnsupportedLanguageException` will be thrown.

When loading a translation file it will be checked to ensure it has the correct format. if the file is not a valid translation file a `\CodeCollab\I18n\InvalidFileException` will be thrown.

### Interface

When using translators in your application always hint against the `\CodeCollab\I18n\Translator` interface instead of the concrete implementation. This allows you to use different translation implementations later without having to change you classes.

## Contributing

[How to contribute][contributing]

## License

[MIT][mit]

## Security issues

If you found a security issue please contact directly by mail instead of using the issue tracker at codecollab-security@pieterhordijk.com

[contributing]: https://github.com/CodeCollab/I18n/blob/master/CONTRIBUTING.md
[mit]: http://spdx.org/licenses/MIT
