<?php

namespace Zalo\FileUpload;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class FileTokenStorage implements TokenStorageInterface
{
    /**
     * @var null|string
     */
    private $file;
    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @param string $file
     */
    public function __construct($file = null)
    {
        if (null === $file) {
            $file = isset($_SERVER['HOME']) ? $_SERVER['HOME'] . DIRECTORY_SEPARATOR . '.zalo' : sys_get_temp_dir() . DIRECTORY_SEPARATOR . '.zalo';
        }

        $this->file = $file;
        $this->fileSystem = new Filesystem();
    }

    /**
     * {@inheritdoc}
     */
    public function read($key = 'access_token')
    {
        $content = $this->fileSystem->exists($this->file) ? Yaml::parse(file_get_contents($this->file)) : [];

        return isset($content[$key]) ? $content[$key] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $config)
    {
        $this->fileSystem->dumpFile($this->file, Yaml::dump($config));
    }
}
