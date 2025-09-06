<?php
header('Content-Type: application/json');
require_once 'includes/config.php';
require_once 'includes/ScientistScraper.php';
require_once 'includes/DataStorage.php';

// Handle AJAX requests for scraping
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action'])) {
        switch ($input['action']) {
            case 'scrape_all':
                try {
                    $scraper = new ScientistScraper();
                    $count = $scraper->scrapeAllFields();
                    
                    echo json_encode([
                        'success' => true,
                        'count' => $count,
                        'message' => "Successfully scraped {$count} scientists"
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'error' => $e->getMessage()
                    ]);
                }
                break;
                
            case 'scrape_field':
                if (isset($input['field'])) {
                    try {
                        $scraper = new ScientistScraper();
                        $count = $scraper->scrapeField($input['field']);
                        
                        echo json_encode([
                            'success' => true,
                            'count' => $count,
                            'message' => "Successfully scraped {$count} scientists from {$input['field']}"
                        ]);
                    } catch (Exception $e) {
                        echo json_encode([
                            'success' => false,
                            'error' => $e->getMessage()
                        ]);
                    }
                } else {
                    echo json_encode([
                        'success' => false,
                        'error' => 'Field parameter required'
                    ]);
                }
                break;
                
            case 'clear_data':
                try {
                    $storage = new DataStorage();
                    $storage->clearData();
                    
                    echo json_encode([
                        'success' => true,
                        'message' => 'Database cleared successfully'
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'error' => $e->getMessage()
                    ]);
                }
                break;
                
            default:
                echo json_encode([
                    'success' => false,
                    'error' => 'Unknown action'
                ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'No action specified'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Only POST requests allowed'
    ]);
}
?>