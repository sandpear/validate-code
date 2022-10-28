<?php

if(!function_exists('fwrite_log'))
{
    /**
     * 日志记录
     * @param $str
     * @param string $filename
     * @return bool
     */
    function fwrite_log($str, $filename='')
    {
        $str = date('[Y-m-d H:i:s] '). $str;
        $filename = $filename?:date('y_m_d').'.log';
        if (is_file($filename) && !is_writable($filename))
            return false;
        $handle = fopen($filename, "a+");
        fwrite($handle, $str . "\r\n");
        fclose($handle);
        return true;
    }
}