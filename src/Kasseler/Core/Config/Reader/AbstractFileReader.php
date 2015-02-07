<?php
namespace Kasseler\Core\Config\Reader;

/**
 * Abstract File Reader
 */
abstract class AbstractFileReader implements FileReaderInterface
{
    /**
     * @throws \Exception
     */
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    abstract public function parse($fileName);
}
