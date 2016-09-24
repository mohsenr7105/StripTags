# StripTags

PHP strip_tags() function only allow to strip tags that are in a string as second parameter!
and I found i need a solution to strip only some tags!

the __StripTags__ is a solution for me now!

## How to use
```php
$stripTags = new StripTags('<b>some bold</b><a href="#">link</a>');

$stripedText = $stripTags->except(['b', 'p'])->strip();
echo $stripedText; // prints 'some bold<a href="#">link</a>'
```
```php
echo (new StripTags('<b>some bold</b><a href="#">link</a>'))->allow(['a'])->strip();
// prints 'some bold<a href="#">link</a>'
```

# Methods
```php
$stripper->text($text = ''); // defines text for stripping
$stripper->allow(['a']); // same as strip_tags('some tag text', '<a>');
$stripper->except(['a']); // means strip only <a> tags/elements
$stripper->strip(); // stripes text
### Tip
> in a moment only use allow() or except() not both
