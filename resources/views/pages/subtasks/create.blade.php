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
                    <h6 class="text-white text-capitalize ps-3">Sub-List</h6>
                </div>
            </div>
        </div>

        <div class="card-body px-0 pb-2">
            <form method="post"
                action="{{ isset($subtask) ? route('sublist.update', $subtask->id) : route('sublist.store') }}"
                autocomplete="off" enctype="multipart/form-data">
                @if (isset($subtask))
                    <input type="hidden" name="_method" value="PUT" />
                @endif
                @csrf
                <input type="hidden" name="task_id" value="{{ $task->id }}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="title" class="bmd-label-floating">Title</label>
                            <input type="text" class="form-control border" id="text" value="{{ @$subtask->title }}"
                                name="title" required>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 mb-3">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" rows="5" name="description" required>{{ @$subtask->description }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <a href="{{ url("sublists", $task->id) }}" class="btn btn-dark w-100"><i class="fa-solid fa-delete-left"></i> Cancel</a>
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
