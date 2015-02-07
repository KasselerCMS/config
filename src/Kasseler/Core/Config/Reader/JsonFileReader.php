<?php
namespace Kasseler\Core\Config\Reader;

/**
 * Json File Loader
 */
class JsonFileReader extends AbstractFileReader
{
    private $ext = '.json';

    /**
     * {@inheritdoc}
     */
    public function parse($fileName)
    {
        $file = $fileName.$this->ext;
        if (!is_readable($file)) {
            throw new \Exception("The file {$file} is either not readable or cannot be found");
        }

        $array = json_decode(file_get_contents($file), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("The file {$file} must contain a valid JSON string");
        }

        return $array;
    }
}
