<div class="modal fade" id="express" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title"> {{ ___('parcel.express_pickup_request') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <form action="{{ route('merchant.panel.pickup.request.express.store') }}" method="post" onsubmit="submitForm(event)">
                @csrf
                <input type="hidden" name="request_type" value="{{ \App\Enums\PickupRequestType::EXPRESS }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="label-style-1">{{ ___('label.name') }} <span class="text-danger">*</span> </label>
                            <input class="form-control input-style-1" type="text" name="name" placeholder="{{ ___('placeholder.name') }}" />
                            <small class="text-danger errorTextBox d-none mt-2" data-error-for="name"></small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="label-style-1">{{ ___('label.address') }} <span class="text-danger">*</span> </label>
                            <input class="form-control input-style-1" type="text" name="address" placeholder="{{ ___('placeholder.address') }}" />
                            <small class="text-danger errorTextBox d-none mt-2" data-error-for="address"></small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="label-style-1">{{ ___('label.phone') }} <span class="text-danger">*</span> </label>
                            <input class="form-control input-style-1" type="tel" name="phone" placeholder="{{ ___('placeholder.phone') }}" />
                            <small class="text-danger errorTextBox d-none mt-2" data-error-for="phone"></small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="label-style-1">{{ ___('parcel.cod_amount') }}</label>
                            <input class="form-control input-style-1" type="number" step="any" name="cod_amount" placeholder="{{ ___('placeholder.cod_amount') }}" />
                            <small class="text-danger errorTextBox d-none mt-2" data-error-for="cod_amount"></small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="label-style-1">{{ ___('parcel.invoice') }}</label>
                            <input class="form-control input-style-1" type="text" name="invoice" placeholder="{{ ___('placeholder.invoice') }}" />
                            <small class="text-danger errorTextBox d-none mt-2" data-error-for="invoice"></small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="label-style-1">{{ ___('parcel.weight') }}(KG)</label>
                            <input class="form-control input-style-1" type="number" step="any" name="weight" placeholder="{{ ___('placeholder.weight') }}" />
                            <small class="text-danger errorTextBox d-none mt-2" data-error-for="weight"></small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="label-style-1">{{ ___('parcel.note')}}</label>
                            <textarea class="form-control input-style-1" name="note" placeholder="{{ ___('placeholder.note') }}"></textarea>
                            <small class="text-danger errorTextBox d-none mt-2" data-error-for="note"></small>
                        </div>
                        <div class="col-md-12 form-group">
                            <div>
                                <div class="form-check justify-content-start mb-0 ">
                                    <input class="form-check-input position-relative ml-0 mt-0" type="checkbox" value="1" id="exchange" name="exchange">
                                    <label class="label-style-1 mb-0 pl-2 pt-2" class="form-check-label" for="exchange"> {{ ___('parcel.exchange_parcel') }} </label>
                                </div>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="exchange"></small>
                            </div>
                        </div>
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
