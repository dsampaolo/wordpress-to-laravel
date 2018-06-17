<?xml version="1.0" encoding="utf-8" ?>
<rss version="2.0"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:wfw="http://wellformedweb.org/CommentAPI/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
>
    <channel>
        <title>{{ config('app.name') }} - Blog Feed</title>
        <atom:link href="{{ route('wordpress-to-laravel.blog.feed') }}" rel="self" type="application/rss+xml"/>
        <link>{{ url('/') }}</link>
        <description></description>
        <lastBuildDate>{{ $posts->first()->published_at->toRfc822String() }}</lastBuildDate>
        <language>fr</language>
        <sy:updatePeriod>daily</sy:updatePeriod>
        <sy:updateFrequency>1</sy:updateFrequency>
        @foreach( $posts as $post )
            <item>
                <title>{{$post->title}}</title>
                <link>{{route('wordpress-to-laravel.blog.show', $post->slug)}}</link>
                <pubDate>{{$post->published_at->toRfc822String()}}</pubDate>
                <guid isPermaLink="false">{{ url($post->url) }}</guid>
                <description><![CDATA[{!! $post->excerpt !!}]]></description>
                <content:encoded><![CDATA[{!! $post->excerpt !!}]]></content:encoded>
            </item>
        @endforeach
    </channel>
</rss>
