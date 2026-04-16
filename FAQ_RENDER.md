# ❓ FAQ - fintrack sur Render

## Q1: Qu'est-ce que je dois copier exactement de PostgreSQL?

**R:** 4 valeurs seulement:

```
Host → DB_HOST
Database → DB_NAME
Username → DB_USER
Password → DB_PASSWORD
```

Et ajouter ces 2 constants:
```
DB_PORT = 5432 (toujours)
DB_TYPE = postgres (toujours)
```

---

## Q2: Où je copie ces valeurs?

**R:** Sur le Dashboard Render:
1. PostgreSQL créé → Tu verras une page avec "Connection Details"
2. Copie les 4 valeurs
3. Colle-les dans Web Service → Environment

---

## Q3: Pourquoi "Free" plan?

**R:** 
- ✅ Pour tester et développer
- ✅ Gratuit pendant 3 mois
- ⚠️ Après: Suppression automatique
- 💡 Passe à "Paid" quand prêt pour production

---

## Q4: Quel "Region" choisir?

**R:** 
- Choisis la même région pour PostgreSQL et Web Service!
- Exemple: Oregon pour les deux
- Cela améliore les performances

---

## Q5: Mon deploy échoue, comment je debug?

**R:**
1. Va dans le Web Service
2. Clique **"Logs"**
3. Cherche les lignes rouges = erreurs
4. Lis le message d'erreur
5. Corrige le problème
6. Clique **"Redeploy"** ou pousse du code

---

## Q6: Combien de temps ça prend?

**R:**
- PostgreSQL: 2-3 min
- Web Service: 2-3 min
- Install (install_postgres.php): < 1 min
- **Total: ~10 minutes**

---

## Q7: Comment tester localement avant de déployer?

**R:** Sur ton PC local:
```bash
# Lancer PHP local
php -S localhost:8000

# Accéder à l'app
http://localhost:8000/index.html
```

---

## Q8: Puis-je utiliser MySQL à la place de PostgreSQL?

**R:** 
- ✅ Oui, le code supporte les deux
- Modifie juste: `DB_TYPE = mysql`
- Change: `DB_PORT = 3306` (MySQL)
- Render a MySQL aussi

---

## Q9: Comment je fais des mises à jour?

**R:**
1. Modifie le code localement
2. Test sur ton PC
3. `git add .`
4. `git commit -m "description"`
5. `git push`
6. Render redéploie **automatiquement**
7. Aucun downtime! ✅

---

## Q10: Mon app affiche une page blanche?

**R:** Étapes:
1. Clique Logs du Web Service
2. Cherche les erreurs PHP
3. Vérifie variables d'environnement
4. Relance: Redeploy
5. Si encore blanc: Contact support

---

## Q11: Combien ça coûte?

**R:**
- **Free Plan**: $0 (3 mois gratuit)
- **PostgreSQL Basique**: ~$6/mois
- **Web Service Basique**: ~$7/mois
- **Total**: ~$13/mois après essai

---

## Q12: Comment je sauvegarde mes données?

**R:**
- Render PostgreSQL = Sauvegarde auto
- Si tu upgrades à "Pro": Backup quotidiens
- Free: Pas de backup auto
- 💡 Exporte régulièrement tes données!

---

## Q13: Peut-on accéder à la BD directement?

**R:** 
- ✅ Oui, avec les credentials
- Utilise pgAdmin ou DBeaver
- ⚠️ Attention à modifier les données!

---

## Q14: Qu'est-ce que "Install_postgres.php" fait?

**R:** 
- Crée les 3 tables: users, categories, depenses
- Insère les 7 catégories par défaut
- Crée les index pour performance
- À appeler UNE SEULE FOIS après deploy

---

## Q15: Puis-je avoir plusieurs apps fintrack?

**R:**
- ✅ Oui! Crée plusieurs Web Services
- Chacun connecté à une BD différente
- Exemple:
  - fintrack-prod
  - fintrack-dev
  - fintrack-test

---

## Q16: L'app ralentit avec le temps?

**R:**
- Mets en cache (Redis)
- Optimise les requêtes SQL
- Index les colonnes fréquemment cherchées
- Nettoie les anciennes données

---

## Q17: Comment je monitore l'app?

**R:**
- Dashboard Render = Voir le statut
- Logs = Voir les erreurs
- Health endpoint: `/health.php`
- Datadog: Intégration optionnelle

---

## Q18: Pouvez-vous avoir d'autres utilisateurs?

**R:**
- ✅ Bien sûr! Chacun se crée un compte
- Chaque user a ses propres dépenses
- Isolation totale par user_id
- Scalabilité: ✅

---

## Q19: Comment reset la BD?

**R:**
1. PostgreSQL Dashboard → Delete (attention!)
2. Crée une nouvelle BD
3. Mets à jour les credentials
4. Redéploie
5. Accède à /install_postgres.php

---

## Q20: Questions encore?

**R:** Check:
- [RENDER_DEPLOYMENT_CHECKLIST.md](RENDER_DEPLOYMENT_CHECKLIST.md)
- [POSTGRES_SETUP.md](POSTGRES_SETUP.md)
- Ou pose la question! 💬

