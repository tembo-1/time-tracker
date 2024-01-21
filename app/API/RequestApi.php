<?php

namespace App\API;

use App\Enums\ApiType;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use SoapClient;
use SoapFault;

abstract class RequestApi
{
    /**
     * @var ApiType
     */
    protected ApiType $type;

    /**
     * @var array
     */
    protected array $param;

    /**
     * @var string
     */
    protected string $method;

    /**
     * @var string
     */
    protected string $link;

    /**
     * @var Response|array|null|SoapClient
     */
    protected Response|array|null|SoapClient  $response;

    /**
     * @param  array  $value
     * @return void
     */
    protected function setParam(array $value):void
    {
        $this->param = $value;
    }

    /**
     * @param  ApiType  $value
     * @return void
     */
    protected function setType(ApiType $value):void
    {
        $this->type = $value;
    }

    /**
     * @param  string  $value
     * @return void
     */
    protected function setLink(string $value):void
    {
        $this->link = $value;
    }

    /**
     * @param  string  $value
     * @return void
     */
    protected function setMethod(string $value):void
    {
        $this->method = $value;
    }

    /**
     * @param  Response|array|null|SoapClient   $value
     * @return void
     */
    protected function setResponse(Response|array|null|SoapClient  $value):void
    {
        $this->response = $value;
    }

    /**
     * @return Response|array|null|SoapClient
     */
    public function getResponse():Response|array|null|SoapClient
    {
        return $this->response;
    }

    /**
     * @return bool
     * @throws SoapFault
     */
    public function goRequest():bool
    {
        if ($this->type === ApiType::JSON) {
            $response = Http::post($this->link.$this->method??null, $this->param??null);

            $this->setResponse($response);

            return true;
        }

        $options = [
            'connection_timeout' => 300,
            'stream_context' => stream_context_create([
                'ssl' => [
                    'verify_peer' => true,
                    'verify_peer_name' => true,
                    'allow_self_signed' => true
                ]
            ])
        ];

        $soapClient = new SoapClient($this->link, $options);

        $this->setResponse($soapClient->__call($this->method, $this->param));

        return true;
    }
}
