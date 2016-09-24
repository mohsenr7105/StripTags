<?php
use PHPUnit\Framework\TestCase;
use Mimrahe\StripTags\Stripper;

class StripperTest extends TestCase
{
    public $text = '<strong>strong text</strong><b>bold text</b><br><a href="#">link</a><p>paragraph</p>';

    public function testOnly()
    {
        $exceptedTags = array(
            'b', 'strong'
        );
        $stripper = new Stripper($this->text);
        $strippedText = $stripper->only($exceptedTags)->strip();
        $this->assertEquals('strong textbold text<br><a href="#">link</a><p>paragraph</p>', $strippedText);
    }

    public function testExcept()
    {
        $allowedTags = array(
            'br', 'strong', 'a'
        );
        $stripper = new Stripper();
        $stripper->text($this->text);
        $stripper->except($allowedTags);
        $strippedText = $stripper->strip();
        $this->assertEquals('<strong>strong text</strong>bold text<br><a href="#">link</a>paragraph', $strippedText);
    }
}