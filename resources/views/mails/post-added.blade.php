<p>
    New Post - <a href="{{ url('/') }}/posts/{{$post->id}}">{{$post->title}}</a> - Added To - <a href="{{ url('/') }}/category/{{$post->category->id}}">{{$post->category->name}}</a> - By - {{ $post->user->name }} -
</p>