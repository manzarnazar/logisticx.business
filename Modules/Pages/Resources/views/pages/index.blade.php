@extends('backend.partials.master')
@section('title', ___('label.pages'))
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.website_setup') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.pages') }}</a></li>
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

            {{-- Pages Header  --}}
            <div class="card-header mb-3">
                <h4 class="title-site">{{ ___('label.page') }} {{ ___('label.list') }}
                </h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg">
                            <tr>
                                <th scope="col">{{ ___('label.id') }}</th>
                                <th scope="col">{{ ___('label.title') }}</th>
                                <th scope="col">{{ ___('label.description') }}</th>
                                <th scope="col">{{ ___('label.status') }}</th>
                                @if (hasPermission('page_update') )
                                <th scope="col">{{ ___('label.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pages as $key=>$page )
                            <tr id="row_{{ $page->id }}">
                                <td>{{ ++$key }}</td>
                                <td> {{ @$page->title }}</td>
                                <td>{!! Str::limit(strip_tags($page->description), 100) !!} </td>
                                <td>{!! $page->my_status !!}</td>


                                @if (hasPermission('page_update') )
                                <td>
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        @if (hasPermission('page_update'))
                                        <a href="{{ route('page.edit', $page->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
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

                {{-- Paginationa --}}
                @if (count($pages))
                <x-paginate-show :items="$pages" />
                @endif

            </div>
        </div>
    </div>

</div>
@endsection
