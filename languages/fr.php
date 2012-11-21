<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki English language
 **/

$french = array(

	/**
	 * Menu items and titles
	 */
	'markdown_wiki' => "Wikis",
	'markdown_wiki:owner' => "Les pages éditées par %s",
	'markdown_wiki:groupowner' => "Les pages du groupe %s",
	'markdown_wiki:friends' => "Les pages éditées par vos abonnés",
	'markdown_wiki:all' => "Toutes les pages",
	'markdown_wiki:group' => "Wiki du groupe",
	'markdown_wiki:home' => "accueil", // If home pages already created, don't change it !
	'wiki:edit' => "Ajouter une page",

	'groups:enable_markdown_wiki' => "Activer le wiki du groupe",

	'markdown_wiki:none' => "Pas de page créée pour l'instant",
	
	'markdown_wiki:edit' => "Édition de la page \"%s\"",
	'markdown_wiki:history' => "Historique de la page \"%s\"",
	'markdown_wiki:discussion' => "Discussion sur la page \"%s\"",
	'markdown_wiki:compare' => "Comparer les révisions de la page \"%s\"",
	'markdown_wiki:compare:result' => "Différences des révisions de la page \"%s\"",
	'markdown_wiki:page:edit' => "Éditer la page",
	'markdown_wiki:page:history' => "Historique",
	'markdown_wiki:page:discussion' => "Discussion",
	'markdown_wiki:page:compare' => "Comparer les révisions",
	
	'markdown_wiki:search_in_group' => "Chercher une page dans le groupe %s",
	'markdown_wiki:search_in_group:or_create' => "ou en créer une",
	'markdown_wiki:search_in_all_group' => "Chercher une page dans tous les groupes",
	'markdown_wiki:search:title' => "Résultat de la recherche %s",
	'markdown_wiki:search:in_text:title' => "Autres pages contenant %s :",

	'markdown_wiki:sidebar:granularity' => "Granularité",
	'markdown_wiki:sidebar:history' => "Historique",
	'markdown_wiki:sidebar:history:50max' => "50 max",
	'markdown_wiki:sidebar:compare:from' => "Depuis",
	'markdown_wiki:sidebar:compare:to' => "vers",
	'markdown_wiki:granularity:character' => "Caractère",
	'markdown_wiki:granularity:word' => "Mot",
	'markdown_wiki:granularity:sentence' => "Phrase",
	'markdown_wiki:granularity:paragraph' => "Paragraphe",
	'markdown_wiki:del' => 'sup',
	'markdown_wiki:ins' => 'ins',
	'markdown_wiki:toggle-modification' => "Afficher/masquer les modifications",
	'markdown_wiki:redirect_from' => "Redirigé depuis",
	
	'markdown_wiki:compare:button' => "Comparer ces révisions",
	
	'markdown_wiki:settings' => "Options du wiki",
	'markdown_wiki:group:settings:title' => "Options du wiki du groupe %s",
	'markdown_wiki:group:settings:option' => "Afficher toutes les pages au lieu de la page d'accueil",
	'markdown_wiki:group:settings:info' => "Activez cette option pour que le lien de la sidebar pointe sur toutes les pages wikis du groupe et non sur la page wiki d'accueil",

	/**
	* River
	**/
	'river:create:object:markdown_wiki' => "%s a créé la page %s",
	'river:comment:object:markdown_wiki' => "%s a commenté la page %s",
	'river:update:object:markdown_wiki' => "%s a modifié la page %s",

	/**
	* Widget
	**/
	'markdown_wiki:num' => "Nombre de pages à afficher :",
	'markdown_wiki:widget:description' => "Affiche vos dernières pages éditées.",
	'markdown_wiki:more' => "Plus...",

	/**
	 * Form fields
	 */
	'markdown_wiki:description' => "Texte",
	'markdown_wiki:summary' => "Résumé de votre modification",
	'markdown_wiki:minorchange' => "Changement mineur. Votre modification ne sera pas notifiée dans l'activité du groupe.",
	'markdown_wiki:tags' => "Tags",
	'markdown_wiki:write_access_id' => "Accès en écriture",

	'markdown_wiki:preview' => "Prévisualisation",
	'markdown_wiki:HTML_output' => "Sortie HTML",
	'markdown_wiki:syntax' => "Guide de syntaxe markdown",

	'markdown_wiki:search:result:not_found' => "Il n'y a pas de résultat correspondant à votre recherche.",
	'markdown_wiki:search:result:not_found:create_it' => "Créer la page %s dans le wiki du groupe %s.",
	'markdown_wiki:search:result:not_found:similar' => "Regardez d'abord dans les résultats de recherche si il existe une page similaire.",
	'markdown_wiki:search:result:found:page' => "Il y a une page nommée %s dans le wiki du groupe %s.",

	/**
	 * Status and error messages
	 */
	'markdown_wiki:no_access' => "Vous ne pouvez pas éditer cette page.",
	'markdown_wiki:error:no_access' => "Vous n'avez pas la permission d'éditer cette page.",
	'markdown_wiki:delete:success' => "Page supprimée.",
	'markdown_wiki:delete:failure' => "La page n'a pas été supprimée.",
	'markdown_wiki:error:no_group' => "Le groupe n'a pas été défini.",
	'markdown_wiki:error:no_title' => "Il faut mettre un titre.",
	'markdown_wiki:error:no_description' => "Vous devez écrire le texte de la page.",
	'markdown_wiki:error:no_entity' => "La page n'a pas été définie.",
	'markdown_wiki:error:no_save' => "La page ne peut pas être enregistrée.",
	'markdown_wiki:error:already_exist' => "Une page avec le même nom existe déjà.",
	'markdown_wiki:saved' => "La page a été enregistrée.",
	'markdown_wiki:redirected' => "La page a été redirigée depuis %s",
	'markdown_wiki:group:settings:save:success' => "Options enregistrées.",
	'markdown_wiki:group:settings:save:failed' => "Impossibles d'enregistrer les options.",

	/**
	 * Object
	 */
	'item:object:markdown_wiki' => "Pages",
	'markdown_wiki:strapline' => "Dernière modification %s par %s dans le groupe %s",
	
	'markdown_wiki:history:date' => "Par %s le",
	'markdown_wiki:history:date_format' => "%e %B %Y à %H:%M",

);

add_translation('fr', $french);
