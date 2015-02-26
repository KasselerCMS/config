<?php

namespace Kasseler\Component\Config\Reader;

use Symfony\Component\Yaml\Yaml;

/**
 * Yaml File Loader
 */
class YamlFileReader extends AbstractFileReader
{
    private $ext = '.yml';

    /**
     * {@inheritdoc}
     */
    public function parse($fileName)
    {
        $file = $fileName.$this->ext;
        if (!is_readable($file)) {
            throw new \Exception("The file {$file} is either not readable or cannot be found");
        }

        try {
            $array = (array)Yaml::parse($file);
        } catch (\Exception $e) {
            trigger_error("Error Yaml parsing", E_USER_ERROR);
        }

        return $array;
    }
}
