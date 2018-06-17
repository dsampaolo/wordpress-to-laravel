<div class="row" style="padding-bottom:20px">
    <div class="col-md-3">
        <img src="{{ $post->image }}" class="img-responsive"/>
    </div>
    <div class="col-md-9">
        <h2 style="margin-top:0; font-size:1.6em; line-height: 1.2em">
            <a href="{{ $post->url }}" class="blue">
                {!! $post->title !!}
            </a>
        </h2>
        <p>{!! $post->excerpt !!}</p>
    </div>
</div>