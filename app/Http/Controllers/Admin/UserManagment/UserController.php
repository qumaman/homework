<?php

namespace App\Http\Controllers\Admin\UserManagment;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //строим страницу пользователя с пагинацией
        return view('admin.user_managment.users.index', [
            'users' => User::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //переносимся на страницу создания пользователя
        return view('admin.user_managment.users.create', [
            'user' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
        //Создаем нового пользователя
        $user = new User;
        //Проверяем требования полей на заполненность
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        //Аватар по умолчанию
        $avatar = 'default.jpg';
        //Если загружен новый аватар
        if($request->hasFile('avatar')){
            $image = $request->file('avatar');
            //переименововаем для уникальности
            $client_name = rand(1111, 9999) . $image->getClientOriginalName();
            $dir_upload = public_path('uploads/avatars/');
            //сохраняем в папку
                if($image->move($dir_upload, $client_name)){
                    //готовим для сохранения в базу если файл сохранен
                    $avatar = $client_name;
                }
        }
        //готовим для сохранения в базу
        $user->name = $request['name'];
        $user->email = $request['email'];  
        $user->avatar = $avatar;
        $request['password'] == null ?: $user->password = bcrypt($request['password']);
        //сохраняем в базу
        $user->save();
        //переносимся на страницу пользователей
        return redirect()->route('admin.user_managment.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //переносимся на страницу редактирования пользователя
        return view('admin.user_managment.users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //Проверяем требования полей на заполненность
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        //Если загружен новый аватар
        if($request->hasFile('avatar')){
            if($request->hasFile('avatar')){
			echo 'Файл загружен <br>';
            $image = $request->file('avatar');
            //переименововаем для уникальности
            $client_name = rand(1111, 9999) . $image->getClientOriginalName();
            $dir_upload = public_path('uploads/avatars/');
            echo $dir_upload . $user->avatar;
                //удаляем старый если не является рисунком по умолчанию
                if(!empty($user->avatar) != 'default.jpg'){
                   @unlink($dir_upload . $user->avatar);
                }
                //сохраняем в папку
                if($image->move($dir_upload, $client_name)){
                    //готовим для сохранения в базу если файл сохранен
                    $user->avatar = $client_name;
                    echo '<img src="uploads/avatars/' . $image->getClientOriginalName() . '">';
                    echo '<br> <a href="/home">Вернутся назад </a> ';
                }
            }
        }
        //готовим для сохранения в базу
        $user->name = $request['name'];
        $user->email = $request['email'];  
        $request['password'] == null ?: $user->password = bcrypt($request['password']);
        //сохраняем в базу
        $user->save();
        //переносимся на страницу пользователей
        return redirect()->route('admin.user_managment.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //удаляем привязанный рисунок если не является рисунком по умолчанию
        if(!empty($user->avatar) != 'default.jpg'){
           @unlink($dir_upload . $user->avatar);
        }
        //удаляем пользователя
        $user->delete();
        //переносимся на страницу пользователей
        return redirect()->route('admin.user_managment.user.index');
    }
}
