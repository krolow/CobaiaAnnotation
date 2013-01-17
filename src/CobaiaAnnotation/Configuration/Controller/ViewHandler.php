<?php
namespace CobaiaAnnotation\Configuration\Controller;

/**
 * @Annotation
 */
class ViewHandler {

    public $view;

    public $layout;

    /**
     * Getter for view
     *
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }
    
    /**
     * Setter for view
     *
     * @param mixed $view Value to set
    
     * @return self
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Getter for layout
     *
     * @return mixed
     */
    public function getLayout()
    {
        return $this->layout;
    }
    
    /**
     * Setter for layout
     *
     * @param mixed $layout Value to set
    
     * @return self
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }
    
    
}