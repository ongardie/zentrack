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
    <p>Un goupe de donn�es quasiement une simple liste.</p>
    
    <p>Il consiste en une liste d'�l�ments de type de donn�es charg�e depuis    la base de donn�e, une liste de valeurs entr�es manuellemnt, ou une liste    de donn�es cr��es dynamiquement gr�ce � du code JavaScript</p>
    
    <p>Vous pouvez visualiser les types de donn�es existant et en cr�er d'autres en consultant :
    <br><b><?=tr('Admin')?> -&gt; 
           <?=tr('Settings Administration')?> -&gt;
           <?=tr('Edit Data Groups')?></b></p>
  </td>    
</tr>
<tr>
  <td class='titleCell'>Les champs d'un groupe de donn�es</td>
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
         Nom de la table de type de donn�es � laquelle faire r�f�rence.          Choisir personaliser (custum) si vous souhaiter valoriser les champs         manuellement ( plut�t que de les choisir � partir de la liste de la base de donn�e)         ou si vous souhaitez utiliser Javascript.     </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Group Name')?></td>
      <td class='bars'>
        Un nom significatif pour votre groupe de donn�es, tel que 'Les priorit�s de l'Ing�gn�rie'
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Description')?></td>
      <td class='bars'>
        Tout commentaitre ou annotation jug� opportun pour ce groupe.
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Eval Type')?></td>
      <td class='bars'>
        Utiliser '<?=tr('Matches')?>' afin de choisir une liste d'�l�ments depuis la         base de donn�es ou manuellement saisir les choix.
        
        <p>Utiliser <?=tr('Javascript')?> afin de saisir du code JavaScript lequel        cr�era la liste d'�l�ments.
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Eval Script')?></td>
      <td class='bars'>
        Ceci n'est disponible que lorsque <?=tr('Eval Type')?> est valoris� �  <?=tr('Javascript')?>.
        
        <p>Le code javascript peut �tre ins�r� apr�s copie directement tel qu'il sera �valu�.
        
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
    <p>Une liste de type de donn�e est cr��e en choisissant le nom de la table dans
    le champ <?=tr('Table Name')?> .  Une fois le groupe de donn�es cr�� vous pouvez    cliquer sur le lien <?=tr('Entries')?> afin de s�l�citonner les �l�ments dans une     liste d'�l�ments valides.</p>
    
    <p>Une liste de type de donn�es est le <b>meilleur</b> moyen permettant d'utiliser    la fonctionnalit� des groupes de donn�es.</p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Listes personnalis�es (constitu�es manuellement)</td>
</tr>
<tr>
  <td class='cell'>
    <p>Une liste personnalis�e est cr��e par la s�lection de l'option '<?=tr('Custom')?>' depuis    le champ <?=tr('Table Name')?> et '<?=tr('Matches')?>' depuis le champ
    <?=tr('Eval Type')?>.
    
    <p>Une fois le groupe de donn�es cr��, cliquer sur le lien 
    <?=tr('Entries')?> produira un menu o� vous pouvez manuellement    entrer le choix qui apparaitra.
    </p>
    
    <p>Une liste personnalis�e n'est <b>pas conseill�e</b> pour  
    tous les champs standard de fiche, mais est tr�s utile pour 
    les valeurs variables de champ.
    </p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Listes cr��es � partir de fichiers.</td>
</tr>
<tr>
  <td class='cell'>
    <p>By choisissant le type  de ' fichier ' d'Eval, vous pouvez employer
	le contenu d'un fichier d�limit� par �tiquette des tags pour
	cr�er des groupes de donn�es.  Ce dispositif est con�u pour �tre
	employ� avec des m�canismes.

	<p>le fichier � employer aura du �tre plac� dans le r�pertoire
	de zentrack/includes/user_data.

	<p>Une fois ceci accompli, le reste du travail est fait � partir
	de l'�cran des m�canismes.

  </td>
</tr>
<tr>
  <td class='titleCell'>Listes JavasScript</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>Des listes de Javascript devraient toujours �tre employ�es avec
	beaucoup d'attention, et ne sont pas recommand�es pour n'importe qui
	sans exp�rience de programmation �tendue.</p>
    
    <p>Des listes de Javascript sont cr��es par l'utilisation du choix '<?=tr('Custom')?>' du champ     <?=tr('Table Name')?> et '<?=tr('Javascript')?>' depuis le champs
    <?=tr('Eval Type')?>.</p>
    
    <p>Vous n'emploierez pas le lien <?=tr('Entries')?> avec les listes Javascript.
    
    <p>La propri�t� particuli�re <b>{formulaire}</b> peut �tre employ�e comme
	pointeur vers l'objet courant forumulaire (elle est traduite vers 
	window.document.formName pendant l'�valuation).  C'est utile pour 
	poiinter vers d'autres champs du formulaire en utilisant le javascript.</p>
    
    <p>La propri�t� particuli�re <b>{champ}</b> peut �tre employ�e comme
	pointeur vers l'objet courant de champ (elle est traduite vers
	window.document.formName.fieldName).  Ceci peut �tre utile pour
	l'usage du m�me javascript dans des m�canismes multiples (des
	m�canismes sont d�crits dans la prochaine section).
    
    <p>On s'attend du code de javascript qu'il cr�e un tableau appel�e
	<b>x</b> qui contiendra un <b>simple table</b> des valeurs ou un
	<b>tableau d'objects</b> avec deux propri�t�s:  �tiquette et valeur.

    
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

<b>Aura pour r�sultat :</b>
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

    <p>Un exemple plus compliqu� :</p>
    
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
  //chaque valeur est un objet avec une �tiquette et une valeur
  x[ x.length ] = { label:'item_'+i, value:i };
}

<b>Aura pour r�sultat :</b>
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
    
    <p>En utilisant la propri�t� {formulaire} :</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Exemple 3: La propri�t� {formulaire} </td>
      </tr>
      <tr>
        <td class='bars'>
<pre>
<b>Admettons que :</b>
  &lt;input type='text' name='custom_number1' value='10'&gt;
  
<b>Ce Code:</b>
var x = new Array();
var x[0] = {form}.custom_number1 + 20;

<b>Aura pour r�sultat :</b>
[ 30 ]

<b>Ainsi, un menu employant ces valeurs obtiendrait:</b>
  &lt;option value='30'&gt;30&lt;/option&gt;

<b>Un champ texte employant ces valeurs obtiendrait simplement :</b>
 &lt;input type='...' value='30'&gt;

</pre>
        </td>
      </tr>
    </table>
    
    
    <p>Un exemple tr�s compliqu� :</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Exemple 4: Substitution Javascript tr�s compliqu�e : </td>
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
  // ce script ajoute des valeurs plac�es dans custom_string1 
  // et custom_string2 aux priorit�s 'dropdown'
  
  // cr�er notre table qui sera employ�e pour peupler des champs
  var x = new Array();
  
  // raccourci aux options dans le menu priorit�
  var options = {form}.priority.options;
  
  // raccourci � la valeur custom_string des champs
  var f1 = {form}.custom_string1.value;
  var f2 = {form}.custom_string2.value;
  
  // recr�er le menu avec existantes des valeurs
  for( var i=0; i &lt; options.length; i++ ) {
    // place chque valeur dans le menu existant 
    // dans notre nouveau tableau
    x[ x.length ] = 
      { label:options[i].text, value:options[i].value };
  
    //s'assure que le menu ne contient pas d�j� notr valeur de 
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
  
  // maintenant quand ceci sera �valu�, le tableau x 
  // contiendra les valeurs de menu existantes
  // plus tout ce que nous avons ajout� via custom_string fields!

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
 (pas r�ellement tr�s utile ici)
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
