<?php
require_once '/var/www/vendor/autoload.php';
//$pdo = new PDO('mysql:host=blogISA.mysql;dbname=blogISA', 'isa', 'isapwd');

$pdo = new PDO("mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE'),
                    getenv('MYSQL_USER'),
                    getenv('MYSQL_PASSWORD'));


//creation tables
echo "[";
$etape = $pdo->exec("CREATE TABLE post(
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            picture VARCHAR(255) NOT NULL,
            scientific VARCHAR(255) NOT NULL,
            size VARCHAR(255) NOT NULL,
            content TEXT(650000) NOT NULL,
            created_at DATETIME,
            PRIMARY KEY(id)
        )");
echo "||";
$etape = $pdo->exec("CREATE TABLE category(
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        )");
echo "||";
$etape = $pdo->exec("CREATE TABLE user(
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        )");
echo "||";
$pdo->exec("CREATE TABLE post_category(
            post_id INT UNSIGNED NOT NULL,
            category_id INT UNSIGNED NOT NULL,
            PRIMARY KEY(post_id, category_id),
            CONSTRAINT fk_post
                FOREIGN KEY(post_id)
                REFERENCES post(id)
                ON DELETE CASCADE
                ON UPDATE RESTRICT,
            CONSTRAINT fk_category
                FOREIGN KEY(category_id)
                REFERENCES category(id)
                ON DELETE CASCADE
                ON UPDATE RESTRICT
        )");
echo "||";
//vidage table
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
echo "||||||||||||";
$faker = Faker\Factory::create('fr_FR');
echo "||";
$posts = [];
$categories = [];
$images = ['Etourneau_CL.jpg', 'MartinPecheur_GB.jpg', 'mesange.jpg', 
'MoineauX_PRM.jpg', 'PicEpeiche_CL.jpg', 'PieBavarde_PRM.jpg', 'pinson-arbre-oiseau.jpg', 
'RougeGorge3_PRM.jpg', 'RougeQueueFrontBlanc_PR.jpg', 'TourterelleTurque_DG.jpg'];
$oiseaux = ["L''étourneau", 'Le Martin Pecheur', 'La mésange bleue', 
                'Le moineau domestique', 'Le pic épeiche', 'La pie bavarde', 'Le pinson', 
                'Le rouge gorge', 'Le rouge queue', 'La tourterelle'];
$latin = ['Sturnus vulgaris', 'Acedo atthis', 'Parus caeruleus', 
            'Passer domesticus', 'Dendrocopos major', 'Pica pica', 'Fringilla coelebs', 
            'Erithacus rubecula', 'Phoenicurus phoenicurus', 'Streptopelia decaocto'];
$size = ['22', '25', '11.5', '15', '22-23', '44 à 48', '15', '14', '14', '32'];
$texte = [
"L''étourneau est un oiseau de taille moyenne, il a un bec jaune pointu et un plumage tacheté. Les plumes noirâtres ont des reflets métalliques, bleus, verts et violets. Après la mue estivale, la livrée est tachetée car l''extrémité des
plumes s''éclaircit. Ces marques sont plus nombreuses chez les jeunes. Au printemps, le plumage est plus foncé, car les marques claires ont disparu par usure et le mâle a l''air plus coloré que la femelle, avec un fond bleu vers
la cuisse. En automne, son plumage se couvre de nombreuses pointes blanches très caractéristiques. Son plumage nuptial, dépourvu de pointes blanches, se teinte de reflets vert et violacé. Reconnaissable en vol à ses ailes triangulaires
et pointues.", 
"Le martin-pêcheur est à peine plus grand qu''un moineau. La partie supérieure est fortement colorée de turquoise et de bleu, les ailes sont plus foncées. Les joues et le dessous sont roux-orange, la gorge est blanche. La femelle porte
de l''orange sur le bas de la cuisse. Lorsqu''il est aperçu en vol, le plumage reflète des tons bleu et orange brillants qui captent la lumière. C''est un oiseau timide, que l''on entend bien avant de le voir : son appel est sonore,
aigu et strident, portant très loin.", 
"C''est la mésange la plus connue et la seule espèce d''Europe qui soit bleue.
Elle est plus petite et plus ronde que la mésange charbonnière, avec un bec plus court.Ce sont de véritables acrobates. Les mésanges bleues recherchent souvent leur nourriture suspendue à de fines branches, c''est pourquoi elles 
préfèrent les boules ou les anneaux de graisse. Malgré leur taille modeste, elles sont très batailleuses et généralement
très agressives et elles n''hésitent pas à chasser de la mangeoire des espèces de même taille qu''elles, telles les mésanges noires ou nonnette.Quelquefois, elles osent même se mesurer à la mésange charbonnière pourtant plus grande. 
La mésange bleue menace les autres oiseaux en gonflant son plumage, ce qui la fait paraître plus grosse. Elles voyagent en troupes éparses en hiver, se disputant
parfois pour se poser sur les distributeurs de graines et de noisettes disposés pour elles. Outre sa formidable capacité, propre à la famille des mésanges, d''ouvrir les graines en martelant leur coque, la mésange bleue se distingue
par une autre méthode : elle incise la coque grâce à son bec tranchant et picore la graine morceau par morceau. En marquant des mésanges bleues, on s''est aperçu que plus d''une centaine pouvait se succéder dans un jardin, même si on
n''en voit que quelques-unes à un moment donné.", 
"Le moineau mâle est un bel oiseau coloré qui se distingue par sa couronne et sa nuque grise avec des coins brun chocolat des deux côtés de la tête, par son bavoir noir, contrastant avec les joues blanches. Plus la bavette du mâle est
grande, plus il connaît de succès auprès des femelles. Le dessus est un mélange de brun, de sable et de gris avec des barres blanches dans les ailes. Dans les villes, leur plumage est souvent plus terne qu''en milieu rural.La femelle 
 du moineau domestique, de même que les jeunes sont des oiseaux plus ternes. Elle n''a pas de noir sur la tête. Cependant, si on l''observe de très près, on remarquera la gamme subtile des tons de brun et de gris de son plumage
avec le dessus rosâtre terminé par du noir, le dessous gris rosâtre et une large rayure crème au-dessus et derrière l''œil.", 
"Le plus répandu de nos pics, le pic épeiche est un oiseau superbe avec son étonnant plumage noir et blanc. Le dessus du pic épeiche est principalement noir, avec de grandes taches blanches, ovales sur les ailes et des rayures sur les
rémiges. En dessous, il est blanc avec une tache rouge écarlate sur le ventre, près de la queue. Le motif de la tête strié de noir entoure des joues blanches. Le mâle porte également une petite tache rouge sur la nuque, absente
chez la femelle.", 
"La pie possède une très longue queue, parfois en éventail et un plumage noir et blanc éclatant, composé de subtiles nuances de vert et de pourpre et un bec puissant.", 
"C''est aussi l''un des plus communs de nos oiseaux de jardin. De la taille d''un moineau, il est facilement reconnaissable à la double barre alaire blanche et aux rectrices externes blanches de la queue, surtout visible en vol. C''est
un oiseau particulièrement coloré, le mâle se distingue par le haut de la tête et la nuque bleu cendré, le dessous orange-rosé et les bandes alaires blanches et le croupion verdâtre.La femelle du pinson ressemble énormément à la femelle 
du moineau domestique, mais peut être différenciée par sa bande alaire blanche et son bec conique et tranchant. Comme pour le mâle, on voit son croupion verdâtre en vol.", 
"Le mâle et la femelle sont presque identiques, avec une couronne, des ailes, le dessus et la queue de couleur brune, une bande grise sur les côtés de la gorge, un ventre blanc et la fameuse  ''gorge rouge'', plus précisément de couleur
orange foncé. L''identification des jeunes peut se révéler difficile, car il leur manque la tache rouge et ils présentent un plumage brun tacheté.Le rouge-gorge est légèrement plus petit qu''un moineau, il est rondelet et haut sur pattes, 
ses grands yeux noirs sont également caractéristiques.", 
"Chez les deux sexes, queue rousse, tremblotante. Le mâle ne peut être confondu. La femelle est brun grisâtre dessus et roussâtre pâle dessous.", 
"Plus petite et plus mince qu''un pigeon avec plumage de couleur rosé-brun sable. Sa coloration est plus claire et plus uniforme que celle de la tourterelle des bois. Le collier autour du cou, qui lui vaut son nom (croissant turc) est
noir avec des extrémités blanches. Ce demi-collier noir et blanc est absent chez les jeunes. Les ailes sont tachetées de noir. En vol, les extrémités blanchâtres et le dessous blanc de la queue, contraste avec le corps brun clair."
];

echo "|---textes--|";
for ($i = 0; $i < count($images); $i++) {
    $res = $pdo->exec("INSERT INTO post SET
        name='{$oiseaux[$i]}',
        slug='{$faker->slug}',
        picture='{$images[$i]}',
        scientific='{$latin[$i]}',
        size='{$size[$i]}',
        created_at ='{$faker->date} {$faker->time}',
        content='{$texte[$i]}'");
    $posts[] = $pdo->lastInsertId();
    echo "\n post-" .$i . ": ". $res . " ==== \n". $texte[$i];
}
$habitat = ['Ville', 'Campagne', 'Montagne', 'Champs', 'Jardin', 'Forêt', 'Bocages', 'Bosquets', 'Parcs', 'Mer'];
for ($i = 0; $i < count($habitat); $i++) {
    $pdo->exec("INSERT INTO category SET
        name='{$habitat[$i]}',
        slug='{$faker->slug}'");
    $categories[] = $pdo->lastInsertId();
    echo "|";
}
foreach ($posts as $post) {
    $randomCategories = $faker->randomElements($categories, 2);
    foreach ($randomCategories as $category) {
        $pdo->exec("INSERT INTO post_category SET
                            post_id={$post},
                            category_id={$category}");
        echo "|";
    }
}
$password = password_hash('admin', PASSWORD_BCRYPT);
echo "||";
$pdo->exec("INSERT INTO user SET
        username='admin',
        password='{$password}'");
echo "||]";