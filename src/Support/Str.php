<?php
namespace Edith\Admin\Support;

use Illuminate\Support\Str as BaseStr;

class Str
{
    /**
     * 参数过滤防止攻击
     * @param string|null $str
     * @return string|null
     */
    public static function filterWords(?string $str = null): ?string
    {
        if (is_null($str)) {
            return $str;
        }
        $farr = array(
            "/<(\\/?)(script|i?frame|style|html|body|title|link|meta|object|\\?|\\%)([^>]*?)>/isU",
            "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",
            "/select\b|insert\b|update\b|delete\b|drop\b|;|\"|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile|dump/is"
        );
        $str = preg_replace($farr, '', $str);
        return strip_tags($str);
    }

    /**
     * 字符串签名
     * @param array $data
     * @param string $mode
     * @return string
     */
    public static function authSign(array $data, string $mode = 'md5'): string
    {
        ksort($data); //排序
        $str = "";
        foreach ($data as $key => $value) {
            if ($value == '' || $key == 'sign') {
                continue;
            }
            $str .= "{$key}={$value}&";
        }
        $str = substr($str, 0, -1);
        return $mode($str); //生成签名
    }

    /**
     * 处理 HTML
     * @param string $content
     * @return array|string|string[]
     */
    public static function htmlReplace(string $content)
    {
        $content = str_replace("&lt;", "<", $content);
        $content = str_replace("&gt;", ">", $content);
        $content = str_replace("&namp;", "&", $content);
        return str_replace("&quot;", "\"", $content);
    }

    /**
     * PHP格式化字节大小
     * @param number $size      字节数
     * @param string $delimiter 数字和单位分隔符
     * @return string            格式化后的带单位的大小
     */
    public static function formatBytes($size, string $delimiter = ''): string
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
        return round($size, 2) . $delimiter . $units[$i];
    }

    /**
     * 转换驼峰
     * @param string $name
     * @return string
     */
    public static function formatClass(string $name): string
    {
        if (str_contains($name, '_')) {
            $temp_array = array();
            $arr = explode("_", $name);
            foreach ($arr as $value) {
                $temp_array[] = ucfirst($value);
            }
            return implode($temp_array);
        } else {
            return strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $name));
        }
    }

    /**
     * 获取随机订单号
     * @param string $str
     * @return string
     */
    public static function getOrderSn(string $str = "ZT"): string
    {
        return $str.date("YmdHis").sprintf('%06s', rand(0,999999));
    }

    /**
     * 过滤字符串中的一些内容
     * @param string $value
     * @return string
     */
    public static function paramFilter(string $value): string
    {
        $value = preg_replace("/<script[\s\S]*?<\/script>/im", "", $value);
        return preg_replace("/<script>|<\/script>/im", "", $value);
    }

    /**
     * 移除微信昵称中的emoji字符
     * @param string $nickname
     * @return string
     */
    public static function removeEmoji(string $nickname): string
    {
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $nickname);
        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);
        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);
        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);
        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        return trim($clean_text);
    }

    /**
     * 生成卡密
     * @param int $num
     * @param int $length
     * @param string $prefix
     * @return array|string
     */
    public static function getCardId(int $num = 1, int $length = 10, string $prefix='GT_')
    {
        //输出数组
        $card = array();
        //填补字符串
        $pad = '';
        //日期
        $temp = time();
        $Y = date('Y', $temp);
        $M = date('m', $temp);
        $TD = date('YmdHis', $temp);
        //长度
        $LY = strlen((string)$Y);
        $LM = strlen((string)$M);
        $LTD = strlen((string)$TD);
        //流水号长度
        $W = 5;
        //根据长度生成填补字串
        if ($length <= 12) {
            $pad = $prefix . BaseStr::random($length - $W);
        } else if ($length <= 16) {
            $pad = $prefix . (string)$Y . BaseStr::random($length - ($LY + $W));
        } else if ($length <= 20) {
            $pad = $prefix . (string)$Y . (string)$M . BaseStr::random($length - ($LY + $LM + $W));
        } else {
            $pad = $prefix . (string)$TD . BaseStr::random($length - ($LTD + $W));
        }
        //生成X位流水号
        for ($i = 0; $i < $num; $i++) {
            $STR = $pad . str_pad((string)($i + 1), $W, '0', STR_PAD_LEFT);
            $card[$i] = $STR;
        }
        return $num == 1 ? $card[0] : $card;
    }

    /**
     * 生成密码
     * @param int $num
     * @return array|string
     */
    public static function getCardPwd(int $num = 1)
    {
        $pwd = array();
        for ($i = 0; $i < $num; $i++) {
            //生成基本随机数
            $chaired = substr(MD5(uniqid(mt_rand(), true)), 8, 16) . BaseStr::random(4);
            $pwd[$i] = strtoupper($chaired);
        }
        return $num == 1 ? $pwd[0] : $pwd;
    }
}
