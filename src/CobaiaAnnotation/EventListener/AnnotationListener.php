<?php
namespace CobaiaAnnotation\EventListener;

use Doctrine\Common\Annotations\Reader;

interface AnnotationListener {

    public function __construct(Reader $reader, $event);
    
    public function manages();

}