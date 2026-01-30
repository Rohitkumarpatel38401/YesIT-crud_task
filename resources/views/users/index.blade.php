@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h1>All Users</h1>
                <div>
                    <a href="{{ route('users.export') }}" class="btn btn-dark">Export User</a>
                    <a href="{{route('users.create')}}" class="btn btn-primary">Add New User</a>
                </div>   
            </div>   
                  
        </div>
        <div class="card-body">
        <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Photo</th>
                <th scope="col">Name</th>
                <th scope="col">Mobile</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
            @forelse($users as $user)
                <tr>
                    <th scope="row">1</th>
                    <td>
                        @if($user->profile_pic)
                            <img src="{{asset('storage/'.$user->profile_pic)}}" style="width:40px; height:40px;" alt="profile Image">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->mobile}}</td>
                    <td>{{$user->email}}</td>
                    <td class="d-flex gap-2">
                        <a href="{{route('users.edit',$user->id)}}" class="btn btn-primary">Edit</a>
                     
                        <form action="{{route('users.destroy',$user->id)}}" method="POST" class="delete-user-form">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger delete-btn">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        No User Found.
                    </td>
                </tr>
            @endforelse
            
        </tbody>
        </table>
        </div>
    </div>

    <script>
        documnet.querySelectorAll('.delete-btn').foreach(button=>{
            button.addEventListener('click',function(e){
                const form = this.closest('.delete-user-form');
                Swal.fire({
                    title: "Are You Sure?",
                    text:"This user will be permanently Deleted!",
                    icon: 'warning',
                    showCancelButton:true,
                    confirmButtonColor: '#4f46e5',
                    confirmButtonText: "Yes Delete it"
                    cancelButtonText: 'No, Keep it'
                }).then(($result)=>{
                    if(result.isConfirmed){
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection