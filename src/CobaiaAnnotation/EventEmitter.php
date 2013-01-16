<?php
namespace CobaiaAnnotation;

class EventEmitter {
    
    static private $events = array(
        'before' => array(),
        'after' => array()
    );

    static public function addEvent($type, $annotationListener) {
        if (!class_exists($annotationListener)) {
            throw \InvalidArgumentException('You must add one existing event class');
        }
        array_push(
            self::$events[$type],
            $annotationListener
        );
    }

    static public function getEvents($type) {
        return self::$events[$type];
    }

}