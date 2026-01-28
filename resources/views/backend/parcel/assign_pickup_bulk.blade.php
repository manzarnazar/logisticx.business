<div class="modal fade " id="assignpickupbulk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="data-modal">

            <div class="modal-header">
                <h5 class="modal-title"> {{ ___('parcel.pickup_man_assign') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>

            <form action="{{ route('parcel.assign-pickup-bulk') }}" method="post">
                @csrf
                <div class="modal-body">

                    <div class="form-row">

                        <div class="form-group col-12 col-md-6 merchant_search">
                            <label class="label-style-1" for="pickup_bulk_merchant">{{ ___('parcel.merchant') }}</label>
                            <select id="pickup_bulk_merchant" name="merchant_id" class="form-control input-style-1 select2" data-url="{{ route('parcel.merchant.get') }}">
                                <option value=""> {{ ___('Select Merchant') }}</option>
                            </select>
                            @error('merchant_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group col-12 col-md-6  ">
                            <label class="label-style-1" for="pickupman_bulk">{{ ___('parcel.delivery_man')}}<span class="text-danger">*</span></label>
                            <select id="pickupman_bulk" class="form-control input-style-1 delivery_man_search_hub_multiple_parcel" name="delivery_man_id" data-url="{{ route('parcel.deliveryman.search') }}">
                                <option selected disabled>Select delivery man</option>
                            </select>
                            @error('delivery_man_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group col-12 col-md-6 ">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <label class="label-style-1" for="track_id">{{ ___('label.track_id')}}<span class="text-danger">*</span> </label>
                            <input id="pickup_parcel_tracking_id" type="text" name="track_id" data-url="{{ route('assign-pickup.parcel.search') }}" placeholder="Enter Tracking Id" class="form-control input-style-1">
                            <div class="search_message"></div>
                        </div>

                        <div class="form-group col-12 col-md-6  ">
                            <label class="label-style-1" for="note">{{ ___('parcel.note')}}</label>
                            <div class="form-control-wrap deliveryman-search">
                                <textarea class="form-control input-style-1" name="note"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-12 col-md-6 ">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <div id="ids"></div>
                            <small id="transfer_to_hub_track_id_not_found3" class="text-danger mt-2 d-none">{{ ___('parcel.no_parcel_found') }}</small>
                            <small id="transfer_to_hub_track_id_found3" class="text-success mt-2 d-none">{{ ___('parcel.parcel_added_successful') }}</small>
                            <small id="transfer_to_hub_track_id_already_added3" class="text-danger mt-2 d-none">{{ ___('alert.already_added') }}</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12 col-md-6">
                            <label class="custom-control custom-checkbox">
                                <input id="send_sms_pickuman" name="send_sms_pickuman" class="custom-control-input" type="checkbox"><span class="custom-control-label">{{ ___('common.send_sms_to_hero') }}</span>
                            </label>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="custom-control custom-checkbox">
                                <input id="send_sms_merchant" name="send_sms_merchant" class="custom-control-input" type="checkbox">
                                <span class="custom-control-label">{{ ___('common.send_sms_to_merchant') }} </span>
                            </label>
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
                                        <th>{{ ___('merchant.business_name')}}</th>
                                        <th>{{ ___('label.mobile')}}</th>
                                        <th>{{ ___('parcel.charge')}}</th>
                                        <th>{{ ___('label.cod')}}</th>
                                        <th>{{ ___('label.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="pickup_parcel_added">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" id="assign_pickup_btn" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></button>
                </div>

            </form>
        </div>
    </div>
</div>
