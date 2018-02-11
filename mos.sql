USE mos;
DROP TABLE surveyswtbl;
CREATE TABLE surveyswtbl (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  surveysw int default 0,
  createdate datetime,
  PRIMARY KEY (id)
); 
