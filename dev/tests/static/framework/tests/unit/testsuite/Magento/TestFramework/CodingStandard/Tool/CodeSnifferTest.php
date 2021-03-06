<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\TestFramework\CodingStandard\Tool;

use PHP_CodeSniffer\Runner;

class CodeSnifferTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\TestFramework\CodingStandard\Tool\CodeSniffer
     */
    protected $_tool;

    /**
     * @var Runner
     */
    protected $_wrapper;

    /**
     * Rule set directory
     */
    const RULE_SET = 'some/ruleset/directory';

    /**
     * Report file
     */
    const REPORT_FILE = 'some/report/file.xml';

    protected function setUp()
    {
        $this->_wrapper = $this->getMock(\Magento\TestFramework\CodingStandard\Tool\CodeSniffer\Wrapper::class);
        $this->_tool = new \Magento\TestFramework\CodingStandard\Tool\CodeSniffer(
            self::RULE_SET,
            self::REPORT_FILE,
            $this->_wrapper
        );
    }

    public function testRun()
    {
        $whiteList = ['test' . rand(), 'test' . rand()];
        $extensions = ['test' . rand(), 'test' . rand()];

        $expectedCliEmulation = [
            'files' => $whiteList,
            'standards' => [self::RULE_SET],
            'extensions' => $extensions,
            'warningSeverity' => 0,
            'reports' => ['full' => self::REPORT_FILE],
        ];

        $this->_tool->setExtensions($extensions);

        $this->_wrapper->expects($this->once())
            ->method('setSettings')
            ->with($this->equalTo($expectedCliEmulation));

        $this->_wrapper->expects($this->once())
            ->method('runPHPCS');

        $this->_tool->run($whiteList);
    }
}
