@extends('layouts.app')

@section('content')
    <div style="max-width:500px" class="mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white ">
                <div class="d-flex justify-content-between align-items-center">
                   <div class="d-flex align-items-center">
                   <h2 class="mx-1">Edit User/ </h2> {{ $user->name}}
                   </div>
                    <div>
                        <a href="/users" class="btn btn-secondary">Back</a>
                    </div>   
                </div>   
                    
            </div>
            <div class="card-body">
                <form action="{{route('users.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Enter Name</label>
                        <input type="text" value="{{old('name',$user->name)}}" class="form-control" id="name" name="name" placeholder="John">
                        @error('name') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" value="{{old('email',$user->email)}}" class="form-control" id="email" name="email" placeholder="name@example.com">
                        @error('email') <small class="text-danger">{{$message}}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile (10 Digits)</label>
                        <input type="text" value="{{old('mobile',$user->mobile)}}" class="form-control" id="mobile" name="mobile" placeholder="">
                        @error('mobile') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="profile_pic" class="form-label">Profile Image</label>
                        <img src="{{asset('storage/'.$user->profile_pic)}}" alt="" style="width:50px;height:50px;border-radius:50%;">

                        <input type="file" class="form-control" id="profile_pic" name="profile_pic" >
                        @error('profile_pic') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" value="{{old('password')}}" class="form-control" id="password" name="password">
                        @error('password') <small class="text-danger">{{$message}}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection