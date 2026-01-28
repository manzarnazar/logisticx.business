<div class="modal fade" id="parcelstatus{{ \App\Enums\ParcelStatus::RECEIVED_WAREHOUSE }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('parcel.received_warehouse') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('parcel.received.warehouse') }}" method="post">
                @csrf
                <input type="hidden" value="" name="parcel_id" id="modal_parcel_id" class="modal_parcel_id" />
                <div class="modal-body">
                    <input type="hidden" value="" name="pickup_man_id" id="modal_parcel_id" class="modal_parcel_id" />
                    <div class="form-row">

                        <div class="col-12 col-md-12 form-group">
                            <label class="label-style-1" for="hub">{{ ___('hub.title') }}<span class="text-danger">*</span> </label>
                            <select id="hub" class="form-control input-style-1 receivedwarehousehub select2" name="hub_id">
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="col-12 col-md-12 form-group">
                            <label class="label-style-1" for="note">{{ ___('parcel.note') }}</label>
                            <textarea class="form-control input-style-1" name="note" rows="5" id="note"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="send_sms_customer" name="send_sms_customer">
                                <label class="custom-control-label" for="send_sms_customer">{{ ___('common.send_sms_to_customer') }}</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="send_sms_merchant" name="send_sms_merchant">
                                <label class="custom-control-label" for="send_sms_merchant">{{ ___('common.send_sms_to_merchant') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                        <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
