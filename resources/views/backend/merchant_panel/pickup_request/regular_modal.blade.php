<div class="modal fade" id="regular" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="data-modal">

            <div class="modal-header">
                <h5 class="modal-title"> {{ ___('parcel.regular_pickup_request') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <form action="{{ route('merchant.panel.pickup.request.regular.store') }}" method="post" onsubmit="submitForm(event)">
                @csrf

                <input type="hidden" name="request_type" value="{{ \App\Enums\PickupRequestType::REGULAR }}">

                <div class="modal-body">
                    <div class="form-group">
                        <label class="label-style-1">{{ ___('parcel.pickup_address') }} <span class="text-danger">*</span></label>
                        {{-- <input class="form-control input-style-1" type="text" name="address" value="{{ auth()->user()->merchant->address }}" /> --}}
                        <textarea class="form-control input-style-1" name="address" placeholder="{{ ___('placeholder.address') }}"> {{ auth()->user()->merchant->address }}</textarea>
                        <small class="text-danger errorTextBox d-none mt-2" data-error-for="address"></small>
                    </div>
                    <div class="form-group">
                        <label class="label-style-1">{{ ___('parcel.parcel_quantity') }} <span class="text-danger">*</span></label>
                        <input class="form-control input-style-1" type="number" name="parcel_quantity" placeholder="{{ ___('placeholder.parcel_quantity') }}" />
                        <small class="text-danger errorTextBox d-none mt-2" data-error-for="parcel_quantity"></small>
                    </div>
                    <div class="form-group">
                        <label class="label-style-1">{{ ___('parcel.note')}} </label>
                        <textarea class="form-control input-style-1" name="note" placeholder="{{ ___('placeholder.note') }}"></textarea>
                        <small class="text-danger errorTextBox d-none mt-2" data-error-for="note"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="j-td-btn" data-loading-text="{{ ___('label.processing') }}"><i class="fa-solid fa-floppy-disk "></i> {{ ___('label.send_request') }} </button>
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i> {{ ___('label.cancel') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>
