<?php
class ScientistScraper {
    private $storage;
    private $scientific_fields;
    
    public function __construct() {
        global $scientific_fields;
        $this->storage = new DataStorage();
        $this->scientific_fields = $scientific_fields;
    }
    
    /**
     * Scrape scientists from all configured fields
     */
    public function scrapeAllFields() {
        $totalScraped = 0;
        
        foreach ($this->scientific_fields as $field => $config) {
            $scraped = $this->scrapeField($field);
            $totalScraped += $scraped;
            
            // Rate limiting between fields
            usleep(REQUEST_DELAY * 1000);
        }
        
        return $totalScraped;
    }
    
    /**
     * Scrape scientists from a specific field
     */
    public function scrapeField($field) {
        if (!isset($this->scientific_fields[$field])) {
            return 0;
        }
        
        $config = $this->scientific_fields[$field];
        $scientists = [];
        
        // Scrape from Wikipedia
        $wikiScientists = $this->scrapeWikipediaField($field, $config);
        $scientists = array_merge($scientists, $wikiScientists);
        
        // Store scraped scientists
        $count = 0;
        foreach ($scientists as $scientist) {
            if ($this->storage->addScientist($scientist)) {
                $count++;
            }
        }
        
        return $count;
    }
    
    /**
     * Scrape scientists from Wikipedia for a specific field
     */
    private function scrapeWikipediaField($field, $config) {
        $scientists = [];
        
        // For this example, we'll use a simplified approach
        // In a real implementation, you'd parse Wikipedia category pages
        $sampleScientists = $this->getSampleScientists($field);
        
        foreach ($sampleScientists as $scientistData) {
            $scientist = [
                'name' => $scientistData['name'],
                'field' => $field,
                'description' => $scientistData['description'] ?? '',
                'birth_year' => $scientistData['birth_year'] ?? '',
                'source' => 'Wikipedia',
                'scraped_at' => date('Y-m-d H:i:s')
            ];
            
            $scientists[] = $scientist;
        }
        
        return $scientists;
    }
    
    /**
     * Get sample scientists for demonstration
     * In a real implementation, this would be replaced with actual scraping
     */
    private function getSampleScientists($field) {
        $samples = [
            'Physics' => [
                ['name' => 'Albert Einstein', 'description' => 'Theoretical physicist, developed theory of relativity', 'birth_year' => '1879'],
                ['name' => 'Marie Curie', 'description' => 'Physicist and chemist, pioneer in radioactivity research', 'birth_year' => '1867'],
                ['name' => 'Stephen Hawking', 'description' => 'Theoretical physicist, expert on black holes', 'birth_year' => '1942'],
                ['name' => 'Richard Feynman', 'description' => 'Theoretical physicist, quantum electrodynamics', 'birth_year' => '1918'],
                ['name' => 'Niels Bohr', 'description' => 'Physicist, contributions to atomic structure and quantum theory', 'birth_year' => '1885']
            ],
            'Chemistry' => [
                ['name' => 'Dmitri Mendeleev', 'description' => 'Chemist, created the periodic table', 'birth_year' => '1834'],
                ['name' => 'Linus Pauling', 'description' => 'Chemist, work on chemical bonding', 'birth_year' => '1901'],
                ['name' => 'Dorothy Hodgkin', 'description' => 'Chemist, X-ray crystallography pioneer', 'birth_year' => '1910'],
                ['name' => 'Robert Woodward', 'description' => 'Organic chemist, synthetic chemistry', 'birth_year' => '1917'],
                ['name' => 'Rosalind Franklin', 'description' => 'Chemist, X-ray crystallography of DNA', 'birth_year' => '1920']
            ],
            'Biology' => [
                ['name' => 'Charles Darwin', 'description' => 'Naturalist, theory of evolution', 'birth_year' => '1809'],
                ['name' => 'Gregor Mendel', 'description' => 'Biologist, father of genetics', 'birth_year' => '1822'],
                ['name' => 'Barbara McClintock', 'description' => 'Geneticist, discovered genetic transposition', 'birth_year' => '1902'],
                ['name' => 'Francis Crick', 'description' => 'Molecular biologist, co-discovered DNA structure', 'birth_year' => '1916'],
                ['name' => 'Jane Goodall', 'description' => 'Primatologist, studied chimpanzees', 'birth_year' => '1934']
            ],
            'Mathematics' => [
                ['name' => 'Isaac Newton', 'description' => 'Mathematician and physicist, calculus', 'birth_year' => '1643'],
                ['name' => 'Leonhard Euler', 'description' => 'Mathematician, graph theory and analysis', 'birth_year' => '1707'],
                ['name' => 'Emmy Noether', 'description' => 'Mathematician, abstract algebra', 'birth_year' => '1882'],
                ['name' => 'Srinivasa Ramanujan', 'description' => 'Mathematician, number theory', 'birth_year' => '1887'],
                ['name' => 'Alan Turing', 'description' => 'Mathematician, theoretical computer science', 'birth_year' => '1912']
            ],
            'Computer Science' => [
                ['name' => 'Ada Lovelace', 'description' => 'First computer programmer', 'birth_year' => '1815'],
                ['name' => 'John von Neumann', 'description' => 'Computer scientist, von Neumann architecture', 'birth_year' => '1903'],
                ['name' => 'Grace Hopper', 'description' => 'Computer scientist, developed first compiler', 'birth_year' => '1906'],
                ['name' => 'Donald Knuth', 'description' => 'Computer scientist, algorithms analysis', 'birth_year' => '1938'],
                ['name' => 'Tim Berners-Lee', 'description' => 'Computer scientist, invented the World Wide Web', 'birth_year' => '1955']
            ],
            'Medicine' => [
                ['name' => 'Hippocrates', 'description' => 'Ancient Greek physician, father of medicine', 'birth_year' => '460 BC'],
                ['name' => 'Alexander Fleming', 'description' => 'Physician, discovered penicillin', 'birth_year' => '1881'],
                ['name' => 'Jonas Salk', 'description' => 'Physician, developed polio vaccine', 'birth_year' => '1914'],
                ['name' => 'Florence Nightingale', 'description' => 'Nurse, founder of modern nursing', 'birth_year' => '1820'],
                ['name' => 'Andreas Vesalius', 'description' => 'Physician, father of modern anatomy', 'birth_year' => '1514']
            ],
            'Engineering' => [
                ['name' => 'Nikola Tesla', 'description' => 'Electrical engineer, AC power systems', 'birth_year' => '1856'],
                ['name' => 'Thomas Edison', 'description' => 'Inventor and engineer, light bulb and phonograph', 'birth_year' => '1847'],
                ['name' => 'Gustave Eiffel', 'description' => 'Civil engineer, designed Eiffel Tower', 'birth_year' => '1832'],
                ['name' => 'Hedy Lamarr', 'description' => 'Inventor, frequency-hopping spread spectrum', 'birth_year' => '1914'],
                ['name' => 'James Watt', 'description' => 'Mechanical engineer, improved steam engine', 'birth_year' => '1736']
            ],
            'Astronomy' => [
                ['name' => 'Galileo Galilei', 'description' => 'Astronomer, telescope observations', 'birth_year' => '1564'],
                ['name' => 'Johannes Kepler', 'description' => 'Astronomer, laws of planetary motion', 'birth_year' => '1571'],
                ['name' => 'Edwin Hubble', 'description' => 'Astronomer, expanding universe', 'birth_year' => '1889'],
                ['name' => 'Carl Sagan', 'description' => 'Astronomer, planetary scientist', 'birth_year' => '1934'],
                ['name' => 'Vera Rubin', 'description' => 'Astronomer, dark matter research', 'birth_year' => '1928']
            ],
            'Psychology' => [
                ['name' => 'Sigmund Freud', 'description' => 'Psychologist, psychoanalysis founder', 'birth_year' => '1856'],
                ['name' => 'B.F. Skinner', 'description' => 'Psychologist, behaviorism', 'birth_year' => '1904'],
                ['name' => 'Jean Piaget', 'description' => 'Psychologist, cognitive development theory', 'birth_year' => '1896'],
                ['name' => 'Albert Bandura', 'description' => 'Psychologist, social learning theory', 'birth_year' => '1925'],
                ['name' => 'Elizabeth Loftus', 'description' => 'Psychologist, memory research', 'birth_year' => '1944']
            ]
        ];
        
        return $samples[$field] ?? [];
    }
    
    /**
     * Make HTTP request with proper headers
     */
    private function makeRequest($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            return $response;
        }
        
        return false;
    }
}
?>