<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\StudentTeacherResource;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        // $this->validate($request, [
        //     'first_name' => 'required|string|max:255',
        //     'last_name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6',
        //     'role' => 'required|string',
        // ]);

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phoneNumber' => $request->phoneNumber,
        ]);

        if ($request->role == 'student') {
            Student::create([
                'user_id' => $user->id,
            ]);
        } elseif ($request->role == 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
            ]);
        }

        return new StudentTeacherResource($user);
    }
}
