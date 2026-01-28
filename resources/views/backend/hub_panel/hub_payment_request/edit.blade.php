@extends('backend.partials.master')
@section('title')
{{ ___('account.hub_payment_request') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href=" " class="breadcrumb-link">{{ ___('hub.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
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
                        <h4 class="title-site">{{ ___('label.edit') }} {{ ___('account.submit_request') }}</h4>
                    </div>

                    <form action="{{route('hub-panel.payment-request.update')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{$singlePayment->id}}">

                        <div class="row">

                            <div class="form-group col-md-12">
                                <label class="label-style-1" for="hub_account_id">{{ ___('label.hub_account') }} <span class="text-danger">*</span> </label>
                                <select id="hub_account_id" name="hub_account_id" class="form-control input-style-1 select2" data-url="{{ route('accounts.searchByHub') }}">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.hub_account') }} </option>
                                    @foreach (auth()->user()->hub->accounts as $account)
                                    <option value="{{ $account->id }}" @selected(old('hub_account_id',$singlePayment->hub_account_id)==$account->id)>{{ @$account->text }}</option>
                                    @endforeach
                                </select>
                                @error('hub_account_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-12">
                                <label class=" label-style-1" for="amount">{{ ___('hub.amount') }}<span class="text-danger">*</span> </label>
                                <input id="amount" type="number" step="any" name="amount" placeholder="{{___('placeholder.amount')}}" class="form-control input-style-1" value="{{old('amount',$singlePayment->amount)}}" require>
                                @error('amount') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12">
                                <label class=" label-style-1" for="description">{{ ___('hub.description') }}<span class="text-danger">*</span> </label>
                                <textarea name="description" class="form-control input-style-1" placeholder="{{___('placeholder.enter_description')}}" require>{{ old('description',$singlePayment->description) }}</textarea>
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                                <a href="{{ route('hub-panel.payment-request.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
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
