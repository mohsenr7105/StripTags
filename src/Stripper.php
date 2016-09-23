<?php
namespace Mimrahe\StripTags;

class Stripper
{
    protected $text = '';
    protected $allowedTags = '';

    public function __construct($text = '')
    {
        if (!empty($text)) {
            return $this->text($text);
        }
    }

    public function text($text)
    {
        $this->text = $text;
        return $text;
    }

    public function except(array $notAllowedTags)
    {
        $this->allowedTags = $this->tags();
        $this->allowedTags = array_diff($this->allowedTags, $notAllowedTags);
        return $this;
    }

    protected function tags()
    {
        return [
            'br',
            'body',
            'html',
            'head',
            'meta',
            'link',
            'strong',
            'b',
            'a',
            'p'
        ];
    }

    public function allow(array $allowedTags)
    {
        $this->allowedTags = $allowedTags;
        return $this;
    }

    public function strip()
    {
        $allowedTags = $this->make();

        $this->reset();

        return strip_tags($this->text, $allowedTags);
    }

    protected function make()
    {
        $tags = implode('><', $this->allowedTags);

        return '<' . $tags . '>';
    }

    protected function reset()
    {
        $this->allowedTags = '';
    }
}