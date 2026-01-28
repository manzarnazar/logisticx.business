<div class="modal fade" id="transfer_to_hub_multiple_parcel" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('parcel.transfer_to_hub') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('parcel.transfer-to-hub-multiple-parcel') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-row">

                        <div class="form-group col-12 col-md-6  ">
                            <label class="label-style-1" for="transfer_hub">{{ ___('hub.to_hub')}}<span class="text-danger">*</span> </label>
                            <select id="transfer_hub" class="form-control input-style-1 select2 d" name="hub_id" data-url="{{ route('parcel.transferHub') }}">
                                <option selected disabled>Select Hub</option>
                                @if (hubIncharge() == 0)
                                @foreach (hubs() as $hub)
                                <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                                @endforeach
                                @else
                                @foreach ($hubs as $hub)
                                @if (hubIncharge() != $hub->id)
                                <option value="{{ $hub->id }}">{{ $hub->name }}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                            @error('hub_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group col-12 col-md-6  ">
                            <label class="label-style-1" for="delivery_man_search">{{ ___('parcel.delivery_man')}}</label>
                            <select id="delivery_man_search_hub_multiple_parcel" class="form-control input-style-1 delivery_man_search_hub_multiple_parcel" name="delivery_man_id" data-url="{{ route('parcel.deliveryman.search') }}">
                                <option selected disabled>{{ ___('placeholder.Select') }} {{ ___('common.deliveryman') }}</option>
                            </select>
                            @error('delivery_man_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group col-12 col-md-6 ">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <label class="label-style-1" for="transfer_to_hub_track_id">{{ ___('label.track_id')}}<span class="text-danger">*</span> </label>
                            <input id="transfer_to_hub_track_id" type="text" name="tracking_id" data-url="{{ route('parcel.searchForHUbTransfer') }}" placeholder="Enter Tracking Id" class="form-control input-style-1">
                            <div class="search_message"></div>
                        </div>


                        <div class="form-group col-12 col-md-6  ">
                            <label class="label-style-1" for="note">{{ ___('parcel.note')}}</label>
                            <div class="form-control-wrap deliveryman-search">
                                <textarea class="form-control input-style-1" name="note"></textarea>
                            </div>
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
                                        <th>{{ ___('label.hub')}}</th>
                                        <th>{{ ___('label.merchant')}}</th>
                                        <th>{{ ___('label.mobile')}}</th>
                                        <th>{{ ___('parcel.charge')}}</th>
                                        <th>{{ ___('label.cod')}}</th>
                                        <th>{{ ___('label.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="t_body">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="transfer_to_hub_multiple_parcel_button" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
