# StripTags

PHP strip_tags() function only allow to strip tags that are in a string as second parameter!
and I found i need a solution to strip all tags except some tags!

the __StripTags__ is a solution for me now!

## How to use
```php
$stripTags = new StripTags('<b>some bold</b><a href="#">link</a>');

$stripedText = $stripTags->except(['b', 'p'])->strip();
echo $stripedText; // prints 'some bold<a href="#">link</a>'
```
or
```php
echo (new StripTags('<b>some bold</b><a href="#">link</a>'))->allow(['a'])->strip();
// prints 'some bold<a href="#">link</a>'
```
