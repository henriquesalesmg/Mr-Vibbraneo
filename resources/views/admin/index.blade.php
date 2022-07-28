@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Users</h6>
                    </div>
                    <a href="{{ route("users.create") }}" class="btn btn-success float-end mt-2 w-25"><i class="fa-solid fa-plus"></i> New User</a>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-4">
                        <table class="table align-items-center mb-0 table-striped " id="tasks-table">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                    </th>
                                    <th
                                        class="text-uppercase  text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Email</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Role</th>
                                    <th class="text-secondary opacity-7">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                    </th>
                                    <th
                                        class="text-uppercase  text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Email</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Role</th>
                                    <th class="text-secondary opacity-7">#</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user->email }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-0 text-sm">{{ ($user->isAdmin()) ? "Admin" : "Moderator" }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle " data-bs-toggle="dropdown"
                                                    id="navbarDropdownMenuLink2">
                                                    Options
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('users.edit', $user->id) }}">
                                                            <i class="fa-solid fa-pen-to-square"></i> Change
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick='askDeleteTask({{ $user->id }})'>
                                                            <i class="fa-solid fa-trash-can"></i> Delete
                                                        </a>
                                                        <form method="post" id="formdelete-{{ $user->id }}"
                                                            action="{{ route('users.destroy', ['user' => $user]) }}">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        There are no registered lists.
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@pushOnce('scripts')
    <script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tasks-table').DataTable();
        });

        function askDeleteTask(id) {
            var answer = confirm(
                'Do you really want to delete this user and all associated content?');

            if (answer) {
                $("#formdelete-" + id).submit();
            }
        }
    </script>
@endPushOnce
