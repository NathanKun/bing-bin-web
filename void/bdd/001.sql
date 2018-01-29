create table Users(
    id varchar(50),
    name text,
    firstname text,
    email text,
    img_url text,
    date_nais timestamp,
    eco_point integer,
    constraint users_primary primary key (id)
);

create table TrashesTypes(
    id varchar(50),
    name text,
    constraint trashestypes_primary primary key (id)
);

create table Trashes(
    id varchar(50),
    name text,
    id_type varchar(50),
    constraint trashes_primary primary key (id)
);

create table Historiques(
    id varchar(50),
    id_user varchar(50),
    id_trashe varchar(50),
    date_of_scan timestamp,
    latitude float,
    longitude float,
    constraint historiques_primary primary key (id),
    constraint historiques_users foreign key (id_user) references Users(id),
    constraint historiques_trashes foreign key(id_trashe) references Trashes(id)
);

create table CouponsTypes(
    id varchar(50),
    name text,
    constraint couponstypes_primary primary key (id)
);

create table Coupons(
    id varchar(50),
    name text,
    id_user varchar(50),
    id_type varchar(50),
    limit_date timestamp,
    used tinyint(1),
    constraint coupons_primary primary key (id),
    constraint coupons_users foreign key(id_user) references Users(id),
    constraint coupons_couponstypes foreign key(id_type) references CouponsTypes(id)
);

