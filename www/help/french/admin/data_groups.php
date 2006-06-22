<?
  $b = dirname(__FILE__);
  include("$b/admin_header.php");
?>
<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr>
  <td class='cell'>
    <p>Un goupe de données quasiement une simple liste.</p>
    
    <p>Il consiste en une liste d'éléments de type de données chargée depuis    la base de donnée, une liste de valeurs entrées manuellemnt, ou une liste    de données créées dynamiquement grâce à du code JavaScript</p>
    
    <p>Vous pouvez visualiser les types de données existant et en créer d'autres en consultant :
    <br><b><?=tr('Admin')?> -&gt; 
           <?=tr('Settings Administration')?> -&gt;
           <?=tr('Edit Data Groups')?></b></p>
  </td>    
</tr>
<tr>
  <td class='titleCell'>Les champs d'un groupe de données</td>
</tr>
<tr>
  <td class='cell'>  
    <table width='80%' align='center'>
    <tr>
      <td class='subTitle'>Champ</td>
      <td class='subTitle'>Sujet</td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Table Name')?></td>
      <td class='bars'>
         Nom de la table de type de données à laquelle faire référence.          Choisir personaliser (custum) si vous souhaiter valoriser les champs         manuellement ( plutôt que de les choisir à partir de la liste de la base de donnée)         ou si vous souhaitez utiliser Javascript.     </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Group Name')?></td>
      <td class='bars'>
        Un nom significatif pour votre groupe de données, tel que 'Les priorités de l'Ingégnérie'
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Description')?></td>
      <td class='bars'>
        Tout commentaitre ou annotation jugé opportun pour ce groupe.
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Eval Type')?></td>
      <td class='bars'>
        Utiliser '<?=tr('Matches')?>' afin de choisir une liste d'éléments depuis la         base de données ou manuellement saisir les choix.
        
        <p>Utiliser <?=tr('Javascript')?> afin de saisir du code JavaScript lequel        créera la liste d'éléments.
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Eval Script')?></td>
      <td class='bars'>
        Ceci n'est disponible que lorsque <?=tr('Eval Type')?> est valorisé à  <?=tr('Javascript')?>.
        
        <p>Le code javascript peut être inséré après copie directement tel qu'il sera évalué.
        
        <p>Voir plus loin dans les listes Javascript la section pour plus de d'information sur ce champ.</p>
      </td>
    </tr>
    </table>

  </td>
</tr>
<tr>
  <td class='titleCell'>Data Type Lists</td>
</tr>
<tr>
  <td class='cell'>
    <p>Une liste de type de donnée est créée en choisissant le nom de la table dans
    le champ <?=tr('Table Name')?> .  Une fois le groupe de données créé vous pouvez    cliquer sur le lien <?=tr('Entries')?> afin de sélécitonner les éléments dans une     liste d'éléments valides.</p>
    
    <p>Une liste de type de données est le <b>meilleur</b> moyen permettant d'utiliser    la fonctionnalité des groupes de données.</p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Listes personnalisées (constituées manuellement)</td>
</tr>
<tr>
  <td class='cell'>
    <p>Une liste personnalisée est créée par la sélection de l'option '<?=tr('Custom')?>' depuis    le champ <?=tr('Table Name')?> et '<?=tr('Matches')?>' depuis le champ
    <?=tr('Eval Type')?>.
    
    <p>Une fois le groupe de données créé, cliquer sur le lien 
    <?=tr('Entries')?> produira un menu où vous pouvez manuellement    entrer le choix qui apparaitra.
    </p>
    
    <p>Une liste personnalisée n'est <b>pas conseillée</b> pour  
    tous les champs standard de fiche, mais est très utile pour 
    les valeurs variables de champ.
    </p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Listes créées à partir de fichiers.</td>
</tr>
<tr>
  <td class='cell'>
    <p>By choisissant le type  de ' fichier ' d'Eval, vous pouvez employer
	le contenu d'un fichier délimité par étiquette des tags pour
	créer des groupes de données.  Ce dispositif est conçu pour être
	employé avec des mécanismes.

	<p>le fichier à employer aura du être placé dans le répertoire
	de zentrack/includes/user_data.

	<p>Une fois ceci accompli, le reste du travail est fait à partir
	de l'écran des mécanismes.

  </td>
</tr>
<tr>
  <td class='titleCell'>Listes JavasScript</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>Des listes de Javascript devraient toujours être employées avec
	beaucoup d'attention, et ne sont pas recommandées pour n'importe qui
	sans expérience de programmation étendue.</p>
    
    <p>Des listes de Javascript sont créées par l'utilisation du choix '<?=tr('Custom')?>' du champ     <?=tr('Table Name')?> et '<?=tr('Javascript')?>' depuis le champs
    <?=tr('Eval Type')?>.</p>
    
    <p>Vous n'emploierez pas le lien <?=tr('Entries')?> avec les listes Javascript.
    
    <p>La propriété particulière <b>{formulaire}</b> peut être employée comme
	pointeur vers l'objet courant forumulaire (elle est traduite vers 
	window.document.formName pendant l'évaluation).  C'est utile pour 
	poiinter vers d'autres champs du formulaire en utilisant le javascript.</p>
    
    <p>La propriété particulière <b>{champ}</b> peut être employée comme
	pointeur vers l'objet courant de champ (elle est traduite vers
	window.document.formName.fieldName).  Ceci peut être utile pour
	l'usage du même javascript dans des mécanismes multiples (des
	mécanismes sont décrits dans la prochaine section).
    
    <p>On s'attend du code de javascript qu'il crée un tableau appelée
	<b>x</b> qui contiendra un <b>simple table</b> des valeurs ou un
	<b>tableau d'objects</b> avec deux propriétés:  étiquette et valeur.

    
    <p>Voici quelques exemples :</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Exemple 1: Tableau simple</td>
      </tr>
      <tr>
        <td class='bars'>
<pre>
<b>Ce code Javascript:</b>
var x = new Array();
for(i=1; i &lt; 4; i++) {
  //Chaque poste est juste la valeur de i
  x[ x.length ] = i;
}

<b>Aura pour résultat :</b>
  [ 1, 2, 3 ]

<b>Ainsi, un menu employant ces valeurs obtiendrait :</b>
  &lt;option value='1'&gt;1&lt;/option&gt;
  &lt;option value='2'&gt;2&lt;/option&gt;
  &lt;option value='3'&gt;3&lt;/option&gt;
 
<b>Un champ texte employant ces valeurs obtiendrait simplement :</b>
  &lt;input type='...' value='1'&gt;
</pre>
        </td>
      </tr>
    </table>

    <p>Un exemple plus compliqué :</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Exemple 2: Table d'ojets</td>
      </tr>
      <tr>
        <td class='bars'>
<pre>
<b>Le Code:</b>
var x = new Array();
for(i=1; i &lt; 4; i++) {
  //chaque valeur est un objet avec une étiquette et une valeur
  x[ x.length ] = { label:'item_'+i, value:i };
}

<b>Aura pour résultat :</b>
[
   [ 'item_1', 1 ],
   [ 'item_2', 2 ],
   [ 'item_3', 3 ]
]

<b>Ainsi, un menu employant ces valeurs obtiendrait:</b>
  &lt;option value='1'&gt;item_1&lt;/option&gt;
  &lt;option value='2'&gt;item_2&lt;/option&gt;
  &lt;option value='3'&gt;item_3&lt;/option&gt;
 
<b>Un champ texte employant ces valeurs obtiendrait simplement :</b>
  &lt;input type='...' value='1'&gt;
</pre>
        </td>
      </tr>
    </table>
    
    <p>En utilisant la propriété {formulaire} :</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Exemple 3: La propriété {formulaire} </td>
      </tr>
      <tr>
        <td class='bars'>
<pre>
<b>Admettons que :</b>
  &lt;input type='text' name='custom_number1' value='10'&gt;
  
<b>Ce Code:</b>
var x = new Array();
var x[0] = {form}.custom_number1 + 20;

<b>Aura pour résultat :</b>
[ 30 ]

<b>Ainsi, un menu employant ces valeurs obtiendrait:</b>
  &lt;option value='30'&gt;30&lt;/option&gt;

<b>Un champ texte employant ces valeurs obtiendrait simplement :</b>
 &lt;input type='...' value='30'&gt;

</pre>
        </td>
      </tr>
    </table>
    
    
    <p>Un exemple très compliqué :</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Exemple 4: Substitution Javascript très compliquée : </td>
      </tr>
      <tr>
        <td class='bars'>
<pre>
<b>Admettons que :</b>
  &lt;select name='priority&gt;
    &lt;option value='1'&gt;high&lt;/option&gt;
    &lt;option value='2'&gt;medium&lt;/option&gt;
    &lt;option value='3'&gt;low&lt;/option&gt;
  &lt;/select&gt;
  
  &lt;input type='text' name='custom_string_1' value='aaaa'&gt;
  &lt;input type='text' name='custom_string_2' value='bbbb'&gt;
  
<b>Le Code:</b>
  // ce script ajoute des valeurs placées dans custom_string1 
  // et custom_string2 aux priorités 'dropdown'
  
  // créer notre table qui sera employée pour peupler des champs
  var x = new Array();
  
  // raccourci aux options dans le menu priorité
  var options = {form}.priority.options;
  
  // raccourci à la valeur custom_string des champs
  var f1 = {form}.custom_string1.value;
  var f2 = {form}.custom_string2.value;
  
  // recréer le menu avec existantes des valeurs
  for( var i=0; i &lt; options.length; i++ ) {
    // place chque valeur dans le menu existant 
    // dans notre nouveau tableau
    x[ x.length ] = 
      { label:options[i].text, value:options[i].value };
  
    //s'assure que le menu ne contient pas déjà notr valeur de 
    // champ, si c'est le cas s'assure que nous ne l'ajoutons pas de nouveau
    if( options[i].value == f1 ) { f1 = null; }
    if( options[i].value == f2 ) { f2 = null; }
  }
  
  // add values of our custom fields to the array
  if( f1 ) {
    x[ x.length ] = f1;
  }
  if( f2 ) {
    x[ x.length ] = f2;
  }
  
  // maintenant quand ceci sera évalué, le tableau x 
  // contiendra les valeurs de menu existantes
  // plus tout ce que nous avons ajouté via custom_string fields!

<b>Would Create:</b>
[
  { label:'high',   value:1 }
  { label:'medium', value:2 }
  { label:'low',    value:3 }
  [ aaaa ]
  [ bbbb ]
]

<b>Ainsi, un menu employant ces valeurs obtiendrait:</b>
    &lt;option value='1'&gt;high&lt;/option&gt;
    &lt;option value='2'&gt;medium&lt;/option&gt;
    &lt;option value='3'&gt;low&lt;/option&gt;
    &lt;option value='aaaa'&gt;aaaa&lt;/option&gt;
    &lt;option value='bbbb'&gt;bbbb&lt;/option&gt;

<b>Un champ texte employant ces valeurs obtiendrait simplement :</b>
 &lt;input type='...' value='1'&gt;
 (pas réellement très utile ici)
</pre>
        </td>
      </tr>
    </table>

    
  </td>
</tr>
</table>

<? 
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
