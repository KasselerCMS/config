<?php

namespace Kasseler\Component\Config\Writer;

/**
 * Json File Writer
 */
class JsonFileWriter extends AbstractFileWriter
{
    private $ext = '.json';
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
            file_put_contents($file, json_encode($array, JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            trigger_error("Error creating file", E_USER_ERROR);
        }
    }
}
