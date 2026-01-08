CREATE TABLE imgs(
    imgid INT AUTO_INCREMENT PRIMARY KEY,
    file VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE users (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL UNIQUE,
    fk_imgid INT NOT NULL,
	FOREIGN KEY (fk_imgid) REFERENCES imgs(imgid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tema(
	temaid INT AUTO_INCREMENT PRIMARY KEY,
	temaname VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE post(
	postid INT AUTO_INCREMENT PRIMARY KEY,
	fk_userid INT NOT NULL,
	fk_temaid INT NOT NULL,
	fk_imgid INT DEFAULT NULL,
	postname VARCHAR(40) NOT NULL,
	posttext VARCHAR(1000) NOT NULL,
	code VARCHAR(500) DEFAULT NULL,
	comments INT NOT NULL DEFAULT 0,
  	upvotes INT NOT NULL DEFAULT 0,
  	downvotes INT NOT NULL DEFAULT 0,
  	data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (fk_temaid) REFERENCES tema(temaid),
	FOREIGN KEY (fk_imgid) REFERENCES imgs(imgid),
	FOREIGN KEY (fk_userid) REFERENCES users(userid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE comentarios_post(
	compostid INT AUTO_INCREMENT PRIMARY KEY,
	fk_postid INT NOT NULL,
	fk_userid INT NOT NULL,
	fk_imgid INT DEFAULT NULL,
	comentario VARCHAR(1000) NOT NULL,
	data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (fk_postid) REFERENCES post(postid),
	FOREIGN KEY (fk_userid) REFERENCES users(userid),
	FOREIGN KEY (fk_imgid) REFERENCES imgs(imgid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE respostas(
	fk_compostid INT NOT NULL,
	fk_userid INT NOT NULL,
	fk_imgid INT DEFAULT NULL,
	resposta VARCHAR(1000) NOT NULL,
	data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (fk_compostid) REFERENCES comentarios_post(compostid),
	FOREIGN KEY (fk_userid) REFERENCES users(userid),
	FOREIGN KEY (fk_imgid) REFERENCES imgs(imgid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE likes(
	fk_postid INT NOT NULL,
	fk_userid INT NOT NULL,
	stat BOOLEAN DEFAULT NULL,
	FOREIGN KEY (fk_postid) REFERENCES post(postid),
	FOREIGN KEY (fk_userid) REFERENCES users(userid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;