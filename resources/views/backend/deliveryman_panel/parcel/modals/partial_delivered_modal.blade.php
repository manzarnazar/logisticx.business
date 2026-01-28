<div class="modal fade" id="partialDeliveredModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('parcel.partial_delivered') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- otp send btn --}}
            <div class="form-group col-12 mt-2">
                <button type="button" class="j-td-btn send_otp_btn" id="send_otp" data-status="{{ \App\Enums\ParcelStatus::PARTIAL_DELIVERED }}" data-url="{{ route('hero.requestParcelDelivery') }}"><i class="fa-regular fa-paper-plane mb-1"></i>{{ ___('label.send_otp_customer') }}</button>
            </div>

            <form action="{{ route('parcel.partial-delivered')}}" method="post" id="partial_deliveredForm">
                @csrf
                <input type="hidden" value="" name="parcel_id" id="parcel_id" class="parcel_id" />
                <div class="modal-body">

                    <div class="form-group">
                        <label class="label-style-1" for="otp">{{ ___('parcel.otp') }} <span class="text-danger">*</span> </label>
                        <input type="text" name="otp" id="otp" class="form-control input-style-1" value="{{ old('otp') }}" placeholder="{{ ___('placeholder.enter_otp') }}" autocomplete="off">
                        <small class="text-danger mt-2 errorTextBox" data-error-for="otp"> </small>
                    </div>

                    <div class="form-group">
                        <label class=" label-style-1" for="quantity">{{ ___('parcel.quantity') }} <span class="text-danger">*</span> </label>
                        <input type="number" id="quantity" name="quantity" class="form-control input-style-1" value="{{ old('quantity', 1) }}" placeholder="{{ ___('parcel.quantity') }}" oninput="this.value=this.value < 1 ? 1 : this.value" />
                        <small class="text-danger mt-2 errorTextBox" data-error-for="quantity"> </small>
                    </div>

                    <div class="form-group">
                        <label class="label-style-1" for="cash_collection">{{ ___('parcel.cash_collection') }} <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control input-style-1 cash-collection" id="cash_collection" value="{{ old('cash_collection',0) }}" name="cash_collection" placeholder="Cash amount">
                        <small class="text-danger mt-2 errorTextBox" data-error-for="cash_collection"> </small>
                    </div>

                    <div class="form-group ">
                        <label class="label-style-1" for="note">{{ ___('parcel.note')}}</label>
                        <div class="form-control-wrap deliveryman-search">
                            <textarea class="form-control input-style-1" name="note" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                    <input id="send_sms_customer" name="send_sms_customer" class="custom-control-input" type="checkbox"><span class="custom-control-label">Send SMS for customer</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                    <input id="send_sms_merchant" name="send_sms_merchant" class="custom-control-input" type="checkbox"><span class="custom-control-label">Send SMS for merchant </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </button>
                    <button type="submit" class="j-td-btn "><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
