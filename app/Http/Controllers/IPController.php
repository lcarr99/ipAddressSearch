<?php

namespace App\Http\Controllers;

use App\Repository\IPSearchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\IPSearchService;

class IPController extends Controller
{
    public static function getIPData(Request $request)
    {
        if ($request->ipAddress !== 'self') {
            $params = $request->route()->parameters();

            $validator = Validator::make($params, ['ipAddress' => 'required|ip']);

            if ($validator->fails()) {
                return Response()->json(['status' => 'error', 'message' => 'Invalid IP Address Entered']);
            }
        }

        $response = IPSearchService::getDataByAddress($request->ipAddress);

        $data = IPSearchService::parseResponse($response);

        IPSearchRepository::create($request->ipAddress, $response);

        $statusCode = $data[0];

        if ($statusCode === '1') {
            if ($request->ipAddress === 'self') {
                $request->ipAddress = $_SERVER['REMOTE_ADDR'];
            }

            $twoLetter = $data[1];
            $threeLetter = $data[2];
            $country = $data[3];

            $data = [
                'status' => 'success',
                'ipAddress' => $request->ipAddress,
                'twoLetter' => $twoLetter,
                'threeLetter' => $threeLetter,
                'country' => $country,
            ];
        } else {
            $data = ['status' => 'error', 'message' => 'IP Not Found'];
        }

        return Response()->json(
            $data
        );
    }
}
