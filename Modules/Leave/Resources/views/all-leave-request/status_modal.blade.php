<div class="modal fade" id="statusUpdateModal{{ $request->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('hr_manage.update_leave_request_status') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('leave-request-status-update', ['id' => $request->id]) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Select Status:</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="status" id="pending" value="{{ Modules\Leave\Enums\LeaveRequestStatus::PENDING }}" {{ $request->status == Modules\Leave\Enums\LeaveRequestStatus::PENDING ? 'checked' : '' }}>
                                Pending
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="status" id="approved" value="{{ Modules\Leave\Enums\LeaveRequestStatus::APPROVED }}" {{ $request->status == Modules\Leave\Enums\LeaveRequestStatus::APPROVED ? 'checked' : '' }}>
                                Approve
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="status" id="rejected" value="{{ Modules\Leave\Enums\LeaveRequestStatus::REJECTED }}" {{ $request->status == Modules\Leave\Enums\LeaveRequestStatus::REJECTED ? 'checked' : '' }}>
                                Reject
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
