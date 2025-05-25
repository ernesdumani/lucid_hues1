<div class="space-y-6">
    <div class="card bg-gradient-to-br from-blue-50 to-purple-50 border-blue-200">
        <h2 class="text-2xl font-bold text-blue-800 mb-4 text-center flex items-center justify-center gap-2">
            🎨 Professional Color Generator 🎨
        </h2>
        <p class="text-blue-600 text-center mb-6">Create perfect color palettes for your designs with color theory and professional tools</p>
    </div>

    <div class="card">
        <h3 class="text-xl font-bold text-blue-800 mb-6 text-center flex items-center justify-center gap-2">
            🎨 Color Harmony Generator
        </h3>

        <div class="space-y-6">
            <!-- Controls -->
            <div class="flex flex-wrap gap-4 items-center justify-center">
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium">Base Color:</label>
                    <input type="color" id="base-color" value="#3b82f6" class="w-16 h-10 p-1 border-2 border-blue-300 rounded cursor-pointer">
                    <span id="base-color-text" class="text-sm text-gray-600">#3b82f6</span>
                </div>

                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium">Harmony:</label>
                    <select id="harmony-type" class="px-3 py-2 border border-blue-300 rounded focus:outline-none focus:border-blue-500">
                        <option value="complementary">Complementary</option>
                        <option value="triadic">Triadic</option>
                        <option value="analogous">Analogous</option>
                        <option value="monochromatic">Monochromatic</option>
                        <option value="split-complementary">Split Complementary</option>
                        <option value="tetradic">Tetradic</option>
                        <option value="random">Random Colors</option>
                    </select>
                </div>

                <button onclick="randomizeBaseColor()" class="btn btn-secondary flex items-center gap-2">
                    🎲 Random
                </button>
            </div>

            <!-- Generate Button -->
            <div class="text-center">
                <button 
                    onclick="generateHarmony()" 
                    id="harmony-btn"
                    class="btn btn-primary text-lg"
                >
                    ✨ Generate New Palette
                </button>
            </div>

            <!-- Generated Palette -->
            <div id="generated-palette" style="display: none;">
                <h3 class="text-lg font-semibold text-blue-800 text-center mb-4">Generated <span id="harmony-name"></span> Palette</h3>
                
                <!-- Color Strip -->
                <div id="generated-color-strip" class="color-strip mb-4"></div>
                
                <!-- Individual Colors -->
                <div id="generated-color-swatches" class="grid grid-cols-5 gap-4 mb-4"></div>
                
                <!-- Quick Actions -->
                <div class="flex justify-center gap-3">
                    <button onclick="useRandomAsBase()" class="btn btn-secondary">
                        🎯 Use Random Color as Base
                    </button>
                    <button onclick="copyAllColors()" class="btn btn-secondary">
                        📋 Copy All Colors
                    </button>
                    <button onclick="saveColorPalette()" class="btn btn-secondary">
                        💾 Save Palette
                    </button>
                </div>
            </div>

            <!-- Quick Presets -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-blue-800 mb-4 text-center">🚀 Quick Generate</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <button onclick="setPresetPalette(['#0077be', '#4a90e2', '#87ceeb', '#20b2aa', '#b0e0e6'], 'Ocean')" class="p-3 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                        <div class="flex gap-1 mb-2">
                            <div class="w-6 h-6 rounded" style="background-color: #0077be"></div>
                            <div class="w-6 h-6 rounded" style="background-color: #4a90e2"></div>
                            <div class="w-6 h-6 rounded" style="background-color: #87ceeb"></div>
                        </div>
                        <p class="text-sm font-medium">Ocean</p>
                    </button>
                    <button onclick="setPresetPalette(['#ff6b6b', '#ff8e53', '#ff6b9d', '#c44569', '#f8b500'], 'Sunset')" class="p-3 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                        <div class="flex gap-1 mb-2">
                            <div class="w-6 h-6 rounded" style="background-color: #ff6b6b"></div>
                            <div class="w-6 h-6 rounded" style="background-color: #ff8e53"></div>
                            <div class="w-6 h-6 rounded" style="background-color: #ff6b9d"></div>
                        </div>
                        <p class="text-sm font-medium">Sunset</p>
                    </button>
                    <button onclick="setPresetPalette(['#228b22', '#32cd32', '#90ee90', '#006400', '#9acd32'], 'Forest')" class="p-3 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                        <div class="flex gap-1 mb-2">
                            <div class="w-6 h-6 rounded" style="background-color: #228b22"></div>
                            <div class="w-6 h-6 rounded" style="background-color: #32cd32"></div>
                            <div class="w-6 h-6 rounded" style="background-color: #90ee90"></div>
                        </div>
                        <p class="text-sm font-medium">Forest</p>
                    </button>
                    <button onclick="setPresetPalette(['#6a1b9a', '#8e24aa', '#ba68c8', '#e1bee7', '#f3e5f5'], 'Purple')" class="p-3 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                        <div class="flex gap-1 mb-2">
                            <div class="w-6 h-6 rounded" style="background-color: #6a1b9a"></div>
                            <div class="w-6 h-6 rounded" style="background-color: #8e24aa"></div>
                            <div class="w-6 h-6 rounded" style="background-color: #ba68c8"></div>
                        </div>
                        <p class="text-sm font-medium">Purple</p>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Trending Palettes -->
    <div class="card">
        <h3 class="text-xl font-bold text-purple-800 mb-6 text-center">🔥 Trending Palettes</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 border border-purple-200 rounded-lg">
                <h4 class="font-semibold text-purple-800 mb-3">Modern Minimal</h4>
                <div class="flex gap-1 mb-4">
                    <?php 
                    $modernColors = ['#f8f9fa', '#e9ecef', '#6c757d', '#495057', '#212529'];
                    foreach($modernColors as $color): ?>
                        <div class="flex-1 h-12 rounded cursor-pointer hover:scale-105 transition-transform" 
                             style="background-color: <?= $color ?>" 
                             onclick="copyColor('<?= $color ?>')"
                             title="Click to copy <?= $color ?>"></div>
                    <?php endforeach; ?>
                </div>
                <p class="text-sm text-gray-600">Clean, minimal palette perfect for modern interfaces</p>
                <div class="flex gap-1 mt-2">
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">minimal</span>
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">modern</span>
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">neutral</span>
                </div>
            </div>

            <div class="p-4 border border-purple-200 rounded-lg">
                <h4 class="font-semibold text-purple-800 mb-3">Vibrant Energy</h4>
                <div class="flex gap-1 mb-4">
                    <?php 
                    $vibrantColors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#ffeaa7'];
                    foreach($vibrantColors as $color): ?>
                        <div class="flex-1 h-12 rounded cursor-pointer hover:scale-105 transition-transform" 
                             style="background-color: <?= $color ?>" 
                             onclick="copyColor('<?= $color ?>')"
                             title="Click to copy <?= $color ?>"></div>
                    <?php endforeach; ?>
                </div>
                <p class="text-sm text-gray-600">Energetic colors that grab attention and inspire action</p>
                <div class="flex gap-1 mt-2">
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">vibrant</span>
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">energetic</span>
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">bold</span>
                </div>
            </div>
        </div>
    </div>
</div>
