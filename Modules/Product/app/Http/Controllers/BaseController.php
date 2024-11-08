<?php

namespace Modules\Product\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{

    public function makeResponsePaginate($data)
    {
        $response = [
            'links' => [
                'first' => $data->url(1),
                'last' => $data->url($data->lastPage()),
                'prev' => $data->previousPageUrl(),
                'next' => $data->nextPageUrl()
            ],
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
        ];
        return $response;
    }
    
}
