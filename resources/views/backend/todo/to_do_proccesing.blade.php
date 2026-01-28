{{-- todoStatus{{ \App\Enums\TodoStatus::PROCESSING }} --}}
<div class="modal fade" id="todo_processing" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('common.processing') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('todo.processing') }}" method="post">
                @csrf
                <input type="hidden" id="todo_id" value="" name="todo_id" class="modal_todo_id" />

                <div class="modal-body">
                    <div class="form-group  ">
                        <label class="label-style-1" for="note">{{ ___('common.note')}}</label>
                        <div class="form-control-wrap deliveryman-search">
                            <textarea class="form-control input-style-1" name="note" rows="5" id="note"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="j-td-btn">{{ ___('label.submit') }}</button>
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
