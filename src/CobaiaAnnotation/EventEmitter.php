<?php
namespace CobaiaAnnotation;

class EventEmitter {
    
    static private $events = array(
    );

    static public function addEvent($type, $annotationListener) {
        if (!class_exists($annotationListener)) {
            throw new \InvalidArgumentExcpetion('You must add one existing event class');
        }
        if (!isset(self::$events[$type])) {
            self::$events[$type] = array();
        }

        array_push(
            self::$events[$type],
            $annotationListener
        );
    }

    static public function getEvents($type) {
        if (array_key_exists($type, self::$events)) {
            return self::$events[$type];
        }

        return array();
    }

    static public function getEventNames() {
        return array_keys(self::$events);
    }

}