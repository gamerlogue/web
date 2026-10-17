<?php

declare(strict_types=1);

/**
 * Italian dictionary for blaspsoft/blasp, which ships none. Read by the package from
 * config/languages; the other languages keep coming from its own copy.
 *
 * ponytail: a starting list of common profanity and slurs, extend it from what users report.
 */
return [
    'severity' => [
        'mild' => [
            'cretino', 'cretina',
        ],
        'moderate' => [
            'idiota', 'idioti', 'deficiente', 'deficienti', 'imbecille', 'imbecilli',
            'coglione', 'coglioni', 'cogliona', 'stronzo', 'stronza', 'stronzi', 'stronzate',
            'culo', 'culi', 'sfigato', 'sfigata',
        ],
        'high' => [
            'cazzo', 'cazzi', 'cazzata', 'cazzate', 'incazzato', 'minchia', 'minchiata',
            'merda', 'merde', 'merdoso', 'fanculo', 'vaffanculo', 'affanculo',
            'puttana', 'puttane', 'troia', 'troie', 'zoccola', 'bastardo', 'bastarda',
            'figa', 'fica', 'pompino', 'scopare', 'sborra', 'stracazzo',
            'figlio di puttana', 'testa di cazzo', 'porco dio', 'porcodio', 'dio cane', 'diocane',
        ],
        'extreme' => [
            'frocio', 'froci', 'finocchio', 'ricchione', 'ricchioni', 'lesbicona',
            'negro', 'negri', 'zingaro di merda', 'ritardato', 'ritardata', 'mongoloide',
        ],
    ],

    'profanities' => [
        'cretino', 'cretina',
        'idiota', 'idioti', 'deficiente', 'deficienti', 'imbecille', 'imbecilli',
        'coglione', 'coglioni', 'cogliona', 'stronzo', 'stronza', 'stronzi', 'stronzate',
        'culo', 'culi', 'sfigato', 'sfigata',
        'cazzo', 'cazzi', 'cazzata', 'cazzate', 'incazzato', 'minchia', 'minchiata',
        'merda', 'merde', 'merdoso', 'fanculo', 'vaffanculo', 'affanculo',
        'puttana', 'puttane', 'troia', 'troie', 'zoccola', 'bastardo', 'bastarda',
        'figa', 'fica', 'pompino', 'scopare', 'sborra', 'stracazzo',
        'figlio di puttana', 'testa di cazzo', 'porco dio', 'porcodio', 'dio cane', 'diocane',
        'frocio', 'froci', 'finocchio', 'ricchione', 'ricchioni', 'lesbicona',
        'negro', 'negri', 'zingaro di merda', 'ritardato', 'ritardata', 'mongoloide',
    ],

    // Ordinary words that contain or sound like an entry above.
    'false_positives' => [
        'culto', 'culla', 'cultura', 'calcolo', 'circolo', 'ridicolo',
        'scopa', 'scopo', 'scopi', 'scoperta', 'scoprire', 'fichi', 'fico', 'figata',
        'finocchi', 'finocchiona', 'negroni', 'bastardi senza gloria', 'troiano', 'troiani',
        'merlo', 'cazzuola', 'piscina', 'scemenza',
    ],

    'substitutions' => [
        '/a/' => ['a', '4', '@', 'à'],
        '/e/' => ['e', '3', 'è', 'é'],
        '/i/' => ['i', '1', '!', 'ì'],
        '/o/' => ['o', '0', 'ò'],
        '/u/' => ['u', 'ù', '*'],
        '/c/' => ['c', 'k'],
        '/z/' => ['z', 's'],
    ],
];
