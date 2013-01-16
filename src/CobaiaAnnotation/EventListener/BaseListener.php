<?php
namespace CobaiaAnnotation\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use ReflectionMethod;
use App;
use Inflector;

abstract class BaseListener {

    protected $reader;

    protected $event;

    public function __construct(AnnotationReader $reader, $event) {
        $this->reader = $reader;
        $this->event = $event;
    }
    
   protected function getReflectionClass($class) {
        if (!class_exists($class)) {
            App::uses($class, 'Controller');
        }

        return new ReflectionClass($class);
    }

    protected function getReflectionMethod($class, $method) {
        if (!class_exists($class)) {
            App::uses($class, 'Controller');
        }

        return new ReflectionMethod($class, $method);
    }

    protected function getControllerName($event = null) {
        $event = $event ?: $this->event;
        return Inflector::camelize(
            $event->data['request']->params['controller']
        ) . 'Controller';
    }

    protected function getActionName($event = null) {
        $event = $event ?: $this->event;
        return $event->data['request']->params['action'];
    }

}