# StripTags

PHP strip_tags() function only allow to strip tags that are in a string as second parameter!
and I found i need a solution to strip only some tags!

the __StripTags__ is a solution for me now!

## How to install
``` bash
composer require mimrahe/striptags:1.1
```
or download release zip package

## How to use
```php
$stripTags = new StripTags('<b>some bold</b><a href="#">link</a>');

$stripedText = $stripTags->only(['b', 'p'])->strip();
echo $stripedText; // prints 'some bold<a href="#">link</a>'
```
```php
echo (new StripTags('<b>some bold</b><a href="#">link</a>'))->except(['a'])->strip();
// prints 'some bold<a href="#">link</a>'
```
```php
$stripper = new Stripper();
$stripper->only(['a', 'ul', 'li']);
$textArray = [
    // some texts that will be stripped
];

foreach($textArray as $text)
{
    echo $stripper->text($text)->strip();
}
```

# Methods
```php
$stripper->text('<a href="#">link</a>'); // defines text for stripping
$stripper->except(['a']); // same as strip_tags('some tag text', '<a>');
$stripper->only(['a']); // means strip only <a> tags/elements
$stripper->strip(); // stripes text
### Tip
> in a moment only use allow() or except() not both
