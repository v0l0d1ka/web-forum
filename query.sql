CREATE TABLE authors (
	id_author INT(6) NOT NULL AUTO_INCREMENT,
    name TINYTEXT NOT NULL,
    passwd TINYTEXT NOT NULL,
    email TINYTEXT NOT NULL,
    sendmail ENUM('yes', 'no') NOT NULL DEFAULT 'no',
    url TINYTEXT NOT NULL,
    about MEDIUMTEXT NOT NULL,
    photo TINYTEXT NOT NULL,
    time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    last_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    themes INT(10) NOT NULL DEFAULT '0',
    statususer ENUM('', 'moderator', 'admin') NOT NULL DEFAULT '',
    PRIMARY KEY (id_author)
) ENGINE=MyISAM;