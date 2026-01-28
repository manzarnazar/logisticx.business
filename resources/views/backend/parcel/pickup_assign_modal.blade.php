<div class="modal fade" id="parcelstatus{{ \App\Enums\ParcelStatus::PICKUP_ASSIGN }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{ ___('parcel.pickup_man_assign') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <form action="{{ route('parcel.pickup.man-assigned') }}" method="post">
                @csrf
                <input type="hidden" class="modal_parcel_id" id="modal_parcel_id" value="" name="parcel_id" />
                <div class="modal-body">
                    <div class="form-row">
                        <div class=" col-12 col-md-12 form-group  ">
                            <label class="label-style-1" for="delivery_man_search_assign">{{ ___('parcel.pickup_man') }}<span class="text-danger">*</span> </label>
                            <select id="delivery_man_search_assign" class="form-control input-style-1 select2 delivery_man_search" name="delivery_man_id" data-url="{{ route('parcel.deliveryman.search') }}">
                                <option value=""></option>
                            </select>
                            @error('delivery_man_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>

                        <div class=" col-12 col-md-12 form-group  ">
                            <label class="label-style-1" for="note">{{ ___('parcel.note') }}</label>
                            <textarea class="form-control input-style-1" name="note"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="send_sms_pickuman" name="send_sms_pickuman">
                                <label class="custom-control-label" for="send_sms_pickuman">{{ ___('common.send_sms_to_hero') }}</label>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="send_sms_merchant" name="send_sms_merchant">
                                <label class="custom-control-label" for="send_sms_merchant">{{ ___('common.send_sms_to_merchant') }}</label>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }} </span></button>
                </div>
            </form>
        </div>
    </div>
</div>
