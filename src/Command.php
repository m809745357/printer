<?php

/*
 * This file is part of the lian/printer.
 *
 * (c) shenyifei <m809745357@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Lian\Printer;

class Command
{
    public $contents = [];

    /**
     * 创建.
     *
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * 该命令使标签内的字符居中且放大一倍.
     *
     * @param int          $number
     * @param array|string $contents
     */
    public function paragraph($contents)
    {
        $this->transform('%s', $contents);

        return $this;
    }

    /**
     * 该命令使标签内的字符居中且放大一倍.
     *
     * @param int          $number
     * @param array|string $contents
     */
    public function centerBlod($contents)
    {
        $this->transform('<CB>%s</CB>', $contents);

        return $this;
    }

    /**
     * 该命令使标签内的字符放大一倍.
     *
     * @param int          $number
     * @param array|string $contents
     */
    public function blod($contents)
    {
        $this->transform('<B>%s</B>', $contents);

        return $this;
    }

    /**
     * 该命令使标签内的字符放大两倍.
     *
     * @param int          $number
     * @param array|string $contents
     */
    public function doubleBlod($contents)
    {
        $this->transform('<DB>%s</DB>', $contents);

        return $this;
    }

    /**
     * 该命令使标签内的字符变高，倍高.
     *
     * @param int          $number
     * @param array|string $contents
     */
    public function leight($contents)
    {
        $this->transform('<L>%s</L>', $contents);

        return $this;
    }

    /**
     * 该命令使标签内的字符变高，倍高.
     *
     * @param int          $number
     * @param array|string $contents
     */
    public function weight($contents)
    {
        $this->transform('<W>%s</W>', $contents);

        return $this;
    }

    /**
     * 该命令将标签内的字符生成二维码并打印.
     *
     * @param array|string $contents
     */
    public function qrcode($contents)
    {
        $this->transform('<QR>%s</QR>', $contents);

        return $this;
    }

    /**
     * 该命令使标签内的字符居中.
     *
     * @param array|string $contents
     */
    public function center($contents)
    {
        $this->transform('<C>%s</C>', $contents);

        return $this;
    }

    /**
     * 转换器.
     *
     * @param [type] $command
     * @param [type] $content
     */
    public function transform($command, $contents = '')
    {
        if (!is_array($contents)) {
            $contents = [$contents];
        }

        foreach ($contents as $key => $conntent) {
            $this->contents[] = sprintf($command, $conntent).'<BR>';
        }

        return $this;
    }
}
