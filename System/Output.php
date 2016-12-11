<?php
class Output {
    const LEVEL_LOG = 0;
    const LEVEL_WARN = 1;
    const LEVEL_ERROR = 2;

    private static $levels = [
        'LOG  ',
        'WARN ',
        'ERROR'
    ];

    public static $instance = null;

    private $output = [];

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function getOutput() {
        foreach ($this->output as $output) {
            print self::$levels[$output[1]] . ': ' . $output[0] . "\n";
        }
    }

    public function getOutputRaw() {
        return $this->output;
    }

    public function log($message) {
        $this->addOutput($message, Output::LEVEL_LOG);
    }

    public function warning($message) {
        $this->addOutput($message, Output::LEVEL_WARN);
    }

    public function error($message) {
        $this->addOutput($message, Output::LEVEL_ERROR);
    }

    public function addOutput($message, $level = Output::LEVEL_LOG) {
        $this->output[] = [$message, $level];
    }

    public function clearOutput() {
        $this->output = [];
    }
}
