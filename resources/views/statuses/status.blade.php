
<li class="media mt-4 mb-4">
    <a href="{{ route('users.show', $user->id )}}">
        <img src="{{ $user->gravatar(50) }}" alt="{{ $user->name }}" class="mr-3 gravatar"/>
    </a>
    <div class="media-body">
        <h5 class="mt- mb-1">{{ $user->name }} <small> / {{ $status->created_at->diffForHumans() }}</small></h5>
        {{ $status->content }}
    </div>
</li>