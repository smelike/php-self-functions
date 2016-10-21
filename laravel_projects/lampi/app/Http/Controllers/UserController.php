<?php

namespace App\Http\Controllers;

//use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{

    public function index()
    {
        $users = \App\User::all();
        //dd($users);
        foreach($users as $user)
        {
            echo $user->name;
        }

        $users = \App\User::where('id', '>', 1)->orderBy('id', 'desc')->take(10)->get();
        //dd($users);
       foreach($users as $user)
       {
           echo '<h1>' .$user->id .'####'. $user->name . '</h1>';
       }

        $userAccounts = $users->reject(function ($user) {
            return $user->name;
        });
        //var_dump($userAccounts);

        \App\User::chunk(200, function($users) {
            //var_dump($users);
        });

        echo "<br/>";
        $user = \App\User::find(1);
        //var_dump($user);

        $users = \App\User::find([1, 3]);

        //dd($users);

        //$model = \App\User::findOrFail(10);
        //dd($model);

        $count = \App\User::where('id', '>', 2)->count();
        dd($count);
    }

    public function store(Request $request)
    {
        $user = new \App\User;
        $user->name = $request->name;
        $user->userAccount = rand(10000, 99999999);
        $user->password = 0000;
        $user->token = 0000;
        $user->status = 2;

        $return = $user->save();

        dd($return);
    }

    public function update(Request $request)
    {
        $user = \App\User::find(102);
        $user->name = 'demodemodemo';
        $return = $user->save();

        //var_dump($return);

        // mass update
        /*
        \App\User::where('status', 2)
                ->where('id' , '<', '30')
                ->update(['status' => 88]);
        */
    }

    public function create(Request $request)
    {
        $user = [
            'name' => 'gugugukodo',
            'userAccount' => rand(20000, 90000),
            'password' => rand(20000, 90000),
            'token' => rand(20000, 90000),
        ];
        $return = \App\User::create($user);
        dd($return);

        // Retrieve the flight by the attributes, or create it if it doesn't exist...
        $flight = \App\User::firstOrCreate(['name' => 'Flight 10']);

        // Retrieve the flight by the attributes, or instantiate a new instance...
        //Note that the model returned by firstOrNew has not yet been persisted
        // to the database. You will need to call save manually to persist it:
        $flight = \App\User::firstOrNew(['name' => 'Flight 10']);
    }

    public function del()
    {
        // deleting models
        $user = \App\User::find(5);
        //$return = $user->delete();
        //var_dump($return);

        $user = \App\User::find(18);
        $return = $user->delete();
        var_dump($return);

        // deleting an existing model by key
        // \App\User::destroy(1);
        // \App\User::destroy([1,2,3]);
        // \App\User::destroy(1,2,3);

        // deleting models by query

        $deleteRows = \App\User::where('status', 0)->delete();

        var_dump($deleteRows);

    }

}
