<x-layout>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-12 col-xl-10">

            <div class="bg-white rounded-4 shadow-sm p-4">

                <h2 class="fw-bold mb-4">Privacy Policy</h2>

                <h5 class="fw-bold">Titolare del trattamento</h5>
                <p>
                    {{ config('app.privacy_owner_name') ?: '[da completare]' }}<br>
                    Contatto:
                    @if (config('app.privacy_owner_email'))
                        <a href="mailto:{{ config('app.privacy_owner_email') }}">{{ config('app.privacy_owner_email') }}</a>
                    @else
                        [da completare]
                    @endif
                </p>

                <h5 class="fw-bold">Dati trattati</h5>
                <ul>
                    <li>Nome, email e password dell'account, indicati alla registrazione. La password è salvata in forma cifrata.</li>
                    <li>Articolo a cui ti iscrivi, data e ora dell'iscrizione e del consenso.</li>
                    <li>Dati tecnici necessari al funzionamento del sito, come l'indirizzo IP usato per limitare gli abusi.</li>
                </ul>

                <h5 class="fw-bold">Finalità</h5>
                <p>
                    I dati servono a gestire il tuo account e a registrare la tua iscrizione all'articolo.
                    Non vengono usati per inviarti email, newsletter o altre comunicazioni.
                </p>

                <h5 class="fw-bold">Base giuridica</h5>
                <p>
                    Il trattamento si basa sul consenso per l'iscrizione all'articolo e sulla necessità di fornire
                    il servizio richiesto per la gestione dell'account.
                </p>

                <h5 class="fw-bold">Conservazione</h5>
                <ul>
                    <li>L'iscrizione è conservata finché non la annulli o finché non viene eliminata dall'amministratore o insieme al tuo account.</li>
                    <li>L'account è conservato finché non ne chiedi la cancellazione al titolare.</li>
                    <li>Ogni nuova iscrizione viene annotata anche nei registri tecnici del server con il tuo nome e la tua email. Questi registri sono cancellati dopo 14 giorni.</li>
                </ul>

                <h5 class="fw-bold">Chi può vedere i dati</h5>
                <p>
                    L'amministratore del sito vede chi si è iscritto, quando e a quale articolo.
                    I dati si trovano sui server del fornitore di hosting del sito.
                </p>

                <h5 class="fw-bold">Cookie</h5>
                <p>
                    Il sito usa solo i cookie tecnici necessari per l'accesso e per la sicurezza dei form.
                </p>

                <h5 class="fw-bold">I tuoi diritti</h5>
                <p>
                    Puoi chiedere al titolare l'accesso, la rettifica, la cancellazione, la limitazione o la portabilità
                    dei tuoi dati e puoi opporti al trattamento. Puoi revocare il consenso in qualsiasi momento annullando
                    l'iscrizione dalla sezione "Le mie iscrizioni". Puoi anche presentare reclamo al Garante per la
                    protezione dei dati personali.
                </p>

            </div>

        </div>

    </div>

</div>

</x-layout>
