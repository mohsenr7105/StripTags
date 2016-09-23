<?php
use PHPUnit\Framework\TestCase;
use Mimrahe\StripTags\Stripper;

class StripperTest extends TestCase
{
    public $text = '<strong>strong text</strong><b>bold text</b><br><a href="#">link</a><p>paragraph</p>';

    public function testExcept()
    {
        $exceptedTags = array(
            'b', 'strong'
        );
        $stripper = new Stripper($this->text);
        $strippedText = $stripper->except($exceptedTags)->strip();
        $this->assertEquals('strong textbold text<br><a href="#">link</a><p>paragraph</p>', $strippedText);
    }

    public function testAllow()
    {
        $allowedTags = array(
            'br', 'strong', 'a'
        );
        $stripper = new Stripper();
        $stripper->text($this->text);
        $stripper->allow($allowedTags);
        $strippedText = $stripper->strip();
        $this->assertEquals('<strong>strong text</strong>bold text<br><a href="#">link</a>paragraph', $strippedText);
    }
}