CREATE TABLE IF NOT EXISTS roles (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL UNIQUE,
  description TEXT NOT NULL
);

INSERT INTO roles (id, name, description) VALUES (1, 'login', 'Login privileges, granted after account confirmation');
INSERT INTO roles (id, name, description) VALUES (2, 'admin', 'Administrative user, has access to everything');

CREATE TABLE IF NOT EXISTS roles_users (
  user_id INTEGER NOT NULL,
  role_id INTEGER NOT NULL,
  PRIMARY KEY (user_id, role_id)
);

CREATE TABLE IF NOT EXISTS users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  email TEXT NOT NULL UNIQUE,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  logins INTEGER NOT NULL DEFAULT 0,
  last_login INTEGER 
);

CREATE TABLE IF NOT EXISTS user_tokens (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER NOT NULL,
  user_agent TEXT NOT NULL,
  token TEXT NOT NULL,
  created INTEGER NOT NULL,
  expires INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS records (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL UNIQUE,
  title TEXT,
  description TEXT,
  keywords TEXT,
  summary TEXT,
  body TEXT,
  num_views INTEGER NOT NULL DEFAULT 0,
  author_id INTEGER NOT NULL,
  created INTEGER NOT NULL,
  published INTEGER NOT NULL DEFAULT 0,
  type TEXT NOT NULL,
  slug TEXT NOT NULL UNIQUE,
  preview TEXT,
  commenting INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS taggings (
  tag_id INTEGER NOT NULL,
  record_id INTEGER NOT NULL,
  position INTEGER NOT NULL,
  PRIMARY KEY (tag_id, record_id)
);

CREATE TABLE IF NOT EXISTS initial_values (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL UNIQUE,
  value TEXT NOT NULL DEFAULT ''
);

INSERT INTO initial_values (id, name) VALUES (1, 'article_title');
INSERT INTO initial_values (id, name) VALUES (2, 'article_description');
INSERT INTO initial_values (id, name) VALUES (3, 'article_keywords');
INSERT INTO initial_values (id, name) VALUES (4, 'tag_title');
INSERT INTO initial_values (id, name) VALUES (5, 'tag_description');
INSERT INTO initial_values (id, name) VALUES (6, 'tag_keywords');

CREATE TABLE IF NOT EXISTS comments (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  author TEXT NOT NULL,
  url TEXT,
  body TEXT NOT NULL,
  article_id INTEGER NOT NULL,
  created INTEGER NOT NULL,
  published INTEGER NOT NULL DEFAULT 0
);
