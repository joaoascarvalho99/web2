CREATE TABLE users(
	userid INTEGER PRIMARY KEY AUTOINCREMENT, 
	username VARCHAR(20) NOT NULL UNIQUE, 
	password VARCHAR(30) NOT NULL,
	email VARCHAR(30) NOT NULL UNIQUE,
	fk_img INTEGER NOT NULL,
	FOREIGN KEY (fk_img) REFERENCES imgs(imgid)
);

CREATE TABLE tema(
	temaid INTEGER PRIMARY KEY AUTOINCREMENT,
	temaname VARCHAR(50) NOT NULL
);

CREATE TABLE imgs(
    imgid INTEGER PRIMARY KEY AUTOINCREMENT,
    file VARCHAR(255) NOT NULL
);

CREATE TABLE post(
	postid INTEGER PRIMARY KEY AUTOINCREMENT, 
	fk_temaid INTEGER NOT NULL, 
	fk_img INTEGER,
	postname VARCHAR(40) NOT NULL, 
	posttext VARCHAR(1000) NOT NULL,
	FOREIGN KEY (fk_temaid) REFERENCES tema(temaid),
	FOREIGN KEY (fk_img) REFERENCES imgs(imgid)
);

CREATE TABLE comentarios(
	fk_postid INTEGER NOT NULL,
	fk_userid INTEGER NOT NULL,
	fk_imgid INTEGER,
	comentario VARCHAR(1000) NOT NULL,
	data VARCHAR(16) NOT NULL,
	FOREIGN KEY (fk_postid) REFERENCES post(postid),
	FOREIGN KEY (fk_userid) REFERENCES users(userid),
	FOREIGN KEY (fk_imgid) REFERENCES imgs(imgid)
);

CREATE TABLE likes(
	likeid INTEGER PRIMARY KEY AUTOINCREMENT,
	fk_postid INTEGER NOT NULL,
	fk_userid INTEGER NOT NULL,
	stat BOOLEAN NOT NULL,
	FOREIGN KEY (fk_postid) REFERENCES post(postid),
	FOREIGN KEY (fk_userid) REFERENCES users(userid)
);

/*
CREATE TABLE users (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL UNIQUE,
    fk_img INTEGER NOT NULL,
	FOREIGN KEY (fk_img) REFERENCES imgs(imgid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tema(
	temaid INT AUTO_INCREMENT PRIMARY KEY,
	temaname VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE imgs(
    imgid INT AUTO_INCREMENT PRIMARY KEY,
    file VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE post(
	postid INT AUTO_INCREMENT PRIMARY KEY, 
	fk_temaid INT NOT NULL, 
	fk_img INT,
	postname VARCHAR(40) NOT NULL, 
	posttext VARCHAR(1000) NOT NULL,
	FOREIGN KEY (fk_temaid) REFERENCES tema(temaid),
	FOREIGN KEY (fk_img) REFERENCES imgs(imgid)
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
	likeid INT AUTO_INCREMENT PRIMARY KEY,
	fk_postid INT NOT NULL,
	fk_userid INT NOT NULL,
	stat BOOLEAN NOT NULL,
	FOREIGN KEY (fk_postid) REFERENCES post(postid),
	FOREIGN KEY (fk_userid) REFERENCES users(userid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

*/


/* INSERTS */
INSERT INTO users (username, password, email, fk_img) VALUES
('joao', '12345', 'joao@example.com'), 1,
('maria', 'abcde', 'maria@example.com', 2),
('tiago', 'pass123', 'tiago@example.com', 3);

INSERT INTO tema (temaname) VALUES
('Tecnologia'),
('Natureza'),
('Arte');

INSERT INTO imgs (file) VALUES
('img1.jpg'),
('img2.png'),
('img3.webp');

INSERT INTO post (fk_temaid, fk_img, postname, posttext) VALUES
(1, 1, 'Novo Smartphone', 'Descrição do novo smartphone lançado este ano.'),
(2, 2, 'Paisagem Verde', 'Uma vista fantástica sobre o vale.'),
(3, NULL, 'Quadro Moderno', 'Obra de arte contemporânea com cores vivas.');

INSERT INTO comentarios (fk_postid, fk_userid, fk_imgid, comentario, data) VALUES
(1, 1, NULL, 'Gostei muito do artigo.', '2025-01-01 14:32'),
(1, 2, NULL, 'Boa explicação!', '2025-01-01 15:10'),
(2, 3, 2, 'Fotografia incrível!', '2025-01-02 09:45'),
(3, 1, NULL, 'Interessante, continua.', '2025-01-03 18:22');

INSERT INTO likes (fk_postid, fk_userid, stat) VALUES
(1, 1, 1),
(1, 2, 1),
(2, 1, 0),
(3, 3, 1);





