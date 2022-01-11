<?php
/**
 * Created by PhpStorm.
 * User: Efqan
 * Date: 1/8/2022
 * Time: 3:59 AM
 */

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface{


    protected $user;
    public function __construct(User $user)
    {
        $this->user=$user;
    }

    public function all():Collection{
        $users=$this->user->orderBy("name")->get()->map(function ($user){
            return [
                "user_id"=>$user->id,
                "name"=>$user->name,
                "email"=>$user->email
            ];
        });

        return $users;
    }

}