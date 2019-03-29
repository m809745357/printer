<?php

/*
 * This file is part of the lian/printer.
 *
 * (c) shenyifei <m809745357@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Lian\Printer\Tests;

use Lian\Printer\Command;
use Lian\Printer\Printer;
use PHPUnit\Framework\TestCase;

class PrinterTest extends TestCase
{
    public function testAddOrder()
    {
        $print = new Printer('66a2d', 'kdt2260799');

        $response = $print->addOrder(Command::create()->paragraph('Hello World'));

        $this->assertSame($response['responseCode'], 0);
        $this->assertSame($response['msg'], '服务器接收订单成功');
    }

    public function testQueryOrder()
    {
        $print = new Printer('66a2d', 'kdt2260799');

        $response = $print->queryOrder('12706113481553838974571');

        $this->assertSame($response['responseCode'], 0);
        $this->assertSame($response['msg'], '已打印');
    }

    public function testQueryPrinterStatus()
    {
        $print = new Printer('66a2d', 'kdt2260799');

        $response = $print->queryPrinterStatus();

        $this->assertSame($response['responseCode'], 0);
        $this->assertSame($response['msg'], '在线,纸张正常');
    }
}
