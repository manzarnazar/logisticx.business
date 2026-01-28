@extends('backend.partials.master')
@section('title')
{{ ___('label.notification') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.notification') }}</a></li>
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
            <div class="j-parcel-main j-parcel-res">
                <div class="card">

                    <div class="card-header mb-3">
                        <h4 class="title-site">{{ ___('label.notification') }}</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  ">
                                <thead class="bg">
                                    <tr>
                                        <th>{{ ___('label.id') }}</th>
                                        <th>{{ ___('label.notify_by') }}</th>
                                        <th>{{ ___('label.message') }}</th>
                                        <th>{{ ___('label.date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($notifications as $notification)
                                    <tr @if ($notification->read_at == null) class="bg-light-blue" {{ $notification->markAsRead() }} @endif>

                                        <td>{{$loop->iteration }}</td> {{-- laravel default --}}
                                        <td>
                                            <div>
                                                <img src="{{ getImage(singleUser($notification->data['user_id'])->upload, 'original','default-image-40x40.png' ) }}" alt=" " height="20" width="20" class="rounded">
                                                <span>{{$notification->data['name']}}</span>
                                            </div>
                                        </td>
                                        <td> <a href="{{ $notification->data['url'] ?? '#' }}"> {{$notification->data['message']}}</a> </td>
                                        <td>{{ @dateTimeFormat($notification->created_at) }}</td>
                                    </tr>
                                    @empty
                                    <x-nodata-found :colspan="5" />
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- pagination component -->
                        @if(count($notifications))
                        <x-paginate-show :items="$notifications" />
                        @endif
                        <!-- pagination component -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()
