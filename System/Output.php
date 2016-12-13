<?php
    
/**
 * Output class
 *
 * @author      Joshua Crocker
 * @category    System
 * @version     1.0.0
 */
class Output {
    /**
      * @const LEVEL_LOG
      */
    const LEVEL_LOG = 0;

    /**
      * @const LEVEL_WARN
      */
    const LEVEL_WARN = 1;

    /**
      * @const LEVEL_ERROR
      */
    const LEVEL_ERROR = 2;

    /**
     * Level Prefixes
     * 
     * @var array
     * @access private
     * @static
     */
    private static $levels = [
        'LOG  ',
        'WARN ',
        'ERROR'
    ];

    /**
     * Class Instance
     * 
     * (default value: null)
     * 
     * @var mixed
     * @access public
     * @static
     */
    public static $instance = null;

    /**
     * Output Array
     *
     * Stores all data to be output
     * 
     * (default value: [])
     * 
     * @var array
     * @access private
     */
    private $output = [];

    /**
     * Get Instance Method
     * 
     * @access public
     * @static
     * @return Output
     */
    public static function getInstance() {
        // Check to see if an instance exists
        if (self::$instance == null) {
            // Create a new instance
            self::$instance = new self();
        }
        
        // Return the instance
        return self::$instance;
    }

    /**
     * Get Output Method
     *
     * Print the data in the output array to the screen
     * 
     * @access public
     * @return void
     */
    public function getOutput() {
        foreach ($this->output as $output) {
            print self::$levels[$output[1]] . ': ' . $output[0] . "\n";
        }
    }

    /**
     * Get Raw Output Method
     *
     * Get the raw output array
     * 
     * @access public
     * @return array
     */
    public function getOutputRaw() {
        return $this->output;
    }

    /**
     * Log Method
     *
     * Create a log-level message
     * 
     * @access public
     * @param mixed $message The message to log
     * @return void
     */
    public function log($message) {
        $this->addOutput($message, Output::LEVEL_LOG);
    }

    /**
     * Warning Method
     *
     * Create a warning-level message
     * 
     * @access public
     * @param mixed $message The message to log
     * @return void
     */
    public function warning($message) {
        $this->addOutput($message, Output::LEVEL_WARN);
    }

    /**
     * Error Method
     *
     * Create an error-level message
     * 
     * @access public
     * @param mixed $message The message to log
     * @return void
     */
    public function error($message) {
        $this->addOutput($message, Output::LEVEL_ERROR);
    }

    /**
     * Add Output Method
     * 
     * @access public
     * @param mixed $message The message to log
     * @param mixed $level The message output level (default: Output::LEVEL_LOG)
     * @return void
     */
    public function addOutput($message, $level = Output::LEVEL_LOG) {
        $this->output[] = [$message, $level];
    }

    /**
     * Clear Output Method
     *
     * Empty the output array
     * 
     * @access public
     * @return void
     */
    public function clearOutput() {
        $this->output = [];
    }
}
