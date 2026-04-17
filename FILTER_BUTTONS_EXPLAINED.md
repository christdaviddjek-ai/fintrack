# 🎯 Guide: Boutons "Filtrer" et "Réinitialiser"

## 📌 Localisation

Page: **crud_depense.php** (Gestion des dépenses)

```
┌─────────────────────────────────┐
│ Catégorie: [Dropdown ▼]         │
│ Mois: [Date picker]             │
│                                 │
│ [Filtrer] [Réinitialiser]      │
└─────────────────────────────────┘
```

---

## 🔍 BOUTON "FILTRER"

### Rôle
**Appliquer les filtres** que tu as sélectionnés et voir SEULEMENT les dépenses correspondantes.

### Fonctionnement

```
AVANT (sans filtre):
┌─────────────┬────────────────┐
│ Catégorie   │ Montant        │
├─────────────┼────────────────┤
│ Alimentation│ 50€ (avril)    │
│ Transport   │ 20€ (avril)    │
│ Alimentation│ 30€ (mai)      │
│ Loisirs     │ 15€ (avril)    │
└─────────────┴────────────────┘
Total: 4 dépenses affichées

═══════════════════════════════════

TU SÉLECTIONNES:
- Catégorie: "Alimentation"
- Mois: "2026-04"

ET TU CLIQUES "FILTRER"

═══════════════════════════════════

APRÈS (avec filtre):
┌─────────────┬────────────────┐
│ Catégorie   │ Montant        │
├─────────────┼────────────────┤
│ Alimentation│ 50€ (avril)    │
└─────────────┴────────────────┘
Total: 1 dépense affichée
(SEULEMENT alimentation d'avril)
```

### Exemple Concret

```
Cas 1: Filtrer par Catégorie seulement
─────────────────────────────────────
Sélectionne: Catégorie = "Transport"
Clique: Filtrer
Résultat: Toutes les dépenses de transport (tous mois)

Cas 2: Filtrer par Mois seulement
─────────────────────────────────────
Sélectionne: Mois = "2026-04"
Clique: Filtrer
Résultat: Toutes les dépenses d'avril (toutes catégories)

Cas 3: Filtrer par Catégorie ET Mois
─────────────────────────────────────
Sélectionne: Catégorie = "Alimentation" + Mois = "2026-04"
Clique: Filtrer
Résultat: SEULEMENT alimentation d'avril
```

### Utilité
✅ **Chercher rapidement** tes dépenses  
✅ **Trouver** ce que tu as dépensé en Restaurant en mars  
✅ **Analyser** tes habitudes par catégorie ou mois  
✅ **Vérifier** une transaction spécifique

---

## 🔄 BOUTON "RÉINITIALISER"

### Rôle
**Effacer TOUS les filtres** et revenir à l'affichage de TOUTES les dépenses.

### Fonctionnement

```
TU AVAIS FILTRÉ:
- Catégorie: "Alimentation"
- Mois: "2026-04"

TABlE AFFICHE: 1 dépense (alimentation avril)

═══════════════════════════════════

TU CLIQUES "RÉINITIALISER"

═══════════════════════════════════

MAINTENANT:
- Catégorie: (vide - toutes)
- Mois: (vide - tous)

TABLE AFFICHE: TOUTES les dépenses (4 au total)
```

### Exemple Concret

```
Situation:
─────────────────────────────────────
Tu as filtré: Transport + Mai 2026
Tu vois: 3 dépenses d'essence

Tu cliques "Réinitialiser"

Résultat:
─────────────────────────────────────
Les filtres disparaissent
Tu vois: 47 dépenses (toutes)
```

### Utilité
✅ **Annuler** tes filtres rapidement  
✅ **Revenir** à la vue globale  
✅ **Recommencer** une nouvelle recherche  
✅ **Nettoyer** les sélections

---

## 💡 CAS D'USAGE RÉELS

### Scénario 1: "Je veux vérifier mes achats alimentaires en avril"
```
1. Va sur CRUD Dépenses
2. Sélectionne: Catégorie = "Alimentation"
3. Sélectionne: Mois = "Avril 2026"
4. Clique: FILTRER
→ Tu vois SEULEMENT tes dépenses alimentaires d'avril
→ Tu comptes le total pour cette catégorie
```

### Scénario 2: "Je veux voir TOUT ce que j'ai dépensé"
```
1. Tu avais appliqué plusieurs filtres
2. Tu veux voir la vue d'ensemble
3. Clique: RÉINITIALISER
→ Tous les filtres disparaissent
→ Tu vois 100% de tes dépenses
```

### Scénario 3: "Je cherche une dépense spécifique"
```
1. Je me souviens d'une dépense en Transport en mars
2. Catégorie = "Transport" + Mois = "Mars 2026"
3. Clique: FILTRER
→ Je vois seulement transport de mars
→ Je trouve facilement ma dépense
```

---

## 🎯 RÉSUMÉ RAPIDE

| Aspect | Filtrer | Réinitialiser |
|--------|---------|---------------|
| **Rôle** | Chercher des dépenses spécifiques | Voir toutes les dépenses |
| **Action** | Affiche ce qui correspond aux critères | Efface les filtres |
| **Résultat** | MOINS de dépenses (plus ciblé) | TOUTES les dépenses |
| **Utilité** | Analyser, vérifier, chercher | Revenir à la vue complète |

---

## 🔧 Détails Techniques

### Code du Filtrer
```php
<button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
```
- Type: Submit (envoie le formulaire)
- Envoie: Les sélections en URL (GET)
- Query string: `?categorie=1&mois=2026-04`
- PHP filtre la table avec ces paramètres

### Code du Réinitialiser
```php
<a href="crud_depense.php" class="btn btn-secondary btn-sm">Réinitialiser</a>
```
- Type: Lien (pas submit)
- Redirige vers: `crud_depense.php` (URL vierge)
- Effet: Les paramètres GET disparaissent
- Résultat: Plus de filtre = affiche tout

---

**Résumé**: Filtrer = chercher | Réinitialiser = tout voir 🎯
