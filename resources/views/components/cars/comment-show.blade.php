@props([
    
    'car',
    
])

<h3>Комментарии к машине:</h3>
    @if($car->comments->isNotEmpty())
        <ul class="list-group">
            @foreach($car->comments->sortByDesc('created_at') as $comment)
                <li class="list-group-item">
                    <strong>{{ $comment->author ?? 'Гость' }}:</strong>
                    <p>{{ $comment->comment }}</p>
                    <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                </li>
            @endforeach
        </ul>
    @else
        <p><em>Комментариев пока нет.</em></p>
    @endif