<?php
namespace Kasseler\Core\Config\Writer;

/**
 * Array File Writer
 */
class ArrayFileWriter extends AbstractFileWriter
{
    private $ext = '.php';

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
            file_put_contents($file, "<?php\nreturn ".var_export($array, true).";\n");
        } catch (\Exception $e) {
            trigger_error("Error creating file", E_USER_ERROR);
        }
    }
}
