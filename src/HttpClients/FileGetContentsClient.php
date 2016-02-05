<?php

namespace HttpClients;

use Interfaces\HttpClient;

class FileGetContentsClient implements HttpClient
{
    public function getData($url)
    {
        return file_get_contents($url);
    }
}
 