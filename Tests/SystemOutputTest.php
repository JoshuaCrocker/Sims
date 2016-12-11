<?php
use PHPUnit\Framework\TestCase;

class SystemOutputTest extends TestCase {
    public function setUp() {
        Output::getInstance()->clearOutput();
    }

    public function testAddLog() {
        Output::getInstance()->log('Test Log');
        Output::getInstance()->addOutput('Test Log');
        Output::getInstance()->addOutput('Test Log', Output::LEVEL_LOG);

        $output = Output::getInstance()->getOutputRaw();

        $this->assertEquals(3, count($output));

        foreach ($output as $o) {
            $this->assertEquals('Test Log', $o[0]); // Separate test?
            $this->assertEquals(0, $o[1]);
        }
    }

    public function testAddWarning() {
        Output::getInstance()->warning('Test Warning');
        Output::getInstance()->addOutput('Test Warning', Output::LEVEL_WARN);

        $output = Output::getInstance()->getOutputRaw();

        $this->assertEquals(2, count($output));

        foreach ($output as $o) {
            $this->assertEquals('Test Warning', $o[0]); // Separate test?
            $this->assertEquals(1, $o[1]);
        }
    }

    public function testAddError() {
        Output::getInstance()->error('Test Error');
        Output::getInstance()->addOutput('Test Error', Output::LEVEL_ERROR);

        $output = Output::getInstance()->getOutputRaw();

        $this->assertEquals(2, count($output));

        foreach ($output as $o) {
            $this->assertEquals('Test Error', $o[0]); // Separate test?
            $this->assertEquals(2, $o[1]);
        }
    }

    public function testMixedMessages() {
        Output::getInstance()->error('Error');
        Output::getInstance()->warning('Warning');
        Output::getInstance()->log('Log');

        $output = Output::getInstance()->getOutputRaw();

        $this->assertEquals(3, count($output));

        $this->assertEquals('Error', $output[0][0]);
        $this->assertEquals(2, $output[0][1]);

        $this->assertEquals('Warning', $output[1][0]);
        $this->assertEquals(1, $output[1][1]);

        $this->assertEquals('Log', $output[2][0]);
        $this->assertEquals(0, $output[2][1]);
    }
}
