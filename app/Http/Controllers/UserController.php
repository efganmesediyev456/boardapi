<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    public function index(){
        return $this->userRepository->all();
    }

    public function login(Request $request){

        $user=User::whereEmail($request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                "error"=>"no user"
            ],404);
        };
        return response()->json($user,200);
    }
    public function register(Request $request){
        $data=$request->only([
            "name","email","password"
        ]);
        $data["password"]=Hash::make($data["password"]);
        $user=User::create($data);
        return response()->json($user);
    }

    public function product(Request $request){
        $pro=new Product();
        $pro->name=$request->name;
        $pro->description=$request->description;
        $file=$request->file("file");

        $fileName=time().".".$file->getClientOriginalExtension();



       $file->storeAs("/public/images",$fileName);

        $pro->file_path=$fileName;

        $pro->save();

        return response()->json($pro,200);
    }

    public function lists(){
        return Product::latest()->get();
    }

    public function delete($id){
        $data=Product::find($id);
        if($data->delete()){
            return response()->json([
                "message"=>"ugurla silindi"
            ]);
        }
        return response()->json([
            "message"=>"silinerken xeta"
        ],422);
    }


    public function show($id){
        return Product::find($id);
    }

    public function update(Request $request,$id){




        $pro=Product::find($id);
        $pro->name=$request->name;
        $pro->description=$request->description;


        if($request->hasFile("file")){
            if(file_exists(public_path("storage/images/".$pro->file_path))){
                unlink(public_path("storage/images/".$pro->file_path));
            }

            $file=$request->file("file");

            $fileName=time().".".$file->getClientOriginalExtension();



            $file->storeAs("/public/images",$fileName);

            $pro->file_path=$fileName;


        }

        $pro->save();

        return response()->json($pro);

    }

}
