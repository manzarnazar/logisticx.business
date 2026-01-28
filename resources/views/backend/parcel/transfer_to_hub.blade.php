<div class="modal fade" id="parcelstatus{{ \App\Enums\ParcelStatus::TRANSFER_TO_HUB }}" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('parcel.transfer_to_hub') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('parcel.transfer-to-hub') }}" method="post">
                @csrf
                <input type="hidden" value="" name="parcel_id" id="modal_parcel_id" class="modal_parcel_id" />
                <div class="modal-body">

                    <div class="form-row">

                        <div class="form-group col-12">
                            <label class="label-style-1" for="transfer-hub">{{ ___('hub.to_hub') }}</label> <span
                                class="text-danger">*</span>
                            <select class="form-control input-style-1 select2" id="transfer-hub" name="hub_id"
                                data-url="{{ route('parcel.transferHub') }}">
                                <option disabled selected>{{ ___('placeholder.select2') }}</option>
                            </select>
                            @error('hub_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="form-group col-12">
                            <label class="label-style-1" for="delivery_man_search">{{ ___('parcel.deliveryman') }}</label>
                            <select id="delivery_man_search_hub" class="form-control input-style-1 select2 delivery_man_search_hub"
                                name="delivery_man_id" data-url="{{ route('parcel.deliveryman.search') }}">
                                <option disabled selected>{{ ___('placeholder.select2') }}</option>
                            </select>
                            @error('delivery_man_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label class="label-style-1" for="note">{{ ___('parcel.note') }}</label>
                            <textarea class="form-control input-style-1" name="note"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i
                            class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </button>
                </div>
            </form>
        </div>
    </div>
</div>
