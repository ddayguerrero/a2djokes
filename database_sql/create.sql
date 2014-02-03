CREATE TABLE jokes 
( _id int(100) NOT NULL AUTO_INCREMENT, 
 category varchar(35) NOT NULL,
 sub_category varchar(35) NOT NULL, 
 joke_type smallint(1) unsigned NOT NULL, 
 description varchar(100),
 question varchar(200),
 answer varchar(200),
 monologue varchar(200),
 url varchar(200),
 joke_source varchar(200),
 comments varchar(100),
 rating int(9) unsigned NOT NULL,
 release_status numeric NOT NULL,
 create_date DATETIME NOT NULL,
 modify_date DATETIME NOT NULL,
  PRIMARY KEY(_id))
ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE category
(_id int(100) unsigned NOT NULL AUTO_INCREMENT, 
 category varchar(35) NOT NULL,
 sub_category varchar(35) NOT NULL,
 num_of_jokes int(100) NOT NULL,
 PRIMARY KEY(_id))
ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE users
(_id int(100) unsigned NOT NULL AUTO_INCREMENT, 
 username varchar(35) NOT NULL,
 password varchar(100) NOT NULL,
 first_name varchar(35) NOT NULL,
 last_name varchar(35) NOT NULL,
 create_date DATETIME NOT NULL,
 modify_date DATETIME NOT NULL,
 PRIMARY KEY(_id))
ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;