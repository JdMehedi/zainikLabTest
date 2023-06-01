<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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
                                                    <img src="{{ asset('storage/' . $user->image) }}" width="50px"
                                                        height="60px" alt="">
                                                </td>
                                                <td>

                                                    <div class="mb-2">
                                                        <form action="{{ route('users.update', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')

                                                            <button type="submit"
                                                                class="btn bg-primary">{{$user->status == true ? __('Disable'):__('Enable')}}</button>
                                                        </form>
                                                    </div>


                                                    <div>
                                                        <form action="{{ route('users.delete', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn bg-danger">Remove</button>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
