<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-purple-800 mb-6 text-center flex items-center justify-center gap-2">
            📅 Dream Timeline
        </h2>
        <p class="text-purple-600 text-center mb-6">View and manage your saved dream palettes</p>
        
        <div class="flex justify-center gap-4 mb-6">
            <button onclick="loadTimeline()" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">
                🔄 Refresh Timeline
            </button>
            <button onclick="clearAllPalettes()" class="px-4 py-2 bg-red-100 text-red-800 rounded hover:bg-red-200 transition-colors">
                🗑️ Clear All
            </button>
        </div>
    </div>

    <!-- Timeline Content -->
    <div id="timeline-content">
        <div id="no-palettes" class="bg-white rounded-xl shadow-lg p-12 text-center">
            <div class="text-6xl mb-4">⏰</div>
            <h3 class="text-lg font-semibold text-purple-800 mb-2">No Dream Palettes Yet</h3>
            <p class="text-purple-600">Create your first dream palette to see it here!</p>
        </div>
    </div>

    <!-- Selected Palette Detail -->
    <div id="selected-palette-detail" class="bg-gradient-to-br from-purple-50 to-indigo-50 bg-white rounded-xl shadow-lg p-6" style="display: none;">
        <h3 id="detail-title" class="text-2xl font-bold text-purple-800 mb-2"></h3>
        <p id="detail-date" class="text-sm text-purple-600 mb-4"></p>
        
        <!-- 3D Visualization -->
        <div id="detail-3d" class="w-full h-96 rounded-lg overflow-hidden bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 flex items-center justify-center mb-4">
            <div class="text-center">
                <h3 id="detail-3d-title" class="text-white text-xl mb-6"></h3>
                <div id="detail-floating-colors" class="grid grid-cols-4 gap-4"></div>
            </div>
        </div>

        <div class="space-y-3">
            <div>
                <h4 class="font-semibold text-purple-800">Dream Description:</h4>
                <p id="detail-dream-text" class="text-sm text-gray-700 mt-1"></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold text-purple-800">Mood:</h4>
                    <p id="detail-mood" class="text-sm text-purple-600 capitalize"></p>
                </div>
                <div id="detail-emotions-container" style="display: none;">
                    <h4 class="font-semibold text-purple-800">Emotions:</h4>
                    <p id="detail-emotions" class="text-sm text-purple-600"></p>
                </div>
            </div>

            <div id="detail-symbols-container" style="display: none;">
                <h4 class="font-semibold text-purple-800">Symbols:</h4>
                <div id="detail-symbols" class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-1"></div>
            </div>
        </div>
    </div>
</div>
