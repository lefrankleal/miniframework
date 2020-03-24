<?php
namespace Core\Helpers;

class HttpResponse
{
    public static function response($data = '')
    {
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json; charset=utf-8");
        header("Accept-Encoding: gzip, deflate");
        http_response_code($data['http_code']);
        if (is_array($data['readable']) && is_array($data['data'])) {
            $i = 0;
            foreach ($data['data'] as $k) {
                foreach ($data['readable'] as $key) {
                    $response[$i][$key] = $k->$key !== null ? $k->$key : '';
                }
                $i++;
            }
        } elseif (is_array($data['data'])) {
            foreach ($data['data'] as $key => $v) {
                $response[$key] = $v !== null ? $v : '';
            }
        } else {
            $response = $data['data'];
        }
        echo json_encode($response, JSON_PARTIAL_OUTPUT_ON_ERROR);
        exit;
    }
}
