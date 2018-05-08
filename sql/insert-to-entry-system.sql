USE entry_system;

--- insert 'standard user' and 'admin' ---

INSERT INTO groups (
	name,
	permissions
) VALUES (
	'Standard user',
	''
);


INSERT INTO groups (
	name,
	permissions
) VALUES (
	'Administrator',
	'{"admin": 1}'
);
