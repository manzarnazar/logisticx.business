<div class="modal fade" id="parcelstatus{{ \App\Enums\ParcelStatus::RECEIVED_BY_HUB }}" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('parcel.received_by_hub') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('parcel.received-by.hub') }}" method="post">
                @csrf
                <input type="hidden" value="" name="parcel_id" id="modal_parcel_id" class="modal_parcel_id input-style-1" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="note">{{ ___('parcel.note') }}</label>
                        <textarea class="form-control input-style-1" id="note" name="note" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i
                            class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </button>
                </div>
            </form>
        </div>
    </div>
</div>
