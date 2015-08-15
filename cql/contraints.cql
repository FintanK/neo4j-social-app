// Define indexes and constraints
CREATE INDEX ON :User(name);
CREATE CONSTRAINT on (u:User) ASSERT u.email IS UNIQUE;
CREATE CONSTRAINT on (i:Interest) ASSERT i.name IS UNIQUE;
CREATE CONSTRAINT on (s:SocialNetwork) ASSERT s.name IS UNIQUE;


// Add John's surname (new property)

MATCH (n { name: 'John' })
SET n.surname = 'Doe'
RETURN n;

// Degrees of separation

MATCH p=shortestPath( (katie:User {name:"Katie"})-[*]-(jack:User {name:"Jack"}) ) RETURN p


// Add a new interest for John

MATCH (u:User)
WHERE u.name = 'John'
CREATE (i:Interest {name:'Soccer'} )<-[:LIKES]-(u);