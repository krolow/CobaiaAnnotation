<?php
namespace CobaiaAnnotation\EventListener;

use CobaiaAnnotation\EventListener\AnnotationListener;
use CobaiaAnnotation\EventListener\BaseListener;
use ClassRegistry;
use ReflectionParameter;

class ViewHandlerListener extends BaseListener implements AnnotationListener {

    public function manages() {
        $annotation = $this->reader->getClassAnnotation(
            $this->getReflectionClass($this->getControllerName()),
            'CobaiaAnnotation\\Configuration\\Controller\\ViewHandler'
        );

        if (!$annotation) {
            return;
        }

        $this->handleAnnotation($annotation);

        $methodReflection =  $this->getReflectionMethod(
            $this->getControllerName(),
            $this->getActionName()
        );

        $annotation = $this->reader->getMethodAnnotation(
            $methodReflection,
            'CobaiaAnnotation\\Configuration\\Controller\\ViewHandler'
        );

        $this->handleAnnotation($annotation);
    }

    protected function handleAnnotation($annotation) {
        if (is_object($annotation) && $annotation->layout !== null) {
            $this->event->subject()->layout = $annotation->layout;
        }

        if (is_object($annotation) && $annotation->view !== null) {
            $this->event->subject()->view = $annotation->view; 
        }
    }

    protected function getControllerName() {
        return $this->event->subject()->name . 'Controller';
    }

    protected function getActionName() {
        return $this->event->subject()->request->params['action'];
    }

}