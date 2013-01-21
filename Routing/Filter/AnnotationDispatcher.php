<?php
App::uses('DispatcherFilter', 'Routing');
App::uses('CakeEventManager', 'Event');

use Doctrine\Common\Annotations\AnnotationReader;

use CobaiaAnnotation\EventEmitter;

class AnnotationDispatcher extends DispatcherFilter {

    private $annotationReader;

    public function __construct(AnnotationReader $annotationReader = null) {
        $this->annotationReader = $annotationReader ?: new AnnotationReader;
    }

    public function beforeDispatch($event) {
        $self = $this;

        $self->broadcast('Dispatcher.before', $event);

        CakeEventManager::instance()->attach(
            function ($event) use ($self) {
                $self->broadcast('Controller.initialize', $event);
            }, 
            'Controller.initialize'
        );
    }

    public function broadcast($eventName, $event) {
        $events = EventEmitter::getEvents($eventName);

        foreach ($events as $eventClass) {
            $handler = new $eventClass($this->annotationReader, $event);
            $handler->manages();
        }
    }

}
