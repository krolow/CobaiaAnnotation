<?php
namespace CobaiaAnnotation\EventListener;

use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionMethod;
use App;

abstract class BaseListener {

    protected $reader;

    protected $event;

    public function __construct(Reader $reader, $event) {
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

}