<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-purple-800 mb-4 text-center">🌙 Describe Your Dream</h2>
        <p class="text-purple-600 text-center mb-6">Share the details of your dream, and watch as it transforms into a living color palette</p>

        <form id="dream-form" class="space-y-4">
            <textarea 
                id="dream-text" 
                placeholder="I dreamed I was walking through a misty forest at twilight. The trees seemed to whisper secrets, and there were glowing butterflies dancing around ancient stone circles..."
                class="w-full h-32 p-4 border-2 border-purple-200 rounded-lg focus:border-purple-400 focus:outline-none resize-none"
            ></textarea>

            <div id="error-message" class="text-red-500 text-sm" style="display: none;"></div>

            <button 
                type="submit" 
                id="generate-btn"
                class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-lg font-medium hover:from-purple-700 hover:to-indigo-700 transition-all"
            >
                🎨 Generate Dream Palette
            </button>
        </form>

        <!-- Quick Examples -->
        <div class="mt-6 grid grid-cols-2 gap-3">
            <button onclick="setDreamText('I was flying through the bright blue sky with golden birds')" class="p-3 bg-blue-50 rounded-lg text-left hover:bg-blue-100 transition-colors">
                <strong>Sky:</strong> Flying through sky
            </button>
            <button onclick="setDreamText('I was swimming in a peaceful ocean with dolphins')" class="p-3 bg-teal-50 rounded-lg text-left hover:bg-teal-100 transition-colors">
                <strong>Water:</strong> Swimming in ocean
            </button>
            <button onclick="setDreamText('I walked through a dark mysterious forest at night')" class="p-3 bg-purple-50 rounded-lg text-left hover:bg-purple-100 transition-colors">
                <strong>Forest:</strong> Dark forest
            </button>
            <button onclick="setDreamText('There was a big fire burning bright with orange flames')" class="p-3 bg-orange-50 rounded-lg text-left hover:bg-orange-100 transition-colors">
                <strong>Fire:</strong> Bright flames
            </button>
        </div>
    </div>

    <!-- Results -->
    <div id="dream-results" class="bg-black/5 border-purple-200 bg-white rounded-xl shadow-lg p-6" style="display: none;">
        <h3 class="text-2xl font-bold text-purple-800 mb-4 text-center">🎨 Your Dream Palette</h3>
        <div class="text-center space-y-2 mb-6">
            <p class="text-sm text-purple-600">
                <strong>Mood:</strong> <span id="dream-mood"></span>
            </p>
            <div id="dream-emotions" class="text-sm text-purple-600" style="display: none;">
                <strong>Emotions:</strong> <span id="emotions-list"></span>
            </div>
        </div>

        <!-- 3D Visualization Area -->
        <div id="dream-palette-3d" class="w-full h-96 rounded-lg overflow-hidden bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 flex items-center justify-center mb-4">
            <div class="text-center">
                <h3 id="palette-title" class="text-white text-xl mb-6"></h3>
                <div id="floating-colors" class="grid grid-cols-4 gap-4"></div>
            </div>
        </div>

        <!-- Color Swatches -->
        <div id="dream-color-swatches" class="flex flex-wrap gap-2 justify-center mb-4"></div>

        <!-- Dream Symbols -->
        <div id="dream-symbols" class="mt-4 p-4 bg-purple-50 rounded-lg" style="display: none;">
            <h4 class="font-semibold text-purple-800 mb-2">🔮 Dream Symbols Detected:</h4>
            <div id="symbols-list" class="space-y-1"></div>
        </div>
    </div>
</div>
