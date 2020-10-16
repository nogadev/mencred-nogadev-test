<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserValidator;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    private $path = "users";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::withTrashed()->get();
        return view($this->path.'.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserValidator $request)
    {
        try{
            $user = new User($request->all());
            if($user->password == ''){
                $password = str_random(8);
                $user->password = bcrypt($password);
            }
            $user->save();
        } catch(Exception $e) {
            session()->put('error','Se ha producido un error');
            return "Fatal error - ".$e->getMessage();
        }
        return redirect()->route($this->path.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view($this->path.'.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserValidator $request, User $user)
    {
        try {
            $user->fill($request->all())->save();
        } catch(Exception $e) {
            session()->put('error','Se ha producido un error');
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return redirect()->route('users.index');
        } catch (Exception $e){
            return "Fatal error - ".$e->getMessage();
        }
    }
}
