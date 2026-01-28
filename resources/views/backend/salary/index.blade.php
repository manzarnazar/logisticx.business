@extends('backend.partials.master')
@section('title')
{{ ___('common.salary') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('common.payroll')}}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('common.salary') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="row">


        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('salary.filter') }}" method="GET">
                        @csrf

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label class="label-style-1" for="user">{{ ___('label.user') }}</label>
                                <select id="userID" name="user" class="form-control input-style-1" data-url="{{ route('user.search') }}">
                                    <option selected disabled> {{___('placeholder.select_user')}}</option>
                                </select>
                                @error('user') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class=" label-style-1" for="month">{{ ___('common.month')}}</label> <span class="text-danger"></span>
                                <input type="month" id="month" name="month" placeholder="yyyy-mm" class="form-control input-style-1" value="{{old('date',isset($request->month) ? $request->month:date('Y-m'))}}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-4 d-flex align-items-end">
                                <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                <a href="{{ route('salary.index') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- data table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('common.salary') }} </h4>
                    @if(hasPermission('salary_create') )
                    <div class=" d-flex">
                        <a href="{{route('salary.create')}}" class="j-td-btn">
                            <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image">
                            <span>{{ ___('label.add') }} </span>
                        </a>
                        <a href="#" class="j-td-btn ml-3" data-toggle="modal" data-target="#autogenerate"> {{ ___('common.auto_generate') }} </a>
                    </div>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.user') }}</th>
                                    <th>{{ ___('label.month') }}</th>
                                    <th>{{ ___('label.basic') }}</th>
                                    <th>{{ ___('label.allowance') }}</th>
                                    <th>{{ ___('label.deduction') }}</th>
                                    <th>{{ ___('label.total') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    <th>{{ ___('label.note') }}</th>
                                    @if (hasPermission('salary_update')|| hasPermission('salary_pay') || hasPermission('salary_delete') || hasPermission('salary_read'))
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @forelse($salaries as $salary)
                                <tr id="row_{{ $salary->id }}">
                                    <td>{{$i++}}</td>
                                    <td>
                                        {{$salary->user->name}}<br />
                                        {{ $salary->user->email }}
                                    </td>
                                    <td>{{ date('M Y', strtotime($salary->month)) }}</td>

                                    <td>{{ @settings('currency') }} {{$salary->amount}}</td>
                                    <td>{{ @settings('currency') }} {{$salary->totalAllowance }}</td>
                                    <td>{{ @settings('currency') }} {{$salary->totalDeduction}}</td>
                                    <td>{{ @settings('currency') }} {{ $salary->netSalary }}</td>
                                    <td> {!! $salary->my_status !!} </td>
                                    <td> {{ $salary->note }} </td>
                                    @if (hasPermission('salary_update') || hasPermission('salary_pay') || hasPermission('salary_delete') || hasPermission('salary_read'))
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>
                                        <div class="dropdown-menu">

                                            @if (hasPermission('salary_update') && $salary->status != \App\Enums\SalaryStatus::PAID )
                                            <a href="{{ route('salary.edit',$salary->id) }}" class="dropdown-item"><i class="fa fa-edit"></i> {{ ___('label.edit') }}</a>
                                            @endif

                                            @if(hasPermission('salary_pay') && $salary->status != \App\Enums\SalaryStatus::PAID)
                                            <a href="{{route('salary.pay.initialize',$salary->id)}}" class="dropdown-item"><i class="fa fa-spinner"></i> {{ ___('label.pay_now') }}</a>
                                            @elseif(hasPermission('salary_pay_reverse') && $salary->status == \App\Enums\SalaryStatus::PAID)
                                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#reverseModal" onclick="setID('#reverseModal #id', {{$salary->id}})"> <i class="fa fa-clock-o"></i> {{ ___('label.pay_reverse') }}</a>
                                            @endif

                                            @if(hasPermission('salary_read') && $salary->status == \App\Enums\SalaryStatus::PAID )
                                            <a href="{{route('salary.payslip',$salary->id)}}" target="_blank" class="dropdown-item"><i class="fa fa-print"></i> {{ ___('label.pay_slip') }}</a>
                                            @endif

                                            @if ( hasPermission('salary_delete') && $salary->status != \App\Enums\SalaryStatus::PAID )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('salary/delete', {{$salary->id}})"> <i class="fa fa-trash"></i> {{ ___('label.delete') }} </a>
                                            @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <x-nodata-found :colspan="10" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- pagination component -->
                    @if(count($salaries))
                    <x-paginate-show :items="$salaries" />
                    @endif
                </div>
                @include('backend.salary.generate')
            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>

@include('backend.salary.salary_reverse')

<!-- end wrapper  -->
@endsection()
@push('scripts')

<script type="text/javascript">
    $(document).ready(function() {

        $("#userID").select2({ 
            allowClear: true
            , ajax: {
                url: $("#userID").data('url')
                , type: "POST"
                , dataType: 'json'
                , delay: 250
                , data: function(params) {
                    return {
                        search: params.term
                        , searchQuery: true
                    };
                }
                , processResults: function(response) {
                    return {
                        results: response
                    };
                }
                , cache: true
            }
        });

        setID = (modal, id) => {
            $(modal).val(id);
        }

    });

</script>

@include('backend.partials.delete-ajax')

@endpush
