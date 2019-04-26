create database moja_domena_pl;

create user moja_domena_pl_apache@localhost identified by "P@ssw0rd";
grant all privileges on moja_domena_pl.* to moja_domena_pl_apache@localhost;

use moja_domena_pl;

create table `table`
(
    id int auto_increment,
    name varchar(25) null,
    surname varchar(25) null,
    email varchar(50) null,
    datetime_add datetime null,
    constraint table_pk
        primary key (id)
);

create unique index table_email_uindex
    on `table` (email);

