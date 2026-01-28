@extends('backend.partials.master')
@section('title', ___('label.client'))
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
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"
                                        class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                                <li class="breadcrumb-item"><a href=""
                                        class="breadcrumb-link">{{ ___('label.website_setup') }}</a></li>
                                <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.client') }}</a></li>
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

                {{-- Client Title header --}}
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('label.client') }} {{ ___('label.list') }}</h4>
                    @if (hasPermission('client_create'))
                        <a href="{{ route('client.create') }}" class="j-td-btn">
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
                                    <th scope="col">{{ ___('label.name') }}</th>
                                    <th scope="col">{{ ___('label.title') }}</th>
                                    <th scope="col">{{ ___('label.facebook') }}</th>
                                    <th scope="col">{{ ___('label.twitter') }}</th>
                                    <th scope="col">{{ ___('label.linkedIn') }}</th>
                                    <th scope="col">{{ ___('label.position') }}</th>
                                    <th scope="col">{{ ___('label.logo') }}</th>
                                    <th scope="col">{{ ___('label.status') }}</th>

                                    @if (hasPermission('client_status_update'))
                                        <th scope="col">{{ ___('label.status_update') }}</th>
                                    @endif
                                    @if (hasPermission('client_update') || hasPermission('client_delete'))
                                        <th scope="col">{{ ___('label.action') }}</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($companies as $key => $client )
                                    <tr id="row_{{ $client->id }}">
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->title }}</td>
                                        <td>{{ $client->facebook_id }}</td>
                                        <td>{{ $client->twitter_id }}</td>
                                        <td>{{ $client->linkedIn_id }}</td>
                                        <td>{{ $client->position }}</td>
                                        <td>
                                            <img width="80" src="{{ data_get($client->client_logo, 'image_one') }}"
                                                alt="client_logo">
                                        </td>
                                        <td>{!! $client->my_status !!}</td>

                                        @if (hasPermission('client_status_update'))
                                            <td>
                                                <a class="nav-link" href="#" role="button" data-toggle="dropdown"> ... </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class=" ">
                                                        @if ($client->status == App\Enums\Status::INACTIVE)
                                                            <li class="media dropdown-item"> <a
                                                                    href="{{ route('client.status.update', $client->id) }}">{{ ___('label.active') }}</a>
                                                            </li>
                                                        @elseif($client->status == App\Enums\Status::ACTIVE)
                                                            <li class="media dropdown-item"> <a
                                                                    href="{{ route('client.status.update', $client->id) }}">{{ ___('label.inactive') }}</a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        @endif
                                        @if (hasPermission('client_update') || hasPermission('client_delete'))
                                            <td>
                                                {{-- new action design  --}}
                                                <div class="d-flex" data-toggle="dropdown">
                                                    <a class="p-2" href="javascript:void()">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                </div>
                                                <div class="dropdown-menu">
                                                    @if (hasPermission('client_update'))
                                                        <a href="{{ route('client.edit', $client->id) }}" class="dropdown-item"><i
                                                                class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                                    @endif
                                                    @if (hasPermission('client_delete'))
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            onclick="delete_row('admin/website-setup/client/delete', {{ $client->id }})">
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
                    <!-- pagination component -->
                    @if (count($companies))
                        <x-paginate-show :items="$companies" />
                    @endif
                    <!-- end pagination component -->

                </div>

            </div>
        </div>

    </div>
@endsection

@push('scripts')
    @include('backend.partials.delete-ajax')
@endpush
