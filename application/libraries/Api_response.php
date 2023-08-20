<?php

class Api_response
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function send($data, $status = 200)
    {
        $this->ci->output
            ->set_content_type('application/json')
            ->set_status_header($status)
            ->set_output(json_encode($data));
    }

    public function error($message, $status = 400)
    {
        $this->send(array('error' => $message), $status);
    }
}
