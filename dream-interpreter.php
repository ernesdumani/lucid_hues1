<?php
class DreamInterpreter {
    
    private static $symbolDatabase = [
        'water' => [
            'keywords' => ['water', 'ocean', 'sea', 'river', 'lake', 'rain', 'swimming', 'drowning', 'waves', 'flood'],
            'meaning' => 'emotions, subconscious mind, cleansing, life flow',
            'colors' => ['#0077be', '#4a90e2', '#87ceeb', '#20b2aa'],
            'intensity' => 0.8
        ],
        'fire' => [
            'keywords' => ['fire', 'flame', 'burning', 'smoke', 'heat', 'candle', 'torch', 'explosion'],
            'meaning' => 'passion, transformation, destruction, energy',
            'colors' => ['#ff4500', '#ff6347', '#ffa500', '#dc143c'],
            'intensity' => 0.9
        ],
        'sky' => [
            'keywords' => ['sky', 'clouds', 'flying', 'airplane', 'birds', 'heaven', 'stars', 'moon', 'sun'],
            'meaning' => 'freedom, aspirations, spirituality, limitless potential',
            'colors' => ['#87ceeb', '#4169e1', '#6495ed', '#b0c4de'],
            'intensity' => 0.7
        ],
        'forest' => [
            'keywords' => ['forest', 'trees', 'woods', 'jungle', 'leaves', 'branches', 'nature'],
            'meaning' => 'growth, life force, mystery, natural wisdom',
            'colors' => ['#228b22', '#32cd32', '#90ee90', '#006400'],
            'intensity' => 0.6
        ],
        'animals' => [
            'keywords' => ['dog', 'cat', 'bird', 'snake', 'lion', 'tiger', 'wolf', 'bear', 'horse', 'fish'],
            'meaning' => 'instincts, primal nature, companionship, wild aspects',
            'colors' => ['#8b4513', '#a0522d', '#daa520', '#cd853f'],
            'intensity' => 0.7
        ],
        'darkness' => [
            'keywords' => ['dark', 'night', 'shadow', 'black', 'darkness', 'midnight'],
            'meaning' => 'unknown, fear, mystery, hidden aspects',
            'colors' => ['#191970', '#483d8b', '#2f4f4f', '#000080'],
            'intensity' => 0.8
        ],
        'light' => [
            'keywords' => ['light', 'bright', 'glow', 'shine', 'golden', 'white', 'illuminated'],
            'meaning' => 'clarity, hope, divine guidance, enlightenment',
            'colors' => ['#ffffe0', '#fffacd', '#f0e68c', '#ffd700'],
            'intensity' => 0.9
        ]
    ];

    private static $emotionDatabase = [
        'peaceful' => [
            'keywords' => ['calm', 'peaceful', 'serene', 'quiet', 'still', 'gentle', 'soft'],
            'colors' => ['#e6f3ff', '#b3d9ff', '#87ceeb', '#4a90e2']
        ],
        'anxious' => [
            'keywords' => ['scared', 'afraid', 'worried', 'nervous', 'panic', 'stress', 'fear'],
            'colors' => ['#ff6b6b', '#ffa07a', '#ff7f50', '#ff4500']
        ],
        'joyful' => [
            'keywords' => ['happy', 'joy', 'laugh', 'smile', 'celebration', 'party', 'fun'],
            'colors' => ['#ffff00', '#ffd700', '#ffa500', '#ff69b4']
        ],
        'mysterious' => [
            'keywords' => ['strange', 'weird', 'mysterious', 'unknown', 'secret', 'hidden'],
            'colors' => ['#4b0082', '#663399', '#8a2be2', '#9370db']
        ],
        'melancholic' => [
            'keywords' => ['sad', 'cry', 'tears', 'lonely', 'empty', 'lost', 'grief'],
            'colors' => ['#4682b4', '#5f9ea0', '#708090', '#2f4f4f']
        ],
        'energetic' => [
            'keywords' => ['running', 'fast', 'energy', 'power', 'strong', 'active', 'moving'],
            'colors' => ['#ff1493', '#ff4500', '#ffa500', '#32cd32']
        ]
    ];

    public static function interpretDream($dreamText) {
        $text = strtolower($dreamText);
        
        // Detect symbols
        $detectedSymbols = [];
        foreach (self::$symbolDatabase as $symbolName => $symbolData) {
            foreach ($symbolData['keywords'] as $keyword) {
                if (strpos($text, $keyword) !== false) {
                    $detectedSymbols[] = [
                        'symbol' => $symbolName,
                        'meaning' => $symbolData['meaning'],
                        'intensity' => $symbolData['intensity']
                    ];
                    break;
                }
            }
        }

        // Detect emotions
        $detectedEmotions = [];
        $overallMood = 'mysterious';
        $moodScore = 0;

        foreach (self::$emotionDatabase as $emotionName => $emotionData) {
            $emotionScore = 0;
            foreach ($emotionData['keywords'] as $keyword) {
                if (strpos($text, $keyword) !== false) {
                    $emotionScore++;
                }
            }
            if ($emotionScore > 0) {
                $detectedEmotions[] = $emotionName;
                if ($emotionScore > $moodScore) {
                    $moodScore = $emotionScore;
                    $overallMood = $emotionName;
                }
            }
        }

        // Generate color suggestions
        $colorSuggestions = [];
        $allColors = [];

        // Add colors from detected symbols
        foreach ($detectedSymbols as $symbol) {
            $symbolData = self::$symbolDatabase[$symbol['symbol']];
            foreach ($symbolData['colors'] as $color) {
                if (!in_array($color, $allColors)) {
                    $allColors[] = $color;
                    $colorSuggestions[] = [
                        'color' => $color,
                        'reasoning' => "Represents {$symbol['symbol']}: {$symbol['meaning']}"
                    ];
                }
            }
        }

        // Add colors from detected emotions
        foreach ($detectedEmotions as $emotion) {
            $emotionData = self::$emotionDatabase[$emotion];
            foreach (array_slice($emotionData['colors'], 0, 2) as $color) {
                if (!in_array($color, $allColors)) {
                    $allColors[] = $color;
                    $colorSuggestions[] = [
                        'color' => $color,
                        'reasoning' => "Reflects $emotion emotional tone"
                    ];
                }
            }
        }

        // If no specific elements detected, use default dreamy colors
        if (empty($allColors)) {
            $defaultColors = ['#e6e6fa', '#f0f8ff', '#ffe4e1', '#f5f5dc', '#e0ffff'];
            foreach ($defaultColors as $color) {
                $allColors[] = $color;
                $colorSuggestions[] = [
                    'color' => $color,
                    'reasoning' => 'Default dreamy atmosphere'
                ];
            }
        }

        return [
            'emotions' => !empty($detectedEmotions) ? $detectedEmotions : ['mysterious'],
            'symbols' => !empty($detectedSymbols) ? $detectedSymbols : [
                ['symbol' => 'dream', 'meaning' => 'subconscious exploration', 'intensity' => 0.5]
            ],
            'overallMood' => $overallMood,
            'colorSuggestions' => array_slice($colorSuggestions, 0, 8)
        ];
    }
}
?>
