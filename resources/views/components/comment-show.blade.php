@props([
    
    'model',
    'title' =>'Комментарии:'
    
])

    @if($model->comments->isNotEmpty())
    <h3>{{$title}}</h3>
        <ul class="list-group">
            @foreach($model->comments->sortByDesc('created_at') as $comment)
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