<div class="modal fade" id="parcelstatus{{ \App\Enums\ParcelStatus::RETURN_ASSIGN_TO_MERCHANT }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title">{{ ___('parcel.return_assign_to_merchant') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('parcel.return-assign-to-merchant') }}" method="post">
                @csrf
                <input type="hidden" class="modal_parcel_id" id="modal_parcel_id" value="" name="parcel_id" />
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="returnassigntomerchant">{{ ___('parcel.delivery_man') }}<span class="text-danger">*</span> </label>
                            <select id="returnassigntomerchant" class="form-control input-style-1 delivery_man_search" name="delivery_man_id" data-url="{{ route('parcel.deliveryman.search') }}">
                                <option value=""></option>
                            </select>
                            @error('delivery_man_id')
                            <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="form-group col-12">
                            <label for="date">{{ ___('label.date') }}<span class="text-danger">*</span> </label>
                            <input type="date" id="date" data-toggle="datepicker" name="date" placeholder="yyyy-mm-dd" class="form-control input-style-1 flatpickr" value="{{ old('date') }}" required>
                            @error('date')
                            <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label for="note">{{ ___('parcel.note') }}</label>
                            <div class="form-control-wrap deliveryman-search">
                                <textarea class="form-control input-style-1" name="note" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label class="custom-control custom-checkbox">
                                <input id="send_sms" name="send_sms" class="custom-control-input" type="checkbox"><span class="custom-control-label">{{ ___('common.send_sms') }}</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
