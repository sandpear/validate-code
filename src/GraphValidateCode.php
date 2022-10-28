<?php
namespace Sandpear\ValidateCode;

class GraphValidateCode
{
    private $code;
    private $font;
    private $charset;
    private $charsetTypes;
    private $img;


    /**
     * 自动生成随机英文数字验证码的字符
     * @var string
     */
    private $charsetNumeric  = '1234567890';
    private $charsetAlphabet = 'abcdefhkmnrstuvwxyABCDEFGHKMNRSTUVWXY';
    private $charsetMixture  = 'abcdefhkmnrstuvwxyABCDEFGHKMNRSTUVWXY234567890';
    private $charsetChinese  =
'的是在不有和这中大为上个我以要他时来用们生到作地于出就分对成会可主发年动同也能下过子说产种面而方后多定行学法所民得经之进着等部度家电力里如水化高自理起小物现实加量都两体制机当使点从业本去把性好应开它合还因由其些然前外天四日那社义事平形相全表间样与关各重新线内数正心你明看原又么利比或但质气第向道命此条只没结解问意建月公无系军很情者最立代想已通并提直题程展五果料象员革位常文总次品式活设及管特件长求老头基资边流路级少图山统接知较将组见计别她手角期根论运农指区强放决西被做必战先回则任取据处队南给色光即保治北造百规热领海东导器压志世金增争济阶油思术极交受联什认六权收证改清美再采转更单风切打白教速花带安场身车例真务具万每目至达走积示议声报斗完类离名确才科张信马节话米整空元况今集温传土许步群广石记需段研界拉林律叫且究观越织装影算低持音众书布复容儿须际商非验连断深难近矿周素技备半办青列响约般史感劳便团往酸历市克何除消构称太准精值号率族维划选标写存候亲快效斯查江型眼王按格养易置派层片始却专状育京识适属圆包火住调满照参红细引听该铁价严龙飞';

    /**
     * 自动生成随机验证码的验证码字符长度
     * @var int|mixed
     */
    protected $codeLength = 4;

    /**
     * 生成验证码所用的英文字体库列表，多字体时，生成验证码会随机使用一种字体生成验证码
     * @var array|mixed
     */
    protected $fontFile   = [
        __DIR__.'/resources/font/century-gothic.ttf',
        __DIR__.'/resources/font/block-font.ttf',
        __DIR__.'/resources/font/elephant.ttf',
        __DIR__.'/resources/font/helvetica.ttf',
    ];
    /**
     * 生成验证码所用的中文字体库列表，多字体时，生成验证码会随机使用一种字体生成验证码
     * @var array|mixed
     */
    protected $fontChineseFile   = [
        __DIR__.'/resources/font/microsoft-ya-hei.ttf',
    ];

    /**
     * 验证码字体字号px
     * @var int|mixed
     */
    protected $fontSize   = 20;

    /**
     * 生成验证码图片高度px
     * @var int|mixed
     */
    protected $imgHeight  = 50;

    /**
     * 生成验证码图片宽度px
     * @var int|mixed
     */
    protected $imgWidth   = 130;

    public $createCharacterNumber = 12;
    public $createLineNumber = 6;
    public $createSnowNumber = 60;
    /**
     * GraphValidateCode constructor.
     * @param array $conf
     */
    public function __construct(array $conf = [])
    {
        if(!extension_loaded('gd'))
            die('请配置环境使其支持GD库！详情:https://www.php.net/manual/en/book.image.php');

        if(!empty($conf['codeLength']))
            $this->codeLength = $conf['codeLength'];

        if(!empty($conf['fontFile']))
            $this->fontFile = $conf['fontFile'];

        if(!empty($conf['fontChineseFile']))
            $this->fontChineseFile = $conf['fontChineseFile'];

        if(!empty($conf['fontSize']))
            $this->fontSize = $conf['fontSize'];

        if(!empty($conf['imgHeight']))
            $this->imgHeight = $conf['imgHeight'];

        if(!empty($conf['imgWidth']))
            $this->imgWidth = $conf['imgWidth'];

        $this->font    = $this->getFont();
        $this->charset = $this->charsetMixture;
    }
    /**
     * 随机字符类型
     * @param int $charsetTypes 字符类型[0:数字, 1:字母, 2:字母数字混合, 3:中文]
     * @return $this
     */
    public function randomCode(int $charsetTypes = 0)
    {
        switch ($charsetTypes)
        {
            case 0:
                $charset = $this->charsetNumeric;
                break;
            case 1:
                $charset = $this->charsetAlphabet;
                break;
            case 3:
                $charset = $this->charsetChinese;
                $this->font = $this->getFontChinese();
                break;
            case 2:
            default:
                $charset = $this->charsetMixture;
                $charsetTypes = 2;
        }
        $this->charset      = $charset;
        $this->charsetTypes = $charsetTypes;
        return $this;
    }

    /**
     * @return $this
     */
    public function createCode()
    {
        $charset    = self::mb_str_split($this->charset);
        $codeLength = count($charset) - 1;
        $this->code = '';
        for ($i = 0; $i < $this->codeLength; $i++) {
            $this->code .= $charset[mt_rand(0, $codeLength)];
        }
        return $this;
    }
    /**
     * 创建验证码
     * @param string $code
     * @return $this
     */
    public function createGraphValidateCode(string $code = null)
    {
        if(!empty($code))
        {
            if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $code))
            {
                $this->font = $this->randomCode(3)->getFontChinese();
            }
            $this->code = mb_substr($code, 0, $this->codeLength);
        }else{
            if(empty($this->code))
                $this->createCode();
        }
        $this->createBg()
            ->createSnow()
            ->createLine()
            ->createCharacter()
            ->createFont()
            ->createLine();
        return $this;
    }

    /**
     * 获取验证码
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * 输出图片流
     * @return string
     */
    public function outputImageBlob()
    {
        ob_start();
        imagepng($this->img);
        imagedestroy($this->img);
        return ob_get_clean();
    }

    /**
     * 输出图片
     * @param bool $is_die
     */
    public function outputPng(bool $is_die = true)
    {
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
        if($is_die)
            die;
    }

    /**
     * 生成背景
     * @return $this
     */
    protected function createBg()
    {
        $this->img = imagecreatetruecolor($this->imgWidth, $this->imgHeight);
        $color = imagecolorallocate($this->img, mt_rand(157, 255),
            mt_rand(157, 255), mt_rand(157, 255));
        imagefilledrectangle($this->img, 0, $this->imgHeight, $this->imgWidth,
            0, $color);
        return $this;
    }

    /**
     * 生成随机字
     * @param int $number
     * @return $this
     */
    protected function createCharacter(int $number = null)
    {
        if(empty($number))
           $number = $this->createCharacterNumber;
        $charset = self::mb_str_split($this->charset);
        $codeLength = count($charset) - 1;
        for ($i = 0; $i < $number; $i++) {
            $font = $this->charsetTypes == 3 ? $this->getFontChinese() : $this->getFont();
            $color = imagecolorallocate($this->img, mt_rand(200, 255),
                mt_rand(200, 255), mt_rand(200, 255));
            $rand = mt_rand(0,$codeLength - 1);
            imagettftext($this->img, intval($this->fontSize * 0.7),
                mt_rand(-60,120), mt_rand(0, $this->imgWidth),
                mt_rand(0, $this->imgHeight), $color,
                $font,
                $charset[$rand]
            );
        }
        return $this;
    }

    /**
     * 生成文字
     * @return $this
     */
    protected function createFont()
    {
        $codeLength = mb_strlen($this->code);
        $_x = $this->imgWidth / $codeLength;
        for ($i = 0; $i < $codeLength; $i++) {
            $fontColor = imagecolorallocate($this->img, mt_rand(0, 156),
                mt_rand(0, 156), mt_rand(0, 156));
            imagettftext($this->img, $this->fontSize,
                mt_rand(-30, 30), $_x * $i + mt_rand(1, 5),
                $this->imgHeight / 1.4, $fontColor,
                $this->font, mb_substr($this->code, $i, 1));
        }
        return $this;
    }

    /**
     * 生成线条
     * @param int $number
     * @return $this
     */
    protected function createLine(int $number = null)
    {
        if(empty($number))
            $number = $this->createLineNumber;
        for ($i = 0; $i < $number; $i++) {
            $color = imagecolorallocate($this->img, mt_rand(0, 156),
                mt_rand(0, 156), mt_rand(0, 156));
            imageline($this->img, mt_rand(0, $this->imgWidth),
                mt_rand(0, $this->imgHeight), mt_rand(0, $this->imgWidth),
                mt_rand(0, $this->imgHeight), $color);
        }
        return $this;
    }

    /**
     * 生成雪花
     * @param int $number
     * @return $this
     */
    protected function createSnow(int $number = null)
    {
        if(empty($number))
            $number = $this->createSnowNumber;
        for ($i = 0; $i < $number; $i++) {
            $color = imagecolorallocate($this->img, mt_rand(200, 255),
                mt_rand(200, 255), mt_rand(200, 255));
            imagestring($this->img, mt_rand(1, 5),
                mt_rand(0, $this->imgWidth), mt_rand(0, $this->imgHeight), '*', $color);
        }
        return $this;
    }

    /**
     * 随机英文字体
     * @param bool $random
     * @return mixed
     */
    protected function getFont(bool $random = true)
    {
        if($random === true) {
            $random = mt_rand(0, count($this->fontFile) - 1);
        }
        return $this->fontFile[$random];
    }

    /**
     * 随机字体
     * @param bool $random
     * @return mixed
     */
    protected function getFontChinese(bool $random = true)
    {
        if($random === true) {
            $random = mt_rand(0, count($this->fontChineseFile) - 1);
        }
        return $this->fontChineseFile[$random];
    }

    public static function mb_str_split( $string )
    {
        # Split at all position not after the start: ^
        # and not before the end: $
        return preg_split('/(?<!^)(?!$)/u', $string );
    }
}