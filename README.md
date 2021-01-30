# Prefetch for Craft CMS 3.x

Prefetch, preload, preconnect, dns prefetch, subresource, prerender in your Twig templates :

```
{% do craft.prefetch.dnsPrefetch('//example.com') %}
{% do craft.prefetch.preconnect('//google.com') %}
{% do craft.prefetch.prefetch('image.png') %}
{% do craft.prefetch.subresource('styles.css') %}
{% do craft.prefetch.prerender('//anothersite.com') %}
{% do craft.prefetch.preload('image.png') %}
```

Or with php :

```
use Ryssbowh\CraftPrefetch\Prefetch;

Prefetch::$plugin->prefetch->dnsPrefetch('//example.com'); 
Prefetch::$plugin->prefetch->dnsPrefetch('//google.com');  
Prefetch::$plugin->prefetch->dnsPrefetch('image.png');  
Prefetch::$plugin->prefetch->dnsPrefetch('styles.css');  
Prefetch::$plugin->prefetch->dnsPrefetch('//anothersite.com');  
Prefetch::$plugin->prefetch->dnsPrefetch('image.png');
```