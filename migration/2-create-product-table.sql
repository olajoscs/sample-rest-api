DROP TABLE IF EXISTS products;

CREATE TABLE products (
  id          INT          NOT NULL AUTO_INCREMENT,
  name        VARCHAR(255) NOT NULL,
  price       INT          NOT NULL,
  categoryId  INT          NOT NULL,
  description TEXT         NOT NULL,
  url         VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  KEY categoryId (categoryId),
  FOREIGN KEY (categoryId) REFERENCES categories (id)
    ON UPDATE RESTRICT
    ON DELETE RESTRICT
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

