<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-03-25
 * Time: 14:07
 */

namespace App\Exceptions\Service;


use App\Exceptions\AppException;

class ServiceException extends AppException
{
    /**
     * ServiceException constructor.
     *
     * @param null $desc
     * @param null $meta
     * @param null $code
     * @param null $previous
     */
    public function __construct($desc = null, $meta = null, $code = null, $previous = null)
    {
        $this->message = 'Service Exception';
        parent::__construct($desc, $meta, $code, $previous);
    }
}
