<?php
class DataStorage {
    private $dataFile;
    
    public function __construct() {
        $this->dataFile = __DIR__ . '/../' . DATA_FILE;
        
        // Create data directory if it doesn't exist
        $dataDir = dirname($this->dataFile);
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0755, true);
        }
        
        // Initialize empty data file if it doesn't exist
        if (!file_exists($this->dataFile)) {
            $this->saveData([]);
        }
    }
    
    /**
     * Load all scientists from storage
     */
    public function getAllScientists() {
        $data = $this->loadData();
        return $data;
    }
    
    /**
     * Get unique fields from stored scientists
     */
    public function getFields() {
        $scientists = $this->getAllScientists();
        $fields = array_unique(array_column($scientists, 'field'));
        sort($fields);
        return $fields;
    }
    
    /**
     * Add a scientist to storage
     */
    public function addScientist($scientist) {
        $scientists = $this->loadData();
        
        // Check if scientist already exists (avoid duplicates)
        foreach ($scientists as $existing) {
            if (strtolower($existing['name']) === strtolower($scientist['name']) && 
                $existing['field'] === $scientist['field']) {
                return false; // Already exists
            }
        }
        
        $scientists[] = $scientist;
        $this->saveData($scientists);
        return true;
    }
    
    /**
     * Get scientists by field
     */
    public function getScientistsByField($field) {
        $scientists = $this->getAllScientists();
        return array_filter($scientists, function($scientist) use ($field) {
            return $scientist['field'] === $field;
        });
    }
    
    /**
     * Clear all data
     */
    public function clearData() {
        $this->saveData([]);
    }
    
    /**
     * Get total count of scientists
     */
    public function getCount() {
        return count($this->getAllScientists());
    }
    
    /**
     * Load data from JSON file
     */
    private function loadData() {
        if (!file_exists($this->dataFile)) {
            return [];
        }
        
        $content = file_get_contents($this->dataFile);
        $data = json_decode($content, true);
        
        return is_array($data) ? $data : [];
    }
    
    /**
     * Save data to JSON file
     */
    private function saveData($data) {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->dataFile, $json);
    }
    
    /**
     * Search scientists by name or description
     */
    public function searchScientists($query) {
        $scientists = $this->getAllScientists();
        $query = strtolower($query);
        
        return array_filter($scientists, function($scientist) use ($query) {
            return strpos(strtolower($scientist['name']), $query) !== false ||
                   strpos(strtolower($scientist['description'] ?? ''), $query) !== false;
        });
    }
}
?>