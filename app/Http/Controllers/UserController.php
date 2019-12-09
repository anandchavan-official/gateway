<?php

namespace App\Http\Controllers;

use App\User;

use App\Traits\APIResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    use APIResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

     /**
     * view a list of Users.
     *
     * @return Illuminate\Http\Response
     */
    public function index(){

        $users = User::all();

        return $this->successResponse($users);
    }

    /**
     * create a new Users.
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:8,confirmed',
        ];

        $this->validate($request, $rules);
        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);

        $user = User::create($fields);
        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    /**
     * View an existing Users.
     *
     * @return Illuminate\Http\Response
     */
    public function show($user){

        $user = User::findOrFail($user);
        return $this->successResponse($user);
    }

    /**
     * update an existing Users.
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $user){

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:user,email' .$user,
            'password' => 'required|min:8,confirmed',
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($user);
        $user->fill($request->all());

        if($request->has('user')){
            $user->password = Hash::make($request->password);
        }

        if ($user->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();
        return $this->successResponse($user);
    }

    /**
     * Remove an existing Users.
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($user){

        $user = User::findOrFail($user);
        $user->delete();
        return $this->successResponse($user);
    }
}
