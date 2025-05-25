// Color conversion utilities
function hexToHsl(hex) {
  const r = Number.parseInt(hex.slice(1, 3), 16) / 255
  const g = Number.parseInt(hex.slice(3, 5), 16) / 255
  const b = Number.parseInt(hex.slice(5, 7), 16) / 255

  const max = Math.max(r, g, b)
  const min = Math.min(r, g, b)
  let h = 0,
    s = 0,
    l = (max + min) / 2

  if (max !== min) {
    const d = max - min
    s = l > 0.5 ? d / (2 - max - min) : d / (max + min)

    switch (max) {
      case r:
        h = (g - b) / d + (g < b ? 6 : 0)
        break
      case g:
        h = (b - r) / d + 2
        break
      case b:
        h = (r - g) / d + 4
        break
    }
    h /= 6
  }

  return [h * 360, s * 100, l * 100]
}

function hslToHex(h, s, l) {
  h /= 360
  s /= 100
  l /= 100

  const hue2rgb = (p, q, t) => {
    if (t < 0) t += 1
    if (t > 1) t -= 1
    if (t < 1 / 6) return p + (q - p) * 6 * t
    if (t < 1 / 2) return q
    if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6
    return p
  }

  let r, g, b
  if (s === 0) {
    r = g = b = l
  } else {
    const q = l < 0.5 ? l * (1 + s) : l + s - l * s
    const p = 2 * l - q
    r = hue2rgb(p, q, h + 1 / 3)
    g = hue2rgb(p, q, h)
    b = hue2rgb(p, q, h - 1 / 3)
  }

  const toHex = (c) => {
    const hex = Math.round(c * 255).toString(16)
    return hex.length === 1 ? "0" + hex : hex
  }

  return `#${toHex(r)}${toHex(g)}${toHex(b)}`
}

// Generate color harmony
function generateColorHarmony(baseColor, harmonyType) {
  if (harmonyType === "random") {
    return Array.from(
      { length: 5 },
      () =>
        `#${Math.floor(Math.random() * 16777215)
          .toString(16)
          .padStart(6, "0")}`,
    )
  }

  const [h, s, l] = hexToHsl(baseColor)

  switch (harmonyType) {
    case "complementary":
      return [
        baseColor,
        hslToHex((h + 180) % 360, s, l),
        hslToHex(h, s * 0.7, Math.min(95, l * 1.2)),
        hslToHex((h + 180) % 360, s * 0.7, Math.max(5, l * 0.8)),
        hslToHex(h, s * 0.4, Math.min(95, l * 1.4)),
      ]
    case "triadic":
      return [
        baseColor,
        hslToHex((h + 120) % 360, s, l),
        hslToHex((h + 240) % 360, s, l),
        hslToHex(h, s * 0.6, Math.min(95, l * 1.2)),
        hslToHex((h + 120) % 360, s * 0.6, Math.max(5, l * 0.8)),
      ]
    case "analogous":
      return [
        hslToHex((h - 30 + 360) % 360, s, l),
        baseColor,
        hslToHex((h + 30) % 360, s, l),
        hslToHex(h, s * 0.7, Math.min(95, l * 1.3)),
        hslToHex(h, s * 0.5, Math.max(5, l * 0.7)),
      ]
    case "monochromatic":
      return [
        hslToHex(h, s, Math.min(95, l * 1.4)),
        hslToHex(h, s * 0.8, Math.min(90, l * 1.2)),
        baseColor,
        hslToHex(h, s * 1.1, Math.max(5, l * 0.8)),
        hslToHex(h, s * 1.2, Math.max(5, l * 0.6)),
      ]
    case "split-complementary":
      return [
        baseColor,
        hslToHex((h + 150) % 360, s, l),
        hslToHex((h + 210) % 360, s, l),
        hslToHex(h, s * 0.6, Math.min(95, l * 1.2)),
        hslToHex((h + 180) % 360, s * 0.4, Math.max(5, l * 0.9)),
      ]
    case "tetradic":
      return [
        baseColor,
        hslToHex((h + 90) % 360, s, l),
        hslToHex((h + 180) % 360, s, l),
        hslToHex((h + 270) % 360, s, l),
        hslToHex(h, s * 0.5, Math.min(95, l * 1.1)),
      ]
    default:
      return [baseColor]
  }
}

// Copy color to clipboard
function copyColor(color) {
  navigator.clipboard.writeText(color).then(() => {
    showToast(`Copied ${color}!`)
  })
}

// Show toast notification
function showToast(message, type = "success") {
  const toast = document.createElement("div")
  toast.className = "toast"
  if (type === "error") {
    toast.style.background = "#ef4444"
  }
  toast.textContent = message
  document.body.appendChild(toast)
  setTimeout(() => toast.remove(), 3000)
}

// Format date
function formatDate(timestamp) {
  return new Date(timestamp).toLocaleDateString("en-US", {
    year: "numeric",
    month: "short",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  })
}

// Generate random color
function getRandomColor() {
  return `#${Math.floor(Math.random() * 16777215)
    .toString(16)
    .padStart(6, "0")}`
}
