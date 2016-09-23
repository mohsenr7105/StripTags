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
            // basic
            '!DOCTYPE', 'html', 'title', 'body',
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'p', 'br', 'hr',
            // formatting
            'acronym', 'abbr', 'address', 'b', 'bdi', 'bdo', 'big',
            'blockquote', 'center', 'cite', 'code', 'del', 'dfn', 'em',
            'font', 'i', 'ins', 'kbd', 'mark', 'meter', 'pre', 'progress',
            'q', 'rp', 'rt', 'ruby', 's', 'samp', 'small', 'strike', 'strong',
            'sub', 'sup', 'time', 'tt', 'u', 'var', 'wbr',
            // forms and input
            'form', 'input', 'textarea', 'button', 'select', 'optgroup', 'option',
            'label', 'fieldset', 'legend', 'datalist', 'keygen', 'output',
            // frames
            'frame', 'frameset', 'noframes', 'iframe',
            // images
            'img', 'map', 'area', 'canvas', 'figcaption', 'figure',
            // audio and video
            'audio', 'source', 'track', 'video',
            // links
            'a', 'link', 'nav',
            // lists
            'ul', 'ol', 'li', 'dir', 'dl', 'dt', 'dd', 'menu', 'menuitem',
            // tables
            'table', 'caption', 'th', 'tr', 'td', 'thead', 'tbody', 'tfoot', 'col', 'colgroup',
            // styles and semantics
            'style', 'div', 'span', 'header', 'footer', 'main', 'section', 'article',
            'aside', 'details', 'dialog', 'summary',
            // meta info
            'head', 'meta', 'base', 'basefont',
            // programming
            'script', 'noscript', 'applet', 'embed', 'object', 'param'
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