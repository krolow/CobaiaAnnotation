<?php
namespace CobaiaAnnotation\EventListener;

use CobaiaAnnotation\EventListener\AnnotationListener;
use CobaiaAnnotation\EventListener\BaseListener;
use ClassRegistry;
use ReflectionParameter;

class ParamConverterListener extends BaseListener implements AnnotationListener {

    public function manages() {
        $methodReflection =  $this->getReflectionMethod(
            $this->getControllerName(),
            $this->getActionName()
        );
        $annotation = $this->reader->getMethodAnnotation(
            $methodReflection,
            'CobaiaAnnotation\\Configuration\\Controller\\ParamConverter'
        );

        if (!$annotation) {
            return;
        }

        $index = 0;
        foreach ($methodReflection->getParameters() as $param) {
            if ($param->name == $annotation->param) {
                break;
            }
            $index++;
        }

        $params = $this->event->subject()->request->params;
        $data = ClassRegistry::init($annotation->class)->{$annotation->method}(null, $params['pass'][$index]);
        $params['pass'][$index] = $data;

        $this->event->subject()->request->addParams($params);
    }

    protected function getControllerName($event = null) {
        $event = $event ?: $this->event;
        return get_class($event->subject());
    }

    protected function getActionName($event = null) {
        $event = $event ?: $this->event;
        return $event->subject()->action;
    }

}