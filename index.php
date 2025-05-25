<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LucidHue - Transform Dreams into Color Palettes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body class="gradient-bg min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-5xl font-bold gradient-text mb-4">🌙 LucidHue ✨</h1>
            <p class="text-lg text-purple-700">Transform your dreams into beautiful color palettes</p>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center mb-8">
            <div class="bg-white rounded-lg p-1 shadow-lg">
                <button onclick="showTab('dreams')" id="tab-dreams" class="tab-btn px-6 py-2 rounded-md font-medium transition-all tab-active">
                    🌙 Dreams
                </button>
                <button onclick="showTab('generator')" id="tab-generator" class="tab-btn px-6 py-2 rounded-md font-medium transition-all text-purple-600 hover:bg-purple-50">
                    🎨 Pro Generator
                </button>
                <button onclick="showTab('timeline')" id="tab-timeline" class="tab-btn px-6 py-2 rounded-md font-medium transition-all text-purple-600 hover:bg-purple-50">
                    📅 Timeline
                </button>
                <button onclick="showTab('inspiration')" id="tab-inspiration" class="tab-btn px-6 py-2 rounded-md font-medium transition-all text-purple-600 hover:bg-purple-50">
                    💡 Inspiration
                </button>
            </div>
        </div>

        <!-- Dreams Tab -->
        <div id="dreams-tab" class="tab-content">
            <?php include 'components/dream-input.php'; ?>
        </div>

        <!-- Generator Tab -->
        <div id="generator-tab" class="tab-content" style="display: none;">
            <?php include 'components/color-generator.php'; ?>
        </div>

        <!-- Timeline Tab -->
        <div id="timeline-tab" class="tab-content" style="display: none;">
            <?php include 'components/dream-timeline.php'; ?>
        </div>

        <!-- Inspiration Tab -->
        <div id="inspiration-tab" class="tab-content" style="display: none;">
            <?php include 'components/inspiration.php'; ?>
        </div>

        <!-- Footer -->
        <div class="text-center mt-12 text-purple-600">
            <p class="text-sm">✨ Where dreams meet design ✨</p>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <script src="js/color-utils.js"></script>
    <script src="js/dream-interpreter.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
