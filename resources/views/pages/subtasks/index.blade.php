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
                        <h6 class="text-white text-capitalize ps-3">Sub-Lists</h6>
                    </div>
                    <a href="{{ url("sublists-create", $task->id) }}" class="btn btn-success float-end mt-2 w-25"><i class="fa-solid fa-plus"></i> Create</a>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-4">
                        <table class="table align-items-center mb-0 table-striped " id="tasks-table">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">List
                                    </th>
                                    <th class="text-uppercase text-center  text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Description</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date</th>
                                    <th class="text-secondary opacity-7">#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">List
                                    </th>
                                    <th class="text-uppercase text-center  text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Description</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date</th>
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
                                                <a style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#description{{ $task->id }}">To view</a>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ \Carbon\Carbon::parse($task->created_at)->format('Y/m/d') }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle " data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                                                    Options
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route("sublist.edit", $task->id) }}">
                                                            <i class="fa-solid fa-pen-to-square"></i> Change
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route("sublists-remove", $task->id) }}">
                                                            <i class="fa-solid fa-up-down"></i> Remove from Sub-lists
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick='askDeleteTask({{ $task->id }})'>
                                                            <i class="fa-solid fa-trash-can"></i> Delete
                                                        </a>
                                                        <form method="post" id="formdelete-{{ $task->id }}"
                                                            action="{{ route('sublist.destroy', ['sublist' => $task]) }}">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                              </div>
                                        </td>
                                    </tr>
                                    <!-- Modal Description-->
                                    <div class="modal fade" id="description{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="description{{ $task->id }}Label" aria-hidden="true">
                                      <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title font-weight-normal" id="description{{ $task->id }}Label">Description</h5>
                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                                {!! $task->description !!}
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- End Modal-->
                                @empty
                                    <tr>
                                        There are no registered sub-lists.
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 mt-3">
                        <a href="{{ url("lists") }}" class="btn btn-dark w-25 float-end"><i class="fa-solid fa-delete-left"></i> Return</a>
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
            var answer = confirm('Deleting this list will also delete all sublists associated with it. Confirm the operation?');

            if (answer) {
                $("#formdelete-" + id).submit();
            }
        }
    </script>
@endPushOnce
