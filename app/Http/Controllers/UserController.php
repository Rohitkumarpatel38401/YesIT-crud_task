<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        // dd($request->hasFile('profile_pic'));
        $data = $request->validated();
        if($request->hasFile('profile_pic')){
            $data['profile_pic'] = $request->file('profile_pic')->store('profiles','public');
        }
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('users.index')->with('success','User Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        if($request->hasFile('profile_pic')){
            //delete
            if($user->profile_pic){
                Storage::disk('public')->delete($user->profile_pic);
            }
            $data['profile_pic'] = $request->file('profile_pic')->store('profiles','public');
            
        }
        if($request->filled('password')){
            $data['password'] = Hash::make($request->password);
        }else{
            unset($data['password']);
        }
        $user->update($data);
        return redirect()->route('users.index')->with('success','User Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($user->profile_pic){
            Storage::disk('public')->delete($user->profile_pic);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success','User Deleted Successfully.');
    }

    public function exportData()
    {
        $fileName = 'user_export.csv';
        $users = User::all();
        $headers = [
            "Content-type" => 'text/cvs',
            "Content-Disposition" => "attachment filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use($users){
            $file = fopen('php://output','w');
            fputcsv($file, ['ID','Name','Email','Mobile','Created At']);

            foreach ($users as $user){
                fputcsv($file, [$user->id, $user->name, $user->email, $user->mobile, $user->created_at]);
            }
            fclose($file);

            return response()->stream($callback, 200, $headers);
        };
    }

}
