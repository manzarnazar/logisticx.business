<div class="modal fade" id="parcelstatus{{ \App\Enums\ParcelStatus::DELIVERED }}" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{ ___('parcel.delivered') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('parcel.delivered') }}" method="post">
                @csrf
                <input type="hidden" value="" name="parcel_id" id="modal_parcel_id" class="modal_parcel_id" />
                <input type="hidden" value="" name="delivery_man_id" id="modal_parcel_id2" class="modal_parcel_id" />

                <div class="modal-body">
                    <div class="form-row">

                        <div class="form-group col-12">
                            <label class="label-style-1" for="note">{{ ___('parcel.note') }}</label>
                            <div class="form-control-wrap deliveryman-search">
                                <textarea class="form-control input-style-1" name="note" rows="5" placeholder="{{ ___('parcel.note') }}"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="custom-control custom-checkbox">
                                <input id="send_sms_customer" name="send_sms_customer" class="custom-control-input" type="checkbox"><span
                                    class="custom-control-label">{{ ___('common.send_sms_to_customer') }}</span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="custom-control custom-checkbox">
                                <input id="send_sms_merchant" name="send_sms_merchant" class="custom-control-input" type="checkbox"><span
                                    class="custom-control-label">{{ ___('common.send_sms_to_merchant') }} </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="j-td-btn"> <i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
