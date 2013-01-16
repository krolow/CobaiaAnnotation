<?php
namespace CobaiaAnnotation\Configuration\Controller;

/**
 * @Annotation
 */
class ParamConverter {

    public $param;

    public $class;

    public $method = 'read';

    public function setParam($param) {
        $this->param = $param;
    }

    public function getParam() {
        return $this->param;
    }

    public function setClass($class) {
        $this->class = $class;
    }

    public function getClass() {
        return $this->class;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function getMethod() {
        return $this->method;
    }

}