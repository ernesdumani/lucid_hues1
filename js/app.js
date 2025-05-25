let currentGeneratedPalette = []
let savedPalettes = JSON.parse(localStorage.getItem("lucidHue_palettes") || "[]")
let selectedPaletteId = null

// Tab functionality
function showTab(tabName) {
  // Hide all tabs
  document.querySelectorAll(".tab-content").forEach((tab) => {
    tab.style.display = "none"
  })

  // Remove active class from all tab buttons
  document.querySelectorAll(".tab-btn").forEach((btn) => {
    btn.classList.remove("tab-active")
    btn.classList.add("text-purple-600", "hover:bg-purple-50")
  })

  // Show selected tab
  document.getElementById(tabName + "-tab").style.display = "block"

  // Add active class to selected tab button
  const activeBtn = document.getElementById("tab-" + tabName)
  activeBtn.classList.add("tab-active")
  activeBtn.classList.remove("text-purple-600", "hover:bg-purple-50")

  // Load timeline if timeline tab is selected
  if (tabName === "timeline") {
    loadTimeline()
  }
}

// Set dream text
function setDreamText(text) {
  document.getElementById("dream-text").value = text
}

// Display colors with 3D effect
function displayColors(colors, containerId, mood = null, title = null) {
  // Update mood if provided
  if (mood && document.getElementById("dream-mood")) {
    const moodElement = document.getElementById("dream-mood")
    moodElement.textContent = mood
    moodElement.className = `mood-indicator mood-${mood}`
  }

  // Create 3D floating colors
  if (containerId === "dream-results") {
    const floatingContainer = document.getElementById("floating-colors")
    floatingContainer.innerHTML = ""
    colors.forEach((color, index) => {
      const div = document.createElement("div")
      div.className = "w-16 h-16 rounded-full shadow-lg animate-pulse color-swatch floating-color"
      div.style.backgroundColor = color
      div.style.animationDelay = `${index * 0.2}s`
      div.style.boxShadow = `0 0 20px ${color}50`
      div.onclick = () => copyColor(color)
      div.title = `Click to copy ${color}`
      floatingContainer.appendChild(div)
    })

    if (title) {
      document.getElementById("palette-title").textContent = title
    }
  }

  // Create color swatches
  const swatchContainer = document.getElementById(
    containerId === "dream-results" ? "dream-color-swatches" : "generated-color-swatches",
  )
  if (swatchContainer) {
    swatchContainer.innerHTML = ""
    colors.forEach((color) => {
      const container = document.createElement("div")
      container.className = "text-center"

      const swatch = document.createElement("div")
      swatch.className = "color-circle mx-auto"
      swatch.style.backgroundColor = color
      swatch.onclick = () => copyColor(color)
      swatch.title = color

      const text = document.createElement("div")
      text.className = "text-xs font-mono mt-1"
      text.textContent = color

      container.appendChild(swatch)
      container.appendChild(text)
      swatchContainer.appendChild(container)
    })
  }
}

// Generate harmony
function generateHarmony() {
  const btn = document.getElementById("harmony-btn")
  btn.innerHTML = '<span class="loading-spinner"></span> Generating...'
  btn.disabled = true

  setTimeout(() => {
    const baseColor = document.getElementById("base-color").value
    const harmonyType = document.getElementById("harmony-type").value
    const colors = generateColorHarmony(baseColor, harmonyType)

    currentGeneratedPalette = colors

    // Display colors in strip
    const strip = document.getElementById("generated-color-strip")
    strip.innerHTML = ""
    colors.forEach((color) => {
      const div = document.createElement("div")
      div.className = "color-strip-item"
      div.style.backgroundColor = color
      div.title = `Click to copy ${color}`
      div.onclick = () => copyColor(color)
      strip.appendChild(div)
    })

    // Display individual swatches
    displayColors(colors, "generator")

    document.getElementById("harmony-name").textContent = harmonyType
    document.getElementById("generated-palette").style.display = "block"

    btn.textContent = "✨ Generate New Palette"
    btn.disabled = false
  }, 500)
}

// Randomize base color
function randomizeBaseColor() {
  const randomColor = getRandomColor()
  document.getElementById("base-color").value = randomColor
  document.getElementById("base-color-text").textContent = randomColor
}

// Use random color as base
function useRandomAsBase() {
  if (currentGeneratedPalette.length > 0) {
    const randomColor = currentGeneratedPalette[Math.floor(Math.random() * currentGeneratedPalette.length)]
    document.getElementById("base-color").value = randomColor
    document.getElementById("base-color-text").textContent = randomColor
  }
}

// Copy all colors
function copyAllColors() {
  if (currentGeneratedPalette.length > 0) {
    const paletteText = currentGeneratedPalette.join(", ")
    navigator.clipboard.writeText(paletteText)
    showToast("Copied entire palette!")
  }
}

// Set preset palette
function setPresetPalette(colors, name) {
  currentGeneratedPalette = colors

  // Display colors in strip
  const strip = document.getElementById("generated-color-strip")
  strip.innerHTML = ""
  colors.forEach((color) => {
    const div = document.createElement("div")
    div.className = "color-strip-item"
    div.style.backgroundColor = color
    div.title = `Click to copy ${color}`
    div.onclick = () => copyColor(color)
    strip.appendChild(div)
  })

  // Display individual swatches
  displayColors(colors, "generator")

  document.getElementById("harmony-name").textContent = name
  document.getElementById("generated-palette").style.display = "block"
}

// Save dream palette
function saveDreamPalette() {
  const dreamText = document.getElementById("dream-text").value
  const colors = Array.from(document.querySelectorAll("#dream-color-swatches .color-circle")).map(
    (el) => el.style.backgroundColor,
  )
  const mood = document.getElementById("dream-mood").textContent

  if (!dreamText || colors.length === 0) {
    showToast("No palette to save!", "error")
    return
  }

  const palette = {
    id: Date.now().toString(),
    dreamText: dreamText,
    colors: colors,
    mood: mood,
    emotions: [],
    symbols: [],
    timestamp: Date.now(),
    title: `Dream ${new Date().toLocaleDateString()}`,
  }

  savedPalettes.unshift(palette)
  savedPalettes = savedPalettes.slice(0, 50) // Keep last 50
  localStorage.setItem("lucidHue_palettes", JSON.stringify(savedPalettes))

  showToast("Dream palette saved!")
  return palette
}

// Save color palette
function saveColorPalette() {
  if (currentGeneratedPalette.length === 0) {
    showToast("No palette to save!", "error")
    return
  }

  const baseColor = document.getElementById("base-color").value
  const harmonyType = document.getElementById("harmony-type").value

  const palette = {
    id: Date.now().toString(),
    baseColor: baseColor,
    harmonyType: harmonyType,
    colors: currentGeneratedPalette,
    timestamp: Date.now(),
    title: `${harmonyType} Palette`,
  }

  // Save to database via API
  fetch("api/save-color-palette.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(palette),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        showToast("Color palette saved!")
      } else {
        showToast("Failed to save palette", "error")
      }
    })
    .catch((error) => {
      console.error("Error:", error)
      showToast("Failed to save palette", "error")
    })
}

// Load timeline
function loadTimeline() {
  const timelineContent = document.getElementById("timeline-content")

  if (savedPalettes.length === 0) {
    timelineContent.innerHTML = `
            <div id="no-palettes" class="card text-center">
                <div class="text-6xl mb-4">⏰</div>
                <h3 class="text-lg font-semibold text-purple-800 mb-2">No Dream Palettes Yet</h3>
                <p class="text-purple-600">Create your first dream palette to see it here!</p>
            </div>
        `
    return
  }

  timelineContent.innerHTML = `
        <div class="palette-grid">
            ${savedPalettes
              .map(
                (palette) => `
                <div class="palette-card" onclick="selectPalette('${palette.id}')">
                    <h4 class="text-sm font-medium text-purple-800 mb-2">${palette.title}</h4>
                    <p class="text-xs text-purple-600 mb-3">${formatDate(palette.timestamp)}</p>
                    <div class="flex flex-wrap gap-1 mb-3">
                        ${palette.colors
                          .slice(0, 6)
                          .map(
                            (color) => `
                            <div class="w-6 h-6 rounded-full border border-white shadow-sm" style="background-color: ${color}"></div>
                        `,
                          )
                          .join("")}
                    </div>
                    <p class="text-xs text-gray-600 line-clamp-2">${palette.dreamText.slice(0, 100)}...</p>
                    <div class="flex gap-1 mt-2">
                        <button onclick="event.stopPropagation(); exportPalette('${palette.id}')" class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200">
                            📤 Export
                        </button>
                        <button onclick="event.stopPropagation(); deletePalette('${palette.id}')" class="text-xs px-2 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200">
                            🗑️ Delete
                        </button>
                    </div>
                </div>
            `,
              )
              .join("")}
        </div>
    `
}

// Select palette for detailed view
function selectPalette(paletteId) {
  const palette = savedPalettes.find((p) => p.id === paletteId)
  if (!palette) return

  selectedPaletteId = paletteId

  document.getElementById("detail-title").textContent = palette.title
  document.getElementById("detail-date").textContent = formatDate(palette.timestamp)
  document.getElementById("detail-dream-text").textContent = palette.dreamText
  document.getElementById("detail-mood").textContent = palette.mood

  // Display 3D colors
  const floatingContainer = document.getElementById("detail-floating-colors")
  floatingContainer.innerHTML = ""
  palette.colors.forEach((color, index) => {
    const div = document.createElement("div")
    div.className = "w-16 h-16 rounded-full shadow-lg animate-pulse color-swatch floating-color"
    div.style.backgroundColor = color
    div.style.animationDelay = `${index * 0.2}s`
    div.style.boxShadow = `0 0 20px ${color}50`
    div.onclick = () => copyColor(color)
    div.title = `Click to copy ${color}`
    floatingContainer.appendChild(div)
  })

  document.getElementById("detail-3d-title").textContent = palette.title

  // Show emotions if available
  if (palette.emotions && palette.emotions.length > 0) {
    document.getElementById("detail-emotions").textContent = palette.emotions.join(", ")
    document.getElementById("detail-emotions-container").style.display = "block"
  } else {
    document.getElementById("detail-emotions-container").style.display = "none"
  }

  // Show symbols if available
  if (palette.symbols && palette.symbols.length > 0) {
    const symbolsContainer = document.getElementById("detail-symbols")
    symbolsContainer.innerHTML = ""
    palette.symbols.forEach((symbol) => {
      const div = document.createElement("div")
      div.className = "text-sm"
      div.innerHTML = `<span class="font-medium text-purple-700">${symbol.symbol}:</span> <span class="text-gray-600 ml-1">${symbol.meaning}</span>`
      symbolsContainer.appendChild(div)
    })
    document.getElementById("detail-symbols-container").style.display = "block"
  } else {
    document.getElementById("detail-symbols-container").style.display = "none"
  }

  document.getElementById("selected-palette-detail").style.display = "block"
}

// Export palette
function exportPalette(paletteId) {
  const palette = savedPalettes.find((p) => p.id === paletteId)
  if (!palette) return

  const data = {
    title: palette.title,
    colors: palette.colors,
    dreamText: palette.dreamText,
    mood: palette.mood,
    emotions: palette.emotions,
    symbols: palette.symbols,
    timestamp: new Date(palette.timestamp).toISOString(),
  }

  const blob = new Blob([JSON.stringify(data, null, 2)], { type: "application/json" })
  const url = URL.createObjectURL(blob)
  const a = document.createElement("a")
  a.href = url
  a.download = `dream-palette-${palette.id}.json`
  a.click()
  URL.revokeObjectURL(url)
}

// Export selected palette
function exportSelectedPalette() {
  if (selectedPaletteId) {
    exportPalette(selectedPaletteId)
  }
}

// Delete palette
function deletePalette(paletteId) {
  if (confirm("Are you sure you want to delete this palette?")) {
    savedPalettes = savedPalettes.filter((p) => p.id !== paletteId)
    localStorage.setItem("lucidHue_palettes", JSON.stringify(savedPalettes))
    loadTimeline()
    if (selectedPaletteId === paletteId) {
      document.getElementById("selected-palette-detail").style.display = "none"
      selectedPaletteId = null
    }
    showToast("Palette deleted")
  }
}

// Delete selected palette
function deleteSelectedPalette() {
  if (selectedPaletteId) {
    deletePalette(selectedPaletteId)
  }
}

// Clear all palettes
function clearAllPalettes() {
  if (confirm("Are you sure you want to delete ALL palettes? This cannot be undone.")) {
    savedPalettes = []
    localStorage.setItem("lucidHue_palettes", JSON.stringify(savedPalettes))
    loadTimeline()
    document.getElementById("selected-palette-detail").style.display = "none"
    selectedPaletteId = null
    showToast("All palettes cleared")
  }
}

// Event listeners
document.addEventListener("DOMContentLoaded", () => {
  // Dream form submission
  document.getElementById("dream-form").addEventListener("submit", (e) => {
    e.preventDefault()
    const dreamText = document.getElementById("dream-text").value.trim()
    if (!dreamText) return

    const btn = document.getElementById("generate-btn")
    btn.innerHTML = '<span class="loading-spinner"></span> Interpreting...'
    btn.disabled = true

    setTimeout(() => {
      const result = interpretDream(dreamText)

      // Display results
      displayColors(result.colors, "dream-results", result.overallMood, `Dream ${new Date().toLocaleDateString()}`)

      // Show emotions
      if (result.emotions && result.emotions.length > 0) {
        document.getElementById("emotions-list").textContent = result.emotions.join(", ")
        document.getElementById("dream-emotions").style.display = "block"
      }

      // Show symbols
      if (result.symbols && result.symbols.length > 0) {
        const symbolsList = document.getElementById("symbols-list")
        symbolsList.innerHTML = ""
        result.symbols.forEach((symbol) => {
          const p = document.createElement("p")
          p.className = "text-sm text-purple-700"
          p.innerHTML = `<strong>${symbol.symbol}:</strong> ${symbol.meaning}`
          symbolsList.appendChild(p)
        })
        document.getElementById("dream-symbols").style.display = "block"
      }

      document.getElementById("dream-results").style.display = "block"
      document.getElementById("dream-results").classList.add("fade-in")

      btn.textContent = "🎨 Generate Dream Palette"
      btn.disabled = false
    }, 1000)
  })

  // Base color change
  document.getElementById("base-color").addEventListener("change", function () {
    document.getElementById("base-color-text").textContent = this.value
  })

  // Load initial timeline
  loadTimeline()
})

function copyColor(color) {
  navigator.clipboard.writeText(color)
  showToast("Copied " + color + "!")
}

function generateColorHarmony(baseColor, harmonyType) {
  // This is a placeholder. Replace with actual color harmony generation logic.
  const numColors = 5
  const colors = []
  for (let i = 0; i < numColors; i++) {
    colors.push(getRandomColor())
  }
  return colors
}

function getRandomColor() {
  const letters = "0123456789ABCDEF"
  let color = "#"
  for (let i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)]
  }
  return color
}

function showToast(message, type = "success") {
  const toastContainer = document.getElementById("toast-container")
  const toast = document.createElement("div")
  toast.textContent = message
  toast.className = `toast toast-${type}`
  toastContainer.appendChild(toast)

  setTimeout(() => {
    toast.remove()
  }, 3000)
}

function formatDate(timestamp) {
  const date = new Date(timestamp)
  const options = { year: "numeric", month: "long", day: "numeric", hour: "numeric", minute: "numeric" }
  return date.toLocaleDateString(undefined, options)
}

function interpretDream(dreamText) {
  // Placeholder implementation
  const colors = [getRandomColor(), getRandomColor(), getRandomColor()]
  const overallMood = "calm"
  const emotions = ["joy", "peace"]
  const symbols = [{ symbol: "water", meaning: "emotions" }]

  return { colors, overallMood, emotions, symbols }
}
