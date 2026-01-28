<div class="modal fade" id="autogenerate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('common.salary_generate') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('salary.storeAutoGenerate') }}" method="post">
                @csrf
                <input type="hidden" value="" name="parcel_id" id="modal_parcel_id" class="modal_parcel_id" />
                <div class="modal-body">
                    <div class="form-group">
                        <label class="label-style-1" for="month">{{ ___('common.month')}}<span class="text-danger">*</span> </label>
                        <input type="month" id="month" name="month" class="form-control input-style-1" value="{{old('month',date('Y-m'))}}" required>
                        @error('month') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="j-td-btn "><i class="fa-solid fa-floppy-disk"></i> {{ ___('menus.submit') }}</button>
                    <button type="button" class="j-td-btn btn-red " data-dismiss="modal"> <i class="fa-solid fa-rectangle-xmark"></i> {{ ___('menus.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
