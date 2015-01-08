Croogodown
----------

This plugin enables use of Markdown (Using the [commonmark](http://commonmark.org/) standard) for nodes.

NB. This does not convert existing HTML nodes to Markdown!

Installation
------------

Install using composer by running `composer require dakota/croogomark`.

Usage
-------------

1. Activate the plugin

2. Disable the CkEditor plugin

3. Create or edit a node

Requirements
------------

* Croogo 2.2 - http://croogo.org/
* PHP 5.3.3

Advanced usage
--------------

When markdown text is rendered into HTML, a number of Croogo hooks are triggered.
This makes it possible to alter the behaviour of the [CommonMark](http://commonmark.thephpleague.com/) library.

The hooks are:

* `Helper.Markdown.beforeMarkdownParse` - Receives two arguments and is triggered after the CommonMark environment is created, but before the AST is generated. The arguments are:
** `environment` - the CommonMark environment object
** `markdown` - the text that will be rendered.
* `Helper.Markdown.beforeMarkdownRender` - Receives one argument, and is triggered after the AST is generated, but before the HTML is rendered.
** `ast` - The CommonMark AST document
* `Helper.Markdown.afterMarkdownRender` - Receives one argument, and is triggered after the HTML is generated.
** `rendered` - The rendered HTML

Custom parsers and renderers
============================

Using the hooks, it is possible to implement your own custom block or inline parser and renderer.
For example, to implement the twitter example given in the [CommonMark documentation](http://commonmark.thephpleague.com/customization/inline-parsing/#example-1---twitter-handles)
you could do the following:

```php
//Config/bootstrap.php
CakeEventManager::instance()->attach(function ($event) {
	//Assuming that you've created the TwitterHandleParser in Lib/
	App::uses('TwitterHandleParser', 'Lib');
	$event->data['environment']->addInlineParser(new TwitterHandleParser());
}, 'Helper.Markdown.beforeMarkdownParse');
```

