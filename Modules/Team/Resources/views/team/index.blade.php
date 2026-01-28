@extends('backend.partials.master')
@section('title', ___('label.teams'))
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.teams') }}</a></li>
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
                    <h4 class="title-site"> {{ ___('label.team') }} {{ ___('label.list') }}</h4>
                    @if (hasPermission('team_create'))
                    <a href="{{ route('team.create') }}" class="j-td-btn">
                        <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image">
                        <span>{{ ___('label.add') }} </span>
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ ___('label.user') }}</th>
                                    <th scope="col">{{ ___('label.image') }}</th>
                                    <th scope="col">{{ ___('label.designation') }}</th>
                                    <th scope="col">{{ ___('label.position') }}</th>
                                    <th scope="col">{{ ___('label.status') }}</th>
                                    @if (hasPermission('team_status_update'))
                                    <th scope="col">{{ ___('label.status_update') }}</th>
                                    @endif
                                    @if (hasPermission('team_update') || hasPermission('team_delete'))
                                    <th scope="col">{{ ___('label.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=0; @endphp
                                @forelse ($teams as $team)
                                <tr id="row_{{ $team->id }}">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ @$team->user->name }}</td>
                                    <td>
                                        <img class="user-avatar" src="{{ getImage($team->user->upload, 'original','default-image-40x40.png') }}" width="40" alt="a" />
                                    </td>
                                    <td>{{ @$team->user->designation->title }}</td>
                                    <td>{{ $team->position }}</td>
                                    <td>{!! $team->my_status !!}</td>
                                    @if (hasPermission('team_status_update'))
                                    <td>
                                        <a class="nav-link" href="#" role="button" data-toggle="dropdown"> ... </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul>
                                                @if ($team->status == App\Enums\Status::ACTIVE)
                                                <li class="media dropdown-item"> <a href="{{ route('team.status.update', @$team->id) }}">{{ ___('label.inactive') }}</a> </li>
                                                @elseif($team->status == App\Enums\Status::INACTIVE)
                                                <li class="media dropdown-item"> <a href="{{ route('team.status.update', @$team->id) }}">{{ ___('label.active') }}</a> </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                    @endif
                                    @if (hasPermission('team_update') || hasPermission('team_delete'))
                                    <td>

                                        {{-- new action design  --}}
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            @if (hasPermission('team_update'))
                                            <a href="{{ route('team.edit', $team->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif
                                            @if (hasPermission('team_delete') == true)
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/website-setup/teams/delete', {{ $team->id }})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
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
                    @if (count($teams))
                    <x-paginate-show :items="$teams" />
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
