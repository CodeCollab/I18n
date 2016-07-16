<?php declare(strict_types=1);
/**
 * Translator based on translation files containing an array with texts
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    I18n
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    1.0.1
 */
namespace CodeCollab\I18n;

/**
 * Translator based on translation files containing an array with texts
 *
 * @category   CodeCollab
 * @package    I18n
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class FileTranslator implements Translator
{
    /**
     * @var array The translations
     */
    private $texts;

    /**
     * Creates instance
     *
     * @param string $translationDirectory The directory containing the translation files
     * @param string $languageCode         The language code of which to get the translations
     *
     * @throws \CodeCollab\I18n\UnsupportedLanguageException When the language is not supported (i.e. no translation
     *                                                       file can be found for the language)
     * @throws \CodeCollab\I18n\InvalidFileException         When the translation file is invalid (i.e. no `$texts`
     *                                                       array present)
     */
    public function __construct(string $translationDirectory, string $languageCode)
    {
        $translationFile = $translationDirectory . '/' . $languageCode . '.php';

        if (!file_exists($translationFile)) {
            throw new UnsupportedLanguageException('Unsupported language (`' . $languageCode . '`).');
        }

        require $translationFile;

        if (!isset($texts)) {
            throw new InvalidFileException(
                'The translation file (`' . $translationFile . '`) has an invalid format.'
            );
        }

        $this->texts = $texts;
    }

    /**
     * Gets the translation by key if any or a placeholder otherwise
     *
     * @param string $key  The translation key for which to find the translation
     * @param array  $data Extra data to use in the translated string as variables
     *
     * @return string The translation or a placeholder when no translation is available
     */
    public function translate(string $key, array $data = []): string
    {
        if (!array_key_exists($key, $this->texts)) {
            return '{{' . $key . '}}';
        }

        if (empty($data)) {
            return $this->texts[$key];
        }

        return call_user_func_array('sprintf', array_merge([$this->texts[$key]], $data));
    }
}
