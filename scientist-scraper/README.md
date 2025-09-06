# Scientists Database - Web Scraper

A dynamic website that scrapes and displays information about notable scientists from various fields of study.

![Website Screenshot](https://github.com/user-attachments/assets/2fd92598-5b39-41f6-ac46-493ba67d392a)

## Features

- **Multi-field Coverage**: Covers 9 scientific fields including Physics, Chemistry, Biology, Mathematics, Computer Science, Medicine, Engineering, Astronomy, and Psychology
- **Dynamic Scraping**: Real-time web scraping functionality with "Update Database" button
- **Interactive Filtering**: Filter scientists by specific fields with dynamic counters
- **Responsive Design**: Beautiful, responsive grid layout that works on all devices
- **Rich Data Display**: Shows scientist names, descriptions, birth years, and field classifications
- **Data Persistence**: JSON-based storage system for scraped data

## Scientific Fields Covered

1. **Physics** - Theoretical and experimental physicists
2. **Chemistry** - Chemists and chemical researchers
3. **Biology** - Biologists, geneticists, and life scientists
4. **Mathematics** - Mathematicians and mathematical theorists
5. **Computer Science** - Computer scientists and programmers
6. **Medicine** - Physicians, medical researchers, and healthcare pioneers
7. **Engineering** - Engineers and inventors across all disciplines
8. **Astronomy** - Astronomers and space scientists
9. **Psychology** - Psychologists and behavioral scientists

## Technology Stack

- **Backend**: PHP 8.3
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Data Storage**: JSON file-based system
- **Web Scraping**: cURL with rate limiting and error handling
- **Styling**: Modern CSS with gradient backgrounds and responsive grid
- **Architecture**: MVC-inspired structure with separate classes

## File Structure

```
scientist-scraper/
├── index.php              # Main website interface
├── scrape.php             # AJAX endpoint for scraping operations
├── includes/
│   ├── config.php         # Configuration and field definitions
│   ├── ScientistScraper.php # Web scraping logic
│   └── DataStorage.php    # Data persistence layer
├── assets/
│   ├── style.css          # Modern responsive styling
│   └── script.js          # Interactive JavaScript functionality
└── data/
    └── scientists.json    # Scraped scientist data storage
```

## Key Features

### Web Scraping Engine
- Configurable scientific field definitions
- Sample data for demonstration (can be extended to real Wikipedia scraping)
- Rate limiting to avoid overwhelming servers
- Error handling and retry logic
- Duplicate detection to prevent data redundancy

### Interactive User Interface
- Real-time filtering by scientific field
- Dynamic statistics display (total scientists, fields covered)
- Responsive card-based layout
- Modern gradient design with hover effects
- Mobile-friendly responsive design

### Data Management
- JSON-based storage system
- CRUD operations for scientist data
- Search functionality
- Field-based organization
- Timestamp tracking for scraping operations

## Installation & Usage

1. **Prerequisites**: PHP 8.0+ with cURL extension enabled

2. **Setup**:
   ```bash
   cd scientist-scraper
   php -S localhost:8001
   ```

3. **Access**: Open `http://localhost:8001` in your browser

4. **Usage**:
   - Click "🔄 Update Database" to scrape new scientist data
   - Use field filter buttons to view scientists from specific fields
   - Browse through the responsive card grid
   - Statistics update automatically based on current filters

## Data Sources

The scraper is designed to work with multiple data sources:

- **Wikipedia Categories**: Scientific field categories
- **Academic Institutions**: University faculty pages
- **Research Organizations**: Member directories
- **Sample Data**: Pre-loaded famous scientists for demonstration

## Extension Possibilities

This foundation can be extended to:

- Add real Wikipedia API integration
- Include scientific paper counts and citations
- Add photo scraping for scientist profiles
- Implement advanced search and sorting
- Add data export functionality (CSV, PDF)
- Include social media integration
- Add scientist achievement timelines
- Implement user favorites and bookmarking

## Design Highlights

- Modern gradient background (purple to blue)
- Card-based scientist profiles with hover effects
- Responsive grid that adapts to screen sizes
- Clean typography and intuitive navigation
- Accessible color contrast and button states
- Smooth animations and transitions

This project demonstrates a complete web scraping solution with modern web design and interactive functionality, providing a solid foundation for a scientist discovery platform.