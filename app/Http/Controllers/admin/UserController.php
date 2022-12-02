<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreUserRequest;
use App\Http\Resources\admin\UserResource;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request['search'] ?? "";
            if ($search != "") {
                $users = User::where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")->get();
            } else {
                $users = User::all();
            }

            return UserResource::collection($users);
        } catch (\Throwable $e) {

            return response(['error' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        try {
            $user = User::where('id', $user->id)->get();

            return UserResource::collection($user);
        } catch (\Throwable $e) {

            return response(['error' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $request->merge([
            'password' => Hash::make($request->password),
        ]);

        try {
            $user = User::create($request->all());
            $adminRole = Role::where('name', $request->user_type)->first();
            $editUserPermission = Permission::where('name', $request->permission_type)->first();
            $user = User::find($user->id);
            $user->attachRole($adminRole);
            $user->attachPermission($editUserPermission);

            new UserResource($user);

            return response(['success' => true], 200);
        } catch (\Throwable $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserRequest $request, $id)
    {
        $user = User::find($id);
        $request->merge([
            'password' => Hash::make($request->password),
        ]);
        try {
            $user->update($request->all());
            return new UserResource($user);
        } catch (\Throwable $e) {

            return response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return response()->json(['message' => 'Record deleted successfully']);
        } catch (\Throwable $e) {
            return response(['error' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }
}
