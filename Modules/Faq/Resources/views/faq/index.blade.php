@extends('backend.partials.master')
@section('title',___('label.faqs') )
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.website_setup') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.faqs') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-parcel-main j-parcel-res">
        <div class="card">

            {{-- FAQ Header Title --}}
            <div class="card-header mb-3">
                <h4 class="title-site">{{ ___('label.faq') }} {{ ___('label.list') }}</h4>
                @if (hasPermission('faq_create'))
                <a href="{{ route('faq.create') }}" class="j-td-btn">
                    <img src="{{asset('backend')}}/icons/icon/plus-white.png" class="jj" alt="no image">
                    <span>{{ ___('label.add') }}</span>
                </a>
                @endif
            </div>

            {{-- FAQ Index Body --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ ___('label.title') }}</th>
                                <th scope="col">{{ ___('label.position') }}</th>
                                <th scope="col">{{ ___('label.status') }}</th>
                                @if(hasPermission('faq_status_update'))
                                <th scope="col">{{ ___('label.status_update') }}</th>
                                @endif
                                @if(hasPermission('faq_update') || hasPermission('faq_delete'))
                                <th scope="col">{{ ___('label.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($all_faq as $key=>$faq )

                            <tr id="row_{{ $faq->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ @$faq->title }}</td>
                                <td>{!! $faq->position !!}</td>
                                <td>{!! $faq->my_status !!}</td>
                                @if(hasPermission('faq_status_update'))
                                <td>
                                    <a class="nav-link" href="#" role="button" data-toggle="dropdown"> ... </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class=" ">
                                            @if($faq->status == App\Enums\Status::ACTIVE)
                                            <li class="media dropdown-item"> <a href="{{ route('faq.status.update',$faq->id) }}">{{ ___('label.inactive')}}</a> </li>
                                            @elseif($faq->status == App\Enums\Status::INACTIVE)
                                            <li class="media dropdown-item"> <a href="{{ route('faq.status.update',$faq->id) }}">{{ ___('label.active')}}</a> </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                                @endif
                                @if(hasPermission('faq_update') || hasPermission('faq_delete'))
                                <td>
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        @if(hasPermission('faq_update'))
                                        <a href="{{ route('faq.edit',$faq->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif
                                        @if(hasPermission('faq_delete') )
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/website-setup/faqs/delete', {{$faq->id}})">
                                            <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                        </a>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>

                            @empty
                            <x-nodata-found :colspan="5" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- pagination component -->
                @if(count($all_faq))
                <x-paginate-show :items="$all_faq" />
                @endif

            </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
