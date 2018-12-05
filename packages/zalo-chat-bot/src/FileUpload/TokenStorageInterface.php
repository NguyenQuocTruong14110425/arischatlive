<?php

namespace Zalo\FileUpload;

interface TokenStorageInterface
{
    /**
     * @return mixed
     */
    public function read();

    /**
     * @param  array $config
     * @return mixed
     */
    public function write(array $config);
}
