CobaiaAnnotation
================

Annotations in CakePHP.

## Why?

- Because Annotations are cool!
- Because We like (or at least I like)
- Because no make sense repeate over and over the same code in PHP
- Use PHP array to configure is sux
- Metadata and Metaprogramming are cool!

## Installing

CobaiaAnnotations make usage of <a href="http://getcomposer.org">composer</a>, so download composer and create your <code>app/composer.json</code>

```javascript
{
    "name": "testing",
    "require": {
        "php": ">=5.3.0",
        "cakephp/debug_kit" : "*",
        "cobaia/cobaia-annotation": "dev-master"
    },
    "minimum-stability": "dev"
}
```

It's time to running <code>composer.phar install</code>

After install it's time to load the plugin, open <code>app/Config/bootstrap.php</code>

```php
CakePlugin::load('CobaiaAnnotation', array('bootstrap' => true));

//register filter
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher',
    'CobaiaAnnotation.AnnotationDispatcher'
));
```


## What annotations do we have in CobaiaAnnotation?


### @ParamConverter

```php
<?php
App::uses('AppController', 'Controller');

use CobaiaAnnotation\Configuration\Controller\ParamConverter;

class ContentsController extends AppController {
   

    /**
     * @ParamConverter("content", class="Content")
     */
    public function view($content = 1) {
        var_dump($content);
    }

}
```

ParamConverter will automatically converts the action paramter to data that is in the database.

### @ViewHandler

```php
<?php
App::uses('AppController', 'Controller');

use CobaiaAnnotation\Configuration\Controller\ViewHandler;

/**
 * @ViewHandler(layout="ajax")
 */
class ContentsController extends AppController {
   
    /**
     * @ViewHandler(view="show")
     */
    public function view() {
    }

    /**
     * @ViewHandler(layout="default")
     */
    public function index() {

    }

}
```

ViewHandler will take care of your view, forget about <code>$this->layout</code>, <code>$this->render()</code>, just define in the annotation what layout you want to use and also what view, and that's it.

It makes also inheritance so if you define one layout or view in the class DocBlock, the actions will inherit the value.

### @ModelLoader, @ComponentLoader, @HelperLoader

```php
<?php
App::uses('AppController', 'Controller');

use CobaiaAnnotation\Configuration\Controller\Loader\ModelLoader;
use CobaiaAnnotation\Configuration\Controller\Loader\ComponentLoader;
use CobaiaAnnotation\Configuration\Controller\Loader\HelperLoader;

/**
 * @ModelLoader({"Content", "Fake"})
 * @ComponentLoader({"Session", "RequestHandler"})
 * @HelperLoader({"Text", "Time", "Number"})
 */
class ContentsController extends AppController {
   

    public function view($content = 1) {
    }

}
```

@Model, @Component, @Helper will handle to you the load of models, components and helpers, not needed anymore put the attribute of class in your code.


## What next?

- @Route (adding custom routes in your controller)
- @Auth (allow, deny)
- @Route (adding custom routes in your controller)
- @Auth (allow, deny)
- @Table
- @HasMany
- @HasAndBelongsToMany
- @BelongsTo
- @Behaviors
- Check performance with 2 autoloads
- Cache annotations parsed
- Add Unit Tests

## License

Licensed under <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
Redistributions of files must retain the above copyright notice.

## Author

Vinícius Krolow - krolow[at]gmail.com
