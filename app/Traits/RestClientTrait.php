<?php
namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Response;
use File;
use setasign\Fpdi\Fpdi;

trait RestClientTrait {

    private $baseUrl = 'http://localhost:8080/';

    public function post($endpoint, $body, $filename) {
        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $response = $client->post($this->baseUrl . $endpoint, ['body' => $body]);
        $data = $response->getBody()->getContents();
        //This not working with one page.
        //header('Content-Type: application/pdf; charset=utf-8');
        //echo $data;

        //Save file
        //File::put('/Users/leandro/Downloads/' . $filename, $data); //External directory
        //$file = '/Users/leandro/Downloads/' . $filename;
        File::put(storage_path('report.pdf'), $data); //Internal directory - Storage folder
        $file = storage_path('report.pdf');
        header('Content-Type: application/pdf');
        //header('Content-Disposition: inline; filename="' . $filename . '"'); // Show in browser - This not working with one page.
        header('Content-Disposition: attachment; filename="' . $filename . '"'); //Download
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        @readfile($file);
    }

    public function postWithHeader($endpoint, $body, $header, $filename) {
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'x-date' => $header,
            ]
        ]);
        $response = $client->post($this->baseUrl . $endpoint, ['body' => $body]);
        $data = $response->getBody()->getContents();
        File::put(storage_path('report.pdf'), $data);
        $file = storage_path('report.pdf');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        @readfile($file);
    }

}
