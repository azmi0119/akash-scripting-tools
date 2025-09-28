@extends('layouts.admin')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Scripts</li>
        </ol>
        <h5 class="font-weight-bolder mb-0">Script Management</h5>
    </nav>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6>All Scripts</h6>
                            </h6>
                        </div>
                        <div class="col-6 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{ route('admin.script.create') }}"><i
                                    class="fas fa-plus"></i>&nbsp;&nbsp;Add Script</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-3 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead style="background-color: #f3f2f7;">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Domain
                                        Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Host</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Daily Convert Click</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Create At</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($scripts->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">No scripts found.</span>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($scripts as $script)
                                        <tr>
                                            <td>
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $script->domain }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $script->name }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $script->host }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $script->convert_click }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $script->created_at->format('d-m-Y') }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('admin.script.edit', $script->id) }}" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Edit script">
                                                    <i class="fas fa-user-edit text-secondary"></i>
                                                </a>

                                                <form action="{{ route('admin.script.destroy', $script->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="cursor-pointer fas fa-trash text-secondary"
                                                        style="border: none; background: no-repeat;"
                                                        data-bs-toggle="tooltip" data-bs-original-title="Delete Script"
                                                        onclick="return confirm('Are you sure you want to delete this script?');">
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
