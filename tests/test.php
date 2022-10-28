<?php
/**
 * 示例测试
 */
require '../vendor/autoload.php';
include_once 'helpers.php';

use Sandpear\ValidateCode\GraphValidateCode;

/*
# 示例一：创建固定验证码
$ValidateCode = new GraphValidateCode();
$code = $ValidateCode->createGraphValidateCode('1234')->getCode();
fwrite_log('固定验证码:' . $code);
$ValidateCode->outputPng(true);
*/


/*
# 示例二：创建随机验证码
$ValidateCode = new GraphValidateCode();
$code = $ValidateCode->createGraphValidateCode()->getCode();
fwrite_log('随机验证码:' . $code);
$ValidateCode->outputPng(true);
*/


/*
# 示例三：创建自定义随机验证码
$config = [
             'codeLength' => 4,   #验证码长度
             'imgWidth'   => 130, #图片宽度
             'imgHeight'  => 50,  #图片高度
             'fontSize'   => 20,  #字体大小
             # 字体文件
             'fontFile' => [
                 __DIR__.'/../src/resources/font/century-gothic.ttf',
             ],
          ];
$ValidateCode = new GraphValidateCode($config);
$code = $ValidateCode->createGraphValidateCode()->getCode();
fwrite_log('自定义随机验证码:' . $code);
$ValidateCode->outputPng(true);
*/


/*
# 示例四：创建随机验证码并返回Blob
$ValidateCode = new GraphValidateCode();
$code = $ValidateCode->createGraphValidateCode()->getCode();
fwrite_log('随机验证码:' . $code);
$outputImageBlob = $ValidateCode->outputImageBlob();
fwrite_log('随机验证码Blob:' . $outputImageBlob);
header('Content-type:image/png');
echo $outputImageBlob;
*/

/*
# 示例五：创建随机验证码并返回Blob的另一个用法
$ValidateCode = new GraphValidateCode();
$code = $ValidateCode->createGraphValidateCode()->getCode();
fwrite_log('随机验证码:' . $code);
$outputImageBlob = $ValidateCode->outputImageBlob();
$base64Png = 'data:image/png;base64,'.base64_encode($outputImageBlob);
fwrite_log('随机验证码Base64:' . $base64Png);
echo '<img src="'.$base64Png.'">';
*/

# 示例六：创建自定义中文验证码（中文验证码不支持随机生成验证码）
$config = [
    'codeLength' => 4,   #验证码长度
    'imgWidth'   => 130, #图片宽度
    'imgHeight'  => 50,  #图片高度
    'fontSize'   => 20,  #字体大小

];
$ValidateCode = new GraphValidateCode($config);
$code = $ValidateCode
  #  ->randomCode(3)
    ->createGraphValidateCode()->getCode();
fwrite_log('自定义中文验证码:' . $code);

$ValidateCode->outputPng(true);