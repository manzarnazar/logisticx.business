@extends('backend.partials.master')
@section('title')
    {{ ___('hub.incharge') }} {{ ___('label.add') }}
@endsection
@section('maincontent')
    <div class="container-fluid  dashboard-content">
        <!-- pageheader -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"
                                        class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('hubs.index') }}"
                                        class="breadcrumb-link">{{ ___('hub.hubs') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('hub-incharge.index', $hub->id) }}"
                                        class="breadcrumb-link">{{ ___('hub.incharge') }}</a></li>
                                <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- end pageheader -->
        <div class="row">
            <!-- basic form -->
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">

                        <div class="form-input-header">
                            <h4 class="title-site"> {{ ___('label.create') }} {{ $hub->name }} {{ ___('hub.incharge') }} </h4>
                        </div>

                        <form action="{{ route('hub-incharge.store', $hub->id) }}" method="POST" enctype="multipart/form-data" id="basicform">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="label-style-1" for="user_id">{{ ___('label.user') }}</label>
                                    <select name="user_id" class="form-control input-style-1 select2">
                                        @if (!blank($users))
                                            @foreach ($users as $key => $user)
                                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ( {{ $user->mobile }})</option>
                                            @endforeach
                                        @else
                                            <option value="">{{ ___('-- Select User --') }}</option>
                                        @endif
                                    </select>
                                    @error('user_id')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="label-style-1" for="status">{{ ___('label.status') }}</label>
                                    <select name="status" class="form-control input-style-1 select2">
                                        @foreach (config('site.status.default') as $key => $status)
                                            <option value="{{ $key }}"
                                                {{ old('status', \App\Enums\Status::ACTIVE) == $key ? 'selected' : '' }}>
                                                {{ ___('common.' . $status) }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="j-create-btns">
                                <div class="drp-btns">
                                    <button type="submit" class="j-td-btn"><i
                                            class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                    <a href="{{ route('hub-incharge.index', $hub->id) }}" class="j-td-btn btn-red"> <i
                                            class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- end basic form -->
        </div>
    </div>
@endsection()
