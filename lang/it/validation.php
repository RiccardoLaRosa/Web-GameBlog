<?php

// Solo le regole usate dai form del sito: per le altre vale il testo inglese di riserva.
return [
    'accepted' => 'Il campo :attribute deve essere accettato.',
    'array' => 'Il campo :attribute non è valido.',
    'confirmed' => 'La conferma del campo :attribute non corrisponde.',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido.',
    'exists' => 'Il valore selezionato per :attribute non è valido.',
    'image' => "Il campo :attribute deve essere un'immagine.",
    'max' => [
        'array' => 'Il campo :attribute non può avere più di :max elementi.',
        'file' => 'Il campo :attribute non può superare :max kilobyte.',
        'numeric' => 'Il campo :attribute non può essere maggiore di :max.',
        'string' => 'Il campo :attribute non può superare :max caratteri.',
    ],
    'min' => [
        'array' => 'Il campo :attribute deve avere almeno :min elementi.',
        'file' => 'Il campo :attribute deve essere di almeno :min kilobyte.',
        'numeric' => 'Il campo :attribute deve essere almeno :min.',
        'string' => 'Il campo :attribute deve contenere almeno :min caratteri.',
    ],
    'password' => [
        'letters' => 'Il campo :attribute deve contenere almeno una lettera.',
        'mixed' => 'Il campo :attribute deve contenere almeno una maiuscola e una minuscola.',
        'numbers' => 'Il campo :attribute deve contenere almeno un numero.',
        'symbols' => 'Il campo :attribute deve contenere almeno un simbolo.',
        'uncompromised' => 'Questa :attribute compare in una fuga di dati: scegline una diversa.',
    ],
    'required' => 'Il campo :attribute è obbligatorio.',
    'string' => 'Il campo :attribute deve essere un testo.',
    'unique' => 'Il valore del campo :attribute è già in uso.',
    'uploaded' => 'Il caricamento del campo :attribute non è riuscito.',

    'attributes' => [
        'name' => 'nome',
        'email' => 'email',
        'password' => 'password',
        'title' => 'titolo',
        'description' => 'descrizione',
        'image' => 'immagine',
        'category_id' => 'categoria',
    ],
];
