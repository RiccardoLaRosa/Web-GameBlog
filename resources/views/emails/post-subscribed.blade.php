<p>Nuova iscrizione a un gioco di GameBlog.</p>
<p><strong>Chi:</strong> {{ $subscription->user->name }} ({{ $subscription->user->email }})</p>
<p><strong>Quando:</strong> {{ $subscription->created_at->format('d/m/Y H:i') }}</p>
<p><strong>Gioco:</strong> <a href="{{ route('posts.show', $subscription->post) }}">{{ $subscription->post->title }}</a></p>
