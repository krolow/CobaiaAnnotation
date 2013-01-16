<?php
App::uses('DispatcherFilter', 'Routing');

use Doctrine\Common\Annotations\AnnotationReader;

use CobaiaAnnotation\EventEmitter;

class AnnotationDispatcher extends DispatcherFilter {

    private $annotationReader;

    public function __construct(AnnotationReader $annotationReader = null) {
        $this->annotationReader = $annotationReader ?: new AnnotationReader;
    }

    public function beforeDispatch($event) {
        $events = EventEmitter::getEvents('before');

        $loader = function ($className, $location) {
            App::uses($className, $location);
        };

        foreach ($events as $eventClass) {
            $event = new $eventClass($this->annotationReader, $event);
            $event->manages();
        }

        /*$reflectionClass = $this->getReflectionClass(
            $this->getControllerName($event)
        );
        $reflectionMethod = $this->getReflectionMethod(
            $reflectionClass,
            $this->getActionName($event)
        );

        $methodAnnotations = $this->annotationReader->getMethodAnnotations($reflectionMethod);
        
        $this->callManagers($methodAnnotations);*/
    }

}
