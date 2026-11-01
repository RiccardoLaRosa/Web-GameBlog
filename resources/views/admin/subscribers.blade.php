<x-layout>

<div class="container py-5">

    <h2 class="fw-bold mb-4">Iscritti ({{ $subscriptions->total() }})</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive mb-3">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Chi</th>
                    <th>Email</th>
                    <th>Quando</th>
                    <th>Gioco</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subscriptions as $subscription)
                    <tr>
                        <td>{{ $subscription->user->name }}</td>
                        <td>{{ $subscription->user->email }}</td>
                        <td>{{ $subscription->created_at->format('d/m/Y H:i') }}</td>
                        <td><a href="{{ route('posts.show', $subscription->post) }}">{{ $subscription->post->title }}</a></td>
                        <td class="text-end">
                            <form action="{{ route('admin.subscribers.destroy', $subscription) }}" method="POST"
                                onsubmit="return confirm('Eliminare questa iscrizione?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Elimina</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nessun iscritto.</td>
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
