<?php

namespace Kasseler\Component\Config;

use Kasseler\Component\Config\Reader\AbstractFileReader;
use Kasseler\Component\Config\Writer\AbstractFileWriter;

class Repository
{
    private $repository;
    private $delimiter = '.';
    private $config = [];
    private $change = [];

    private $reader;
    private $writer;

    /**
     * @param AbstractFileReader $reader
     * @param AbstractFileWriter $writer
     * @param                    $repository
     */
    public function __construct(AbstractFileReader $reader, AbstractFileWriter $writer, $repository)
    {
        $this->reader = $reader;
        $this->writer = $writer;
        $this->repository = $repository;
    }

    /**
     * @param $array
     *
     * @return array
     */
    private function explodeTree($array)
    {
        $splitRE   = '/' . preg_quote($this->delimiter, '/') . '/';
        $returnArr = [];
        foreach ($array as $key => $val) {
            $parts  = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
            $leafPart = array_pop($parts);

            $parentArr = &$returnArr;
            foreach ($parts as $part) {
                if (!isset($parentArr[$part])) {
                    $parentArr[$part] = [];
                } elseif (!is_array($parentArr[$part])) {
                    $parentArr[$part] = [];
                }
                $parentArr = &$parentArr[$part];
            }

            if (empty($parentArr[$leafPart])) {
                $parentArr[$leafPart] = $val;
            }
        }

        return $returnArr;
    }

    /**
     * @param $key
     *
     * @return array
     * @throws \Exception
     */
    private function getParametrs($key)
    {
        $segs = explode($this->delimiter, $key);
        if (count($segs) < 2) {
            throw new \Exception("Incorrect config key");
        }
        $name = array_shift($segs);

        return [$name, $segs];
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     * @throws \Exception
     */
    public function set($key, $value)
    {
        list($name) = $this->getParametrs($key);
        $this->change[] = $name;
        $this->config = array_merge_recursive($this->config, $this->explodeTree([$key => $value]));

        return $this;
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return null
     * @throws \Exception
     */
    public function get($key, $default = null)
    {
        list($name, $segs) = $this->getParametrs($key);
        if (!isset($this->config[$name])) {
            $this->read($name);
        }

        $root = $this->config[$name];
        foreach($segs as $name) {
            if(isset($root[$name])) {
                $root = $root[$name];
            } else {
                if($default == null){
                    throw new \Exception("Key '{$name}' in [ {$key} ] not found");
                } else {
                    return $default;
                }
            }
        }

        return $root;
    }

    /**
     * @param $name
     */
    public function read($name)
    {
        $this->config[$name] = $this->reader->parse($this->repository.$name);
    }

    /**
     * @param null $name
     *
     * @throws \Exception
     */
    public function write($name = null)
    {
        if ($name == null) {
            foreach ($this->change as $config) {
                if (isset($this->config[$config])) {
                    $this->writer->dump($this->repository.$config, $config, $this->config[$config]);
                } else {
                    throw new \Exception("Config '{$config}' not found");
                }
            }
            $this->change = [];
        } else {
            $this->writer->dump($this->repository.$name, $name, $this->config[$name]);
        }
    }
}
