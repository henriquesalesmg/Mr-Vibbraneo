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
                <h6 class="text-white text-capitalize ps-3">List</h6>
            </div>
        </div>
    </div>

    <div class="card-body px-0 pb-2">
        <form method="post" action="{{ isset($task) ? route('lists.update', $task->id) : route('lists.store') }}"
            autocomplete="off" enctype="multipart/form-data">
            @if (isset($task))
                <input type="hidden" name="_method" value="PUT" />
            @endif
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="title" class="bmd-label-floating">Title</label>
                        <input type="text" class="form-control border" id="text" value="{{ @$task->title }}"
                            name="title" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="contributors" class="bmd-label-floating">Contributors</label>
                        <select name="contributors[]" id="edit-states1-id" class="test" multiple="multiple"
                            style="display: none;">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    @isset($task) {!! \App\Http\Classes\TaskUsers::selected($task, $user->id) !!} @endisset>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="status" class="bmd-label-floating">Status</label>
                        <select name="status" class="form-control border" required>
                            <option value="0" {{ (@$task->status == 0) ? "selected" : ""; }} >Created</option>
                            <option value="1" {{ (@$task->status == 1) ? "selected" : ""; }} >Started</option>
                            <option value="2" {{ (@$task->status == 2) ? "selected" : ""; }} >In production</option>
                            <option value="3" {{ (@$task->status == 3) ? "selected" : ""; }} >Done</option>
                            <option value="4" {{ (@$task->status == 4) ? "selected" : ""; }} >Incomplete</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" rows="5" name="description" required>{{ @$task->description }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <a href="{{ url('lists') }}" class="btn btn-dark w-100"><i
                                class="fa-solid fa-delete-left"></i> Cancel</a>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <button type="submit" class="btn btn-primary float-end w-100"><i
                                class="fa-solid fa-floppy-disk"></i> Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@pushOnce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/js/BsMultiSelect.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
        var $multiSelects = $("select[multiple='multiple']");

        function install() {
            $multiSelects.bsMultiSelect();
        }
        install();
    </script>
@endPushOnce
