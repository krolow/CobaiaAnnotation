<?php
require APP . 'vendor' . DS . 'autoload.php';


use Doctrine\Common\Annotations\AnnotationRegistry;
use CobaiaAnnotation\EventEmitter;

AnnotationRegistry::registerAutoloadNamespace(
    "CobaiaAnnotation\\Configuration\\Controller", 
    dirname(dirname(__FILE__)) . DS . 'src' . DS
);

EventEmitter::addEvent(
    'before',
    'CobaiaAnnotation\\EventListener\\ParamConverterListener'
);