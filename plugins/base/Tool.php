<?php
/**
 * Created by PhpStorm.
 * User: shawn
 */
class Tool
{
    /**
     * 检查配置是否合法
     * @param $conf
     * @return bool
     */
    public static function check($conf){
        if (empty($conf['path']) || empty($conf['rules'])){
            Log::error('empty path or rules.');
            return false;
        }
        if (!is_dir($conf['path']) && !file_exists($conf['path'])){
            Log::error('path illegal.');
            return false;
        }
        return true;
    }

    /**
     * 获取目录下所有文件
     * @param $path
     * @return array|bool
     */
    public static function getFiles($path){
        if (!is_dir($path)){
            if (file_exists($path)){
                return array($path);
            }
            return false;
        }
        $dir = new RecursiveDirectoryIterator($path);
        $files = array();
        for (; $dir->valid(); $dir->next()) {
            if ($dir->isDir() && !$dir->isDot()) {
                if ($dir->haschildren()) {
                    $files = array_merge($files, self::getFiles($dir->getChildren()));
                }
            }else if($dir->isFile()){
                $files[] = $dir->getPathName();
            }
        }
        return $files;
    }

    /**
     * 根据文件完整路径获取文件名
     * @param $filePath
     * @return bool|string
     */
    public static function getFileName($filePath){
        $pos = strrpos($filePath, '/');
        $len = strlen($filePath) - $pos;
        return substr($filePath, $pos + 1, $len);
    }
}