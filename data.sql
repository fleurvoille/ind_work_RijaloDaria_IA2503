
INSERT INTO movies (title, description, year, genre, rating)
VALUES
('Interstellar', 'A team of explorers travels beyond this galaxy to discover a new home for humanity.', 2014, 'Sci-Fi', 8.7),
('Inception', 'A thief enters peoples dreams to steal secrets and manipulate ideas.', 2010, 'Sci-Fi', 8.8),
('The Dark Knight', 'Batman faces the Joker, a criminal who brings chaos to Gotham City.', 2008, 'Action', 9.0),
('Avatar', 'A marine travels to Pandora and becomes part of an extraordinary world.', 2009, 'Fantasy', 7.9),
('The Shawshank Redemption', 'A banker sentenced to life imprisonment finds hope and friendship in prison.', 1994, 'Drama', 9.3),
('Joker', 'A troubled comedian struggles with society and gradually transforms into a criminal.', 2019, 'Drama', 8.4),
('Harry Potter and the Philosopher''s Stone', 'A young boy discovers that he is a wizard and begins his journey at Hogwarts.', 2001, 'Fantasy', 7.6),
('Titanic', 'Two people from different social backgrounds fall in love aboard the famous ship.', 1997, 'Romance', 7.9);


UPDATE movies SET poster = 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg'
WHERE title = 'Interstellar';

UPDATE movies SET poster = 'https://image.tmdb.org/t/p/w500/oYuLEt3zVCKq57qu2F8dT7NIa6f.jpg'
WHERE title = 'Inception';

UPDATE movies SET poster = 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg'
WHERE title = 'The Dark Knight';

UPDATE movies SET poster = 'https://image.tmdb.org/t/p/w500/t6HIqrRAclMCA60NsSmeqe9RmNV.jpg'
WHERE title = 'Avatar';

UPDATE movies SET poster = 'https://image.tmdb.org/t/p/w500/9cqNxx0GxF0bflZmeSMuL5tnGzr.jpg'
WHERE title = 'The Shawshank Redemption';

UPDATE movies SET poster = 'https://image.tmdb.org/t/p/w500/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg'
WHERE title = 'Joker';

UPDATE movies SET poster = 'https://image.tmdb.org/t/p/w500/wuMc08IPKEatf9rnMNXvIDxqP4W.jpg'
WHERE title = 'Harry Potter and the Philosopher''s Stone';

UPDATE movies SET poster = 'https://image.tmdb.org/t/p/w500/9xjZS2rlVxm8SFx8kPC3aIGCOYQ.jpg'
WHERE title = 'Titanic';


SELECT * FROM movies;