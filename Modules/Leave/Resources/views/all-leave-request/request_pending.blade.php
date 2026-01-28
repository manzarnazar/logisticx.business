<div class="modal fade" id="pendingModal">
    {{-- {{dd($request->id)}} --}}
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ ___('hr_manage.leave_pending')}}</h5>
                <div class="status-text available-text">
                    <span>{{ ___('hr_manage.available_days') }} : <span class="availableDays"></span></span>

                </div>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span> </button>
            </div>
            <div class="modal-body">


                <form action="{{ route('request-pending') }}" method="post">
                    @csrf
                    <input type="hidden" value="" name="request_id" id="request_id" class="modal_request_id" />

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="note">{{ ___('hr_manage.pending_note')}}</label>
                            <div class="form-control-wrap deliveryman-search">
                                <textarea class="form-control" name="note" rows="5" id="note"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="j-td-btn"><span>{{ ___('label.submit') }}</span></button>
                        <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
