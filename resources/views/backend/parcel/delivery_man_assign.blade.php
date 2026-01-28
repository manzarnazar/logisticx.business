<div class="modal fade" id="parcelstatus{{ \App\Enums\ParcelStatus::DELIVERY_MAN_ASSIGN }}" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('parcel.delivery_man_assign') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('parcel.delivery-man-assign') }}" method="post">
                @csrf
                <input type="hidden" value="" name="parcel_id" id="modal_parcel_id" class="modal_parcel_id" />
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label class="label-style-1" for="delivery_man_search">{{ ___('parcel.delivery_man') }}</label> <span
                                class="text-danger">*</span>
                            <select id="delivery_man_search" class="form-control input-style-1 select2 delivery_man_search"
                                name="delivery_man_id" data-url="{{ route('parcel.deliveryman.search') }}">
                                <option value=""></option>
                            </select>
                            @error('delivery_man_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label class="label-style-1" for="note">{{ ___('parcel.note') }}</label>
                            <div class="form-control-wrap deliveryman-search">
                                <textarea class="form-control  input-style-1" name="note"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-12 align-self-auto">
                            <label class="custom-control custom-checkbox">
                                <input id="send_sms" name="send_sms" class="custom-control-input" type="checkbox"><span
                                    class="custom-control-label">{{ ___('common.send_sms') }}</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="j-td-btn "><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"> <i
                            class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
