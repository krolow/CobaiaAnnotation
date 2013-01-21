<?php
namespace CobaiaAnnotation\EventListener;

use CobaiaAnnotation\EventListener\AnnotationListener;
use CobaiaAnnotation\EventListener\BaseListener;
use ClassRegistry;
use ReflectionParameter;

class LoadListener extends BaseListener implements AnnotationListener {

    public function manages() {
        $classReflection = $this->getReflectionClass($this->getControllerName());
        $modelAnnotation = $this->reader->getClassAnnotation(
            $classReflection,
            'CobaiaAnnotation\\Configuration\\Controller\\Load\\Model'
        );

        $this->handleModelAnnotation($modelAnnotation);

        $helperAnnotation = $this->reader->getClassAnnotation(
            $classReflection,
            'CobaiaAnnotation\\Configuration\\Controller\\Load\\Helper'
        );

        $this->handleHelperAnnotation($helperAnnotation);

        $componentAnnotation = $this->reader->getClassAnnotation(
            $classReflection,
            'CobaiaAnnotation\\Configuration\\Controller\\Load\\Component'
        );

        $this->handleComponentAnnotation($componentAnnotation);
    }

    protected function handleModelAnnotation($annotation) {
        $value = $this->handleAnnotation($annotation, 'models');

        if (!$value) {
            return;
        }
        
        foreach ($value as $model) {
            $this->event->subject()->loadModel($model);
        }
    }

    protected function handleHelperAnnotation($annotation) {
        $this->event->subject()->helpers = $this->handleAnnotation($annotation, 'helpers');
    }

    protected function handleComponentAnnotation($annotation) {
        $value = $this->handleAnnotation($annotation, 'components');

        if (!$value) {
            return;
        }

        $this->event->subject()->components = $value;
        $this->event->subject()->Components->init($this->event->subject());
    }

    protected function handleAnnotation($annotation, $name) {
        if (!is_object($annotation) || $annotation->{$name} == null) {
            return;
        }

        $value = $annotation->{$name};

        if (!is_array($value)) {
            $value = array($value);
        }

        return $value;
    }

    protected function getControllerName() {
        return $this->event->subject()->name . 'Controller';
    }

}