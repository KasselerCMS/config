<?php

namespace Kasseler\Component\Config\Writer;

/**
 * Abstract File Writer
 */
abstract class AbstractFileWriter implements FileWriterInterface
{
    /**
     * {@inheritdoc}
     */
    abstract public function dump($file, $name, array $array);
}
