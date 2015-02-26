<?php

namespace Kasseler\Component\Config\Writer;

/**
 * XML File Writer
 */
class XmlFileWriter extends AbstractFileWriter
{
    private $ext = '.xml';
    private $version = '1.0';
    private $encoding = 'UTF-8';
    /** @var \XMLWriter */
    private $writer;

    /**
     * @param $data
     * @param $name
     *
     * @return string
     */
    public function convert($data, $name) {
        $this->writer->openMemory();
        $this->writer->setIndent(true);
        $this->writer->startDocument($this->version, $this->encoding);
        $this->writer->startElement($name);
        if (is_array($data)) {
            $this->getXML($data);
        }
        $this->writer->endElement();
        return $this->writer->outputMemory();
    }

    /**
     * @param $data
     */
    private function getXML($data) {
        foreach ($data as $key => $val) {
            if (is_numeric($key)) {
                $key = 'key'.$key;
            }
            if (is_array($val)) {
                $this->writer->startElement($key);
                $this->getXML($val);
                $this->writer->endElement();
            } else {
                $this->writer->writeElement($key, $val);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dump($fileName, $name, array $array)
    {
        $this->writer = new \XMLWriter();
        $file = $fileName.$this->ext;
        if(file_exists($file)){
            if(!is_writable($file)){
                throw new \Exception("The file {$file} is either not writable");
            }
        }

        try {
            file_put_contents($file, $this->convert($array, $name));
        } catch (\Exception $e) {
            trigger_error("Error creating file", E_USER_ERROR);
        }
    }
}
