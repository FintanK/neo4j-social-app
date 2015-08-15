CREATE
(
	john:User {
		name:'John',
		email: "john@abc.com",
		address: "1 Example address, Cork",
		country : 'Ireland',
		age:28,
		gender:'M'
	}
),
(mary:User {name:'Mary', email: "mary@abc.com", address: "2 example address, Donegal", country :'Ireland', age:26, gender:'F' }),
(jack:User {name:'Jack', email: "jack@abc.com", address: "3 example address, Mayo", country :'Ireland', age:29, gender:'M' }),
(katie:User {name:'Katie', email: "katie@abc.com", address: "4 example address, Dublin", country :'Ireland', age:23, gender:'F' })


// Create relationships between nodes

CREATE
(john)-
	[:FOLLOWS{
		connection:'friend',
		since: 10/04/2013
	}]->(mary),

(john)-[:FOLLOWS{connection:'friend', since: 12/06/2011}]->(jack),
(mary)-[:FOLLOWS{connection:'friend', since: 10/04/2013}]->(john),
(katie)-[:FOLLOWS{connection:'friend', since: 10/04/2013}]->(mary)


// Create nodes for user social network details

CREATE
(johntwitter:SocialNetwork
	{
		Application:'Twitter',
		ID:'@Johnny'
	}
),
(jacktwitter:SocialNetwork {Application:'Twitter',ID:'@Jack'})


// Create a relationship between the users and their social network details

CREATE
(john)
	-[:USES_SOCIAL_NETWORK{
		posts:25
	}]->(johntwitter),
(jack)-[:USES_SOCIAL_NETWORK{posts:12}]->(jacktwitter)


// Create nodes for the 'sport' category and sport types

CREATE
(sport:Interest{name:'Sport'}),
(tennis:Interest{name:'Tennis'}),
(football:Interest{name:'Soccer'}),
(badminton:Interest{name:'Badminton'}),

// Create relationships between the sports and their category nodes

(tennis)-[:IS_A]->(sport),
(football)-[:IS_A]->(sport),
(badminton)-[:IS_A]->(sport),

// Create relationships between user's and thier interests
(mary)-[:LIKES]->(tennis),
(john)-[:LIKES]->(tennis);