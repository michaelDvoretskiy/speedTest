<?php

namespace Pendella\SpeedTest\Test;

class GoogleApiTest extends Test
{
    const BASE_TEST_API_URL = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';
    const MOBILE_TYPE_VALUE = "mobile";
    const DESKTOP_TYPE_VALUE = "desktop";
    const API_KEY = 'XXXXXXXXX';

    public function getResults(string $url, int $type) {

        $res = [];
        if ($type == self::TYPE_MOBILE || $type == self::TYPE_BOTH) {
            $res[self::MOBILE_TYPE_VALUE] = $this->makeTest($url, self::MOBILE_TYPE_VALUE);
        }
        if ($type == self::TYPE_DESKTOP || $type == self::TYPE_BOTH) {
            $res[self::DESKTOP_TYPE_VALUE] = $this->makeTest($url, self::DESKTOP_TYPE_VALUE);
        }

        return $res;
    }

    private function makeTest(string $url, string $typeName) {
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request(
                'GET',
                self::BASE_TEST_API_URL,
                [
                    'query' => [
                        'strategy' => $typeName,
                        'url' => $url,
                        'key' => self::API_KEY
                    ]
                ]
            );
            if (in_array(substr($response->getStatusCode(),0,1), ['4','5'])) {
                return $this->createErrorJsonResponse($response->getStatusCode());
            } else {
                $responseJson = json_decode($response->getBody(), true);
                $res['Performance'] = [
                    'score' => $responseJson['lighthouseResult']['categories']['performance']['score'],
                    'displayValue' => $responseJson['lighthouseResult']['categories']['performance']['score'] * 100 . " %"
                ];
                foreach (['first-contentful-paint', 'interactive', 'speed-index', 'total-blocking-time',
                             'largest-contentful-paint', 'cumulative-layout-shift'] as $key) {
                    $res[$responseJson['lighthouseResult']['audits'][$key]['title']] = [
                        'score' => $responseJson['lighthouseResult']['audits'][$key]['score'],
                        'displayValue' => $responseJson['lighthouseResult']['audits'][$key]['displayValue']
                    ];
                }

            }
            return $res;
        } catch (\Throwable $e) {
            return $this->createErrorJsonResponse(500);
        }
    }

    private function createErrorJsonResponse($status) {
        $res['Performance'] = [
            'score' => $status,
            'displayValue' => 'error'
        ];
        foreach (['first-contentful-paint', 'interactive', 'speed-index', 'total-blocking-time',
                     'largest-contentful-paint', 'cumulative-layout-shift'] as $key) {
            $res[$key] = [
                'score' => 0,
                'displayValue' => 'error'
            ];
        }
        return $res;
    }
}
