@extends('backend.partials.master')

@section('title')
{{ ___('menus.coverage') }} {{ ___('label.create') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('coverage.index')}}" class="breadcrumb-link">{{ ___('menus.coverage') }}</a></li>
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('label.create') }} {{ ___('menus.coverage') }} </h4>
                    </div>

                    <form action="{{route('coverage.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        <div class="form-row">


                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="parent">{{ ___('label.parent') }}</label>
                                <select name="parent" id="parent" class="form-control input-style-1 select2">
                                    <option value="" @selected(true)>{{ ___('label.select') }}</option>

                                    @foreach($coverages as $coverage)

                                    <option value="{{ $coverage->id}}" @selected(old('parent')==$coverage->id)> {{ $coverage->name }}</option>

                                    <x-coverage-child :coverage="$coverage" name="parent" />

                                    @endforeach

                                </select>
                                @error('parent') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>



                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="name">{{ ___('label.name') }}<span class="text-danger">*</span> </label>
                                <input type="text" name="name" id="name" class="form-control input-style-1" value="{{ old('name') }}" placeholder="{{ ___('placeholder.name') }}" autocomplete="off">
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>



                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="position">{{ ___('label.position') }}</label>
                                <input type="number" class="form-control input-style-1" id="position" name="position" value="{{ old('position',0) }}" placeholder="Position" autocomplete="off">
                                @error('position') <span class="text-danger small"> {{$message}}</span> @enderror
                            </div>



                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                                <select name="status" id="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status',\App\Enums\Status::ACTIVE)==$key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>

                        <div class="j-create-btns mt-2">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('coverage.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection()
