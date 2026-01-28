@extends('backend.partials.master')
@section('title')
{{ ___('account.accounts') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{route('accounts.index')}}" class="breadcrumb-link">{{ ___('account.accounts') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- data table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('accounts.filter')}}" method="GET">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12 col-xl-3 col-lg-4 col-md-6">
                                <label class=" label-style-1" for="holder_name">{{ ___('label.holder_name') }}</label>
                                <input type="text" id="holder_name" name="holder_name" placeholder="{{ ___('placeholder.holder_name') }}" class="form-control input-style-1" value="{{old('holder_name', $request->holder_name)}}">
                                @error('holder_name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-xl-3 col-lg-4 col-md-6">
                                <label class=" label-style-1" for="account_no">{{ ___('label.account_no')}}</label> <span class="text-danger"></span>
                                <input type="text" id="account_no" name="account_no" placeholder="{{ ___('placeholder.account_no') }}" class="form-control input-style-1" value="{{old('account_no', $request->account_no)}}">
                                @error('account_no') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-xl-3 col-lg-4 col-md-6">
                                <label class=" label-style-1" for="bank">{{ ___('label.bank') }}<span class="text-danger">*</span> </label>
                                <select name="bank" class="form-control input-style-1 select2">
                                    <option selected disabled> {{ ___('placeholder.select_bank_name') }}</option>
                                    @foreach ($banks as $bank )
                                    <option value="{{ $bank->id}}" @selected(old('bank')==$bank->id)> {{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                                @error('bank') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class=" col-12 col-xl-3 col-lg-4 col-md-6 d-flex align-items-end p-1">
                                <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                <a href="{{ route('accounts.index') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>


            <!-- list show view -->
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('account.accounts') }}</h4>
                    @if(hasPermission('account_create') == true)
                    <a href="{{route('accounts.create')}}" class="j-td-btn">
                        <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                    </a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.gateway') }}</th>
                                    <th>{{ ___('label.user_info') }}</th>
                                    <th>{{ ___('label.account_info') }}</th>
                                    <th>{{ ___('label.balance') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    @if(hasPermission('account_update') == true || hasPermission('account_delete') == true )
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @forelse($accounts as $account)
                                <tr id="row_{{ $account->id }}">
                                    <td>{{$i++}}</td>

                                    <td>
                                        @if($account->gateway == 1)
                                        Cash
                                        @elseif($account->gateway == 2)
                                        Bank
                                        @elseif($account->gateway == 3)
                                        Rocket
                                        @elseif($account->gateway == 4)
                                        bKash
                                        @elseif($account->gateway == 5)
                                        Nagad
                                        @endif
                                    </td>

                                    <!-- Account Info part -->
                                    <td>
                                        @if($account->user)
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="{{ getImage($account->user->upload, 'original','default-image-40x40.png' ) }}" alt="user" class="rounded" width="40" height="40">
                                            </div>
                                            <div class="ml-1">
                                                <strong>{{@$account->user->name}}</strong>
                                                <div>{{@$account->user->email}}</div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>

                                    <td>

                                        @if($account->account_holder_name != null)
                                        <div class="d-flex gap-3">
                                            <span>{{ ___('label.name') }}:</span>
                                            <span>{{ $account->account_holder_name }}</span>
                                        </div>
                                        @endif

                                        @if($account->account_no != null)
                                        <div class="d-flex gap-3">
                                            <span>{{ ___('label.number') }}:</span>
                                            <span>{{ $account->account_no }}</span>
                                        </div>
                                        @endif
                                        @if($account->bank != null)
                                        <div class="d-flex gap-3">
                                            <span>{{ ___('label.bank') }}:</span>
                                            <span>{{@$account->bank->bank_name}}</span>
                                        </div>
                                        @endif
                                        @if($account->branch_name != null)
                                        <div class="d-flex gap-3">
                                            <span>{{ ___('label.branch') }}:</span>
                                            <span>{{@$account->branch_name}}</span>
                                        </div>
                                        @endif

                                        @if($account->mobile != null)
                                        <div class="d-flex gap-3">
                                            <span>{{ ___('label.mobile') }}:</span>
                                            <span>{{@$account->mobile}}</span>
                                        </div>
                                        @endif
                                        @if($account->account_type != null)
                                        <div class="d-flex gap-3">
                                            <span>{{ ___('label.type') }}:</span>
                                            <span>{{$account->account_type == 1 ? ___('label.merchant') : ___('label.personal')}} </span>
                                        </div>
                                        @endif


                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <span>{{ ___('label.opening') }}:</span>
                                            <span class="whitespace-nowrap">{{ settings('currency') . " " . $account->opening_balance }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <span>{{ ___('label.current') }}:</span>
                                            <span class="whitespace-nowrap">{{ settings('currency') . " " . $account->balance }}</span>
                                        </div>
                                    </td>

                                    <td>{!! $account->my_status !!}</td>
                                    @if(hasPermission('account_update') == true || hasPermission('account_delete') == true )
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            @if(hasPermission('account_update') == true )
                                            <a href="{{route('accounts.edit',$account->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif
                                            @if( hasPermission('account_delete') == true )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/accounts/delete', {{$account->id}})">
                                                <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <x-nodata-found :colspan="7" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- pagination component -->
                @if(count($accounts))
                <x-paginate-show :items="$accounts" />
                @endif
                <!-- end pagination component -->

            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper-->
@endsection()
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
