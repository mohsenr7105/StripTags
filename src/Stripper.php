<?php
namespace Mimrahe\StripTags;
/**
 * strip_tags() replacement class
 *
 * @package     mimrahe/striptags
 * @author      mohsen ranjbar <mimrahe@gmail.com>
 */

class Stripper
{
    /**
     * subject to be stripped
     * @var array|string
     */
    protected $subject;

    /**
     * function to do on subjects before stripping
     * @var callable
     */
    protected $before;

    /**
     * function to do on subjects after stripping
     * @var callable
     */
    protected $after;

    /**
     * function to filter subjects before stripping
     * @var callable
     */
    protected $filter;

    /**
     * allowed tags string
     * @var string|array
     */
    protected $allowedTags = array();

    /**
     * Stripper constructor.
     * @param array|string $subject
     */
    public function __construct($subject = '')
    {
        if (!empty($subject)) {
            return $this->on($subject);
        }
    }

    /**
     * defines subject to be stripped
     * @param array|string $subject
     * @return $this
     */
    public function on($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * defines not allowed tags
     * @param array $notAllowedTags
     * @return $this
     */
    public function only(array $notAllowedTags)
    {
        $this->allowedTags = $this->tags();
        $this->allowedTags = array_diff($this->allowedTags, $notAllowedTags);
        return $this;
    }

    /**
     * defines allowed tags
     * @param array $allowedTags
     * @return $this
     */
    public function except(array $allowedTags)
    {
        $this->allowedTags = $allowedTags;
        return $this;
    }

    /**
     * stripes $subject with $allowedTags
     * @return string
     */
    public function strip()
    {
        $allowedTags = $this->make();

        if(is_array($this->subject)){
            return $this->stripArray($allowedTags, $this->subject);
        }

        return strip_tags($this->subject, $allowedTags);
    }

    /**
     * set function to do on subjects before stripping
     * @param callable $before
     * @return $this
     */
    public function before(callable $before)
    {
        $this->before = $before;
        return $this;
    }

    /**
     * set function to do on subjects after stripping
     * @param callable $after
     * @return $this
     */
    public function after(callable $after)
    {
        $this->after = $after;
        return $this;
    }

    /**
     * set function to filter subjects before stripping
     * @param callable $filter
     * @return $this
     */
    public function filter(callable $filter)
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * makes strip_tags() allowed tags string
     * @return string
     */
    protected function make()
    {
        $tags = implode('><', $this->allowedTags);

        return empty($tags) ? $tags : '<' . $tags . '>';
    }

    /**
     * strip array subjects
     * @param string $allowedTags
     * @return array
     */
    protected function stripArray($allowedTags, array $subject)
    {
        if(is_callable($this->filter)){
            $subject = $this->doFilter($subject);
        }

        if(is_callable($this->before)){
            array_walk_recursive($subject, $this->before);
        }

        array_walk_recursive($subject, function(&$value) use ($allowedTags) {
            $value = strip_tags($value, $allowedTags);
        });

        if(is_callable($this->after)){
            array_walk_recursive($subject, $this->after);
        }

        return $subject;
    }

    /**
     * does filter on subject
     * @param array $subject
     * @return array
     */
    protected function doFilter(array $subject)
    {
        $filtered = array_filter($subject, $this->filter, ARRAY_FILTER_USE_BOTH);

        foreach($subject as $key => $value)
        {
            if(is_array($value)){
                $result = $this->doFilter($value);
                if(!empty($result))
                    $filtered[$key] = $result;
            }
        }

        ksort($filtered);
        return $filtered;
    }

    /**
     * returns html elements/tags list in an array
     * @return array
     */
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
}