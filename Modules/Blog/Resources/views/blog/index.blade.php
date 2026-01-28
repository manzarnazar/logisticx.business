@extends('backend.partials.master')
@section('title', ___('label.blogs'))
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
                            <li class="breadcrumb-item breadcrumb-link"><a href="">{{ ___('label.blogs') }}</a></li>
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
                <h4 class="title-site">{{ ___('label.blog') }} {{ ___('label.list') }}</h4>
                @if (hasPermission('blog_create'))
                <a href="{{ route('blog.create') }}" class="j-td-btn">
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
                                <th scope="col">{{ ___('label.author') }}</th>
                                <th scope="col">{{ ___('label.date') }}</th>
                                <th scope="col">{{ ___('label.title') }}</th>
                                <th scope="col">{{ ___('label.banner') }}</th>
                                <th scope="col">{{ ___('label.description') }}</th>
                                <th scope="col">{{ ___('label.position') }}</th>
                                <th scope="col">{{ ___('label.status') }}</th>

                                @if (hasPermission('blog_status_update'))
                                <th scope="col">{{ ___('label.status_update') }}</th>
                                @endif
                                @if (hasPermission('blog_update') || hasPermission('blog_delete'))
                                <th scope="col">{{ ___('label.action') }}</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($blogs as $key => $blog )
                            <tr id="row_{{ $blog->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ $blog->user->name }}</td>
                                <td>{{ dateFormat($blog->date) }}</td>
                                <td>{{ $blog->title }}</td>
                                <td> <img class="h-50px w-100 object-fit-cover" src="{{ getImage($blog->upload, 'original','default-image-80x80.png') }}" alt="blog_logo"> </td>
                                {{-- <td>{!! Str::limit($blog->description, 150) !!}</td> --}}
                                <td>{!! Str::limit(strip_tags($blog->description), 150) !!} </td>
                                <td>{{ $blog->position }}</td>
                                <td>{!! $blog->my_status !!}</td>

                                @if (hasPermission('blog_status_update'))
                                <td>
                                    <a class="nav-link" href="#" role="button" data-toggle="dropdown"> ... </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class=" ">
                                            @if ($blog->status == App\Enums\Status::INACTIVE)
                                            <li class="media dropdown-item"> <a href="{{ route('blog.status.update', $blog->id) }}">{{ ___('label.active') }}</a>
                                            </li>
                                            @elseif($blog->status == App\Enums\Status::ACTIVE)
                                            <li class="media dropdown-item"> <a href="{{ route('blog.status.update', $blog->id) }}">{{ ___('label.inactive') }}</a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                                @endif
                                @if (hasPermission('blog_update') || hasPermission('blog_delete'))
                                <td>
                                    {{-- new action design  --}}
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                    </div>

                                    <div class="dropdown-menu">
                                        @if (hasPermission('blog_update') == true)
                                        <a href="{{ route('blog.edit', $blog->id) }}" class="dropdown-item">
                                            <i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif
                                        @if (hasPermission('blog_delete') == true)
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/website-setup/blogs/delete', {{ $blog->id }})">
                                            <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                        </a>
                                        @endif
                                    </div>
                                    {{-- end new action design  --}}
                                </td>
                                @endif
                            </tr>

                            @empty
                            <x-nodata-found :colspan="9" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if (count($blogs))
                <x-paginate-show :items="$blogs" />
                @endif
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
