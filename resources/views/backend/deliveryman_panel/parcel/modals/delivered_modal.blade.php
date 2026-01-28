<div class="modal fade" id="deliveredModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{ ___('parcel.delivered') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>

            {{-- otp send btn --}}
            <div class="form-group col-12 mt-2">
                <button type="button" class="j-td-btn send_otp_btn" id="send_otp" data-status="{{ \App\Enums\ParcelStatus::DELIVERED }}" data-url="{{ route('hero.requestParcelDelivery') }}"><i class="fa-regular fa-paper-plane mb-1"></i>{{ ___('label.send_otp_customer') }}</button>
            </div>

            <form action="{{ route('parcel.delivered') }}" method="post" id="deliveryForm">
                @csrf
                <input type="hidden" value="" name="parcel_id" id="parcel_id" class="parcel_id" />

                <div class="modal-body">
                    <div class="form-row">

                        <div class="form-group col-12">
                            <label class=" label-style-1" for="otp">{{ ___('parcel.otp') }} <span class="text-danger">*</span> </label>
                            <input type="text" name="otp" id="otp" class="form-control input-style-1" value="{{ old('otp') }}" placeholder="{{ ___('placeholder.enter_otp') }}" autocomplete="off">
                            <small class="text-danger mt-2 errorTextBox" data-error-for="otp"> </small>
                        </div>

                        <div class="form-group col-12">
                            <label class="label-style-1" for="note">{{ ___('parcel.note') }}</label>
                            <textarea class="form-control input-style-1" name="note" rows="5" placeholder="{{ ___('parcel.note') }}"></textarea>
                            <small class="text-danger mt-2 errorTextBox" data-error-for="note"> </small>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="custom-control custom-checkbox">
                                <input id="send_sms_customer" name="send_sms_customer" class="custom-control-input" type="checkbox"><span class="custom-control-label">Send SMS for customer</span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="custom-control custom-checkbox">
                                <input id="send_sms_merchant" name="send_sms_merchant" class="custom-control-input" type="checkbox"><span class="custom-control-label">Send SMS for merchant </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span></button>
                    <button type="submit" class="j-td-btn"> <i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.save') }}</span></button> </div>
            </form>
        </div>
    </div>
</div>
