@extends('layouts.app')

@section('content')
    <div class="container mt-3">


        <div class="card">
            <div class="card-body text-center">
                <h4>User list</h4>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>


            @if ($users->count() > 0)
                <table class="table">
                    <thead>
                        <tr class="table-primary">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $user->image) }}" width="50px" height="60px"
                                        alt="">
                                </td>
                                <td>

                                    <div class="mb-2">
                                        <form action="{{ route('users.delete', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning tabindex='0'">Disable</button>
                                        </form>
                                    </div>

                                    <div>
                                        <form action="{{ route('users.delete', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger tabindex='0'">Remove</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @else
                <div class="text-center">
                    <h3>No data found</h3>
                </div>
            @endif
        </div>
        <div class="d-flex justify-content-end mt-2">
            {{ $users->links() }}
        </div>

    </div>
@endsection
