@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('content')
    <div class="card px-3 py-3">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <div class="card-title">
                    <h6 class="text-white text-capitalize ps-3">User</h6>
                </div>
            </div>
        </div>

        <div class="card-body px-0 pb-2">
            <form method="post"
                action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                autocomplete="off" enctype="multipart/form-data">
                @if (isset($user))
                    <input type="hidden" name="_method" value="PUT" />
                @endif
                @csrf
                <input type="hidden" name="user_id" value="{{ @$user->id }}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name" class="bmd-label-floating">Name</label>
                            <input type="text" class="form-control border" id="text" value="{{ @$user->name }}"
                                name="name" required>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control border" id="email" value="{{ @$user->email }}"
                                name="email" required>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="email">Password</label>
                            <input type="text" class="form-control border" id="password" value=""
                                name="password" {{ (isset($user)) ? "" : "required" }}>
                            @isset($user)
                                <small>Leave it blank if you are not going to change the password.</small>
                            @endisset
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" class="form-control border" required>
                                <option value="">Select</option>
                                <option value="1">Admin</option>
                                <option value="2">Manager</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <a href="{{ url("users") }}" class="btn btn-dark w-100"><i class="fa-solid fa-delete-left"></i> Cancel</a>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <button type="submit" class="btn btn-primary float-end w-100"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@pushOnce('scripts')
@endPushOnce
