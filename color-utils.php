<?php
class ColorUtils {
    
    // Color conversion utilities
    public static function hexToHsl($hex) {
        $r = hexdec(substr($hex, 1, 2)) / 255;
        $g = hexdec(substr($hex, 3, 2)) / 255;
        $b = hexdec(substr($hex, 5, 2)) / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $h = 0;
        $s = 0;
        $l = ($max + $min) / 2;

        if ($max !== $min) {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);

            switch ($max) {
                case $r:
                    $h = ($g - $b) / $d + ($g < $b ? 6 : 0);
                    break;
                case $g:
                    $h = ($b - $r) / $d + 2;
                    break;
                case $b:
                    $h = ($r - $g) / $d + 4;
                    break;
            }
            $h /= 6;
        }

        return [$h * 360, $s * 100, $l * 100];
    }

    public static function hslToHex($h, $s, $l) {
        $h /= 360;
        $s /= 100;
        $l /= 100;

        $hue2rgb = function($p, $q, $t) {
            if ($t < 0) $t += 1;
            if ($t > 1) $t -= 1;
            if ($t < 1/6) return $p + ($q - $p) * 6 * $t;
            if ($t < 1/2) return $q;
            if ($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;
            return $p;
        };

        if ($s === 0) {
            $r = $g = $b = $l;
        } else {
            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;
            $r = $hue2rgb($p, $q, $h + 1/3);
            $g = $hue2rgb($p, $q, $h);
            $b = $hue2rgb($p, $q, $h - 1/3);
        }

        $toHex = function($c) {
            $hex = dechex(round($c * 255));
            return strlen($hex) === 1 ? '0' . $hex : $hex;
        };

        return '#' . $toHex($r) . $toHex($g) . $toHex($b);
    }

    // Color harmony generators
    public static function generateComplementary($baseColor) {
        list($h, $s, $l) = self::hexToHsl($baseColor);
        return [
            $baseColor,
            self::hslToHex(($h + 180) % 360, $s, $l),
            self::hslToHex($h, $s * 0.7, min(95, $l * 1.2)),
            self::hslToHex(($h + 180) % 360, $s * 0.7, max(5, $l * 0.8)),
            self::hslToHex($h, $s * 0.4, min(95, $l * 1.4))
        ];
    }

    public static function generateTriadic($baseColor) {
        list($h, $s, $l) = self::hexToHsl($baseColor);
        return [
            $baseColor,
            self::hslToHex(($h + 120) % 360, $s, $l),
            self::hslToHex(($h + 240) % 360, $s, $l),
            self::hslToHex($h, $s * 0.6, min(95, $l * 1.2)),
            self::hslToHex(($h + 120) % 360, $s * 0.6, max(5, $l * 0.8))
        ];
    }

    public static function generateAnalogous($baseColor) {
        list($h, $s, $l) = self::hexToHsl($baseColor);
        return [
            self::hslToHex(($h - 30 + 360) % 360, $s, $l),
            $baseColor,
            self::hslToHex(($h + 30) % 360, $s, $l),
            self::hslToHex($h, $s * 0.7, min(95, $l * 1.3)),
            self::hslToHex($h, $s * 0.5, max(5, $l * 0.7))
        ];
    }

    public static function generateMonochromatic($baseColor) {
        list($h, $s, $l) = self::hexToHsl($baseColor);
        return [
            self::hslToHex($h, $s, min(95, $l * 1.4)),
            self::hslToHex($h, $s * 0.8, min(90, $l * 1.2)),
            $baseColor,
            self::hslToHex($h, $s * 1.1, max(5, $l * 0.8)),
            self::hslToHex($h, $s * 1.2, max(5, $l * 0.6))
        ];
    }

    // Trending color palettes
    public static function getTrendingPalettes() {
        return [
            [
                'id' => 'modern-minimal',
                'name' => 'Modern Minimal',
                'colors' => ['#f8f9fa', '#e9ecef', '#6c757d', '#495057', '#212529'],
                'description' => 'Clean, minimal palette perfect for modern interfaces',
                'tags' => ['minimal', 'modern', 'neutral']
            ],
            [
                'id' => 'vibrant-energy',
                'name' => 'Vibrant Energy',
                'colors' => ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#ffeaa7'],
                'description' => 'Energetic colors that grab attention and inspire action',
                'tags' => ['vibrant', 'energetic', 'bold']
            ],
            [
                'id' => 'nature-inspired',
                'name' => 'Nature Inspired',
                'colors' => ['#2d5016', '#61892f', '#86c232', '#c6d57e', '#f4f3ee'],
                'description' => 'Earthy tones inspired by natural landscapes',
                'tags' => ['nature', 'earthy', 'organic']
            ]
        ];
    }

    // Export formats
    public static function exportToCSS($palette) {
        $css = ":root {\n";
        foreach ($palette['colors'] as $index => $color) {
            $css .= "  --color-" . ($index + 1) . ": $color;\n";
        }
        $css .= "  --color-primary: " . $palette['colors'][0] . ";\n";
        $css .= "  --color-secondary: " . ($palette['colors'][1] ?? $palette['colors'][0]) . ";\n";
        $css .= "  --color-accent: " . ($palette['colors'][2] ?? $palette['colors'][0]) . ";\n";
        $css .= "}";
        return $css;
    }

    public static function exportToSass($palette) {
        $sass = "// " . $palette['name'] . " Color Palette\n";
        foreach ($palette['colors'] as $index => $color) {
            $sass .= "\$color-" . ($index + 1) . ": $color;\n";
        }
        $sass .= "\$color-primary: " . $palette['colors'][0] . ";\n";
        $sass .= "\$color-secondary: " . ($palette['colors'][1] ?? $palette['colors'][0]) . ";\n";
        $sass .= "\$color-accent: " . ($palette['colors'][2] ?? $palette['colors'][0]) . ";\n";
        return $sass;
    }
}
?>
