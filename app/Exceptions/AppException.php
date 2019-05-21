<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    protected $desc = null;
    protected $meta = null;

    /**
     * AppException constructor.
     *
     * @param null $desc
     * @param null $meta
     * @param null $code
     * @param null $previous
     */
    public function __construct($desc = null, $meta = null, $code = null, $previous = null)
    {
        $this->message = 'App Exception';
        $this->desc    = $desc;
        $this->meta    = $meta;
        parent::__construct($this->message, $code, $previous);
    }

    public function getDesc()
    {
        return $this->desc;
    }

    public function getMeta()
    {
        return $this->meta;
    }
}
