# Prefetch for Craft CMS 3.x

This plugin allows you to prefetch, preload, preconnect, dns prefetch, subresource, prerender any url in your Twig templates.
Also allows you to load an external font asynchronously.

## Register

```
{% do craft.prefetch.dnsPrefetch('//example.com') %}
{% do craft.prefetch.preconnect('//google.com') %}
{% do craft.prefetch.prefetch('image.png') %}
{% do craft.prefetch.subresource('styles.css') %}
{% do craft.prefetch.prerender('//anothersite.com') %}
{% do craft.prefetch.preload('image.png') %}
{% do craft.prefetch.asynchronousFont('https://fonts.googleapis.com/css2?family=Potta+One&display=swap') %}
```

For very specific cases you can use the `register` method :

`{% do craft.prefetch.register('https://anothersite.com/myFonts.css', 'stylesheet', ['media' => 'print', 'crossorigin']) %}`

This will output :

`<link rel="stylesheet" href="https://anothersite.com/myFonts.css" media="print" crossorigin>`

All these methods also available in php on the Prefetch service :

```
use Ryssbowh\CraftPrefetch\Prefetch;

Prefetch::$plugin->prefetch->dnsPrefetch('//example.com'); 
```

All these methods (but `register`) accept a second parameter to define html arguments :

```
{% do craft.prefetch.preload('image.png', ['crossorigin']) %}
```

By default, the preconnect method will add the crossorigin argument if the domain called is different than the origin domain.

## Print html

Call the hook where you want the html echoed out : `{% hook 'prefetch' %}`


Icons made by https://www.flaticon.com/authors/smashicons