# StripTags

PHP strip_tags() function only allow to strip tags that are not in a string as second parameter!
and I found i need a solution to strip only some tags!

the __StripTags__ is a solution for me now!

## How to install
``` bash
composer require mimrahe/striptags:1.3.0
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

__filter an array and then stripping__
```php
$stripped = $stripper->on($textArray)
                     ->filter(function($value, $key){
                        // some checks
                        return $bool;
                     })
                     ->strip();
```

__do something on array before stripping__
```php
$stripped = $stripper->on($textArray)
                     ->before(function(&$value, $key){
                        // do something on array values
                        // note that $value must be as a reference
                        // $key may be a reference
                     })
                     ->strip();
```

__do something on array items after stripping__
```php
$stripped = $stripper->on($textArray)
                     ->after(function(&$value, $key){
                        // do something on array values
                        // note that $value must be as a reference
                        // $key may be a reference
                     })
                     ->strip();
```

# Methods
__Constructor__: Stripper constructor
```php
new Stripper(array | string $subject);
```
parameters:
- $subject: text or array of texts that strippers works on

returns: $this

__on__: specify string or array of strings stripper works on (same as constructor)
```php
$stripper->on(array | string $subject);
```
parameters:
- $subject: text or array of texts that stripper works on

returns: $this

__only__: says strip only this tags
```php
$stripper->only(array $tags);
```
parameters:
- $tags: array of tags that will be stripped

returns: $this

__except__: says strip all tags except some (same as strip_tags)
```php
$stripper->except(array $tags);
```
parameters:
- $tags: array of tags that will not be stripped

returns: $this

### Tip
- in a moment only use only() or except() not both

__filter__: specify a callback which filters subject array
```php
$filter = function($value, $key){
    // some check on value
    return $bool;
}
$stripper->filter(callable $filter);
```
parameters:
- $filter: a closure does filter on array

returns: $this

__before__: specify a callback effects before stripping
```php
$before = function(&$value, $key){
    $value = '<br>' . $value;
}
$stripper->before(callable $before);
```
parameters:
- $before: a closure effects on array items

returns: $this

__after__: specify a callback effects on array items after stripping
```php
$after = function(&$value, $key){
    $value = trim($value);
}
$stripper->after(callable $after);
```
parameters:
- $after: a closure effects on stripped array

returns: $this

__strip__: strips string or array of strings
```php
$stripper->strip();
```
returns: stripped string or array of stripped string
