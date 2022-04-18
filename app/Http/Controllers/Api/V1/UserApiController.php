<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\UserResource;
use App\models\User;
use App\models\Cars;


class UserApiController extends Controller
{
   

    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show($id)
    {
        return new UserResource(User::findorFail($id));
    }

    public function getcar($id, $carname)
    {
       
        $car = Cars::where('car_name',$carname)->firstOrFail();
        $user = User::findorFail($id);
        
        if (is_null($car->user_id)){
            
            //user has a car
           if( 0 < Cars::where('user_id',$id)->count()){
               $message = 'У пользовтаеля уже есть машина '. $car->car_name;
            return Response::json(['error' => $message], 200);
            }

            $car->user_id = $id;
            $car->save();
            //user got the car
            $message = "Пользователь ". $user->name ." получил машину ".$car->car_name;
            return Response::json(['message' => $message], 200);
           
        }        

        // car is busy
        return Response::json(['error' =>'Данная машина занята!'], 200);        
    }
}
