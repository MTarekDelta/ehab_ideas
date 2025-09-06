// JavaScript for Scientists Database functionality

document.addEventListener('DOMContentLoaded', function() {
    initializeFiltering();
    initializeScraping();
});

/**
 * Initialize filtering functionality
 */
function initializeFiltering() {
    // Add event listeners to filter buttons
    const filterButtons = document.querySelectorAll('nav button[onclick^="filterField"]');
    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const field = this.textContent.trim();
            filterField(field === 'All Fields' ? 'all' : field);
        });
    });
}

/**
 * Filter scientists by field
 */
function filterField(field) {
    const cards = document.querySelectorAll('.scientist-card');
    const buttons = document.querySelectorAll('nav button');
    
    // Update active button
    buttons.forEach(btn => btn.classList.remove('active'));
    
    if (field === 'all') {
        // Show all cards
        cards.forEach(card => {
            card.style.display = 'block';
            card.classList.remove('hidden');
        });
        document.getElementById('filter-all').classList.add('active');
    } else {
        // Show only cards matching the field
        cards.forEach(card => {
            const cardField = card.dataset.field;
            if (cardField === field) {
                card.style.display = 'block';
                card.classList.remove('hidden');
            } else {
                card.style.display = 'none';
                card.classList.add('hidden');
            }
        });
        
        // Find and activate the clicked button
        buttons.forEach(btn => {
            if (btn.textContent.trim() === field) {
                btn.classList.add('active');
            }
        });
    }
    
    // Update stats
    updateStats();
}

/**
 * Initialize scraping functionality
 */
function initializeScraping() {
    const scrapeBtn = document.getElementById('scrape-btn');
    if (scrapeBtn) {
        scrapeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            scrapeData();
        });
    }
}

/**
 * Scrape new scientist data
 */
function scrapeData() {
    const scrapeBtn = document.getElementById('scrape-btn');
    const originalText = scrapeBtn.innerHTML;
    
    // Show loading state
    scrapeBtn.innerHTML = '🔄 Scraping... <span class="spinner"></span>';
    scrapeBtn.disabled = true;
    scrapeBtn.classList.add('loading');
    
    // Make AJAX request to scrape.php
    fetch('scrape.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ action: 'scrape_all' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification(`Successfully scraped ${data.count} new scientists!`, 'success');
            
            // Reload page to show new data
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            showNotification('Error scraping data: ' + (data.error || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Scraping error:', error);
        showNotification('Error scraping data. Please try again.', 'error');
    })
    .finally(() => {
        // Reset button state
        scrapeBtn.innerHTML = originalText;
        scrapeBtn.disabled = false;
        scrapeBtn.classList.remove('loading');
    });
}

/**
 * Update statistics display
 */
function updateStats() {
    const visibleCards = document.querySelectorAll('.scientist-card:not(.hidden)');
    const totalCards = document.querySelectorAll('.scientist-card');
    
    // Update scientist count
    const scientistCount = document.querySelector('.stat-number');
    if (scientistCount) {
        scientistCount.textContent = visibleCards.length;
    }
    
    // Update fields count
    const fieldsCount = document.querySelectorAll('.stat-number')[1];
    if (fieldsCount && visibleCards.length > 0) {
        const visibleFields = new Set();
        visibleCards.forEach(card => {
            visibleFields.add(card.dataset.field);
        });
        fieldsCount.textContent = visibleFields.size;
    }
}

/**
 * Show notification message
 */
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 1rem;
        max-width: 400px;
        animation: slideIn 0.3s ease;
    `;
    
    notification.querySelector('button').style.cssText = `
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        margin: 0;
        line-height: 1;
    `;
    
    // Add animation keyframes if not already added
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

/**
 * Search functionality (if search input is added later)
 */
function searchScientists(query) {
    const cards = document.querySelectorAll('.scientist-card');
    const searchTerm = query.toLowerCase();
    
    cards.forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        const description = card.querySelector('.description')?.textContent.toLowerCase() || '';
        const field = card.querySelector('.field').textContent.toLowerCase();
        
        if (name.includes(searchTerm) || description.includes(searchTerm) || field.includes(searchTerm)) {
            card.style.display = 'block';
            card.classList.remove('hidden');
        } else {
            card.style.display = 'none';
            card.classList.add('hidden');
        }
    });
    
    updateStats();
}

/**
 * Sort scientists by name or field
 */
function sortScientists(criteria) {
    const grid = document.getElementById('scientists-grid');
    const cards = Array.from(grid.querySelectorAll('.scientist-card'));
    
    cards.sort((a, b) => {
        let aValue, bValue;
        
        if (criteria === 'name') {
            aValue = a.querySelector('h3').textContent;
            bValue = b.querySelector('h3').textContent;
        } else if (criteria === 'field') {
            aValue = a.querySelector('.field').textContent;
            bValue = b.querySelector('.field').textContent;
        } else if (criteria === 'year') {
            aValue = a.querySelector('.year')?.textContent || '0';
            bValue = b.querySelector('.year')?.textContent || '0';
            // Extract year numbers for proper sorting
            aValue = parseInt(aValue.match(/\d+/) || [0])[0];
            bValue = parseInt(bValue.match(/\d+/) || [0])[0];
        }
        
        return aValue < bValue ? -1 : aValue > bValue ? 1 : 0;
    });
    
    // Clear grid and re-append sorted cards
    grid.innerHTML = '';
    cards.forEach(card => grid.appendChild(card));
}

// Export functions for onclick handlers
window.filterField = filterField;
window.scrapeData = scrapeData;
window.searchScientists = searchScientists;
window.sortScientists = sortScientists;