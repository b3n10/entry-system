USE entry_system;

INSERT INTO users (
	id,
	username,
	password,
	salt,
	name,
	date_joined,
	user_group
) VALUES (
	NULL,
	'ben',
	'password',
	'salt',
	'Ben Lleve',
	'2018-05-10 11:38:15',
	'1'
);
