@extends('backend.partials.master')
@section('title')
{{ ___('account.subscribe') }} {{ ___('label.list') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('account.subscribe') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('account.subscribe') }}</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                                      <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('account.subscribe') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @forelse($subscribes as $subscribe)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td> {{ $subscribe->email }}</td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="2" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- pagination component -->
                    @if(count($subscribes))
                    <x-paginate-show :items="$subscribes" />
                    @endif
                    <!-- pagination component -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()
