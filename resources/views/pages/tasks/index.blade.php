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
                        <h6 class="text-white text-capitalize ps-3">Lists</h6>
                    </div>
                    <a href="{{ route("lists.create") }}" class="btn btn-success float-end mt-2 w-25"><i class="fa-solid fa-plus"></i> Create</a>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-4">
                        <table class="table align-items-center mb-0 table-striped " id="tasks-table">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">List
                                    </th>
                                    <th
                                        class="text-uppercase text-center  text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Description</th>
                                    <th
                                        class="text-center text-center  text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Contributors</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Manager</th>
                                    <th class="text-secondary opacity-7">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">List
                                    </th>
                                    <th
                                        class="text-uppercase text-center  text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Description</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Contributors</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Manager</th>
                                    <th class="text-secondary opacity-7">#</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($tasks as $task)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $task->title }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="font-weight-bold mb-0">
                                                <a style="cursor: pointer" data-bs-toggle="modal"
                                                    data-bs-target="#description{{ $task->id }}">To view</a>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="font-weight-bold mb-0">
                                                <a style="cursor: pointer" data-bs-toggle="modal"
                                                    data-bs-target="#users{{ $task->id }}">To view</a>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if(\App\Http\Classes\TaskUsers::contributor($task) || (Auth::user()->hasRole('admin')) || (Auth::user()->id == $task->manager_id))
                                            <select onchange="document.location.href = 'status?values=' +this.value+'/{{ $task->id }}'"
                                                name="status" id="status" class="form-control border px-2" style="cursor: pointer">
                                                <option value="0" {{ (@$task->status == 0) ? "selected" : ""; }} >Created</option>
                                                <option value="1" {{ (@$task->status == 1) ? "selected" : ""; }} >Started</option>
                                                <option value="2" {{ (@$task->status == 2) ? "selected" : ""; }} >In production</option>
                                                <option value="3" {{ (@$task->status == 3) ? "selected" : ""; }} >Done</option>
                                                <option value="4" {{ (@$task->status == 4) ? "selected" : ""; }} >Incomplete</option>
                                            </select>
                                            @else
                                            {{ \App\Http\Classes\Status::status($task->status) }}
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ \App\Models\User::find($task->manager_id)->name }}
                                        </td>
                                        <td class="align-middle">
                                            <div class="dropdown">
                                                @if(\App\Http\Classes\TaskUsers::contributor($task) || (Auth::user()->hasRole('admin')) || (Auth::user()->id == $task->manager_id))
                                                <a href="#" class="dropdown-toggle " data-bs-toggle="dropdown"
                                                    id="navbarDropdownMenuLink2">
                                                    Options
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('lists.edit', $task->id) }}">
                                                            <i class="fa-solid fa-pen-to-square"></i> Change
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ url('sublists', $task->id) }}">
                                                            <i class="fa-solid fa-list"></i> Sublists
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ url('sublists-create', $task->id) }}">
                                                            <i class="fa-solid fa-plus"></i> Add Sublist
                                                        </a>
                                                    </li>
                                                    @if(Auth::user()->id == $task->manager_id)
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick='askDeleteTask({{ $task->id }})'>
                                                            <i class="fa-solid fa-trash-can"></i> Delete
                                                        </a>
                                                        <form method="post" id="formdelete-{{ $task->id }}"
                                                            action="{{ route('lists.destroy', ['list' => $task]) }}">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                    </li>
                                                    @endif
                                                </ul>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal Description-->
                                    <div class="modal fade" id="description{{ $task->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="description{{ $task->id }}Label"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title font-weight-normal"
                                                        id="description{{ $task->id }}Label">Description</h5>
                                                    <button type="button" class="btn-close text-dark"
                                                        data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {!! $task->description !!}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-gradient-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal-->
                                    <!-- Modal Contributors-->
                                    <div class="modal fade" id="users{{ $task->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="description{{ $task->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title font-weight-normal"
                                                        id="users{{ $task->id }}Label">Contributors</h5>
                                                    <button type="button" class="btn-close text-dark"
                                                        data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @for ($i = 0;
                                                                    $i <
                                                                    count(
                                                                        App\Models\User::find(
                                                                            $task->users()->get()->pluck('id'),
                                                                        ),
                                                                    );
                                                                    $i++)
                                                        <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                            {{ App\Models\User::find($task->users()->get()->pluck('id'))[$i]->name }}
                                                        </h6>
                                                    @endfor
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-gradient-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal-->
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
                'Deleting this list will also delete all sublists associated with it. Confirm the operation?');

            if (answer) {
                $("#formdelete-" + id).submit();
            }
        }
    </script>
@endPushOnce
