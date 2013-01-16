<?php
namespace CobaiaAnnotation\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;

interface AnnotationListener {

    public function __construct(AnnotationReader $reader, $event);
    
    public function manages();

}