@extends('layouts.admin')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                    href="{{ route('admin.users.index') }}">Users</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Create User</li>
        </ol>
        <h5 class="font-weight-bolder mb-0">Script Management</h5>
    </nav>
@stop

@section('content')

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">Add Script</h5>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('admin.script.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="domain" class="form-control-label">Domain</label>
                                <div class="@error('domain')border border-danger rounded-3 @enderror">
                                    <select class="form-control" id="domain" name="domain">
                                        <option value="" selected>Select Domain</option>
                                        <option value="abdullahportfolio.com"
                                            {{ old('domain') == 'abdullahportfolio.com' ? 'selected' : '' }}>
                                            abdullahportfolio.com</option>
                                    </select>
                                    @error('domain')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cart_addon" class="form-control-label">Cart Addon</label>
                                <div class="@error('cart_addon')border border-danger rounded-3 @enderror">
                                    <select class="form-control" id="cart_addon" name="cart_addon">
                                        <option value="" selected>Select Cart Addon</option>
                                        <option value="1" {{ old('cart_addon') == 1 ? 'selected' : '' }}>Home Page
                                            Redirection All Brands (False)</option>
                                        <option value="2" {{ old('cart_addon') == 2 ? 'selected' : '' }}>iframe
                                        </option>
                                        <option value="3" {{ old('cart_addon') == 3 ? 'selected' : '' }}>Direct UTM
                                            Link SP</option>
                                        <option value="4" {{ old('cart_addon') == 4 ? 'selected' : '' }}>Wordpress
                                            Cookie Stuffing</option>
                                        <option value="5" {{ old('cart_addon') == 5 ? 'selected' : '' }}>Add To Cart -
                                            Cookie Stuffing (SP)</option>
                                    </select>
                                    @error('cart_addon')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Name, Host, Tracking Time -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-validation">
                                <label for="user-name" class="form-control-label">Name</label>
                                <div class="@error('user.name')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" placeholder="Name" id="user-name"
                                        name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="host" class="form-control-label">Host (without Https Only Fill Domain
                                    Name)</label>
                                <div class="@error('host')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" placeholder="www.fastrackeyewear.com"
                                        id="host" name="host" value="{{ old('host') }}">
                                    @error('host')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tracking_time" class="form-control-label">Tracking Time</label>
                                <div class="@error('tracking_time')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" placeholder="10" id="tracking_time"
                                        name="tracking_time" value="{{ old('tracking_time') }}">
                                    @error('tracking_time')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daily Limit Convert Click, Device Type, Daily Limit Convert Click -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-validation">
                                <label for="convert-click" class="form-control-label">Daily Limit Convert Click</label>
                                <div class="@error('convert_click')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" placeholder="100" id="convert-click"
                                        name="convert_click" value="{{ old('convert_click') }}">
                                    @error('convert_click')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="device-type" class="form-control-label">Device Type</label>
                                <div class="@error('device_type')border border-danger rounded-3 @enderror">
                                    <select class="form-control select2" id="device-type" name="device_type[]" multiple>
                                        <option value="Mobile"
                                            {{ in_array('Mobile', old('device_type', [])) ? 'selected' : '' }}>Mobile
                                        </option>
                                        <option value="Tablet"
                                            {{ in_array('Tablet', old('device_type', [])) ? 'selected' : '' }}>Tablet
                                        </option>
                                        <option value="Desktop"
                                            {{ in_array('Desktop', old('device_type', [])) ? 'selected' : '' }}>Desktop
                                        </option>
                                    </select>

                                    @error('device_type')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="social_media" class="form-control-label">Social Media Exclude</label>
                                <div class="@error('social_media')border border-danger rounded-3 @enderror">
                                    <select class="form-control select2" id="social_media" name="social_media[]"
                                        multiple>
                                        <option value="Facebook"
                                            {{ in_array('Facebook', old('social_media', [])) ? 'selected' : '' }}>Facebook
                                        </option>
                                        <option value="Instagram"
                                            {{ in_array('Instagram', old('social_media', [])) ? 'selected' : '' }}>
                                            Instagram</option>
                                        <option value="Twitter"
                                            {{ in_array('Twitter', old('social_media', [])) ? 'selected' : '' }}>Twitter
                                        </option>
                                        <option value="LinkedIn"
                                            {{ in_array('LinkedIn', old('social_media', [])) ? 'selected' : '' }}>LinkedIn
                                        </option>
                                    </select>
                                    @error('social_media')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group has-validation">
                                <label for="tracking-one-url" class="form-control-label">Tracking Url 1 (Aff
                                    Link)</label>
                                <div class="@error('tracking_one_url')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" id="tracking-one-url"
                                        name="tracking_one_url" value="{{ old('tracking_one_url') }}">
                                    @error('tracking_one_url')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-validation">
                                <label for="main_domain" class="form-control-label">Main Domain Only For
                                    Elexkerwalker</label>
                                <div class="@error('main_domain')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" id="main_domain" name="main_domain"
                                        value="{{ old('main_domain') }}">
                                    @error('main_domain')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="off_location" class="form-control-label">Is Off Location</label>
                                <div class="@error('off_location')border border-danger rounded-3 @enderror">
                                    <select class="form-control" id="off_location" name="off_location">
                                        <option value="" hidden selected>Select Off Location</option>
                                        <option value="1" {{ old('off_location') == 1 ? 'selected' : '' }}>True
                                        </option>
                                        <option value="0" {{ old('off_location') == 0 ? 'selected' : '' }}>False
                                        </option>
                                    </select>
                                    @error('off_location')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country" class="form-control-label">Country</label>
                                <div class="@error('country')border border-danger rounded-3 @enderror">
                                    <select class="form-control select2" id="country" name="country[]" multiple>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ in_array($country->id, old('country', [])) ? 'selected' : '' }}>
                                                {{ $country->iso3 }} - {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">Save Script</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@stop
