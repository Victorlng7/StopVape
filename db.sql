CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  nom VARCHAR(100) NOT NULL,
  prenom VARCHAR(100) NOT NULL,
  mot_de_passe VARCHAR(255) NOT NULL
);

CREATE TABLE suivi_quotidien (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  date_releve DATE NOT NULL,
  
  puffs INT DEFAULT 0,
  volume_ml DECIMAL(5,2) DEFAULT 0,
  taux_nicotine DECIMAL(4,2) DEFAULT 0,
  
  cigarettes_fumees INT DEFAULT 0,
  niveau_manque TINYINT DEFAULT 1,
  
  depenses_euros DECIMAL(6,2) DEFAULT 0,
  
  FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);