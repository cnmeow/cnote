CREATE TABLE users (
id SERIAL PRIMARY KEY,
email VARCHAR(255), -- In next version, we can use email to login/reset password
username VARCHAR(255) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL
);

CREATE TABLE tasks (
id SERIAL PRIMARY KEY,
userId INTEGER REFERENCES users(id) ON DELETE CASCADE,
title VARCHAR(255) NOT NULL,
content TEXT,
duedate DATE,
status INTEGER
);
