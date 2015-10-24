Sitemap plugin for CakePHP
==========================

[![Build Status](https://travis-ci.org/Adnan0703/sitemap.svg)](https://travis-ci.org/Adnan0703/sitemap)
[![Coverage Status](https://coveralls.io/repos/Adnan0703/sitemap/badge.svg?branch=master&service=github)](https://coveralls.io/github/Adnan0703/sitemap?branch=master)


The **Sitemap** plugin is a CakePHP wrapper around [Cartographer](http://github.com/tackk/cartographer/) library. 
It makes it very easy to generate sitemap. The **Sitemap** plugin can handle Sitemaps of more than 50,000 entries. 
Also it iterates over table records instead of retrieving all records at once.

Requirements
------------

 * PHP 5.4+
 * CakePHP 3.0
 * Cartographer Library (included as composer dependency)

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).


```
composer require adnan0703/Sitemap
```

How to use it
-------------

For example if you want to generate sitemap of Posts model, you need to define `sitemapQuery` method in Posts table class
and `sitemapEntry` virtual property in entity class of Posts model. The `sitemapQuery` method must return `Query` object and
`sitemapEntry` must be an `array` containing at least `url` key.

With `sitemapQuery` method you can control records that will be added to sitemap and with `sitemapEntry` virtual property
you can control properties of sitemap entry.
``` php
// in Posts table class
public function sitemapQuery()
{
	return $this->find()
		->select(['id', 'name'])
		->where(['published' => true]);
}
```
``` php
// in Posts entity class
protected function _getSitemapEntry() 
{
	return [
		'url' => $url, // required
		'changefreq' => 'weekly', // optional
		'priority' => '0.8', // optional
	];
}
```
Now we can generate sitemap of Posts model as shown in code below.
``` php
set_time_limit(60*10); // if you have lots of records
$models = ['Posts'];
$dirPath = WWW_ROOT . DS . 'sitemaps';
$sitemap = new \Adnan0703\Sitemap\Lib\Sitemap();
$mainSitemap = $sitemap->createSitemap(
	$dirPath, 
	'http://cakephp.org/sitemaps/', 
	$models, 
	true
);
// $mainSitemap will be 'http://cakephp.org/sitemaps/sitemap.xml'
```
You can also add Pages controller urls and other urls in sitemap.
``` php
Configure::write('Sitemap.pages', [
	[
		'url' => Router::url(['controller' => 'Pages', 'action' => 'home'], true), 
		'priority' => '0.9', 
		'changefreq' => 'daily'
	],
	[
		'url' => Router::url(['controller' => 'Pages', 'action' => 'about_us'], true), 
		'priority' => '0.9', 
		'changefreq' => 'daily'
	],
]);
```

Configuration Options
---------------------

**Sitemap** plugin has two configuration options.
`Sitemap.pages` and `Sitemap.findLimit`. `Sitemap.pages` option has been explained above. With `Sitemap.findLimit` you can
limit the number of records **Sitemap** retrieves at a time while iterating over table.
``` php
Configure::write('Sitemap.findLimit', 600);
```

Support
-------

For bugs and feature requests, please use the [issues](https://github.com/adnan0703/Sitemap/issues) section of this repository.

Contributing to this Plugin
---------------------------

Please feel free to contribute to the plugin with new issues, requests, unit tests and code fixes or new features.

License
-------

Copyright 2015, Adnan Aslam

Licensed under The MIT License
Redistributions of files must retain the above copyright notice.
