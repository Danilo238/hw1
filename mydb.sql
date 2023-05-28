create database test;
use test;

create table users(
	id integer primary key NOT NULL auto_increment,
    email varchar(30) not null unique,
    username varchar(20) not null unique,
    password varchar(20)
);

create table games(
	id integer primary key NOT NULL,
    name varchar(20)
);

create table preferiti(
	id_user integer NOT NULL,
    id_game integer NOT NULL,
    primary key (id_user, id_game),
    foreign key (id_user) references users(id),
    foreign key (id_game) references games(id)
);