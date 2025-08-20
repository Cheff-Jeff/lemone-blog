<?php
$pdo = new PDO(
    'mysql:host=lemone-blog-db;port=3306;dbname=lemoneBlogDB;charset=utf8',
    'root',
    'root_password'
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$user1 = [
    'email' => 'jeffreynijkamp@mail.com',
    'password' => password_hash('password', PASSWORD_DEFAULT)
];

$user2 = [
    'email' => 'henrycavill@mail.com',
    'password' => password_hash('password', PASSWORD_DEFAULT)
];

$user3 = [
    'email' => 'jamesgunn@mail.com',
    'password' => password_hash('password', PASSWORD_DEFAULT)
];

$stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
$stmt->bindParam(':email', $user1['email']);
$stmt->bindParam(':password', $user1['password']);
$stmt->execute();
$user1['id'] = $pdo->lastInsertId();

$stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
$stmt->bindParam(':email', $user2['email']);
$stmt->bindParam(':password', $user2['password']);
$stmt->execute();
$user2['id'] = $pdo->lastInsertId();

$stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
$stmt->bindParam(':email', $user3['email']);
$stmt->bindParam(':password', $user3['password']);
$stmt->execute();
$user3['id'] = $pdo->lastInsertId();



$post1 = [
    'title' => "Tom Cruise brak 'bijna' zijn rug door stunt in Mission: Impossible",
    'content' => 'Tom Cruise heeft tijdens de opnames van de actiefilm Mission: Impossible - The Final Reckoning "bijna" zijn rug gebroken. Ook zijn de vingers van de 63-jarige acteur uit de kom geschoten, schrijft Entertainment Weekly. Cruise staat erom bekend dat hij de stunts in de films zelf uitvoert. "O, dit heeft mijn rug bijna gebroken", zegt hij bij de digitale release van de film, waarbij hij samen met regisseur Christopher McQuarrie terugblikt. De acteur geeft commentaar bij de scène waarin hij zich aan een vliegtuigvleugel moet vasthouden. Ook bespreken Cruise en McQuarrie een scène waarin Cruise zich moest vasthouden aan een veiligheidsgordel. "Dit zorgde ervoor dat de gewrichten in Toms vingers uit elkaar werden getrokken door de kracht. Tegen de tijd dat we deze scène hadden afgerond, waren zijn handen helemaal opgezwollen. Het was zo pijnlijk om te zien", zegt de regisseur. Mission: Impossible - The Final Reckoning is het achtste en laatste deel van de Mission: Impossible-actiefilmreeks met Cruise in de hoofdrol. De acteur heeft door zijn rol in de films het Guinness World Record voor de "meeste sprongen met een brandende parachute" in handen.',
    'created_at' => '2025-08-21',
    'user_id' => $user1['id']
];

$post2 = [
    'title' => 'Serie over Guinness-brouwerij eind september op Netflix te zien',
    'content' => "De nieuwe serie House of Guinness is vanaf 25 september bij Netflix te zien. De serie draait om de gelijknamige bierbrouwerij. House of Guinness is geïnspireerd op de familie Guinness van het bekende donkergekleurde bier. Het verhaal speelt zich af in de negentiende eeuw in Dublin en New York en begint meteen na het overlijden van Sir Benjamin Guinness, die verantwoordelijk was voor het succes van de familiebrouwerij. De serie is bedacht en geschreven door Steven Knight, die eerder de succesvolle serie Peaky Blinders bedacht. De hoofdrollen in House of Guinness zijn voor Anthony Boyle, Louis Partridge, Emily Fairn en Fionn O'Shea. Tom Shankland en Mounia Akl regisseren de serie.",
    'created_at' => '2025-08-19',
    'user_id' => $user2['id']
];

$post3 = [
    'title' => "Margot Robbie werkt met haar productiebedrijf aan The Sims-film",
    'content' => "Margot Robbie werkt met haar productiebedrijf LuckyChap aan een The Sims-film, meldt The Hollywood Reporter. Kate Herron, die verantwoordelijk is voor de Disney+-serie Loki, is de beoogde regisseur van de film. The Sims is een simulatiegame waarin spelers een poppetje kunnen creëren en een levensloop kunnen uitstippelen voor deze Sim. Zo kunnen Sims een baan krijgen in verschillende sectoren, kinderen krijgen of adopteren en een huis kopen. Het eerste deel kwam in 2000 uit. Daarna volgden nog drie nieuwe delen en talloze uitbreidingssets. Het is nog onduidelijk hoe de film over The Sims eruit gaat zien en hoeveel elementen uit het spel erin worden verwerkt. Ook is niet duidelijk wie de hoofdrollen gaan spelen. LuckyChap werd in 2014 opgericht door onder anderen Robbie. Het productiebedrijf boekte al verschillende successen. De grootste kaskraker was Barbie, met Robbie in de hoofdrol. Die film bracht wereldwijd ruim 1,3 miljard euro op.",
    'created_at' => '2025-07-19',
    'user_id' => $user3['id']
];

$stmt = $pdo->prepare("INSERT INTO posts (title, content, created_at, user_id) VALUES(:title, :content, :date, :user_id)");
$stmt->bindParam(':title', $post1['title']);
$stmt->bindParam(':content', $post1['content']);
$stmt->bindParam(':date', $post1['created_at']);
$stmt->bindParam(':user_id', $post1['user_id']);
$stmt->execute();
$post1['id'] = $pdo->lastInsertId();

$stmt = $pdo->prepare("INSERT INTO posts (title, content, created_at, user_id) VALUES(:title, :content, :date, :user_id)");
$stmt->bindParam(':title', $post2['title']);
$stmt->bindParam(':content', $post2['content']);
$stmt->bindParam(':date', $post2['created_at']);
$stmt->bindParam(':user_id', $post2['user_id']);
$stmt->execute();
$post2['id'] = $pdo->lastInsertId();

$stmt = $pdo->prepare("INSERT INTO posts (title, content, created_at, user_id) VALUES(:title, :content, :date, :user_id)");
$stmt->bindParam(':title', $post3['title']);
$stmt->bindParam(':content', $post3['content']);
$stmt->bindParam(':date', $post3['created_at']);
$stmt->bindParam(':user_id', $post3['user_id']);
$stmt->execute();
$post3['id'] = $pdo->lastInsertId();



$response1 = [
    'title' => "Guinness Serie ?",
    'content' => "Wouw ik kan niet wachten, Ik houd van Guinness!",
    'user_id' => $user1['id'],
    'post_id' => $post2['id']
];
$response2 = [
    'title' => "Zijn de stunts echt?",
    'content' => "Ik dacht dat acteurs verplicht een stunt man moesten gebruiken.",
    'user_id' => $user3['id'],
    'post_id' => $post1['id']
];
$response3 = [
    'title' => "Harley Quinn...",
    'content' => "Is dat niet die vrouw die Harley Quinn speelde?!",
    'user_id' => $user2['id'],
    'post_id' => $post3['id']
];

$stmt = $pdo->prepare("INSERT INTO reactions (title, content, created_at, user_id, post_id) VALUES (:title, :content, '25-08-21', :user_id, :post_id)");
$stmt->bindParam(':title', $response1['title']);
$stmt->bindParam(':content', $response1['content']);
$stmt->bindParam(':user_id', $response1['user_id']);
$stmt->bindParam(':post_id', $response1['post_id']);
$stmt->execute();

$stmt = $pdo->prepare("INSERT INTO reactions (title, content, created_at, user_id, post_id) VALUES (:title, :content, '25-08-21', :user_id, :post_id)");
$stmt->bindParam(':title', $response2['title']);
$stmt->bindParam(':content', $response2['content']);
$stmt->bindParam(':user_id', $response2['user_id']);
$stmt->bindParam(':post_id', $response2['post_id']);
$stmt->execute();

$stmt = $pdo->prepare("INSERT INTO reactions (title, content, created_at, user_id, post_id) VALUES (:title, :content, '25-08-21', :user_id, :post_id)");
$stmt->bindParam(':title', $response3['title']);
$stmt->bindParam(':content', $response3['content']);
$stmt->bindParam(':user_id', $response3['user_id']);
$stmt->bindParam(':post_id', $response3['post_id']);
$stmt->execute();