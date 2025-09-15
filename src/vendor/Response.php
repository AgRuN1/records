<?php

namespace vendor;

class Response
{
    function __construct(
        private $data=null,
        private bool $success=true,
        private int $status=200,
        private string $message=''
    )
    {}

    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }

    public function setHTTPStatus()
    {
        http_response_code($this->status);
    }

    public function toArray(): array
    {
        return [
            'data'=>$this->data,
            'success'=>$this->success,
            'status'=>$this->status,
            'message'=>$this->message
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}