<?php

/*
 * This file is part of the lian/printer.
 *
 * (c) shenyifei <m809745357@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Lian\Printer;

class Printer
{
    protected $key;
    protected $deviceNo;
    protected $printContent;
    protected $times = 1;
    protected $url = 'http://open.printcenter.cn:8080';

    /**
     * http://open.printcenter.cn:8080/.
     *
     * @param string $key
     * @param string $deviceNo
     */
    public function __construct(string $key, string $deviceNo)
    {
        $this->key = $key;
        $this->deviceNo = $deviceNo;
    }

    /**
     * 打印订单.
     * ----------S2小票机返回的结果有如下几种：----------.
     * {"responseCode":0,"msg":"服务器接收订单成功","orderindex":"xxxxxxxxxxxxxxxxxx"}
     * {"responseCode":1,"msg":"打印机编号错误"}
     * {"responseCode":2,"msg":"服务器处理订单失败"}
     * {"responseCode":3,"msg":"打印内容太长"}
     * {"responseCode":4,"msg":"请求参数错误"}
     * {"responseCode":4,"msg":"错误的机器号或口令"}.
     *
     * @param Command $command
     * @param int     $time
     * @param string  $format
     */
    public function addOrder(Command $command, int $time = 1, string $format = 'json')
    {
        $content = implode('', $command->contents);

        $query = array_filter([
            'key' => $this->key,
            'deviceNo' => $this->deviceNo,
            'printContent' => $content,
            'times' => $time,
        ]);

        return $this->post('/addOrder', $query);
    }

    /**
     * 查询订单是否打印成功(支持S1、S2两种小票机).
     * ----------S2小票机返回的结果有如下几种：----------
     * {"responseCode":0,"msg":"已打印"}
     * {"responseCode":0,"msg":"未打印"}
     * {"responseCode":1,"msg":"请求参数错误"}
     * {"responseCode":2,"msg":"没有找到该索引的订单"}
     * {"responseCode":4,"msg":"错误的机器号或口令"}.
     *
     * @param [type] $orderindex
     * @param string $format
     */
    public function queryOrder($orderindex, string $format = 'json')
    {
        $query = array_filter([
            'key' => $this->key,
            'deviceNo' => $this->deviceNo,
            'orderindex' => $orderindex,
        ]);

        return $this->post('/queryOrder', $query);
    }

    /**
     * 查询打印机的状态(支持S1、S2两种小票机).
     * 注释:打印机离线状态在打印机异常状态90秒之后可被检测到。
     * ----------S2小票机返回的结果有如下几种：----------
     * {"responseCode":0,"msg":"离线"}
     * {"responseCode":0,"msg":"在线,纸张正常"}
     * {"responseCode":0,"msg":"在线,缺纸"}
     * {"responseCode":1,"msg":"请求参数错误"}
     * {"responseCode":4,"msg":"错误的机器号或口令"}.
     *
     * @param string $format
     */
    public function queryPrinterStatus()
    {
        $query = array_filter([
            'key' => $this->key,
            'deviceNo' => $this->deviceNo,
        ]);

        return $this->post('/queryPrinterStatus', $query);
    }

    /**
     * 掉接口.
     *
     * @param string $uri
     * @param array  $query
     * @param string $format
     */
    public function post(string $uri, array $query, string $format = 'json')
    {
        $url = $this->url.$uri;
        $options = [
            'http' => [
                'header' => 'Content-type: application/x-www-form-urlencoded ',
                'method' => 'POST',
                'content' => http_build_query($query),
            ],
        ];
        $context = stream_context_create($options);

        $response = file_get_contents($url, false, $context);

        return 'json' === $format ? \json_decode($response, true) : $response;
    }
}
