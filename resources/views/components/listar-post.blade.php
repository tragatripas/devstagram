<div>
    @if ($posts->count())

        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            @foreach ($posts as $post)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                        <img src="{{ asset('uploads/' . $post->imagen) }}" alt="imagen del posts {{ $post->titulo }}">
                        <div class="py-2 p-4">
                            <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}" class="font-bold text-gray-500">{{ $post->titulo }}</a>
                            <p class="text-sm text-gray-600">{{ Str::limit($post->descripcion, 100) }}</p>
                            <p class="text-sm text-gray-400">Publicado por: <span class="font-bold">{{ $post->user->username }}</span></p>
                            <p class="text-sm text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                </div>

            @endforeach
        </div>

        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    @else
        <p class="text-center">No hay posts todavia.</p>
    @endif
</div>