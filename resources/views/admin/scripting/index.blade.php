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
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Phone</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Role</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Since</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <!-- If User as Image it show up if not then a random picture will be displayed -->
                                                <img src="https://i.pravatar.cc/?img=2" class="avatar avatar-sm me-3"
                                                    alt="avatar">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Dashui</h6>
                                                <p class="text-xs text-secondary mb-0">Manager DashUI</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">manager@dashui.dev</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">+91 9090898978</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">Manager</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">ACTIVE</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">14-09-2025</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="#" class="mx-3" data-bs-toggle="tooltip"
                                            data-bs-original-title="Edit user">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>

                                        <button class="cursor-pointer fas fa-trash text-secondary"
                                            style="border: none; background: no-repeat;" data-bs-toggle="tooltip"
                                            data-bs-original-title="Delete User">
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
