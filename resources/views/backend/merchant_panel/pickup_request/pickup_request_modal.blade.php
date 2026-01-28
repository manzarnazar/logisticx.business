<div class="modal fade" id="pickup-request" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="data-modal">
            <div class="modal-header">
                <h5 class="modal-title">{{ ___('parcel.select_pickup_request') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body j-container">
                <div class="j-data-recv grid-2 ">
                    <div class="j-data-box d-inline text-center">
                        <a href="#" class="" data-toggle="modal" data-target="#regular">
                            <i class="icon-plus"></i>
                            <br>
                            <span>{{ ___('parcel.add_regular') }} </span>
                        </a>
                    </div>
                    <div class="j-data-box d-inline text-center">
                        <a href="#" class="" data-toggle="modal" data-target="#express">
                            <i class="icon-plus"></i><br>
                            <span>{{ ___('parcel.add_express') }} </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
