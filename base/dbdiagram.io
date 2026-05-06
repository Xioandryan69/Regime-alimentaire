Project regimeAlimentaire {
  database_type: "MySQL"
}

Table users {
  id int [pk, increment]
  nom varchar(100)
  email varchar(150) [unique]
  password varchar(255)
  genre enum('H','F')
  date_naissance date
  created_at datetime
}

Table age_ranges {
  id int [pk, increment]
  age_min int
  age_max int
}

Table recommendations_weight {
  id int [pk, increment]
  age_range_id int
  genre enum('H','F')
  imc_min decimal(4,2)
  imc_max decimal(4,2)
  poids_min decimal(5,2)
  poids_max decimal(5,2)
}

Table health_rules {
  id int [pk]
  type varchar(50)
  age_min int
  age_max int
  genre enum('H','F')
  valeur_min decimal(5,2)
  valeur_max decimal(5,2)
}

Table user_health {
  id int [pk, increment]
  user_id int
  taille decimal(5,2)
  poids decimal(5,2)
  imc decimal(5,2)
  date_mesure datetime
}

Table objectifs {
  id int [pk, increment]
  nom varchar(100)
}

Table user_objectifs {
  user_id int
  objectif_id int
}

Table regimes {
  id int [pk, increment]
  nom varchar(100)
  description text
  pourcentage_viande int
  pourcentage_poisson int
  pourcentage_volaille int
  calories int
  prix decimal(10,2)
  duree_jours int
}

Table activites {
  id int [pk, increment]
  nom varchar(100)
  description text
  calories_brulees int
  duree_minutes int
}

Table recommendations {
  id int [pk, increment]
  user_id int
  regime_id int
  activite_id int
  date_debut date
  date_fin date
}

Table wallet {
  id int [pk, increment]
  user_id int
  solde decimal(10,2)
}

Table codes {
  id int [pk, increment]
  code varchar(50) [unique]
  valeur decimal(10,2)
  utilise boolean
}

Table transactions {
  id int [pk, increment]
  user_id int
  code_id int
  montant decimal(10,2)
  date_transaction datetime
}

Table abonnements {
  id int [pk, increment]
  user_id int
  type enum('FREE','GOLD')
  date_debut date
  date_fin date
}

Table imc_categories {
  id int [pk]
  min_value decimal(4,2)
  max_value decimal(4,2)
  label varchar(50)
}

Ref: recommendations_weight.age_range_id > age_ranges.id
Ref: user_health.user_id > users.id
Ref: user_objectifs.user_id > users.id
Ref: user_objectifs.objectif_id > objectifs.id
Ref: recommendations.user_id > users.id
Ref: recommendations.regime_id > regimes.id
Ref: recommendations.activite_id > activites.id
Ref: wallet.user_id > users.id
Ref: transactions.user_id > users.id
Ref: transactions.code_id > codes.id
Ref: abonnements.user_id > users.id