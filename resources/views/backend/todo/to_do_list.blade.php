<div class="modal fade" id="todoModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ ___('common.to_do_add')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('todo.store') }}" method="post" id="todoStoreForm" onsubmit="submitForm(event)">
                    @csrf

                    <div class="form-row">

                        <div class="col-12 form-group">
                            <label class=" label-style-1">{{ ___('label.title')}}<span class="text-danger">*</span> </label>
                            <input type="text" name="title" placeholder="{{ ___('placeholder.enter_title') }}" class="form-control input-style-1">
                            <small class="text-danger errorTextBox d-none mt-2" data-error-for="title"></small>
                            {{-- @error('title') <small class="text-danger mt-2">{{ $message }}</small> @enderror --}}
                        </div>

                        <div class="col-12 form-group">
                            <label class="label-style-1">{{ ___('common.description')}}</label>
                            <textarea class="form-control input-style-1" name="description" placeholder="{{ ___('placeholder.enter_description') }}"></textarea>
                            <small class="text-danger errorTextBox d-none mt-2" data-error-for="description"></small>
                            {{-- @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror --}}
                        </div>

                        <div class="col-12 col-md-7 form-group">
                            <label class="label-style-1">{{ ___('common.assign')}}<span class="text-danger">*</span> </label>
                            <select name="user_id" class="form-control input-style-1 select2 todo_assign_user" data-url="{{ route('user.search') }}" data-skip-user-type="{{ App\Enums\UserType::MERCHANT }}">
                                <option value=""></option>
                            </select>
                            <small class="text-danger errorTextBox d-none mt-2" data-error-for="user_id"></small>
                            {{-- @error('user_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror --}}
                        </div>
                        <div class="col-12 col-md-5 form-group  ">
                            <label class="label-style-1">{{ ___('common.date')}}<span class="text-danger">*</span> </label>
                            <input type="date" name="date" class="form-control input-style-1 flatpickr" value="{{old('date',date('Y-m-d'))}}">
                            <small class="text-danger errorTextBox d-none mt-2" data-error-for="date"></small>
                            {{-- @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror --}}
                        </div>
                    </div>

                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn" data-loading-text="{{ ___('label.processing') }}"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                        <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></button>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" form="todoStoreForm" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></button> --}}
            </div>
        </div>
    </div>
</div>
