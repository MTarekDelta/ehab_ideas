<?php
require_once 'includes/config.php';
require_once 'includes/ScientistScraper.php';
require_once 'includes/DataStorage.php';

$scraper = new ScientistScraper();
$storage = new DataStorage();

// Get scraped data or load from storage
$scientists = $storage->getAllScientists();
$fields = $storage->getFields();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scientists Database - Discover Scientists Across All Fields</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Scientists Database</h1>
        <p>Discover notable scientists across various fields of study</p>
    </header>

    <nav>
        <div class="nav-container">
            <button id="scrape-btn" onclick="scrapeData()">🔄 Update Database</button>
            <button id="filter-all" onclick="filterField('all')" class="active">All Fields</button>
            <?php foreach ($fields as $field): ?>
                <button onclick="filterField('<?php echo htmlspecialchars($field); ?>')"><?php echo htmlspecialchars($field); ?></button>
            <?php endforeach; ?>
        </div>
    </nav>

    <main>
        <div class="stats">
            <div class="stat-item">
                <span class="stat-number"><?php echo count($scientists); ?></span>
                <span class="stat-label">Total Scientists</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo count($fields); ?></span>
                <span class="stat-label">Fields Covered</span>
            </div>
        </div>

        <div class="scientists-grid" id="scientists-grid">
            <?php foreach ($scientists as $scientist): ?>
                <div class="scientist-card" data-field="<?php echo htmlspecialchars($scientist['field']); ?>">
                    <h3><?php echo htmlspecialchars($scientist['name']); ?></h3>
                    <p class="field"><?php echo htmlspecialchars($scientist['field']); ?></p>
                    <?php if (!empty($scientist['description'])): ?>
                        <p class="description"><?php echo htmlspecialchars($scientist['description']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($scientist['birth_year'])): ?>
                        <p class="year">Born: <?php echo htmlspecialchars($scientist['birth_year']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($scientists)): ?>
            <div class="empty-state">
                <h2>No Scientists Found</h2>
                <p>Click "Update Database" to scrape scientist data from various sources.</p>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>Data scraped from various public sources including Wikipedia and academic institutions.</p>
        <p>Last updated: <?php echo date('Y-m-d H:i:s'); ?></p>
    </footer>

    <script src="assets/script.js"></script>
</body>
</html>