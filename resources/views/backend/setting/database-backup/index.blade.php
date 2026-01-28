@extends('backend.partials.master')
@section('title')
{{ ___('menus.database_backup') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ ___('menus.database_backup') }}</a></li>
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
                    <h4 class="title-site">{{ ___('menus.database_backup') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>{{ ___('settings.backup_description') }}</p>
                        </div>
                    </div>

                    <div class="j-create-btns">
                        <div class="drp-btns">
                            <a href="{{ route('database.backup.download') }}" class="j-td-btn"> <img src="{{ asset('backend/icons/icon/download-white-5.png') }}" class="jj" alt="no image"> <span>{{ ___('label.download') }}</span> </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end data table  -->
</div>
<!-- end wrapper  -->
@endsection()
