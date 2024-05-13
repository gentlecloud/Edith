<?php

namespace Gentle\Edith\Support;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class File
{
    /**
     * 输出xml字符
     * @param array $values
     * @return string|null
     **/
    public static function arrToXml(array $values): ?string
    {
        if (count($values) <= 0) {
            return null;
        }
        $xml = "<xml>";
        foreach ($values as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 将xml转为array
     * @param string $xml
     * @return array|null
     */
    public static function xmlToArray(string $xml): ?array
    {
        if (!$xml) {
            return null;
        }
        // 检查xml是否合法
        $xml_parser = xml_parser_create();
        if (!xml_parse($xml_parser, $xml, true)) {
            xml_parser_free($xml_parser);
            return null;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * 将array或者对象转为json
     * @param $array
     * @return string|null
     */
    public static function arrToJson($array): ?string
    {
        if (is_array($array)) {
            return json_encode($array);
        } elseif (is_object($array)) {
            $json = json_encode($array, JSON_FORCE_OBJECT);
            return $json;
        } else {
            return null;
        }
    }

    /**
     * 将OBJ或者对象转为ARRAY
     * @param $object
     * @return array
     */
    public static function objToArray($object): array
    {
        $array = array();
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        } else {
            $array = $object;
        }
        return $array;
    }

    /**
     * 检测目录并循环创建目录
     * @param string $dir
     * @return bool
     */
    public static function mkdirs(string $dir): bool
    {
        if (!file_exists($dir)) {
            self::mkdirs(dirname($dir));
            mkdir($dir, 0777);
        }
        return true;
    }


    /**
     * @param $source
     * @param $dest
     * 复制文件到指定文件
     * @return bool
     */
    public static function copyDir($source, $dest): bool
    {
        if (!is_dir($dest)) {
            self::mkdirs($dest, 0755, true);
        }
        foreach (
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            ) as $item
        ) {
            if ($item->isDir()) {
                $sontDir = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
                if (!is_dir($sontDir)) {
                    self::mkdirs($sontDir, 0755, true);
                }
            } else {
                copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            }
        }
        return true;
    }

    /**
     * 获取文件夹大小
     * @param string $dir
     * @return int|null
     */
    public static function getDirSize(string $dir): ?int
    {
        if(!is_dir($dir)){
            return null;
        }
        $handle = opendir($dir);
        $sizeResult = 0;
        while (false !== ($FolderOrFile = readdir($handle))) {
            if ($FolderOrFile != "." && $FolderOrFile != "..") {
                if (is_dir("$dir/$FolderOrFile")) {
                    $sizeResult += self::getDirSize("$dir/$FolderOrFile");
                } else {
                    $sizeResult += filesize("$dir/$FolderOrFile");
                }
            }
        }

        closedir($handle);
        return $sizeResult;
    }

    /**
     * 创建文件
     * @param string $file
     * @param string $content
     * @return true
     * @throws \Exception
     */
    public static function createFile(string $file, string $content): bool
    {
        $myfile = fopen($file, "w") or throw new \Exception('Unable to open file!');
        fwrite($myfile, $content);
        fclose($myfile);
        return true;
    }
    /**
     * 基于数组创建目录
     * @param array $files
     */
    public static function createDirOrFiles(array $files): void
    {
        foreach ($files as $key => $value) {
            if (str_ends_with($value, '/')) {
                mkdir($value);
            } else {
                file_put_contents($value, '');
            }
        }
    }

    /**
     * 判断文件或目录是否有写的权限
     * @param string $file
     * @return bool
     */
    public static function isWritable(string $file): bool
    {
        if (DIRECTORY_SEPARATOR == '/' AND !@ ini_get("safe_mode")) {
            return is_writable($file);
        }
        if (!is_file($file) OR ($fp = @fopen($file, "r+")) === false) {
            return false;
        }
        fclose($fp);
        return true;
    }

    /**
     * 写入日志
     * @param string $path
     * @param $content
     * @return bool|int
     */
    public static function writeLog(string $path, $content): bool|int
    {
        self::mkdirs(dirname($path));
        if (!is_string($content)) {
            $content = json_encode($content);
        }
        return file_put_contents($path, "\r\n" . date('Y-m-d H:i:s') . ': ' . $content, FILE_APPEND);
    }
}
