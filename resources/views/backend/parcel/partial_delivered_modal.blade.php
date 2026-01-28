<div class="modal fade" id="parcelstatus{{ \App\Enums\ParcelStatus::PARTIAL_DELIVERED }}" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('parcel.partial_delivered') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('parcel.partial-delivered') }}" method="post">
                @csrf
                <input type="hidden" value="" name="parcel_id" id="modal_parcel_id" class="modal_parcel_id" />
                <div class="modal-body">
                    {{-- quantity --}}

                    <div class="form-group">
                        <label class=" label-style-1" for="quantity">{{ ___('parcel.quantity') }} <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="quantity" name="quantity" class="form-control input-style-1"
                            value="{{ old('quantity', 1) }}" placeholder="{{ ___('parcel.quantity') }}"
                            oninput="this.value=this.value < 1 ? 1 : this.value" />
                        @error('quantity')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="label-style-1" for="cash_collection">{{ ___('parcel.cash_collection') }} </label> <span
                            class="text-danger">*</span>
                        <input type="text" class="form-control input-style-1 cash-collection" id="cash_collection"
                            value="{{ old('cash_collection', 0) }}" name="cash_collection" placeholder="Cash amount">
                        @error('cash_collection')
                            <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group ">
                        <label class="label-style-1" for="note">{{ ___('parcel.note') }}</label>
                        <div class="form-control-wrap deliveryman-search">
                            <textarea class="form-control input-style-1" name="note" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                    <input id="send_sms_customer" name="send_sms_customer" class="custom-control-input"
                                        type="checkbox"><span class="custom-control-label">{{ ___('common.send_sms_to_customer') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                    <input id="send_sms_merchant" name="send_sms_merchant" class="custom-control-input"
                                        type="checkbox"><span class="custom-control-label">{{ ___('common.send_sms_to_merchant') }} </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="j-td-btn "><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i
                            class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }} </span></button>
                </div>
            </form>
        </div>
    </div>
</div>
