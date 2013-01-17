<?php
namespace CobaiaAnnotation\EventListener;

use CobaiaAnnotation\EventListener\AnnotationListener;
use CobaiaAnnotation\EventListener\BaseListener;
use ClassRegistry;
use ReflectionParameter;
use Inflector;

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
        $params = $this->event->data['request']->params;
        $data = ClassRegistry::init($annotation->class)->{$annotation->method}(null, $params['pass'][$index]);
        $params['pass'][$index] = $data;
        $this->event->data['request']->addParams($params);
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