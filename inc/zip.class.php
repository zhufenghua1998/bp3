<?php


/**
 * zip扩展类（兼容win)
 * --------   对一个文件/目录打包，例如：  ---------------
 * // 对程序根目录打包：
 *   ExtendedZip::zipTree(get_base_root(), 'archive.zip', ZipArchive::CREATE);
 * // 对上级目录打包
 *   ExtendedZip::zipTree('../', 'archive.zip', ZipArchive::CREATE);
 */

class ExtendedZip extends ZipArchive {

    // Member function to add a whole file system subtree to the archive
    public function addTree($dirname, $local_name = '') {
        if ($local_name)
            $this->addEmptyDir($local_name);
        $this->_addTree($dirname, $local_name);
    }

    // Internal function, to recurse
    protected function _addTree($dirname, $local_name) {
        $dir = opendir($dirname);
        while ($filename = readdir($dir)) {
            // Discard . and ..
            if ($filename == '.' || $filename == '..')
                continue;

            // zip打包排除项
            if($filename==".user.ini" || $filename==".git" || $filename==".idea" || $filename==".gitattributes"){
                continue;
            }
            // Proceed according to type
            $path = $dirname . DIRECTORY_SEPARATOR . $filename;
            $local_path = $local_name ? ($local_name . DIRECTORY_SEPARATOR . $filename) : $filename;
            if (is_dir($path)) {
                // Directory: add & recurse
                $this->addEmptyDir($local_path);
                $this->_addTree($path, $local_path);
            }
            else if (is_file($path)) {
                // File: just add
                $this->addFile($path, $local_path);
            }
        }
        closedir($dir);
    }

    // Helper function
    public static function zipTree($dirname, $zipFilename, $flags = 0, $local_name = '') {
        $zip = new self();
        $zip->open($zipFilename, $flags);
        $zip->addTree($dirname, $local_name);
        $zip->close();
    }
}