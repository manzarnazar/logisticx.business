<div class="modal fade " id="assign_return_merchant" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="data-modal">

            <div class="modal-header">
                <h5 class="modal-title"> {{ ___('parcel.return_assign_to_merchant') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('parcel.assign-return-to-merchant-bulk') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-row">

                        <div class="form-group col-12 col-md-6  merchant_search">
                            <label class="label-style-1" for="return_merchant_bulk_merchant">{{ ___('parcel.merchant') }}</label>
                            <select id="return_merchant_bulk_merchant" name="merchant_id" class="form-control input-style-1 select2" data-url="{{ route('parcel.merchant.get') }}">
                                <option value=""> {{ ___('Select Merchant') }}</option>
                            </select>
                            @error('merchant_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label class="label-style-1" for="return_todeliveryman_bulk">{{ ___('parcel.delivery_man')}}<span class="text-danger">*</span></label>
                            <select id="return_todeliveryman_bulk" class="form-control input-style-1 delivery_man_search_hub_multiple_parcel" name="delivery_man_id" data-url="{{ route('parcel.deliveryman.search') }}">
                                <option value=""></option>
                            </select>
                            @error('delivery_man_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <label class="label-style-1" for="return_parcel_tracking_id">{{ ___('label.track_id')}}<span class="text-danger">*</span> </label>
                            <input id="return_parcel_tracking_id" type="text" name="track_id" data-url="{{ route('assign-return-to-merchant.parcel.search') }}" placeholder="Enter Tracking Id" class="form-control input-style-1">
                            <div class="search_message"></div>
                        </div>

                        <div class="form-group col-12 col-md-6  ">
                            <label class="label-style-1" for="return_date">{{ ___('label.date')}}<span class="text-danger">*</span> </label>
                            <input id="return_date" type="date" name="date" data-toggle="datepicker" data-parsley-trigger="change" placeholder="yyyy-mm-dd" class="form-control input-style-1 flatpickr">
                        </div>

                        <div class="form-group col-12 col-md-6   ">
                            <label class="label-style-1" for="note">{{ ___('parcel.note')}}</label>
                            <div class="form-control-wrap deliveryman-search">
                                <textarea class="form-control input-style-1" name="note"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-12 col-md-6 align-self-center">
                            <label class="custom-control custom-checkbox">
                                <input id="send_sms" name="send_sms" class="custom-control-input" type="checkbox"><span class="custom-control-label">Send SMS</span>
                            </label>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <div id="ids"></div>
                            <small id="transfer_to_hub_track_id_not_found4" class="text-danger mt-2 d-none">{{ ___('parcel.no_parcel_found') }}</small>
                            <small id="transfer_to_hub_track_id_found4" class="text-success mt-2 d-none"> {{ ___('parcel.parcel_added_successful') }} </small>
                            <small id="transfer_to_hub_track_id_already_added4" class="text-danger mt-2 d-none">{{ ___('alert.already_added') }}</small>
                        </div>

                    </div>
                    <div class="border"></div>
                    <div class="row px-3">
                        <div class="table-responsive">
                            <table class="table  ">
                                <thead class="bg">
                                    <tr>
                                        <th>{{ ___('label.id') }}</th>
                                        <th>{{ ___('merchant.track_id')}}</th>
                                        <th>{{ ___('label.merchant')}}</th>
                                        <th>{{ ___('label.mobile')}}</th>
                                        <th>{{ ___('parcel.charge')}}</th>
                                        <th>{{ ___('label.cod')}}</th>
                                        <th>{{ ___('label.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="return_parcel_added">
                                </tbody>
                            </table>
                            <div class="table-responsive">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="assign_return_merchant_btn" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                        <button type="button" class="j-td-btn btn-red" data-dismiss="modal"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
