<?php
namespace Kasseler\Core\Config\Reader;

/**
 * XML File Loader
 */
class XmlFileReader extends AbstractFileReader
{
    private $ext = '.xml';

    /**
     * @param array $input
     *
     * @return array
     */
    private function replaceKeys(array $input) {
        $return = [];
        foreach ($input as $key => $value) {
            if (preg_match('/^key([0-9]+)$/m', $key)) {
                $key = str_replace('key', '', $key);
            }

            if (is_array($value)){
                $value = $this->replaceKeys($value);
            }
            $return[$key] = $value;
        }
        return $return;
    }

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
            $array = (array) new \SimpleXMLElement(file_get_contents($file));

            $callback = function(&$value) use (&$callback){
                $value = (is_object($value)) ? (array)$value : $value;
                if (is_array($value)) {
                    array_walk($value, $callback);
                }
            };

            array_walk($array, $callback);
        } catch (\Exception $e) {
            trigger_error("Error XML parsing", E_USER_ERROR);
        }

        return $this->replaceKeys($array);
    }
}
