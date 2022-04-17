<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\CarsResource;
use App\models\Cars;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarsApiController extends Controller
{
    public function index()
    {
        
        return CarsResource::collection(Cars::all());
    }

    public function show($id)
    {
        return new CarsResource(Cars::findorFail($id));
    }
}
