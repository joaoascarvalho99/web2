CREATE TABLE imgs(
    imgid INT AUTO_INCREMENT PRIMARY KEY,
    file VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE users (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL UNIQUE,
    fk_img INT NOT NULL,
	FOREIGN KEY (fk_img) REFERENCES imgs(imgid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tema(
	temaid INT AUTO_INCREMENT PRIMARY KEY,
	temaname VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE post(
	postid INT AUTO_INCREMENT PRIMARY KEY,
	fk_userid INT NOT NULL,
	fk_temaid INT NOT NULL,
	fk_img INT,
	postname VARCHAR(40) NOT NULL,
	posttext VARCHAR(1000) NOT NULL,
	FOREIGN KEY (fk_temaid) REFERENCES tema(temaid),
	FOREIGN KEY (fk_img) REFERENCES imgs(imgid),
	FOREIGN KEY (fk_userid) REFERENCES users(userid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE comentarios(
	fk_postid INT NOT NULL,
	fk_userid INT NOT NULL,
	fk_imgid INT,
	comentario VARCHAR(1000) NOT NULL,
	data VARCHAR(16) NOT NULL,
	FOREIGN KEY (fk_postid) REFERENCES post(postid),
	FOREIGN KEY (fk_userid) REFERENCES users(userid),
	FOREIGN KEY (fk_imgid) REFERENCES imgs(imgid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE likes(
	fk_postid INT NOT NULL,
	fk_userid INT NOT NULL,
	stat BOOLEAN NOT NULL,
	FOREIGN KEY (fk_postid) REFERENCES post(postid),
	FOREIGN KEY (fk_userid) REFERENCES users(userid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;