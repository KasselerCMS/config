<?php

namespace Kasseler\Component\Config\Writer;

use Symfony\Component\Yaml\Yaml;

/**
 * Yaml File Loader
 */
class YamlFileWriter extends AbstractFileWriter
{
    private $ext = '.yml';

    /**
     * {@inheritdoc}
     */
    public function dump($fileName, $name, array $array)
    {
        $file = $fileName.$this->ext;
        if(file_exists($file)){
            if(!is_writable($file)){
                throw new \Exception("The file {$file} is either not writable");
            }
        }
        try {
            file_put_contents($file, Yaml::dump($array, 20, $indent = 4, $exceptionOnInvalidType = true, $objectSupport = true));
        } catch (\Exception $e) {
            trigger_error("Error creating file", E_USER_ERROR);
        }


    }
}
