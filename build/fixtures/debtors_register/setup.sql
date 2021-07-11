
create table debtors (
    id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    surname VARCHAR(255),
    ssn INTEGER,
    PRIMARY KEY (id)
);

insert into debtors (name, surname, ssn) values ('Hugh', 'Rhodes', 665512);
insert into debtors (name, surname, ssn) values ('Hope', 'Foster', 445689);
insert into debtors (name, surname, ssn) values ('Eugenia', 'Turner', 114780);
insert into debtors (name, surname, ssn) values ('Lucy', 'Cross', 330698);
insert into debtors (name, surname, ssn) values ('Karen', 'Kelly', 741896);
