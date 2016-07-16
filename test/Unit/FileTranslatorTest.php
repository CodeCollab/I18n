<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\I18n;

use CodeCollab\I18n\FileTranslator;
use CodeCollab\I18n\Translator;
use CodeCollab\I18n\UnsupportedLanguageException;
use CodeCollab\I18n\InvalidFileException;

class FileTranslatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CodeCollab\I18n\FileTranslator::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf(Translator::class, new FileTranslator(TEST_DATA_DIR, 'en_US'));
    }

    /**
     * @covers CodeCollab\I18n\FileTranslator::__construct
     */
    public function testThrowsOnUnsupportedLanguage()
    {
        $this->expectException(UnsupportedLanguageException::class);
        $this->expectExceptionMessage('Unsupported language (`en`).');

        new FileTranslator(TEST_DATA_DIR, 'en');
    }

    /**
     * @covers CodeCollab\I18n\FileTranslator::__construct
     */
    public function testThrowsOnInvalidFormattedTranslationFile()
    {
        $this->expectException(InvalidFileException::class);
        $this->expectExceptionMessage('The translation file (`' . TEST_DATA_DIR . '/wrongformat.php`) has an invalid format.');

        new FileTranslator(TEST_DATA_DIR, 'wrongformat');
    }

    /**
     * @covers CodeCollab\I18n\FileTranslator::__construct
     * @covers CodeCollab\I18n\FileTranslator::translate
     */
    public function testTranslateReturnsPlaceholderOnNonExistentTranslation()
    {
        $this->assertSame('{{nonexistent}}', (new FileTranslator(TEST_DATA_DIR, 'en_US'))->translate('nonexistent'));
    }

    /**
     * @covers CodeCollab\I18n\FileTranslator::__construct
     * @covers CodeCollab\I18n\FileTranslator::translate
     */
    public function testTranslateWithoutVariables()
    {
        $this->assertSame('lorem ipsum', (new FileTranslator(TEST_DATA_DIR, 'en_US'))->translate('example.text'));
    }

    /**
     * @covers CodeCollab\I18n\FileTranslator::__construct
     * @covers CodeCollab\I18n\FileTranslator::translate
     */
    public function testTranslateWithSingleVariable()
    {
        $this->assertSame(
            'This translation has a variable',
            (new FileTranslator(TEST_DATA_DIR, 'en_US'))->translate('single.variable.%', ['variable'])
        );
    }

    /**
     * @covers CodeCollab\I18n\FileTranslator::__construct
     * @covers CodeCollab\I18n\FileTranslator::translate
     */
    public function testTranslateWithMultipleVariables()
    {
        $this->assertSame(
            'This translation has multiple variables',
            (new FileTranslator(TEST_DATA_DIR, 'en_US'))->translate('multi.variable.%%', ['translation', 'variables'])
        );
    }
}
