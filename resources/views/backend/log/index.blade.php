@extends('backend.partials.master')

@section('title', ___('menus.Activity_logs') )

@section('maincontent')

<div class="container-fluid  dashboard-content">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link"> <i class="ti-home"></i> </a></li>
            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('menus.Activity_logs') }}</a></li>
        </ol>
    </nav>

    <!-- data table  -->
    <div class="card">
        <div class="card-header mb-3">
            <h4 class="title-site">{{ ___('label.logs') }}</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead class="bg">
                        <tr>
                            <th>#</th>
                            <th>{{ ___('label.Log_name') }}</th>
                            <th>{{ ___('label.event') }}</th>
                            {{-- <th>{{ ___('label.subject_type') }}</th> --}}
                            <th>{{ ___('label.description') }}</th>
                            <th>{{ ___('label.causer') }}</th>
                            <th>{{ ___('label.view') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @forelse($logs as $log)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$log->log_name}}</td>
                            <td>{{___('label.'.$log->event)}}</td>
                            {{-- <td>{{$log->subject_type}}</td> --}}
                            <td>{{___('label.'.$log->description)}}</td>
                            <td>{{ $log->causer ? $log->causer->name : 'Unknown User' }}</td>
                            <td> <a href="{{ route('log-activity-view',$log->id) }}" class="btn btn-primary btn-sm modalBtn" data-toggle="modal" data-target="#dynamic-modal" data-modalsize="modal-lg" data-title="{{ ___('label.Log_details') }}"> <i class="fa fa-eye"></i></a> </td>
                        </tr>
                        @empty
                        <x-nodata-found : colspan="5" />
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- pagination component -->
            @if(count($logs))
            <x-paginate-show :items="$logs" />
            @endif
            <!-- pagination component -->
        </div>
    </div>

</div>
@endsection()
