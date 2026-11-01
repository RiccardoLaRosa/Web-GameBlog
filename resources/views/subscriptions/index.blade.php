<x-layout>

<div class="container py-5">

    <h2 class="fw-bold mb-4">Le mie iscrizioni</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive mb-3">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Gioco</th>
                    <th>Categoria</th>
                    <th>Iscritto il</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subscriptions as $subscription)
                    <tr>
                        <td><a href="{{ route('posts.show', $subscription->post) }}">{{ $subscription->post->title }}</a></td>
                        <td>{{ $subscription->post->category?->name ?? '-' }}</td>
                        <td>{{ $subscription->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <form action="{{ route('posts.unsubscribe', $subscription->post) }}" method="POST"
                                onsubmit="return confirm('Annullare questa iscrizione?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Annulla iscrizione</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Non sei iscritto a nessun gioco. <a href="{{ route('posts.index') }}">Scopri i giochi</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $subscriptions->links() }}
    </div>

</div>
</x-layout>
