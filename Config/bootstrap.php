<?php
require APP . 'vendor' . DS . 'autoload.php';


use Doctrine\Common\Annotations\AnnotationRegistry;
use CobaiaAnnotation\EventEmitter;

AnnotationRegistry::registerAutoloadNamespace(
    "CobaiaAnnotation\\Configuration\\Controller", 
    dirname(dirname(__FILE__)) . DS . 'src' . DS
);

EventEmitter::addEvent(
    'Controller.initialize',
    'CobaiaAnnotation\\EventListener\\ParamConverterListener'
);
EventEmitter::addEvent(
    'Controller.beforeRender',
    'CobaiaAnnotation\\EventListener\\ViewHandlerListener'
);

EventEmitter::addEvent(
    'Controller.initialize',
    'CobaiaAnnotation\\EventListener\\LoaderListener'
);