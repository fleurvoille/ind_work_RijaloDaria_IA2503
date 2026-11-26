CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user'
);

CREATE TABLE movies (
    id SERIAL PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    year INTEGER NOT NULL,
    genre VARCHAR(100) NOT NULL,
    rating DECIMAL(3,1) DEFAULT 0,
    poster VARCHAR(255),
    trailer VARCHAR(255)
);

CREATE TABLE favorites (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    movie_id INTEGER REFERENCES movies(id) ON DELETE CASCADE,
    UNIQUE(user_id, movie_id)
);

UPDATE users
SET role = 'admin'
WHERE email = 'aaabbb@gmail.com';


UPDATE users
SET role = 'admin'
WHERE email = 'bbbccc@gmail.com';
