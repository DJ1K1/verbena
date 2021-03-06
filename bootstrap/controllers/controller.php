<?php

/**
 * VERBENA FRAMEWORK
 * 2015 - MIT LICENSE.
 */

namespace Bootstrap\Controllers;

use Bootstrap\Environment\Tracer;
use Bootstrap\Components\Language;
use Bootstrap\Components\Security;
use Bootstrap\Views\View;
use Bootstrap\Exceptions\ControllerException;

class Controller {

    /**
     * Instances container.
     * @var object
     */
    protected static $_instances = [];

    /**
     * View variables.
     * @var array
     */
    protected static $view = [];


    /**
     * Create the controller instance.
     *
     * @access  public
     * @param   void
     * @return  object
     */
    public static function instance_class() {
        
        $_class = get_called_class();

        if (!isset(static::$_instances[$_class])) {
            static::$_instances[$_class] = new $_class();
        }

        return static::$_instances[$_class];

    }

    /**
     * Get the name of the current called method.
     *
     * @access  public
     * @param   void
     * @return  string
     */
    public static function get_current_called_method() {

        $_traces = debug_backtrace();

        if (isset($_traces[3]['args'][0]['method'])) {
            return $_traces[3]['args'][0]['method']; 
        } 

        return null; 

    }

    /**
     * Set session language and redirect 
     * to the webroot (if not null).
     *
     * @access  public
     * @param   string
     * @param   bool
     * @return  void
     */
    public static function language($_language = null, $_redirect = null) {

        if (!is_null($_language)) {
            Language::set($_language);
        }

        if (is_null($_redirect)) {
            View::redirect();
        }

    }

    /**
     * Magic method that will be called when trying
     * to call a class method that doesn't exists.
     *
     * @access  public
     * @param   string
     * @param   array
     * @return  exception
     */
    public function __call($name, $arguments) {

        Tracer::add("[[Controller:]] called an undefined method [['$name']]");

        try {
            throw new ControllerException("called an undefined method [['$name']]");
        }
        catch (ControllerException $exception) {
            echo $exception->get_formatted_exception();
        }

    }

    /**
     * Magic method that will be called when trying
     * to call statically a class method that 
     * doesn't exists.
     *
     * @access  public
     * @param   string
     * @param   array
     * @return  exception
     */
    public static function __callStatic($name, $arguments) {

        Tracer::add("[[Controller:]] called an undefined method [['$name']]");

        try {
            throw new ControllerException("called an undefined method [['$name']]");
        }
        catch (ControllerException $exception) {
            echo $exception->get_formatted_exception();
        }
    
    }

}