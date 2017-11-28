DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
  id   INT AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  url  VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);
