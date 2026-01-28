@extends('backend.partials.master')
@section('title', ___('label.features'))
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.features') }}</a>
                            </li>
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

            {{-- Features Header  --}}
            <div class="card-header mb-3">
                <h4 class="title-site">{{ ___('label.features') }} {{ ___('label.list') }}
                </h4>
                @if (hasPermission('features_create'))
                <a href="{{ route('features.create') }}" class="j-td-btn">
                    <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image">
                    <span>{{ ___('label.add') }}</span>
                </a>
                @endif
            </div>

            {{-- features Body --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ ___('label.title') }}</th>
                                <th scope="col">{{ ___('label.image') }}</th>
                                <th scope="col">{{ ___('label.description') }}</th>
                                <th scope="col">{{ ___('label.position') }}</th>

                                <th scope="col">{{ ___('label.status') }}</th>
                                @if (hasPermission('features_status_update'))
                                <th scope="col">{{ ___('label.status_update') }}</th>
                                @endif

                                @if (hasPermission('features_update') || hasPermission('features_delete'))
                                <th scope="col">{{ ___('label.action') }}</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($features as $key=>$feature )
                            <tr id="row_{{ $feature->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ $feature->title }}</td>
                                <td>
                                    <img height="40" width="40" src="{{ getImage($feature->upload, 'image_two','default-image-40x40.png') }}" alt="image" class="rounded">
                                </td>
                                <td>{!! Str::limit($feature->description, 100) !!}</td>
                                <td>{!! $feature->position !!}</td>
                                <td>{!! $feature->my_status !!}</td>
                                @if (hasPermission('features_status_update'))
                                <td>
                                    <a class="nav-link" href="#" role="button" data-toggle="dropdown"> ... </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class=" ">
                                            @if ($features->status == App\Enums\Status::INACTIVE)
                                            <li class="media dropdown-item"> <a href="{{ route('features.status.update', $feature->id) }}">{{ ___('label.active') }}</a>
                                            </li>
                                            @elseif($features->status == App\Enums\Status::ACTIVE)
                                            <li class="media dropdown-item"> <a href="{{ route('features.status.update', $feature->id) }}">{{ ___('label.inactive') }}</a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                                @endif

                                @if (hasPermission('features_update') || hasPermission('features_delete'))
                                <td>
                                    {{-- new action design  --}}
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        @if (hasPermission('features_update'))
                                        <a href="{{ route('features.edit', $feature->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif
                                        @if (hasPermission('features_delete'))
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/website-setup/features/delete', {{ $feature->id }})">
                                            <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                        </a>
                                        @endif
                                    </div>
                                    {{-- end new action design  --}}
                                </td>
                                @endif
                            </tr>

                            @empty
                            <x-nodata-found :colspan="7" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if (count($features))
                <x-paginate-show :items="$features" />
                @endif
                <!-- Pagination -->
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
