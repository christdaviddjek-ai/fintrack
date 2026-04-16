-- Script pour ajouter la colonne revenu_mensuel à la table users
-- Exécutez ce script si la table users existe déjà

ALTER TABLE users ADD COLUMN revenu_mensuel DECIMAL(10, 2) DEFAULT 0;

-- Vérification
SELECT * FROM users;
