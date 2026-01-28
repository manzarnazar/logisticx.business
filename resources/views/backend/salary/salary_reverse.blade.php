<div class="modal fade" id="reverseModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ ___('label.reverse_salary_pay')}}</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span> </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('salary.pay.reverse') }}" method="post">
                    @csrf

                    <input type="hidden" value="" name="id" id="id" />

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="note">{{ ___('label.note')}}</label>
                            <textarea class="form-control input-style-1" name="note" rows="5" id="note" placeholder="{{ ___('placeholder.note')}}"></textarea>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i> <span>{{ ___('label.submit') }}</span></button>
                        <button type="button" class="j-td-btn btn-red" data-dismiss="modal"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
