-- Create database
CREATE DATABASE IF NOT EXISTS lucidhue CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lucidhue;

-- Create dream_palettes table
CREATE TABLE IF NOT EXISTS dream_palettes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dream_text TEXT NOT NULL,
    colors JSON NOT NULL,
    mood VARCHAR(50),
    emotions JSON,
    symbols JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(255) DEFAULT 'Dream Palette'
);

-- Create color_palettes table for generator
CREATE TABLE IF NOT EXISTS color_palettes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    base_color VARCHAR(7) NOT NULL,
    harmony_type VARCHAR(20) NOT NULL,
    colors JSON NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO dream_palettes (dream_text, colors, mood, emotions, symbols, title) VALUES
('I dreamed of floating in a cosmic ocean with stars reflecting in the water', 
 '["#0077be", "#4a90e2", "#87ceeb", "#20b2aa", "#b0e0e6"]', 
 'peaceful',
 '["peaceful", "serene"]',
 '[{"symbol": "water", "meaning": "emotions and subconscious mind"}]',
 'Cosmic Ocean Dream'),
('I was flying through bright clouds in the sky with golden birds', 
 '["#87ceeb", "#4169e1", "#6495ed", "#b0c4de", "#add8e6"]', 
 'joyful',
 '["joyful", "free"]',
 '[{"symbol": "sky", "meaning": "freedom and aspirations"}]',
 'Sky Flight Dream'),
('I walked through a mysterious dark forest at night with glowing eyes watching', 
 '["#191970", "#483d8b", "#2f4f4f", "#000080", "#4b0082"]', 
 'mysterious',
 '["mysterious", "introspective"]',
 '[{"symbol": "darkness", "meaning": "mystery and unknown"}, {"symbol": "forest", "meaning": "growth and natural wisdom"}]',
 'Dark Forest Dream');
