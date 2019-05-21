<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-03-25
 * Time: 13:11
 */

namespace App\Helpers\Api;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait Response
{
    /**
     * @var enum
     */
    protected $status = FoundationResponse::HTTP_OK;

    /**
     * @return enum
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param enum $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param mixed $data
     * @param array $headers
     * @return mixed
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatus(), $headers);
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    public function error($data)
    {
        return $this->setStatus(FoundationResponse::HTTP_INTERNAL_SERVER_ERROR)->respond($data);
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    public function success($data)
    {
        return $this->respond($data);
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    public function fail($data)
    {
        return $this->setStatus(FoundationResponse::HTTP_BAD_REQUEST)->respond($data);
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    public function notFound($data)
    {
        return $this->setStatus(FoundationResponse::HTTP_NOT_FOUND)->respond($data);
    }
}
