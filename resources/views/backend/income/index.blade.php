@extends('backend.partials.master')
@section('title')
{{ ___('account.income') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('account.accounts') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('account.income') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('income.filter') }}" method="GET">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="label-style-1" for="account_ids">{{ ___('label.to_account') }}</label>
                                <select id="account_ids" name="account_id" class="form-control input-style-1 select2">
                                    <option selected disabled> {{ ___('placeholder.select_account') }}</option>
                                    @foreach ($accounts as $account)
                                    @if ($account->type == App\Enums\AccountType::ADMIN)
                                    <option {{ old('account_id', @$request->account_id) == $account->id ? 'selected' : '' }} value="{{ $account->id }}">
                                        @if ($account->gateway == App\Enums\FixedAccountHeads::ReceiveFromMerchant)
                                        {{ $account->user->name }} (Cash)
                                        @else
                                        @if ($account->gateway == 3)
                                        bKash ,
                                        @elseif ($account->gateway == 4)
                                        Rocket ,
                                        @elseif ($account->gateway == 5)
                                        Nagad ,
                                        @endif
                                        {{ $account->account_holder_name }}
                                        ({{ $account->account_no }}
                                        {{ $account->branch_name }}
                                        {{ $account->mobile }})
                                        @endif
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class=" label-style-1" for="date">{{ ___('label.date') }}</label>
                                <input type="date" id="date" name="date" data-parsley-trigger="change" placeholder= "{{___('placeholder.enter_date_range')}}" class="form-control input-style-1 flatpickr-range" value="{{ old('date', @$request->date) }}">
                                @error('date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-4 ">
                                <label class="label-style-1" for="account_head_id">{{ ___('label.account_heads') }}</label>
                                <select id="account_head_id" name="account_head_id" class="form-control input-style-1 select2" data-account-balance-url="{{ route('accounts.current-balance') }}">
                                    <option value="0" selected disabled>{{ ___('menus.select') }} {{ ___('label.account_heads') }}</option>
                                    @foreach ($accountHeads as $head)
                                    <option value="{{ $head->id }}" @selected((old('account_head_id',$request->account_head_id)==$head->id) ) > {{ $head->name }} </option>
                                    @endforeach
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="account_head_id"></small>
                            </div>

                            <div class=" mt-2 col-md-4 d-flex align-items-end p-1">
                                <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i>
                                <span>{{ ___('label.filter') }}</span></button>
                                <a href="{{ route('income.index') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i>
                                <span>{{ ___('label.clear') }}</span></a>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('account.income') }}  {{ ___('label.list') }}</h4>
                    @if (hasPermission('income_create'))
                    <a href="{{ route('income.create') }}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span> </a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table    ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.account_head') }}</th>
                                    <th>{{ ___('label.from') }}</th>
                                    <th>{{ ___('label.to_account') }}</th>
                                    <th>{{ ___('label.amount') }}</th>
                                    <th>{{ ___('label.date') }}</th>
                                    <th>{{ ___('label.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($incomes as $key => $income)
                                <tr id="row_{{ $income->id }}">
                                    <td>{{ ++$key }}</td>
                                    <td> @if(@$income->accountHead->name) {{ @$income->accountHead->name }} @endif </td>
                                    <td>
                                        @if(@$income->title) {{ @$income->title }} @endif

                                        @if(@$income->delivery_man_id) {{ @$income->deliveryman->user->name }} @endif

                                        @if(@$income->merchant_id) <div>{{ 'Merchant: ' . @$income->merchant->business_name }}</div> @endif

                                        @if(@$income->account_head_id == \App\Enums\FixedAccountHeads::ReceiveFromHub)
                                        <div>{{ 'Hub: ' . @$income->hub->name }}</div>
                                        <div>{{ 'Account Name: ' . @$income->hubAccount->account_holder_name }}</div>
                                        <div>{{ 'Account Number: ' . @$income->hubAccount->account_no }}</div>
                                        @endif
                                    </td>

                                    <td>
                                        @if(@$income->account->account_holder_name) <div>{{ 'Name: ' . @$income->account->account_holder_name }}</div> @endif
                                        @if(@$income->account->account_no) <div>{{ 'Number: ' . @$income->account->account_no }}</div> @endif
                                        @if(@$income->account->branch_name) <div>{{ 'Branch: ' . @$income->account->branch_name }}</div> @endif
                                        @if(@$income->account->mobile) <div>{{ 'Mobile: ' . @$income->account->mobile }}</div> @endif
                                    </td>

                                    <td>
                                        <p> {{ @settings('currency') }}{{ $income->amount }}</p>
                                        @if($income->receipt !==null) <a href="{{asset($income->upload->original) }}" download="receipt"> <i class="fa-solid fa-cloud-arrow-down"></i> {{ ___('label.download_receipt') }}</a> @endif
                                    </td>

                                    <td> {{ dateTimeFormat($income->date) }} </td>

                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>
                                        <div class="dropdown-menu">

                                            <a href="{{ route('income.view', $income->id) }}" class="dropdown-item"><i class="fa fa-eye" aria-hidden="true"></i> {{ ___('label.view') }}</a>

                                            @if (hasPermission('income_update') )
                                            <a href="{{ route('income.edit', $income->id) }}" class="dropdown-item"><i class="fa fa-edit"></i> {{ ___('label.edit') }}</a>
                                            @endif

                                            @if (hasPermission('income_delete') )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/income/delete', {{ $income->id }})"> <i class="fa fa-trash"></i> {{ ___('label.delete') }} </a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="7" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- pagination component -->
                    @if (count($incomes))
                    <x-paginate-show :items="$incomes" />
                    @endif
                    <!-- end pagination component -->
                </div>
            </div>
        </div>
        <!-- end table  -->
    </div>
</div>
<!-- end wrapper  -->

@endsection

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
