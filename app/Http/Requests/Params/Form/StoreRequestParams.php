<?php

namespace App\Http\Requests\Params\Form;

use App\Core\Http\Requests\Params\RequestParams;
use Illuminate\Http\UploadedFile;

class StoreRequestParams extends RequestParams
{
    public function __construct(
      public Array $fields
    ) {
    }
}
//
//{
//    "fields": {
//    "1": {
//        "value": 1
//        },
//        "2": {
//        "value": []
//        },
//        "3": {
//        "value":"222"
//        },
//        "4": {
//        "value":"124"
//        },
//        "5": {
//        "value": {
//            "lng": 37.542824,
//                "lat": 55.749451,
//                "location": "Москва, Врачебный проезд, 4"
//            }
//        },
//        "6": {
//        "value": 400
//        }
//    }
//}
