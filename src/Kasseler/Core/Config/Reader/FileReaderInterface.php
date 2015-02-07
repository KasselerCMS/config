<?php
namespace Kasseler\Core\Config\Reader;

/**
 * File Reader Interface
 */
interface FileReaderInterface
{
    /**
     * @return array
     */
    public function parse($fileName);
}
