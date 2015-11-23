<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 23/11/15
 * Time: 08:31
 */

namespace devgiants\ged\DocumentBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class Upload
{

    /**
     * @var Container the container
     */
    protected $container;

    /**
     * @var string Filename of the uploaded file
     */
    private $fileName;

    /**
     * @var int Size of uploaded file in bytes
     */
    private $fileSize;

    /**
     * @var string File extension of uploaded file
     */
    private $fileExtension;

    /**
     * @var string Path to newly uploaded file (after upload completed)
     */
    private $fileNameWithoutExt;


    /**
     * @var string the saved file path
     */
    private $savedFile;

    /**
     * @var string Error message if handleUpload() returns false (use getErrorMsg() to retrieve)
     */
    private $errorMsg;

    /**
     * @var bool
     */
    private $isXhr;

    /**
     * @var string File upload directory (include trailing slash)
     */
    public $uploadDir;

    /**
     * @var array permitted file extensions
     */
    public $allowedExtensions;

    /**
     * @var int Max file upload size in bytes (default 10MB)
     */
    public $sizeLimit = 10485760;

    /**
     * @var string Optionally save uploaded files with a new name by setting this
     */
    public $newFileName;

    /**
     * @var string
     */
    public $corsInputName = 'XHR_CORS_TARGETORIGIN';

    /**
     * @var null|string
     */
    public $uploadName = 'uploadfile';

    /**
     * @param Container $container the global container
     * @param null $uploadName the file upload name
     * @throws \Exception exception thrown
     */
    function __construct(Container $container) {

        $this->container = $container;
    }


    function setFileInfo($uploadName) {
        if ($uploadName !== null) {
            $this->uploadName = $uploadName;
        }

        if (isset($_FILES[$this->uploadName])) {
            $this->isXhr = false;

            if ($_FILES[$this->uploadName]['error'] === UPLOAD_ERR_OK) {
                $this->fileName = $_FILES[$this->uploadName]['name'];
                $this->fileSize = $_FILES[$this->uploadName]['size'];

            } else {
                $this->setErrorMsg($this->errorCodeToMsg($_FILES[$this->uploadName]['error']));
            }

        } elseif (isset($_SERVER['HTTP_X_FILE_NAME']) || isset($_GET[$this->uploadName])) {
            $this->isXhr = true;

            $this->fileName = isset($_SERVER['HTTP_X_FILE_NAME']) ?
                $_SERVER['HTTP_X_FILE_NAME'] : $_GET[$this->uploadName];

            if (isset($_SERVER['CONTENT_LENGTH'])) {
                $this->fileSize = (int)$_SERVER['CONTENT_LENGTH'];

            } else {
                throw new \Exception('Content length is empty.');
            }
        }

        if ($this->fileName) {
            $pathinfo = pathinfo($this->fileName);

            if (array_key_exists('extension', $pathinfo) &&
                array_key_exists('filename', $pathinfo))
            {
                $this->fileExtension = strtolower($pathinfo['extension']);
                $this->fileNameWithoutExt = $pathinfo['filename'];
            }

            $this->fileName = str_replace(array('/','\\'),'_',$this->fileName);
        }
    }
    /**
     * Returns file name
     * @return string the fileName
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * Returns the filesize
     * @return int the file size
     */
    public function getFileSize() {
        return $this->fileSize;
    }

    /**
     * Return the file extension
     * @return string the file extension
     */
    public function getExtension() {
        return $this->fileExtension;
    }

    /**
     * Returns the error message
     * @return string the error message
     */
    public function getErrorMsg() {
        return $this->errorMsg;
    }

    /**
     * @return string the saved file path
     */
    public function getSavedFile() {
        return $this->savedFile;
    }

    /**
     * Transforms error code to error message
     * @param $code string the error code
     * @return string the error message
     */
    private function errorCodeToMsg($code) {
        switch($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = 'File size exceeds limit.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = 'The uploaded file was only partially uploaded.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = 'No file was uploaded.';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = 'Missing a temporary folder.';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = 'Failed to write file to disk.';
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = 'File upload stopped by extension.';
                break;
            default:
                $message = 'Unknown upload error.';
                break;
        }
        return $message;
    }

    /**
     * CHecks extensions
     * @param $ext string the extension to check
     * @param $allowedExtensions array allowed extensions
     * @return bool wether extension match or not
     */
    private function checkExtension($ext, $allowedExtensions) {
        if (!is_array($allowedExtensions))
            return false;

        if (!in_array(strtolower($ext), array_map('strtolower', $allowedExtensions)))
            return false;

        return true;
    }

    /**
     * Sets the error message
     * @param $msg string the error message
     */
    private function setErrorMsg($msg) {
        if (empty($this->errorMsg))
            $this->errorMsg = $msg;
    }

    /**
     * Fix dir if missing
     * @param $dir string the dir path
     * @return mixed|string the dir path fixed
     */
    private function fixDir($dir) {
        if (empty($dir))
            return $dir;

        $slash = DIRECTORY_SEPARATOR;
        $dir = str_replace('/', $slash, $dir);
        $dir = str_replace('\\', $slash, $dir);
        return substr($dir, -1) == $slash ? $dir : $dir . $slash;
    }

    // escapeJS and jsMatcher are adapted from the Escaper component of
    // Zend Framework, Copyright (c) 2005-2013, Zend Technologies USA, Inc.
    // https://github.com/zendframework/zf2/tree/master/library/Zend/Escaper
    private function escapeJS($string) {
        return preg_replace_callback('/[^a-z0-9,\._]/iSu', $this->jsMatcher, $string);
    }

    /**
     * @param $matches
     * @return string
     */
    private function jsMatcher($matches) {
        $chr = $matches[0];

        if (strlen($chr) == 1)
            return sprintf('\\x%02X', ord($chr));

        if (function_exists('iconv'))
            $chr = iconv('UTF-16BE', 'UTF-8', $chr);

        elseif (function_exists('mb_convert_encoding'))
            $chr = mb_convert_encoding($chr, 'UTF-8', 'UTF-16BE');

        return sprintf('\\u%04s', strtoupper(bin2hex($chr)));
    }

    /**
     * @param $data
     * @return string
     */
    public function corsResponse($data) {
        if (isset($_REQUEST[$this->corsInputName])) {
            $targetOrigin = $this->escapeJS($_REQUEST[$this->corsInputName]);
            $targetOrigin = htmlspecialchars($targetOrigin, ENT_QUOTES, 'UTF-8');
            return "<script>window.parent.postMessage('$data','$targetOrigin');</script>";
        }
        return $data;
    }

    /**
     * @param $path string the file path
     * @return string the MIME type
     */
    public function getMimeType($path) {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $fileContents = file_get_contents($path);
        $mime = $finfo->buffer($fileContents);
        $fileContents = null;
        return $mime;
    }

    public function isWebImage($path) {
        $pathinfo = pathinfo($path);

        if (array_key_exists('extension', $pathinfo)) {
            if (!in_array(strtolower($pathinfo['extension']), array('gif', 'png', 'jpg', 'jpeg')))
                return false;
        }

        $type = exif_imagetype($path);

        if (!$type)
            return false;

        return ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG);
    }

    private function saveXhr($path) {
        if (false !== file_put_contents($path, fopen('php://input', 'r')))
            return true;
        return false;
    }

    private function saveForm($path) {
        if (move_uploaded_file($_FILES[$this->uploadName]['tmp_name'], $path))
            return true;
        return false;
    }

    private function save($path) {
        if (true === $this->isXhr)
            return $this->saveXhr($path);
        return $this->saveForm($path);
    }

    public function handleUpload($uploadDir = null, $allowedExtensions = null) {
        if (!$this->fileName) {
            $this->setErrorMsg('Incorrect upload name or no file uploaded');
            return false;
        }

        if ($this->fileSize == 0) {
            $this->setErrorMsg('File is empty');
            return false;
        }

        if ($this->fileSize > $this->sizeLimit) {
            $this->setErrorMsg('File size exceeds limit');
            return false;
        }

        if (!empty($uploadDir))
            $this->uploadDir = $uploadDir;

        $this->uploadDir = $this->fixDir($this->uploadDir);

        if (!file_exists($this->uploadDir)) {
            $this->setErrorMsg('Upload directory does not exist');
            return false;

        } else if (!is_writable($this->uploadDir)) {
            $this->setErrorMsg('Upload directory exists, but is not writable');
            return false;
        }

        if (is_array($allowedExtensions))
            $this->allowedExtensions = $allowedExtensions;

        if (!empty($this->allowedExtensions)) {
            if (!$this->checkExtension($this->fileExtension, $this->allowedExtensions)) {
                $this->setErrorMsg('Invalid file type');
                return false;
            }
        }

        $this->savedFile = $this->uploadDir . $this->fileName;

        if (!empty($this->newFileName)) {
            $this->fileName = $this->newFileName;
            $this->savedFile = $this->uploadDir . $this->fileName;

            $this->fileNameWithoutExt = null;
            $this->fileExtension = null;

            $pathinfo = pathinfo($this->fileName);

            if (array_key_exists('filename', $pathinfo))
                $this->fileNameWithoutExt = $pathinfo['filename'];

            if (array_key_exists('extension', $pathinfo))
                $this->fileExtension = strtolower($pathinfo['extension']);
        }

        if (!$this->save($this->savedFile)) {
            $this->setErrorMsg('File could not be saved');
            return false;
        }

        return true;
    }
}