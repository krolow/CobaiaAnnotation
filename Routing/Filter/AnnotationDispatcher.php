<?php
App::uses('DispatcherFilter', 'Routing');
App::uses('CakeEventManager', 'Event');

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\FileCacheReader;

use CobaiaAnnotation\EventEmitter;

class AnnotationDispatcher extends DispatcherFilter {

    private $annotationReader;

    public function __construct(Reader $annotationReader = null) {
        $this->annotationReader = $annotationReader ?: new FileCacheReader(
            new AnnotationReader(),
            TMP,
            Configure::read('debug') > 0
        );
    }

    public function beforeDispatch($event) {
        foreach (EventEmitter::getEventNames() as $eventName) {
            foreach (EventEmitter::getEvents($eventName) as $eventClass) {
                $this->attachEvent($eventName, $eventClass, $this->annotationReader);
            }
        }
    }

    protected function attachEvent($eventName, $eventClass, $annotationReader) {
        CakeEventManager::instance()->attach(
            function ($event) use ($eventClass, $annotationReader) {
                $eventHandler = new $eventClass($annotationReader, $event);
                $eventHandler->manages();
            }, 
            $eventName
        );        
    }

}
