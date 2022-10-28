
# validate-code 生成验证码图片
- 根据验证码生成图片。

## 生成效果：
![image](https://github.com/sandpear/validate-code/blob/master/tests/1.png)

![image](https://github.com/sandpear/validate-code/blob/master/tests/2.png)

![image](https://github.com/sandpear/validate-code/blob/master/tests/3.png)

## 安装：
```
composer require sandpear/validate-code
```

- 单纯的生成验证码图片扩展。
- 使用方法见`tests/test.php`文件示例:

```
require '../vendor/autoload.php';
require 'helpers.php';
```

## 示例一：创建固定验证码图片
```
    use Sandpear\ValidateCode\GraphValidateCode;
    $ValidateCode = new GraphValidateCode();
    $code = $ValidateCode->createGraphValidateCode('1234')->getCode();
    fwrite_log('固定验证码:' . $code);
    $ValidateCode->outputPng(true);
```

##示例二：创建随机验证码图片
```
    use Sandpear\ValidateCode\GraphValidateCode;
    $ValidateCode = new GraphValidateCode();
    $code = $ValidateCode->createGraphValidateCode()->getCode();
    fwrite_log('随机验证码:' . $code);
    $ValidateCode->outputPng(true);
```

## 示例三：创建自定义随机验证码图片
```
    use Sandpear\ValidateCode\GraphValidateCode;
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
```

## 示例四：创建随机验证码并返回图片Blob
```
    use Sandpear\ValidateCode\GraphValidateCode;
    $ValidateCode = new GraphValidateCode();
    $code = $ValidateCode->createGraphValidateCode()->getCode();
    fwrite_log('随机验证码:' . $code);
    $outputImageBlob = $ValidateCode->outputImageBlob();
    fwrite_log('随机验证码Blob:' . $outputImageBlob);
    header('Content-type:image/png');
    echo $outputImageBlob;
```

## 示例五：创建随机验证码并返回图片Blob的另一个用法
```
    use Sandpear\ValidateCode\GraphValidateCode;
    $ValidateCode = new GraphValidateCode();
    $code = $ValidateCode->createGraphValidateCode()->getCode();
    fwrite_log('随机验证码:' . $code);
    $outputImageBlob = $ValidateCode->outputImageBlob();
    $base64Png = 'data:image/png;base64,'.base64_encode($outputImageBlob);
    fwrite_log('随机验证码Base64:' . $base64Png);
    echo '<img src="'.$base64Png.'">';
```
    
## 示例六：创建自定义中文验证码（中文验证码不支持随机码）
```
    use Sandpear\ValidateCode\GraphValidateCode;
    $config = [
        'codeLength' => 4,   #验证码长度
        'imgWidth'   => 130, #图片宽度
        'imgHeight'  => 50,  #图片高度
        'fontSize'   => 20,  #字体大小
        # 字体文件
        'fontChineseFile' => [
         __DIR__.'/../src/resources/font/microsoft-Ya-hei.ttf',
        ],
    ];
    $ValidateCode = new GraphValidateCode($config);
    $code = $ValidateCode->createGraphValidateCode('吾验证码')->getCode();
    fwrite_log('自定义中文验证码:' . $code);
    $ValidateCode->outputPng(true);
```



