# Neos CMS JS Minifier

A Neos CMS plugin to minifie JS for Neos CMS

## Installation

The NeosRulez.JsMinifier package is listed on packagist (https://packagist.org/packages/neosrulez/jsminifier) - therefore you don't have to include the package in your "repositories" entry any more.

Just add the following line to your require section:

```
"neosrulez/jsminifier": "*"
```

And the run this command to fetch the plugin:

```
composer update
```

## Fusion

In your site package Fusion file you can add the .js files to minifie

```
prototype(Neos.Neos:Page) {
    head {
        yourjs = NeosRulez.JsMinifier:JsFile
        yourjs {
            source = 'resource://Your.Site/Private/JavaScript/app.js'
            inline = FALSE
            outputFolder = 'resource://Your.Site/Public/JavaScript/'
        }
    }
}
```

## Author

* E-Mail: mail@patriceckhart.com 
* URL: http://www.patriceckhart.com 