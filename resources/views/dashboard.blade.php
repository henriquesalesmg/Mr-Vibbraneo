@extends('layouts.admin')


@section('styles')
@endsection

@section('content')
    <div class="card card-body mx-3 mx-md-4 mb-4">
        <div class="row gx-4 mb-2">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="{{ asset('assets/img/persona.png') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        {{ Auth::user()->name }}
                    </h5>
                    <p class="mb-0 font-weight-normal text-sm">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-12 col-xl-8">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <h6 class="mb-0">You are on Mr. Vibbraneo!</h6>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder">Start</h6>
                            <ul class="list-group">
                                <li class="list-group-item border-0 px-0">
                                    <div class="text-body ms-3 w-80 mb-0 border-bottom py-3">For usage instructions, <a href="{{ url("about") }}">click here</a> and access the tutorial.</div>
                                </li>
                                <li class="list-group-item border-0 px-0">
                                    <div class="text-body ms-3 w-80 mb-0 border-bottom py-3">If you already know how to use the system, access the listings and do the tasks according to your plan.</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <h6 class="mb-0">Tasks</h6>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-group">
                                <li class="list-group-item mb-2">
                                    <div class="">
                                        <div class="card-header p-3 pt-2">
                                            <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                                <i class="fa-solid fa-list-check"></i>
                                            </div>
                                            <div class="text-end pt-1">
                                                <p class="text-sm mb-0 text-capitalize">Total Lists</p>
                                                <h4 class="mb-0">{{ count($tasks) }}</h4>
                                            </div>
                                        </div>
                                        <hr class="dark horizontal my-0">
                                        <div class="card-footer p-3">
                                            <p class="mb-0"><span class="text-success font-weight-bolder">{{ count($tasks_user) }} created by you</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
