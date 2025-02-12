<?php

return [

    /*
     * Seznam služeb na webu u ceníku, je potřeba první změnit tady a změna se projeví na webu
     */

    'offer' => [
        'start' => [
            'Základní luxování interiéru',
            'Vyluxování zavazadlového prostoru',
            'Vyluxování koberečků',
            'Ošetření plastů proti poškrábání',
            'Vyleštění čelního skla',
        ],
        'middle' => [
            '<strong>Detailní</strong> luxování interiéru',
            'Vyluxování zavazadlového prostoru',
            'Vyčištění koberečků',
            'Ošetření plastů proti poškrábání',
            'Důkladné vyčištění párou',
            'Vyleštění oken a zrcátek',
            'Tepování sedaček a koberečků',
            'Desinfekce klimatizace',
        ],
        'deluxe' => [
            '<strong>Detailní</strong> luxování interiéru',
            'Vyluxování zavazadlového prostoru',
            'Vyčištění koberečků',
            'Ošetření plastů proti poškrábání',
            'Důkladné vyčištění párou',
            'Vyleštění všech oken z obou stran',
            'Tepování sedaček a koberečků',
            'Základní čištění kožených částí',
            'Vyčištění klimatizace s vůní po citrónu',
            'Navoskování čelního skla',
        ],
    ],

    /*
     * Seznam služeb na webu u ceníku, je potřeba první změnit tady a změna se projeví na webu
     */

    'prices' => [
        'start' => 999,
        'middle' => 2499,
        'deluxe' => 3999,
    ],

    /*
     * Tým čistění interiérů Kondrac, plnění na web zleva
     */

    'team' => [
        [
            'name' => 'Štěpán Dub',
            'position' => 'Majitel',
            'tel' => '+420 602 352 402',
            'facebook' => '',
            'instagram' => 'https://www.instagram.com/cisteni_interieru_kondrac',
        ],
    ],

    /*
     *  Administrace webu
     */
    'admin' => [
        'chartColors' => [
            '2022' => '#750fd9',
            '2023' => '#e39e49',
            '2024' => '#0ca1ca',
            '2025' => '#0d68f3',
            '2026' => '#729718',
        ],
    ],

];
