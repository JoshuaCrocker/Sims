<?php
    
/**
 * Database class
 * 
 * @extends     PDO
 * @author      Joshua Crocker
 * @category    System
 * @version     1.0.0
 */
class Database extends PDO {
    
    /**
     * Database Constructor
     * 
     * @access public
     * @param string $file The Database Configuration file (default: 'my_setting.ini')
     * @return void
     */
    public function __construct($file = 'my_setting.ini') {
        if (!$settings = parse_ini_file($file, TRUE)) {
            throw new exception('Unable to open ' . $file . '.');
        }

        $dns = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['schema'];

        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
    }
}
