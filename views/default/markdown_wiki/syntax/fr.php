<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki Syntax file
 **/
 
$clickToExpand = elgg_echo('markdown_wiki:syntax:clicktoexpand');

$body = <<<HTML
<div id="syntaxPane" class="pane hidden mlm pas">

<h2>Manuel d'écriture markdown</h2>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-text" title="$clickToExpand"> Texte<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>2 espaces à la fin pour un retour à la ligne, _italique_ ou **gras**</span>
</h3>

<div id="link-text" style="display: none;">

	<h4 id="link-linebreaks">Retour à la ligne</h4>
	<p>Terminez une ligne par 2 espaces pour ajouter un retour à la ligne <code>&lt;br/&gt;</code> :</p>
	<pre>Quel est le nouveau paradigme ?<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><br/>Décroissance quantitative et croissance qualitative</pre>
	
	<h4 id="link-italics-bold">Italique et gras</h4>
	<pre><span class="hi">*</span>Cette phrase est en italique<span class="hi">*</span>, et la tour de Pise <span class="hi">_</span>en Italie<span class="hi">_</span>.
	<span class="hi">**</span>Ce texte est en gras<span class="hi">**</span>, et mal se nourrir rend <span class="hi">__</span>gras aussi<span class="hi">__</span>.
	Vous pouvez <span class="hi">***</span>aussi écrire en gras et italique<span class="hi">***</span> et trouver <span class="hi">___</span>des gras en Italie<span class="hi">___</span>.</pre>

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-headers" title="$clickToExpand"> Titres<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>Soulignez par = ou - ou utilisez des #</span>
</h3>

<div id="link-headers" style="display: none;">

	<p>Soulignez le titre pour créer des titres de niveau <code>&lt;h1&gt;</code> et <code>&lt;h2&gt;</code> :</p>
	<pre>Titre 1
		<span class="hi">========</span>
		Titre 2
		<span class="hi">--------</span>
	</pre>

	<p>Le nombre de = ou - n&#39;a pas d&#39;importance, un seul signe marchera. Il est quand même recommandé de souligner tout le titre pour que ce soit plus agréable en texte plein.</p>
	<p>Vour pouvez aussi utiliser le dièse pour créer différent niveau de titre :</p>
	<pre><span class="hi">#</span> Titre 1 <span class="hi">#</span>
		<span class="hi">##</span> Titre 2 <span class="hi">##</span>
		<span class="hi">###</span> Titre 3 <span class="hi">###</span>
		<span class="hi">####</span> Titre 4 <span class="hi">####</span>
	</pre>
	<p>Les dièses après le titre sont facultatifs.</p>
	&nbsp;

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-horizontal-rules" title="$clickToExpand"> Ligne horizontale<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>3 ou plus de -, + ou *</span>
</h3>

<div id="link-horizontal-rules" style="display: none;">

	<p>Insérez une ligne horizontale <code>&lt;hr/&gt;</code> en écrivant 3 ou plus de signe moins, astérisques, or trait du bas à la suite :</p>
	<pre><span class="hi">---</span></pre>
	<pre>Ligne horizontale 1<br/><span class="hi">---</span>
		Ligne horizontale 2<br/><span class="hi">*******</span>
		Ligne horizontale 3<br/><span class="hi">___</span>
	</pre>
	<p>Mettre des espaces entre les caractères marche aussi :</p>
	<pre>Ligne horizontale 4<br/><span class="hi">- - - -</span></pre>

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-lists" title="$clickToExpand"> Listes<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>Faites des puces avec -, + ou * et numérotation avec 1.</span>
</h3>

<div id="link-lists" style="display: none;">

	<h4 id="link-simple-lists">Liste simple</h4>
	<p>Une liste <code>&lt;ul&gt;</code> à puces :</p>
	<pre><div class="bl">un retour à la ligne</div>
		<span class="hi">-</span><span class="spaces">&nbsp;</span>Utilisez le signe moins pour une puce
		<span class="hi">+</span><span class="spaces">&nbsp;</span>ou le signe plus
		<span class="hi">*</span><span class="spaces">&nbsp;</span>ou un astérisque
		<div class="bl">un retour à la ligne</div>
	</pre>
	<p>Une liste <code>&lt;ol&gt;</code> numérotée :</p>
	<pre><div class="bl">un retour à la ligne</div>
		<span class="hi">1.</span><span class="spaces">&nbsp;</span>Un un et un point, facile
		<span class="hi">2.</span><span class="spaces">&nbsp;</span>Markdown fait la numérotation à votre place
		<span class="hi">7.</span><span class="spaces">&nbsp;</span>donc ce sera le numéro 3 qui sera affiché ici.
		<div class="bl">un retour à la ligne</div>
	</pre>

	<h4 id="link-advanced-lists">Utilisation avançée des listes</h4>
	<p>Pour ajouter une liste dans une liste, il faut indenter chaque niveau de 4 espaces :</p>
	<pre><div class="bl">un retour à la ligne</div>
		<span class="hi">1.</span><span class="spaces">&nbsp;</span>Liste à puces dans une liste numérotée :
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="hi">-</span><span class="spaces">&nbsp;</span>Indenté.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="hi">*</span><span class="spaces">&nbsp;</span>Indenté de 8 espaces.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="hi">-</span><span class="spaces">&nbsp;</span>Et de nouveau indenté de 4 espaces.
		<span class="hi">2.</span><span class="spaces">&nbsp;</span>Multiple paragraphes dans une liste :
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>C&#39;est plus lisible d&#39;indenter un paragraphe de 4 espaces.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>Vous pouvez en mettre 2,
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>mais ça peut porter à confusion.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>Bref, 4 c&#39;est bien.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>Vous pouvez aussi faire plusieurs paragraphes dans une liste.<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>
		Ce paragraphe fait encore parti de la liste, mais il est un peu décalé et moins lisible pour les humains. Pour y remédier, indentez manuellement le paragraphe.
		<span class="hi">3.</span><span class="spaces">&nbsp;</span>Bloc de code dans une liste :
		<div class="bl">un retour à la ligne</div>
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>Sautez une ligne et indentez de 8 espaces.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>C&#39;est 4 espaces pour la liste,
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>et 4 espaces pour le bloc de code.
		<span class="hi">4.</span><span class="spaces">&nbsp;</span>Citation dans une liste :
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="hi">&gt;</span><span class="spaces">&nbsp;</span>indentez le &gt; par 4 espaces.
		<div class="bl">un retour à la ligne</div>
	</pre>

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#blockquotes" title="$clickToExpand"> Bloc de citation<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>Commencez par &gt;</span>
</h3>

<div id="blockquotes" style="display: none;">

	<p>Ajoutez <code>&gt;</code> au début de la ligne pour faire un <code>&lt;blockquote&gt;</code>.</p>
	<pre><span class="hi">&gt;</span> La syntaxe est la même que les mails.
	Une fois un bloc de citation commençé, le &gt; n&#39;est pas obligatoire, mais c&#39;est plus lisible.
	Pour sortir du bloc de citation, il faut un retour à la ligne.
	<div class="bl">un retour à la ligne</div>
	</pre>

	<h4>Utilisation avançée des citations</h4>
	<p>Citation dans une citation :</p>
	<pre><span class="hi">&gt;</span> Le début de la citation.
		<span class="hi">&gt;</span> <span class="hi">&gt;</span> Et hop, un autre bloc de citation !
		<span class="hi">&gt;</span> <span class="hi">&gt;</span> <span class="hi">&gt;</span> <span class="hi">&gt;</span> Vous pouvez en faire tant que vous voulez.
	</pre>
	<p>Les listes dans une citation :</p>
	<pre><span class="hi">&gt;</span><span class="hi">-</span><span class="spaces">&nbsp;</span>Tout simplement
		<span class="hi">&gt;</span><span class="hi">-</span><span class="spaces">&nbsp;</span>avec un &gt; et un espace devant
		<span class="hi">&gt;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="hi">*</span><span class="spaces">&nbsp;</span>Une sous-liste.
	</pre>
	<p>Bloc de code dans une citation :</p>
	<pre><div class="bl">un retour à la ligne</div>
		<span class="hi">&gt;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>Indentez de 5 espaces au total.  Le premier
		<span class="hi">&gt;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>est pour la citation.
	</pre>
	
</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-links" title="$clickToExpand"> Liens<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>[foo](http://foo.com)</span>
</h3>

<div id="link-links" style="display: none;">

	<h4 id="link-basic-links">Liens simples</h4>
	<p>Il y a 3 manières de faire un lien :</p>
	<pre>Voici un lien direct vers <span class="hi">[http://www.google.com/]()</span>.
		Ici, un lien formaté vers <span class="hi">[Google](http://www.google.com/)</span>.
		Et un lien avec référence <span class="hi">[Google][1]</span>.
		Ou encore avec référence, mais plus lisible <span class="hi">[Yahoo!][yahoo]</span>.
		Et avec référence, mais implicite <span class="hi">[Wikipedia][]</span>.<br/>
		<span class="hi">[1]:</span> http://www.google.com/
		<span class="hi">[yahoo]:</span> http://www.yahoo.com/
		<span class="hi">[Wikipedia]:</span> http://www.wikipedia.org/
	</pre>
	<p>La définition du lien peut apparaître n&#39;importe où dans le document. Avant ou après le lien.
	Le nom de référence <code>[1]</code> et <code>[yahoo]</code> doit être unique, et n&#39;est pas sensible à la casse :
	<code>[yahoo]</code> est identique à <code>[YAHOO]</code>.</p>

	<h4 id="link-relative-links">Liens relatifs</h4>
	<p>Le parser Markdown a été modifié pour supporter les liens "relatifs" à la manière des wikis :</p>
	<pre>Ceci est un lien <span class="hi">[une page]()</span>.
		Un autre lien formaté vers <span class="hi">[une autre page](le lien)</span>.
		Et un lien avec référence vers <span class="hi">[encore une autre page][1]</span>.<br/>
		<span class="hi">[1]:</span> le lien
	</pre>
	<p>Le lien sera en bleu si la page existe et en rouge si elle n&#39;a pas encore été crée, mais pas dans la prévisualisation.</p>
	<p>Vous pouvez aussi faire un lien vers une page d&#39;un autre groupe.
	Le lien doit commencer par <code>/wiki/group/GUID/page/</code>, où GUID est le GUID du groupe. De cette façon :</p>
	<pre>Ceci est un lien vers la page d&#39;accueil de <span class="hi">[le groupe](/wiki/group/42/page/accueil)</span>.
		Et un lien avec référence vers <span class="hi">[une autre page du groupe][1]</span>.<br/>
		<span class="hi">[1]:</span> /wiki/group/42/page/la page
	</pre>

	<h4 id="link-advanced-links">Liens en mode avançé</h4>
	<p>Les liens peuvent avoir un attribut title, qui sera affiché au survol de la souris. Les attributs title sont utiles si le lien n&#39;est pas assez précis sur la direction auquel il pointe.</p>
	<pre>Un lien avec son attribut title <span class="hi">[lien pas assez descriptif](http://www.google.com/ "Google")</span>.
		Et en lien avec référence <span class="hi">[us][web]</span>.<br/>
		<span class="hi">[web]:</span> http://elgg.org/ "Elgg"
	</pre>
	<p>Vous pouvez aussi utilisez les liens standards en HTML :</p>
	<pre>&lt;a href="http://example.com" title="example"&gt;example&lt;/a&gt;</pre>

	<h4 id="link-bare-links">Liens entre signe inférieur et supérieur</h4>
	<p>Vous pouvez aussi écrire un lien entouré des signes inférieur et supérieur :</p>
	<pre>Voici un lien <span class="hi">&lt;</span>http://example.com<span class="hi">&gt;</span></pre>

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-image" title="$clickToExpand"> Images<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>![foo](http://foo.com/img.jpeg)</span>
</h3>

<div id="link-image" style="display: none;">

	<p>Ajouter une image se fait comme les liens, mais avec un point d&#39;exclamation avant le crochet. :</p>
	<pre>![foo](http://foo.com/img.jpeg).</pre>
	<p>Le mot entre crochets correspond à l&#39;attribut alt text, qui sera affiché si le navigateur ne peut pas trouver l&#39;image.</p>
	<p>Comme les liens, une image peut être définie avec un lien en référence :</p>
	<pre>Cette image est <span class="hi">![foo][foo]</span>.
	<span class="hi">[foo]:</span> http://foo.com/img.jpeg
			 "Image foo"
	</pre>
	<p>Vous pouvez utilisez un lien implicite :</p>
	<pre>Ceci <span class="hi">![foo][]</span> fonctionne.</pre>
	<p>Le mot en référence servira aussi pour l&#39;attribut alt text.</p>
	<p>Vous pouvez aussi utiliser le code HTML standard, qui vous permet de définir la taille de l&#39;image :</p>
	<pre>&lt;img src="http://foo.com/img.jpeg" width="100" height="100"&gt;</pre>
	<p>L&#39;URL peut être relative ou entière.</p>
	&nbsp;

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-code" title="$clickToExpand"> Block de code<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>Indetez la ligne de 4 espaces</span>
</h3>

<div id="link-code" style="display: none;">

	<p>Indenter la ligne de 4 espaces créé un block de code <code>&lt;pre&gt;</code><code>&lt;code&gt;</code> :</p>
	<pre>
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>printf("Changez le monde !");
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>printf("Faites un pas de côté...");
	</pre>

	<p>Le texte sera entouré par la balise de code, et affiché avec une police de caractère monospace.</p>
	<p>La syntaxe Markdown et HTML seront ignorés dans un bloc de code :</p>
	<pre>
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>&lt;blink&gt;
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>   Vous n&#39;aimeriez pas ça si ce 
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>   n&#39;était pas dans un bloc de code.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>&lt;/blink&gt;
	</pre>
	
	<p>Il est possible de faire un bloc de code d&#39;une autre façon, en entourant le code par 3 backticks <code>```</code>. Vous pouvez ajouter le type de code qu&#39;il contient afin que le code soit coloré :
	<pre>```php
			echo = 'C&#39;est génial !';
		```
	</pre>

	<h4 id="link-code-spans">Code sur une ligne</h4>
	<p>Utilisez un simple backticks <code>`</code> pour écrire du code dans une ligne ou paragraphe :</p>
	<pre>Pressez les touches <span class="hi">`</span>&lt;Ctrl + Alt&gt;<span class="hi">`</span>, et appuyer sur <span class="hi">`</span>suppr<span class="hi">`</span>.</pre>
	<p>(La touche backticks est en haut à gauche de la plupart des claviers.)</p>
	<p>Comme les blocs de code, le code sur une ligne sera affiché avec une police de caractère monospace. La syntaxe Markdown et HTML seront ignorés.</p>
	&nbsp;

</div>

<h3><a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-html" title="$clickToExpand">
	Syntaxe HTML<span class="expander-arrow-small-hide expander-arrow-small-show">
</a></h3>

<div id="link-html" style="display: none;">

	<p>Si vous avez besoin de quelques choses que la syntaxe Markdown ne peut pas faire, utilisez du HTML. Notez que seules quelques balises HTML sont supportées :</p>
	<pre> Pour redémarrer votre ordinatuer, pressez <span class="hi">&lt;kbd&gt;</span>ctrl<span class="hi">&lt;/kbd&gt;</span>+&lt;kbd&gt;alt&lt;/kbd&gt;+&lt;kbd&gt;del&lt;/kbd&gt;.
	</pre>
	<p>La syntaxe Markdown fonctionne avec les balises HTML span:</p>
	<pre><span class="hi">&lt;b&gt;</span>La syntaxe Markdown marche <span class="hi">*</span>bien<span class="hi">*</span> ici.<span class="hi">&lt;/b&gt;</span>
	</pre>
	<p>Les bolcs HTML ont quelques restrictions :</p>
	<ol>
		<li>La balise d&#39;ouverture et de fermeture ne doivent pas être indentées.</li>
		<li>La syntaxe Markdown ne peut pas être utilisée entre des balises HTML.</li>
	</ol>
	<pre><span class="hi">&lt;pre&gt;</span>Vous ne pouvez <span class="hi">&lt;em&gt;</span>pas<span class="hi">&lt;/em&gt;</span> utiliser la syntaxe Markdown ici.<span class="hi">&lt;/pre&gt;</span>
	</pre>

</div>

<h3><a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-need-more-detail" title="$clickToExpand">
	En savoir plus ?<span class="expander-arrow-small-hide expander-arrow-small-show">
</a></h3>

<div id="link-need-more-detail" style="display: none;">

	<p>Visitez <a target="_blank" href="http://michelf.ca/projets/php-markdown/syntaxe/	">cette page</a>.</p><br/>

</div>

</div>
HTML;

echo str_replace("\t",'',$body);