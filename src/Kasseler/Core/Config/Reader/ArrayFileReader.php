<?php
namespace Kasseler\Core\Config\Reader;

/**
 * Array File Reader
 */
class ArrayFileReader extends AbstractFileReader
{
    private $ext = '.php';

    /**
     * {@inheritdoc}
     */
    public function parse($fileName)
    {
        $file = $fileName.$this->ext;
        if (!is_readable($file)) {
            throw new \Exception("The file {$file} is either not readable or cannot be found");
        }

        $array = include $file;

        if (!is_array($array)) {
            throw new \Exception("The file {$file} must return a PHP array");
        }

        return $array;
    }
}
