-- drop database first if exists --
DROP DATABASE IF EXISTS entry_system;

CREATE DATABASE entry_system;

USE entry_system;

CREATE TABLE users (
	id int(5) not null AUTO_INCREMENT PRIMARY KEY,
	username varchar(20) not null,
	password varchar(64) not null,
	salt varchar(32) not null,
	name varchar(50) not null,
	date_joined datetime not null,
	user_group int(5) not null
);

CREATE TABLE groups (
	id int(5) not null AUTO_INCREMENT PRIMARY KEY,
	name varchar(20) not null,
	permissions text
);

CREATE TABLE users_session (
	id int(5) not null AUTO_INCREMENT PRIMARY KEY,
	user_id int(5) not null,
	hash varchar(64) not null
);
