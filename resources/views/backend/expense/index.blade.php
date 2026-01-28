@extends('backend.partials.master')
@section('title')
{{ ___('account.expense') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('account.accounts') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('account.expense') }}</a></li>
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
                    <form action="{{route('expense.filter')}}" method="GET">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-12 col-md-4">
                                <label class=" label-style-1" for="date">{{ ___('label.date')}}</label>
                                <input type="text" id="date" name="date" data-parsley-trigger="change" placeholder= "{{___('placeholder.enter_date_range')}}" class="form-control input-style-1 flatpickr-range" value="{{old('date',$request->date)}}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="account_ids">{{ ___('label.to_account')}}</label>
                                <select id="account_ids" name="account_id" class="form-control input-style-1 select2">
                                    <option selected disabled> {{ ___('placeholder.select_account') }}</option>
                                    @foreach($accounts as $account)
                                    @if ($account->type == App\Enums\AccountType::ADMIN)

                                    <option {{ (old('account_id',$request->account_id) == $account->id) ? 'selected' : '' }} value="{{ $account->id }}">
                                        @if($account->gateway == 1)
                                        {{$account->user->name}} (Cash)
                                        @else
                                        @if($account->gateway == 3)
                                        bKash ,
                                        @elseif ($account->gateway == 4)
                                        Rocket ,
                                        @elseif ($account->gateway == 5)
                                        Nagad ,
                                        @endif
                                        {{$account->account_holder_name}}
                                        ({{$account->account_no}}
                                        {{$account->branch_name}}
                                        {{$account->mobile}})
                                        @endif
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
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

                            <div class="form-group col-md-4 d-flex align-items-end p-1">
                                <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                <a href="{{ route('expense.index') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="card">


                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('account.expense') }} {{ ___('label.list') }}</h4>
                    @if(hasPermission('expense_create') )
                    <a href="{{route('expense.create')}}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span> </a>
                    @endif
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.account_head') }}</th>
                                    <th>{{ ___('label.from_account')}}</th>
                                    <th>{{ ___('label.beneficiary')}}</th>
                                    <th>{{ ___('label.amount')}}</th>
                                    <th>{{ ___('label.date')}}</th>
                                    <th>{{ ___('label.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($expenses as $expense)
                                <tr id="row_{{ $expense->id }}">
                                    <td>{{$expense->id}}</td>
                                    <td> {{ @$expense->accountHead->name }} </td>

                                    <td>
                                        @if(@$expense->account->account_holder_name) <div>{{ 'Name: ' . @$expense->account->account_holder_name }}</div> @endif
                                        @if(@$expense->account->account_no) <div>{{ 'Number: ' . @$expense->account->account_no }}</div> @endif
                                        @if(@$expense->account->branch_name) <div>{{ 'Branch: ' . @$expense->account->branch_name }}</div> @endif
                                        @if(@$expense->account->mobile) <div>{{ 'Mobile: ' . @$expense->account->mobile }}</div> @endif
                                    </td>

                                    <td>
                                        @if(@$expense->title) {{ @$expense->title }} @endif

                                        @if(@$expense->delivery_man_id) {{ @$expense->deliveryman->user->name }} @endif

                                        @if(@$expense->hub_id) <div>{{ 'Hub: ' . @$expense->hub->name }}</div> @endif
                                        @if(@$expense->hubAccount->account_holder_name) <div>{{ 'Account Name: ' . @$expense->hubAccount->account_holder_name }}</div> @endif
                                        @if(@$expense->hubAccount->account_no) <div>{{ 'Account Number: ' . @$expense->hubAccount->account_no }}</div> @endif
                                    </td>

                                    <td>
                                        <p> {{ @settings('currency') }}{{ $expense->amount }}</p>
                                        @if($expense->receipt !==null) <a href="{{asset($expense->upload->original) }}" download="receipt"> <i class="fa-solid fa-cloud-arrow-down"></i> {{ ___('label.download_receipt') }}</a> @endif
                                    </td>

                                    <td>{{ dateTimeFormat($expense->date) }}</td>

                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>
                                        <div class="dropdown-menu">

                                            <a href="{{ route('expense.view', $expense->id) }}" class="dropdown-item"><i class="fa fa-eye" aria-hidden="true"></i> {{ ___('label.view') }}</a>

                                            @if(hasPermission('expense_update') )
                                            <a href="{{route('expense.edit',$expense->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif
                                            @if(hasPermission('expense_delete') )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/expense/delete', {{$expense->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="7" />
                                @endforelse
                            </tbody>
                        </table>

                        <!-- pagination component -->
                        @if(count($expenses))
                        <x-paginate-show :items="$expenses" />
                        @endif
                        <!-- end pagination component -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end table  -->
</div>

<!-- end wrapper  -->
@endsection
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
