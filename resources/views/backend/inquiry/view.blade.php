<div class="m-1">

    <div class="form-input-header">
        <h4 class="title-site pb-3 mb-3"> {{ ___('menus.customer_inquiry') }} </h4>
    </div>

    <div>

        <ul class="j-eml-list">
            <li>
                <h6 class="heading-6">{{___('label.name')}}</h6>
                <span>{{$inquiry->name}}</span>
            </li>
            <li>
                <h6 class="heading-6">{{___('label.email')}}</h6>
                <span>{{$inquiry->email}}</span>
            </li>
            <li>
                <h6 class="heading-6">{{___('label.phone')}}</h6>
                <span>{{$inquiry->phone}}</span>
            </li>
            <li>
                <h6 class="heading-6">{{___('label.date')}}</h6>
                <span>{{ dateFormat($inquiry->created_at) }}</span>

            </li>
            <li>
                <h6 class="heading-6">{{___('label.message')}}</h6>
                <span>{{$inquiry->message}}</span>
            </li>
        </ul>
        
    </div>

</div>
