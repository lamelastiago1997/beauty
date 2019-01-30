CREATE TABLE utilizadores (
	u_id						int not null AUTO_INCREMENT,
	u_email					varchar(80) not null,
	u_password				varchar(256) not null,
	u_estado					char(1) not null,
	
	PRIMARY KEY(u_id)
);

CREATE TABLE conf_conta (
	cc_id					int not null AUTO_INCREMENT,
	u_id					int not null,
	cc_codigo			int not null,
	cc_estado			int not null,
	
	PRIMARY KEY(cc_id),

	CONSTRAINT FK_RELATIONSHIP_1 FOREIGN KEY (u_id)
   REFERENCES utilizadores (u_id) 
);
