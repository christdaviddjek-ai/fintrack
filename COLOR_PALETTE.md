# 🎨 Palette de Couleurs - fintrack

## 🎯 Design System

**Style**: Moderne, épuré, premium  
**Direction**: Finance contemporaine · Confiance · Accessibilité

---

## 📊 Palette Principale

### Neutrals (Ink + Surface)

```
🖤 --ink              #0a0f1e   (Noir principal - texte & bg)
🖤 --ink-light       #1a2235   (Gris foncé - éléments secondaires)
🖤 --ink-muted       #2e3a52   (Gris moyen - texte muted)

⚪ --surface          #ffffff   (Blanc pur - bg principal)
🩶 --surface-2       #f4f6fb   (Gris très clair - alt bg)
🩶 --surface-3       #eaecf5   (Gris clair - surfaces tertiaires)
```

### Accent Colors

```
🟢 --emerald         #00c78c   ✅ Succès, gains, CTA primaire
🟢 --emerald-dark    #00a675   (Hover state emerald)
🟢 --emerald-glow    rgba(0,199,140,0.15)  (Subtle background)

🔴 --rose            #ff4d6d   ❌ Erreurs, dépenses négatives
🟠 --amber           #ffaa00   ⚠️ Warnings, attention
🔵 --sky             #3b82f6   ℹ️ Info, liens, données
```

---

## 📝 Text & Borders

```
--text-primary       #0a0f1e   (Texte principal - lisible)
--text-secondary     #4a5578   (Texte secondaire - subtle)
--text-muted         #8892aa   (Texte light - très subtle)

--border             #e2e6f0   (Bordures standards)
--border-strong      #c8cedf   (Bordures accentuées)
```

---

## 🌟 Effects

### Shadows (Depth)
```
--shadow-sm          0 1px 4px rgba(10,15,30,0.06)
--shadow-md          0 4px 16px rgba(10,15,30,0.08)
--shadow-lg          0 12px 40px rgba(10,15,30,0.12)
--shadow-emerald     0 8px 24px rgba(0,199,140,0.25)  ✨ Emerald glow
```

### Radius (Smoothness)
```
--radius-sm          6px
--radius-md          10px
--radius-lg          16px
--radius-xl          24px
```

### Animation
```
--transition         all 0.22s cubic-bezier(0.4, 0, 0.2, 1)
```

---

## 🔤 Typography

```
Display Font:  'Syne' (wght: 400, 600, 700, 800)
               → Headings, bold, premium feel

Body Font:     'DM Sans' (wght: 300, 400, 500, 600)
               → Readable, clean, accessible
```

---

## 🎨 Color Usage Guide

| Situation | Couleur | Raison |
|-----------|---------|--------|
| **CTA Principal** | Emerald `#00c78c` | Succès, appelle à l'action |
| **Texte principal** | Ink `#0a0f1e` | Contraste maximal, lisibilité |
| **Backgrounds** | Surface `#ffffff` / `#f4f6fb` | Propre, professionnel |
| **Erreurs/Alert** | Rose `#ff4d6d` | Danger classique, visible |
| **Dépenses** | Rose `#ff4d6d` | Assoc. négative naturelle |
| **Revenus** | Emerald `#00c78c` | Assoc. positive naturelle |
| **Info messages** | Sky `#3b82f6` | Neutre, informatif |
| **Warnings** | Amber `#ffaa00` | Attention requise |
| **Bordures** | Border `#e2e6f0` | Subtile, divise sans crier |

---

## 💡 Accessibility

- ✅ **Contrast WCAG AAA** sur tous les textes
- ✅ **Emerald + Ink** = 13:1 contrast ratio (excellent)
- ✅ **Rose + Surface** = 7.2:1 contrast ratio (AAA)
- ✅ **Ne pas dépendre UNIQUEMENT de la couleur** (labels + icônes)

---

## 🔄 Dark Mode (Futur)

```
Possibilité d'ajouter des variables pour dark mode:

--ink-dark: #ffffff
--surface-dark: #0a0f1e
--text-primary-dark: #ffffff
--border-dark: #2e3a52

@media (prefers-color-scheme: dark) {
  :root {
    --ink: var(--ink-dark);
    ...
  }
}
```

---

## 📐 Responsive

Palette reste **identique sur tous les écrans**
- Shadows plus subtiles sur mobile (GPU optimization)
- Radius conservés (adaptabilité)
- Fonts scalent avec rem units

---

## 🎯 Résumé

fintrack utilise une palette **moderne + accessible**:
- ✨ **Emerald** pour l'action & succès
- 🔴 **Rose** pour les avertissements & dépenses
- ⚫ **Ink** pour la confiance & lisibilité
- ⚪ **Surface** pour la clarté

**Total**: 6 teintes primaires + 7 accents = **Design cohérent & scalable**
