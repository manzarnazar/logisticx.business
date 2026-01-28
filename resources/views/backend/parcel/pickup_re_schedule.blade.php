<div class="modal fade" id="parcelstatus{{ \App\Enums\ParcelStatus::PICKUP_RE_SCHEDULE }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('parcel.pickup_re_schedule') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('parcel.pickup.re.schedule') }}" method="post">
                @csrf
                <input type="hidden" value="" name="parcel_id" id="modal_parcel_id" class="modal_parcel_id" />
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-8 form-group">
                            <label class="label-style-1" for="delivery_man_search_reschedule">{{ ___('parcel.pickup_man') }}</label> <span class="text-danger">*</span>
                            <select id="delivery_man_search_reschedule" class="form-control input-style-1 delivery_man_search " name="delivery_man_id" data-url="{{ route('parcel.deliveryman.search') }}">
                                <option value=""></option>
                            </select>

                        </div>

                        <div class="col-md-4 form-group">
                            <label class="label-style-1" for="date">{{ ___('label.date') }}<span class="text-danger">*</span> </label>
                            <input type="date" id="date" name="date" class="form-control input-style-1 flatpickr" placeholder="Enter Date" value="{{ old('date') }}">
                        </div>

                        <div class="col-md-12 form-group  ">
                            <label class="label-style-1" for="note">{{ ___('parcel.note') }}</label>
                            <div class="form-control-wrap deliveryman-search">
                                <textarea class="form-control input-style-1" name="note"></textarea>
                            </div>
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
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </button>
                </div>

            </form>
        </div>
    </div>
</div>
