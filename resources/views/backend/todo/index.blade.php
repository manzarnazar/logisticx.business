@extends('backend.partials.master')

@section('title', ___('common.to_do_list') )

@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('common.to_do') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('common.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="j-parcel-main j-parcel-res">
                <div class="card">

                    <div class="card-header mb-3">
                        <h4 class="title-site">{{ ___('common.to_do_list') }}</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg">
                                    <tr>
                                        <th>{{ ___('label.id') }}</th>
                                        <th>{{ ___('common.date') }}</th>
                                        <th>{{ ___('common.title') }}</th>
                                        <th>{{ ___('common.description') }}</th>
                                        <th>{{ ___('common.assign') }}</th>
                                        <th>{{ ___('common.note') }}</th>
                                        <th>{{ ___('common.status') }}</th>
                                        <th>{{ ___('common.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($todos as $key => $todo)
                                    <tr id="row_{{ $todo->id }}">
                                        <td>{{++$key}}</td>
                                        <td> {{dateFormat($todo->date)}}</td>
                                        <td> {{$todo->title}}</td>
                                        <td> {{\Str::limit($todo->description,100,' ...')}}</td>
                                        <td> {{$todo->user->name}}</td>
                                        <td> {{$todo->note}}</td>
                                        <td> {!! $todo->TodoStatus !!} </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend be-addon">
                                                    <div class="d-flex" data-toggle="dropdown">
                                                        <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                                    </div>
                                                    <div class="dropdown-menu">

                                                        @if(hasPermission('todo_update')==true)

                                                        @if ($todo->status == \App\Enums\TodoStatus::PENDING )
                                                        <a href="#" class="dropdown-item todo_action" data-id="{{ $todo->id }}" data-toggle="modal" data-target="#todo_processing"><i class="fa fa-spinner"></i> {{ ___('label.processing') }}</a>
                                                        <a href="" class="dropdown-item" id="todoeditModal1" data-target="#todoeditModal{{$todo->id}}" data-toggle="modal"><i class="fa fa-edit"></i> {{ ___('label.edit') }}</a>
                                                        @endif

                                                        @if($todo->status == \App\Enums\TodoStatus::PROCESSING )
                                                        <a href="#" class="dropdown-item todo_action" data-id="{{ $todo->id }}" data-toggle="modal" data-target="#todo_complete"> <i class="fa fa-check"></i> {{ ___('label.complete') }}</a>
                                                        @endif

                                                        @endif

                                                        @if(hasPermission('todo_delete')== true)
                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('todo/delete', {{$todo->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @include('backend.todo.to_do_edit')
                                    @include('backend.todo.to_do_proccesing')
                                    @include('backend.todo.to_do_completed')

                                    @empty
                                    <x-nodata-found :colspan="8" />
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- pagination component -->
                        @if(count($todos))
                        <x-paginate-show :items="$todos" />
                        @endif
                        <!-- pagination component -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection()

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.todo_action').click(function() {
            var id = $(this).data('id');
            $(".modal_todo_id").attr("value", id);
        });

    });

</script>

@include('backend.partials.delete-ajax')

@endpush
