<?php


namespace Fengjian199308\Weather;


use Fengjian199308\Weather\Exceptions\HttpException;
use Fengjian199308\Weather\Exceptions\InvalidArgumentException;
use GuzzleHttp\Client;

class Weather
{
    /**
     * @var string
     */
    protected $key;

    protected $guzzleOptions = [];

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getWeather($city, $type = 'base', $format = 'json')
    {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        if (!in_array($type, ['base', 'all'])) {
            throw new InvalidArgumentException('Invalid type value(base/all): '.$type);
        }

        if (!in_array($format, ['json', 'xml'])) {
            throw new HttpException('Invalid response format: '.$format);
        }

        $params = array_filter([
            'key'   =>  $this->key,
            'city'  =>  $city,
            'extensions'    =>  $type,
            'output'    =>  $format,
        ]);

        try {
            $response = $this->getHttpClient()->get($url, [
                'query' => $params,
            ])->getBody()->getContents();

            return $format === 'json' ? json_decode($response, true) : $response;

        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }
}