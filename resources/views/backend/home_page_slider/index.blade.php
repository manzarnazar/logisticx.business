@extends('backend.partials.master')
@section('title', ___('label.home_page_slider'))
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->

    {{-- Old Breadbrmb --}}
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item breadcrumb-link"><a href="{{ route('dashboard.index') }}">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item breadcrumb-link"><a href="">{{ ___('label.website_setup') }}</a></li>
                            <li class="breadcrumb-item breadcrumb-link"><a href="">{{ ___('label.home_page_slider') }}</a></li>
                            <li class="breadcrumb-item breadcrumb-link"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-parcel-main j-parcel-res">
        <div class="card">

            <div class="card-header mb-3">
                <h4 class="title-site">{{ ___('label.home_page_slider') }} {{ ___('label.list') }}</h4>
                @if (hasPermission('blog_create'))
                <a href="{{ route('HomePageSider.create') }}" class="j-td-btn">
                    <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image">
                    <span>{{ ___('label.add') }}</span>
                </a>
                @endif
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ ___('label.small_title') }}</th>
                                <th scope="col">{{ ___('label.title') }}</th>
                                <th scope="col">{{ ___('label.description') }}</th>
                                <th scope="col">{{ ___('label.page_link') }}</th>
                                <th scope="col">{{ ___('label.video_link(embed)') }}</th>
                                <th scope="col">{{ ___('label.banner') }}</th>
                                <th scope="col">{{ ___('label.position') }}</th>
                                <th scope="col">{{ ___('label.date') }}</th>
                                <th scope="col">{{ ___('label.status') }}</th>
                                <th scope="col">{{ ___('label.action') }}</th>


                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($HomePageSlider as $key => $blog )
                            <tr id="row_{{ $blog->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ $blog->small_title }}</td>
                                 <td>{{ $blog->title }}</td>
                                 <td>{{ $blog->description }}</td>
                                 <td>{{ $blog->page_link }}</td>
                                 <td>{{ $blog->video_link }}</td>

                                <td> <img class="h-50px w-100 object-fit-cover" src="{{ getImage($blog->banner, 'original','default-image-80x80.png') }}" alt="blog_logo"> </td>
                                <td>{{ $blog->position }}</td>
                                <td>{{ dateFormat($blog->date) }}</td>
                                <td>{!! $blog->my_status !!}</td>


                                <td>
                                    {{-- new action design  --}}
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                    </div>

                                    <div class="dropdown-menu">
                                        @if (hasPermission('home_page_slider_update') == true)
                                        <a href="{{ route('HomePageSider.edit',$blog->id) }}" class="dropdown-item">
                                            <i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif
                                        @if (hasPermission('home_page_slider_delete') == true)
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/website/home-page-slider/delete',{{$blog->id}})">
                                            <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                        </a>
                                        @endif
                                    </div>
                                    {{-- end new action design  --}}
                                </td>

                            </tr>

                            @empty
                            <x-nodata-found :colspan="9" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if (count($HomePageSlider))
                <x-paginate-show :items="$HomePageSlider" />
                @endif
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
