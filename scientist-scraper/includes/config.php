<?php
// Configuration settings for the scientist scraper
define('DATA_FILE', 'data/scientists.json');
define('CACHE_TIME', 3600); // 1 hour cache time

// Scientific fields to scrape
$scientific_fields = [
    'Physics' => [
        'wikipedia_category' => 'Category:Physicists',
        'keywords' => ['physicist', 'physics', 'quantum', 'relativity']
    ],
    'Chemistry' => [
        'wikipedia_category' => 'Category:Chemists', 
        'keywords' => ['chemist', 'chemistry', 'molecular', 'chemical']
    ],
    'Biology' => [
        'wikipedia_category' => 'Category:Biologists',
        'keywords' => ['biologist', 'biology', 'evolution', 'genetics']
    ],
    'Mathematics' => [
        'wikipedia_category' => 'Category:Mathematicians',
        'keywords' => ['mathematician', 'mathematics', 'theorem', 'algebra']
    ],
    'Computer Science' => [
        'wikipedia_category' => 'Category:Computer_scientists',
        'keywords' => ['computer scientist', 'algorithm', 'programming', 'artificial intelligence']
    ],
    'Medicine' => [
        'wikipedia_category' => 'Category:Physicians',
        'keywords' => ['physician', 'doctor', 'medical', 'medicine']
    ],
    'Engineering' => [
        'wikipedia_category' => 'Category:Engineers',
        'keywords' => ['engineer', 'engineering', 'technology', 'innovation']
    ],
    'Astronomy' => [
        'wikipedia_category' => 'Category:Astronomers',
        'keywords' => ['astronomer', 'astronomy', 'telescope', 'space']
    ],
    'Psychology' => [
        'wikipedia_category' => 'Category:Psychologists',
        'keywords' => ['psychologist', 'psychology', 'behavior', 'mind']
    ]
];

// User agent for web scraping
define('USER_AGENT', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

// Rate limiting - delay between requests (milliseconds)
define('REQUEST_DELAY', 1000);
?>