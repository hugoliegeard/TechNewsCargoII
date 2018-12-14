-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 14 Décembre 2018 à 15:56
-- Version du serveur :  10.1.13-MariaDB
-- Version de PHP :  5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `technews`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `membre_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `special` tinyint(1) NOT NULL,
  `spotlight` tinyint(1) NOT NULL,
  `date_creation` datetime NOT NULL,
  `status` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`id`, `categorie_id`, `membre_id`, `titre`, `slug`, `contenu`, `featured_image`, `special`, `spotlight`, `date_creation`, `status`) VALUES
(1, 2, 4, '"On a vingt ans de retard" : avant d''accueillir la COP24, Katowice fait mine de combattre la pollution', 'on-a-vingt-ans-de-retard-avant-d-accueillir-la-cop24-katowice-fait-mine-de-combattre-la-pollution', '<p>Dix mètres, puis cinquante, puis cent-cinquante. Le drone déploie ses ailes dans le ciel de Katowice, en Pologne, qui accueillera la COP24 du 3 au 14 décembre. Bourré de capteurs, l''engin renifle tout ce qui passe sous son nez. Au sol, Sylwia Jarosławska-Sobór contrôle les résultats en temps réel sur l''écran d''un ordinateur portable. "Ici, c''est le taux de monoxyde de carbone, là, c''est la poussière dans l''air… Rien ne lui échappe, assure cette ingénieure du Głównego Instytutu Górnictwa. Après un vol, il arrive que les absorbeurs soient tout sales à cause des particules fines que l''appareil a trouvées sur son passage. C''est assez incroyable."</p>', '16164503.jpg', 1, 1, '2018-11-30 09:45:34', 'a:1:{s:9:"published";i:1;}'),
(2, 2, 2, 'Les "gilets jaunes" attendus à Matignon', 'gilets-jaunes-des-porte-parole-recus-a-matignon', '<p>Plus tôt dans la journée, le ministre de l''Intérieur, Christophe Castaner, a estimé que le mouvement n''était "pas un phénomène de masse".</p>', '16556325.jpg', 0, 1, '2018-11-30 09:45:34', 'a:1:{s:9:"published";i:1;}'),
(3, 2, 4, 'Emmanuel Macron et les "gilets jaunes" : les raisons de l''impossible dialogue', 'emmanuel-macron-et-les-gilets-jaunes-les-raisons-de-limpossible-dialogue', '<h2>Mauvaise lecture de la victoire d&#39;Emmanuel Macron en 2017, mirage d&#39;une adh&eacute;sion massive aux id&eacute;es d&eacute;fendues par le chef de l&#39;Etat, propos jug&eacute;s m&eacute;prisants &agrave; l&#39;&eacute;gard des Fran&ccedil;ais en difficult&eacute;... De nombreux facteurs expliquent la situation inextricable dans laquelle le chef de l&#39;Etat et sa majorit&eacute; se retrouvent aujourd&#39;hui, analyse le chercheur Arnaud Mercier.</h2>\r\n\r\n<p><em>Arnaud Mercier, auteur de cet article, est professeur en information-communication &agrave; l&rsquo;Institut fran&ccedil;ais de presse (IFP), Universit&eacute; Paris 2 Panth&eacute;on-Assas.&nbsp;<a href="https://theconversation.com/gilets-jaunes-versus-emmanuel-macron-aux-racines-de-lincommunication-108048" rel="nofollow" target="_blank">La version originale de cet article</a>&nbsp;a &eacute;t&eacute; publi&eacute;e sur le site The Conversation, dont franceinfo est partenaire.</em></p>\r\n\r\n<hr />\r\n<p>Les conditions d&#39;une n&eacute;gociation ouverte entre l&#39;ex&eacute;cutif et les manifestants sont loin d&#39;&ecirc;tre r&eacute;unies, ne serait-ce que parce que le mouvement n&#39;a de culture organisationnelle ni des manifestations ni de la n&eacute;gociation.</p>\r\n\r\n<p>Mais au-del&agrave; du d&eacute;faut de structuration des gilets jaunes, le plus inqui&eacute;tant pour la suite des &eacute;v&eacute;nements tient au&nbsp;<a href="https://theconversation.com/le-gouvernement-face-aux-gilets-jaunes-les-conditions-de-la-communication-107902" rel="nofollow" target="_blank">terreau d&#39;incommunication</a>&nbsp;avec l&#39;ex&eacute;cutif, sur lequel le mouvement est en train de d&eacute;g&eacute;n&eacute;rer. Les rh&eacute;toriques divergent et donnent &agrave; la situation pr&eacute;sente toutes les caract&eacute;ristiques d&#39;une impasse, comme en attestent le verbatim des slogans et tweets des manifestants.</p>\r\n\r\n<h2>&quot;J&#39;ai &eacute;t&eacute; &eacute;lu par choix, pour appliquer mon programme&quot;</h2>\r\n\r\n<p>L&#39;&eacute;norme erreur d&#39;appr&eacute;ciation de l&#39;&eacute;quipe &eacute;lys&eacute;enne et de l&#39;actuelle majorit&eacute; est de croire que le large succ&egrave;s de 2017 refl&egrave;te&nbsp;<a href="https://theconversation.com/la-presidentielle-de-2017-est-une-election-par-defaut-75991" rel="nofollow" target="_blank">un vote d&#39;adh&eacute;sion</a>. L&#39;incroyable ascension du candidat Macron a aliment&eacute; un narratif journalistique fait de fascination et d&#39;aveuglement. Fascination pour un succ&egrave;s inattendu d&#39;un novice en campagne &eacute;lectorale. Aveuglement quant aux conditions &eacute;troites de sa victoire. Aveuglement partag&eacute; par le premier concern&eacute; qui r&eacute;p&egrave;te en boucle des formules du type :<em>&nbsp;&quot;Les Fran&ccedil;ais ont vot&eacute; pour le changement que j&#39;incarne.&quot;</em>&nbsp;R&eacute;p&eacute;tons, martelons m&ecirc;me, que c&#39;est loin d&#39;&ecirc;tre le cas !</p>\r\n\r\n<p>En effet, d&egrave;s le premier tour, l&#39;enqu&ecirc;te Ipsos aupr&egrave;s de 4&nbsp;700 personnes, r&eacute;alis&eacute;e quelques jours avant le scrutin, montrait des lignes de faiblesse franches et massives. Parmi ceux se d&eacute;clarant certains d&#39;aller voter, les trois motivations test&eacute;es pour le choix des candidats trahissaient un manque d&#39;app&eacute;tence pour le choix Macron.</p>\r\n\r\n<p>Dans les trois cas, son score est le plus significatif par rapport &agrave; ces trois principaux concurrents. Il est le moins l&#39;objet d&#39;un vote d&#39;adh&eacute;sion (seuls 43% votent pour lui car il leur convient), il est le plus un vote par d&eacute;faut (31%) et le plus un vote tactique pour effacer un adversaire ind&eacute;sirable (26%).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt="" src="https://www.francetvinfo.fr/image/75j477zp0-b578/754/386/16589067.jpg" style="width:100%" title=" | " /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Et quand on interroge les m&ecirc;mes sur les qualit&eacute;s attribu&eacute;es aux candidats, l&#39;adh&eacute;sion au programme macronien est minimale. 59 % des &eacute;lecteurs de Fillon s&#39;appr&ecirc;tent &agrave; voter pour lui parce qu&#39;il &quot;a un bon projet&quot;, idem pour 40% des &eacute;lecteurs de M&eacute;lenchon, et seulement 37% des &eacute;lecteurs de Macron et 34% des &eacute;lecteurs de Le Pen (dont la dimension protestataire du vote l&#39;emporte souvent sur le projet lui-m&ecirc;me). Ce parall&egrave;le protestataire avec la candidate du FN se retrouve dans une autre r&eacute;ponse : 65% des &eacute;lecteurs Le Pen veulent voter pour elle car elle incarne le changement et 64% des &eacute;lecteurs Macron pour lui (contre seulement 39% M&eacute;lenchon et 7% Fillon).</p>\r\n\r\n<p>Emmanuel Macron a donc raison sur ce point : il a r&eacute;ussi &agrave; incarner durant la campagne, le changement en politique, changement de g&eacute;n&eacute;ration, de style, de fa&ccedil;on de faire de la politique,&nbsp;<a href="https://theconversation.com/macron-candidat-de-la-protestation-si-si-71018" rel="nofollow" target="_blank">au dessus des partis traditionnels</a>.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Je veux moraliser et responsabiliser la vie publique, et renouveler la repr&eacute;sentation nationale.Emmanuel Macrondans son programme officiel de candidat en 2017</p>\r\n\r\n<p>Il a reconnu devant la presse pr&eacute;sidentielle, le 13 f&eacute;vrier 2018, qu&#39;il avait b&eacute;n&eacute;fici&eacute; d&#39;une d&eacute;sesp&eacute;rance politique, affirmant avec lucidit&eacute; :<em>&nbsp;&quot;Je ne suis pas l&#39;enfant naturel de temps calmes de la vie politique, je suis le fruit d&#39;une forme de brutalit&eacute; de l&#39;Histoire, d&#39;une effraction, parce que la France &eacute;tait malheureuse et inqui&egrave;te.&quot;</em></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Il a donc pu laisser croire que le vote pour Macron et ses candidats aux l&eacute;gislatives servirait &agrave; donner un grand coup de balai sur les forces habituelles de gouvernement (ce qui fut le cas), tout en renouvelant l&#39;exercice du pouvoir au profit d&#39;<a href="https://theconversation.com/reforme-constitutionnelle-le-macronisme-horizontal-en-campagne-et-vertical-au-pouvoir-93593" rel="nofollow" target="_blank">une d&eacute;mocratie plus directe et horizontale</a>(ce qui n&#39;est toujours pas le cas &agrave; ce jour).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>&quot;Maintenir le cap social-lib&eacute;ral&quot;</h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Mais, surtout, son &eacute;lection ne signifiait pas un changement de logiciel socio-&eacute;conomique vers un social-lib&eacute;ralisme en rupture avec la tradition sociale-&eacute;tatiste interventionniste. Tous les malheurs de l&#39;impopularit&eacute; d&#39;Emmanuel Macron reposent sur cette funeste analyse de s&#39;&ecirc;tre cru mandat&eacute; pour une politique n&eacute;o-lib&eacute;rale qui n&#39;&eacute;tait pas celle &agrave; laquelle aspiraient les Fran&ccedil;ais, m&ecirc;me pas une bonne partie de ceux qui ont vot&eacute; pour lui.</p>\r\n\r\n<p>Dans les &eacute;tudes conduites sur la recherche des valeurs d&eacute;finissant &quot;l&#39;&eacute;lecteur social-lib&eacute;ral&quot; lors des r&eacute;gionales de 2015, Luc Rouban peine &agrave; d&eacute;gager plus de 6% des enqu&ecirc;t&eacute;s.&nbsp;<a href="https://theconversation.com/quest-ce-que-le-liberalisme-egalitaire-comprendre-la-philosophie-de-macron-76808" rel="nofollow" target="_blank">Le socle id&eacute;ologique</a>&nbsp;des &eacute;lecteurs totalement en phase avec la synth&egrave;se programmatique originale offerte par Emmanuel Macron est donc extr&ecirc;mement faible.</p>\r\n\r\n<p>Si vous ajoutez que, d&#39;apr&egrave;s les m&ecirc;mes calculs,<em>&nbsp;&quot;au total, son &eacute;lectorat r&eacute;unit 63 % d&#39;&eacute;lecteurs anti-lib&eacute;raux, qu&#39;ils soient de droite ou de gauche&quot;</em>(Luc Rouban,&nbsp;<em><a href="http://www.pressesdesciencespo.fr/fr/livre/?GCOI=27246100208540" rel="nofollow" target="_blank">Le paradoxe du macronisme</a></em>, 2018, p.56), les graines de l&#39;incompr&eacute;hension totale ne pouvaient que germer en quelques mois.</p>\r\n\r\n<h2>Le mirage de l&#39;adh&eacute;sion massive</h2>\r\n\r\n<p>M&ecirc;me s&#39;il est encore impossible de disposer d&#39;&eacute;tudes pr&eacute;cises et fiables dressant un portrait sociologique des manifestants, les propos recueillis face aux micros ou sur les r&eacute;seaux socionum&eacute;riques montrent une population qui partage majoritairement quelques caract&eacute;ristiques. Une large majorit&eacute; n&#39;a pas vot&eacute; pour Emmanuel Macron &agrave; la pr&eacute;sidentielle de 2017, ni au premier tour &ndash; car beaucoup se disent si &eacute;c&oelig;ur&eacute;s de la politique&nbsp;<a href="https://theconversation.com/des-elections-sans-electeurs-le-fleau-de-labstention-massive-79708" rel="nofollow" target="_blank">qu&#39;ils ne votent plus</a>&ndash;, ni au second tour, o&ugrave; il y avait pourtant un choix binaire tr&egrave;s marqu&eacute; entre deux visions du monde et deux visions de la d&eacute;mocratie r&eacute;publicaine.</p>\r\n\r\n<p>Il faut rappeler, &agrave; cet &eacute;gard, que seulement un peu plus de 43% des &eacute;lecteurs inscrits ont choisi de voter Macron au second tour. Et un tiers d&#39;entre eux ont pr&eacute;f&eacute;r&eacute; s&#39;abstenir ou voter blanc ou nul. L&#39;adh&eacute;sion massive du pays n&#39;est donc qu&#39;un mirage dont la R&eacute;publique en Marche s&#39;est nourrie pour affirmer un plan radical de transformation du pays outrepassant les contestations syndicales et les r&eacute;sistances du terrain.</p>\r\n\r\n<p>C&#39;est cette lubie qui continue &agrave; nourrir le discours des responsables gouvernementaux, tel Benjamin Grivaux qui r&eacute;p&egrave;te &agrave; vide un discours de fermet&eacute; (&quot;<em>On a dit que nous ne changerions pas de cap. Parce que le cap est le bon&quot;</em>, dimanche 2 d&eacute;cembre). Comme si le vote Macron avait &eacute;t&eacute; un vote massif d&#39;adh&eacute;sion et que ses &eacute;lecteurs se sentiraient trahis par tout r&eacute;am&eacute;nagement du rythme des r&eacute;formes ou de certaines des mesures embl&eacute;matiques qui les exemplifient.</p>\r\n\r\n<p>Une telle posture remobilise fatalement une partie des manifestants, comme l&#39;exprime ce tweet d&#39;un opposant.</p>\r\n\r\n<p>Ils sont inconscients, nous les #GiletsJaunes nous maintiendrons aussi le capUn internaute sur Twitterdimanche 2 d&eacute;cembre</p>\r\n\r\n<p>Elle alimente l&#39;id&eacute;e qu&#39;il est d&eacute;connect&eacute; des Fran&ccedil;ais.</p>\r\n\r\n<p>Macron ne changera pas de cap car il est id&eacute;ologiquement dans une posture autiste.Un internaute sur Twitterdimanche 2 d&eacute;cembre</p>\r\n\r\n<p>Et l&#39;on voit, d&egrave;s lors, que l&#39;allumette initiale qui mit le feu aux poudres (la nouvelle hausse des taxes sur les carburants) n&#39;est plus d&#39;actualit&eacute;, et que face &agrave; la volont&eacute; farouche de ne rien l&acirc;cher sur cette programmation fiscale, le pouvoir est aujourd&#39;hui aux prises avec une contestation &eacute;largie, d&eacute;bordant de revendications diverses, assez souvent contradictoires.</p>\r\n\r\n<p>Une concession sur l&#39;essence ne suffira donc plus &agrave; ce stade. Et cela permet aux contestataires de retourner l&#39;accusation de blocage contre le pr&eacute;sident.</p>', 'emmanuel-macron-et-les-gilets-jaunes-les-raisons-de-limpossible-dialogue.jpeg', 0, 1, '2018-12-04 14:38:31', 'a:1:{s:7:"refused";i:1;}'),
(5, 2, 4, '"Gilets jaunes" : le préfet de police de Paris prévoit un "dispositif assez semblable à celui de la semaine passée"', 'gilets-jaunes-le-prefet-de-police-de-paris-prevoit-un-dispositif-assez-semblable-a-celui-de-la-semaine-passee', '<h2>Le porte-parole du gouvernement, Benjamin Griveaux, a appel&eacute; les &quot;gilets jaunes&quot; &agrave; &ecirc;tre &quot;raisonnables&quot; et ne pas manifester, &quot;au regard&quot; de l&#39;attentat &agrave; Strasbourg qui a fait trois morts et 13 bless&eacute;s.</h2>\r\n\r\n<p>Quel avenir les&nbsp;<a href="https://www.francetvinfo.fr/economie/transports/gilets-jaunes/">&quot;gilets jaunes&quot;</a>&nbsp;? A la veille d&#39;une possible nouvelle journ&eacute;e de mobilisation, samedi 15 d&eacute;cembre, le leader de la CGT souhaite des&nbsp;<em>&quot;convergences&quot;</em>&nbsp;avec le mouvement.&nbsp;<em>&quot;Il faut des gr&egrave;ves partout&quot;</em>, a lanc&eacute;&nbsp;le secr&eacute;taire g&eacute;n&eacute;ral du syndicat, Philippe Martinez, vendredi 14 d&eacute;cembre. Le pr&eacute;fet de police de Paris a annonc&eacute;&nbsp;<em>&quot;un dispositif&nbsp;</em>[de s&eacute;curit&eacute;]<em>&nbsp;semblable &agrave; celui de la semaine pass&eacute;e&quot;</em>&nbsp;sur&nbsp;<a href="https://www.rtl.fr/actu/debats-societe/gilets-jaunes-un-dispositif-semblable-a-celui-de-la-semaine-derniere-dit-michel-delpuech-7795919496">RTL</a>. L&#39;id&eacute;e est de&nbsp;<em>&quot;se pr&eacute;parer &agrave; la situation qui pourrait &ecirc;tre la pire&quot;</em>.</p>\r\n\r\n<p><strong>&nbsp;Le gouvernement appelle &agrave; ne pas manifester.&nbsp;</strong>Le gouvernement n&#39;a&nbsp;<em>&quot;&agrave; ce stade pas d&eacute;cid&eacute; d&#39;interdire les manifestations&quot;</em>&nbsp;pr&eacute;vues par des &quot;gilets jaunes&quot; samedi mais son porte-parole Benjamin Griveaux les a appel&eacute;s &agrave; &ecirc;tre&nbsp;<em>&quot;raisonnables&quot;</em>,&nbsp;<em>&quot;au regard&quot;</em>&nbsp;de l&#39;attentat&nbsp;&agrave; Strasbourg qui a fait trois morts et 13 bless&eacute;s.</p>\r\n\r\n<p><strong>&nbsp;Sur le terrain, la mobilisation continue.</strong>&nbsp;Au p&eacute;age autoroutier de la Barque, sur l&#39;A8, &agrave; la sortie d&#39;Aix-en-Provence, les gilets jaunes avaient d&eacute;j&agrave; repris leur position dans la nuit de mercredi &agrave; jeudi, avec le soutien sur place de Fran&ccedil;ois Ruffin, le d&eacute;put&eacute; de la Somme. Avant de se faire &agrave; nouveau &eacute;vacuer par les forces de l&#39;ordre.</p>\r\n\r\n<p><strong>&nbsp;Un sixi&egrave;me mort en marge des blocages.</strong>&nbsp;Dans la nuit de mercredi &agrave; jeudi, peu apr&egrave;s minuit, une sixi&egrave;me personne a perdu la vie en lien avec ce conflit, un &quot;gilet jaune&quot; de 23 ans percut&eacute; par un poids lourd, &agrave; la sortie Avignon-sud de l&#39;A7.</p>', 'gilets-jaunes-le-prefet-de-police-de-paris-prevoit-un-dispositif-assez-semblable-a-celui-de-la-semaine-passee.jpeg', 0, 1, '2018-12-14 09:55:37', 'a:2:{s:9:"publisher";i:1;s:7:"refused";i:1;}');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`, `slug`) VALUES
(2, 'Politique', 'politique'),
(3, 'Economie', 'economie'),
(4, 'Education', 'education'),
(5, 'Sports', 'sports');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id` int(11) NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_inscription` datetime NOT NULL,
  `derniere_connexion` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`id`, `prenom`, `nom`, `email`, `password`, `date_inscription`, `derniere_connexion`, `roles`) VALUES
(2, 'Sebastien', 'FARGE', 'hugo.liegeard@tech.news', 'test', '2018-11-30 09:45:34', NULL, 'a:1:{i:0;s:11:"ROLE_AUTEUR";}'),
(3, 'Mickael', 'LOUZET', 'm.louzet@tech.news', '$2y$13$l2bJz2qTc3GWtx9s9odJzeuE0v4MD3p739k46K5NIiXb9F2zGSuhu', '2018-12-05 14:38:36', NULL, 'a:1:{i:0;s:11:"ROLE_MEMBRE";}'),
(4, 'Hugo', 'LIEGEARD', 'hugo.liegeard@technews.fr', '$2y$13$y49Gkb2bXhtlbkRHU2kLFuignACopMhBP5sY3aA3imxn5IfZYpxUy', '2018-12-06 10:16:40', '2018-12-14 13:28:58', 'a:1:{i:0;s:10:"ROLE_ADMIN";}'),
(5, 'Sébastien', 'FARGE', 'sebastien.farge@tech.news', '$2y$13$1aACBoycuGDV6vt.14KrmekiEMhBKYJ.Eqhq0PAIxvB8zcf6zHM/G', '2018-12-14 14:36:00', NULL, 'a:1:{i:0;s:11:"ROLE_MEMBRE";}');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20181129155014'),
('20181130091357'),
('20181207110445'),
('20181214092030');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`) VALUES
(1, 'sebastien.farge@tech.news');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_23A0E66BCF5E72D` (`categorie_id`),
  ADD KEY `IDX_23A0E666A99F74A` (`membre_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_497DD634989D9B62` (`slug`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E666A99F74A` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id`),
  ADD CONSTRAINT `FK_23A0E66BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
