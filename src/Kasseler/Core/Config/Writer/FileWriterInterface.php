<?php
namespace Kasseler\Core\Config\Writer;

/**
 * File Writer Interface
 */
interface FileWriterInterface
{
    /**
     * @param $file
     * @param $name
     * @param $array
     *
     * @return array
     */
    public function dump($file, $name, array $array);
}
