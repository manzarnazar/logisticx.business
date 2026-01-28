@extends('backend.partials.master')

@section('title')
{{ ___('label.attendance') }} {{ ___('label.update') }}
@endsection

@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.attendance') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active"> {{ ___('label.update') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <div class="form-inputs">

            <div class="form-input-header">
                <h4 class="title-site"> {{ ___('label.update') }} {{ ___('label.attendance') }} </h4>
            </div>

            <form action="{{ route('attendance.update') }}" method="post">
                @csrf
                @method('put')

                <input type="hidden" name="id" value="{{ @$attendance->id }}">

                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label class="label-style-1" for="user">{{ ___('label.user') }}</label>
                        <input type="text" class="form-control input-style-1" id="user" value="{{ @$attendance->user->name }}" @disabled(true)>
                        <input type="hidden" name="user_id" value="{{ @$attendance->user_id }}">
                        @error('user_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="label-style-1" for="date">{{ ___('label.date') }}</label>
                        <input type="date" id="date" name="date" placeholder="Enter Date range" class="form-control input-style-1 flatpickr" value="{{ old('date',  @$attendance->date) }}">
                        @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="label-style-1" for="date">{{ ___('label.check_in') }}</label>
                        <input type="time" class="form-control input-style-1" name="check_in" value="{{ old('check_in', @$attendance->check_in) }}" placeholder="00:00">
                        @error('check_in') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="label-style-1" for="date">{{ ___('label.check_out') }}</label>
                        <input type="time" class="form-control input-style-1" name="check_out" value="{{ old('check_out',@$attendance->check_out)  }}" placeholder="00:00">
                        @error('check_out') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="label-style-1" for="date">{{ ___('label.type') }}</label>
                        <select name="type" class="form-control input-style-1 select2" required>
                            @foreach(config('attendance.type') as $typeKey => $option)
                            <option value="{{ $typeKey }}" @selected( old('type', @$attendance->type )== $typeKey) >{{ ___('label.'.$option) }}</option>
                            @endforeach
                        </select>
                        @error('type') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="label-style-1" for="note">{{ ___('label.note') }}</label>
                        <textarea name="note" id="note" class="form-control input-style-1" placeholder="{{ ___('placeholder.note')}}">{{ old('note',@$attendance->note) }}</textarea>
                        @error('note') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div class="j-create-btns">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i> <span>{{ ___('label.update') }}</span></button>
                        <a href="{{ route('attendance.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark"></i> <span>{{ ___('label.cancel') }} </span></a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
