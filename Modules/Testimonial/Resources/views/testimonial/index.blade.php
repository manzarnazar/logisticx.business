@extends('backend.partials.master')
@section('title', ___('label.testimonial'))
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.website_setup') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.testimonial') }}</a> </li>
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
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('label.testimonial') }} {{ ___('label.list') }}</h4>
                    @if (hasPermission('testimonial_create'))
                    <a href="{{ route('testimonial.create') }}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span> </a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">{{ ___('label.client') }}</th>
                                    <th scope="col">{{ ___('label.rating') }}</th>
                                    <th scope="col">{{ ___('label.review') }}</th>
                                    <th scope="col">{{ ___('label.position') }}</th>
                                    <th scope="col">{{ ___('label.status') }}</th>

                                    @if (hasPermission('testimonial_update') || hasPermission('testimonial_delete'))
                                    <th scope="col">{{ ___('label.action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @forelse (@$testimonials as $key => $testimonial )
                                <tr id="row_{{ $testimonial->id }}">
                                    <td>{{ ++$key }}</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ getImage($testimonial->upload, 'image_one','default-image-40x40.png') }}" alt="" width="40" height="40" />
                                            </div>
                                            <div class="flex-grow-1 ml-2">
                                                <strong>{{ @$testimonial->client_name }}</strong> <br>
                                                <span>{{ @$testimonial->designation }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ @$testimonial->rating }}</td>
                                    <td>{!! Str::limit($testimonial->description, 250) !!}</td>
                                    <td class="text-center">{!! $testimonial->position !!}</td>
                                    <td class="text-center">{!! $testimonial->my_status !!}</td>

                                    @if (hasPermission('testimonial_update') || hasPermission('testimonial_delete'))
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            @if (hasPermission('testimonial_update'))
                                            <a href="{{ route('testimonial.edit', $testimonial->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i>
                                                {{ ___('label.edit') }}</a>

                                            <a href="{{ route('testimonial.status.update', @$testimonial->id) }}" class="dropdown-item">
                                                @if ($testimonial->status == App\Enums\Status::ACTIVE)
                                                <i class="fa fa-power-off text-danger"></i>
                                                {{ ___('label.inactive') }}
                                                @else
                                                <i class="fa fa-power-off text-danger"></i>
                                                {{ ___('label.active') }}
                                                @endif
                                            </a>
                                            @endif

                                            @if (hasPermission('testimonial_delete'))
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/website-setup/testimonial/delete', {{ $testimonial->id }})">
                                                <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                            </a>
                                            @endif
                                        </div>

                                    </td>
                                    @endif
                                </tr>

                                @empty
                                <x-nodata-found :colspan="9" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- pagination component -->
                    @if (count($testimonials))
                    <x-paginate-show :items="$testimonials" />
                    @endif
                    <!-- Pagination -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
