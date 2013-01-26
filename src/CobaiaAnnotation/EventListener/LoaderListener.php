<?php
namespace CobaiaAnnotation\EventListener;

use CobaiaAnnotation\EventListener\AnnotationListener;
use CobaiaAnnotation\EventListener\BaseListener;
use ClassRegistry;
use ReflectionParameter;

class LoaderListener extends BaseListener implements AnnotationListener {

    public function manages() {
        $classReflection = $this->getReflectionClass($this->getControllerName());
        $modelAnnotation = $this->reader->getClassAnnotation(
            $classReflection,
            'CobaiaAnnotation\\Configuration\\Controller\\Loader\\ModelLoader'
        );

        $this->handleModelAnnotation($modelAnnotation);

        $helperAnnotation = $this->reader->getClassAnnotation(
            $classReflection,
            'CobaiaAnnotation\\Configuration\\Controller\\Loader\\HelperLoader'
        );

        $this->handleHelperAnnotation($helperAnnotation);

        $componentAnnotation = $this->reader->getClassAnnotation(
            $classReflection,
            'CobaiaAnnotation\\Configuration\\Controller\\Loader\\ComponentLoader'
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
        $value = $this->handleAnnotation($annotation, 'helpers');

        if (!$value) {
            return;
        }

        $this->event->subject()->helpers = $value;
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
            return false;
        }

        $value = $annotation->{$name};

        if (!is_array($value)) {
            $value = array($value);
        }

        return count($value) > 0 ? $value : false;
    }

    protected function getControllerName() {
        return $this->event->subject()->name . 'Controller';
    }

}