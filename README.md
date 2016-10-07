# StripTags

PHP strip_tags() function only allow to strip tags that are not in a string as second parameter!
and I found i need a solution to strip only some tags!

the __StripTags__ is a solution for me now!

## How to install
``` bash
composer require mimrahe/striptags:1.2.1
```
or download release zip package

## How to use
__Namespace__
```php
\Mimrahe\StripTags\Stripper;
```

__strip only some tags__
```php
$stripTags = new Stripper('<b>some bold</b><a href="#">link</a>');

$stripedText = $stripTags->only(['b', 'p'])->strip();
echo $stripedText; // prints 'some bold<a href="#">link</a>'
```

__strip all tags except some tags__
```php
echo (new Stripper('<b>some bold</b><a href="#">link</a>'))->except(['a'])->strip();
// prints 'some bold<a href="#">link</a>'
```

__in loop usage example__
```php
$stripper = new Stripper();
$stripper->only(['a', 'ul', 'li']);
$textArray = [
    // some texts that will be stripped
];

foreach($textArray as $text)
{
    echo $stripper->on($text)->strip();
}
```

__giving an Array to Stripper__
```php
$stripper = new Stripper();
$stripper->only(['a', 'ul', 'li']);
$textArray = [
    // some texts that will be stripped
];
$strippedArray = $stripper->on($textArray)->strip();
```
### Tip
- you can give a nested array to method 'on'

# Methods
```php
$stripper->on('<a href="#">link</a>'); // defines text for stripping
$stripper->except(['a']); // same as strip_tags('some tag text', '<a>');
$stripper->only(['a']); // means strip only <a> tags/elements
$stripper->strip(); // stripes text
```
### Tip
- in a moment only use only() or except() not both
