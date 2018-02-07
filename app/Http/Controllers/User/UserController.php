<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Mail\UserCreated;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['store','resend']);
        $this->middleware('auth:api')->except(['store','verify','resend']);
        $this->middleware('scope:manage_accounts')->only(['show','update']);
        $this->middleware('transform.input:'.UserTransformer::class)->only(['store','update']);
        $this->middleware('can:view,user')->only(['show']);
        $this->middleware('can:update,user')->only(['update']);
        $this->middleware('can:delete,user')->only(['destroy']);
    }

    public function index()
    {
        return $this->showAll(User::all());
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            // Password_confirmation field must be present in the input.
        ];
        //if validation failed exception will be thrown
        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);
        return $this->showOne($user);
    }

    public function update(Request $request, User $user)
    {
        /*
         * server receive request when change Content-Type to application/x-www-form-urlencoded
         */
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'verified' => 'required',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];
        $this->validate($request, $rules);
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }
        if ($req->has('password')) {
            $user->password = bcrypt($req->password);
        }
        if ($req->has('admin')) {
            if (!$user->isVerified()) {
                return $this->errorResponse('Only verified users can modify the admin field', 409);
            }
            $user->admin = $request->admin;
        }
        if (!$user->isDirty()) {
            return $this->errorResponse('No changes in values to update', 409);
        }
        $user->save();
        return $this->showOne($user);
    }

    public function show(User $user)
    {
        return $this->showOne($user);
    }

    public function destroy(User $user)
    {
        if($user->delete()){
            return $user;
        }else{
            return $this->errorResponse('something went wrong please try again');
        }
    }

    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verification_token = null;
        $user->verified = User::VERIFIED_USER;
        $user->save();
        return $this->showMessage('The user has been verified successfully');
    }

    public function resend(User $user)
    {
        if(!$user->isVerified()){
            Mail::to($user)->send(new UserCreated($user));
            return $this->showMessage('The verification code has been sent to your email');
        }else{
            return $this->errorResponse('This user is already verified');
        }

    }
}
