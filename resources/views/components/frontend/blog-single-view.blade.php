<div class="swiper-slide">
    <div class="blog-single-2">
        
        <div class="blog-pic-2">
            <a href="{{ route('frontend.blog-single', $blog->slug) }}">
                <img class="object-fit-cover w-100 h-200px" src="{{ getImage($blog->upload, 'image_two','default-image-80x80.png') }}" alt="image">
            </a>
        </div>

        <div class="blog-desc-2">
            
            <ul class="blog-meta-2">
                <li> <i class="ti-timer"></i> <span>{{dateFormat($blog->date)}}</span> </li>
                <li> <i class="ti-user"></i> <span>{{@$blog->user->name}}</span> </li>
            </ul>

            <div class="blog-text">
                <a href="{{ route('frontend.blog-single', $blog->slug) }}">
                    <h5 class="heading-5"> {{ Str::limit($blog->title, 40) }} </h5>
                </a>
                <p> {!! Str::limit(strip_tags($blog->description), 75) !!} </p>
                <a href="{{ route('frontend.blog-single',$blog->slug) }}" class="blog-btnn"> {{ ___('label.read_more')}} <i class="ti-arrow-right"></i> </a>
            </div>
        </div>
    </div>
</div>
