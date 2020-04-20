mod-admin
===========
Module for PIXELION CMS

[![Latest Stable Version](https://poser.pugx.org/shopium/mod-admin/v/stable)](https://packagist.org/packages/shopium/mod-admin)
[![Total Downloads](https://poser.pugx.org/shopium/mod-admin/downloads)](https://packagist.org/packages/shopium/mod-admin)
[![Monthly Downloads](https://poser.pugx.org/shopium/mod-admin/d/monthly)](https://packagist.org/packages/shopium/mod-admin)
[![Daily Downloads](https://poser.pugx.org/shopium/mod-admin/d/daily)](https://packagist.org/packages/shopium/mod-admin)
[![Latest Unstable Version](https://poser.pugx.org/shopium/mod-admin/v/unstable)](https://packagist.org/packages/shopium/mod-admin)
[![License](https://poser.pugx.org/shopium/mod-admin/license)](https://packagist.org/packages/shopium/mod-admin)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer require --prefer-dist shopium/mod-admin "*"
```

or add

```
"shopium/mod-admin": "*"
```

to the require section of your `composer.json` file.

Add to web config.
```
'modules' => [
    'admin' => ['class' => 'shopium\mod\admin\Module'],
],
```