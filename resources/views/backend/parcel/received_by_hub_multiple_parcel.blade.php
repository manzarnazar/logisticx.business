<div class="modal fade" id="received_by_hub_multiple_parcel" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title"> {{ ___('parcel.received_by_hub') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <form action="{{ route('parcel.received-by-mulbiple-hub') }}" method="post">
                @csrf
                <input type="hidden" value="" name="parcel_id" id="modal_parcel_id" class="modal_parcel_id" />
                <div class="modal-body">
                    <div class="form-row">

                        <div class="form-group col-12 col-md-6  ">
                            <label class="label-style-1" for="received_transfer-hub">{{ ___('label.hub')}}<span class="text-danger">*</span> </label>
                            <select id="received_transfer-hub" class="form-control input-style-1 select2" name="from_hub_id" data-url="{{ route('parcel.transferHub') }}">
                                <option value=""></option>
                                @foreach (hubs() as $hub)
                                <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                                @endforeach
                            </select>
                            @error('hub_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group col-12 col-md-6 multiple-recived-by-hub ">
                            <label class="label-style-1" for="received_track_id">{{ ___('label.track_id')}}<span class="text-danger">*</span> </label>
                            <input id="received_track_id" name="track_id" placeholder="Enter Tracking Id" data-url="{{ route('parcel.received-by-hub-search') }}" class="form-control input-style-1" />
                        </div>

                        <div class="form-group col-12 col-md-6 ">
                            <label class="label-style-1" for="note">{{ ___('label.note')}}</label>
                            <textarea name="note" id="note" class="form-control input-style-1"></textarea>
                        </div>

                        <div class="form-group col-12 col-md-6 ">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <div id="ids"></div>
                            <small id="transfer_to_hub_track_id_not_found2" class="text-danger mt-2 d-none">{{ ___('parcel.no_parcel_found') }}</small>
                            <small id="transfer_to_hub_track_id_found2" class="text-success mt-2 d-none">{{ ___('parcel.parcel_added_successful') }}</small>
                            <small id="transfer_to_hub_track_id_already_added2" class="text-danger mt-2 d-none">{{ ___('alert.already_added') }}</small>
                        </div>

                    </div>

                    <div class="border"></div>

                    <div class="row px-3">
                        <div class="table-responsive">
                            <table class="table  ">
                                <thead class="bg">
                                    <tr>
                                        <th>{{ ___('label.id')}}</th>
                                        <th>{{ ___('merchant.track_id')}}</th>
                                        <th>{{ ___('label.merchant')}}</th>
                                        <th>{{ ___('label.mobile')}}</th>
                                        <th>{{ ___('parcel.charge')}}</th>
                                        <th>{{ ___('label.cod')}}</th>
                                        <th>{{ ___('label.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="received_trakings_ids">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></button>
                    <button type="submit" class="j-td-btn  "> <i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
