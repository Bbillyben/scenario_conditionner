# Scenario Conditionner plugin pour Jeedom

<p align="center">
  <img width="100" src="/plugin_info/scenario_conditionner_icon.png">
</p>

Ce plugin permet d'activer ou désactiver des scénarios en fonction de l'évaluation d'une condition.

La condition est évaluée en entrée (vrai) ou en sortie (faux) et les actions sont paramétrables sur ces deux points.


# |Configuration|
  
  1. activer le plugin
  
  2. Configurations :  pas de configuration
  
  3. créer un premier équipement
 
  
 # |Equipement|
 <p align="center">
  <img width="100%" src="/plugin_info/img/equipement.PNG">
</p>

 

 ### Paramètres généraux      
 
 * __Nom de l'équipement__ 
 * __Objet parent__ 
 * __Catégorie__ 
 * __Options__

 Comme tout équipement classique
 
 ### Résumé des scénarios et Actions
 Ici sont résumés les scénarios configurés dans l'onglet "Scenario Conditioner", ainsi que les actions paramétrées en entrée et en sortie de condition.
 
 
 ### Condition  
  * __Condition à évaluer__ : Condition que Jeedom évaluera (voir testeur d'expression) pour définir si nous entrons dans la condition (==vrai) ou en sortons (==faux). Le bouton sur la droite permet de sélectionner des commandes info à évaluer (comportement similaire à celui dans les scénarios pour les blocs **si**)
  *  __Tester__ : Bouton permettant d'ouvrir le testeur d'expression avec la condition préremplie pour test.
 
 # Commandes
  
 Quatre commandes sont créées avec l'équipement : 
* __Status__ : Donne le status vrai/faux qui est lié soit à l'évaluation de la condition ou à une valeur forcée par les commandes force entrée ou force sortie
* __Force Vérification__ : force l'évaluation de la condition
* __Force Entrée__ : force les actions en entrée, et bascule le status à vrai
* __Force Sortie__ : force les actions en sortie, et bascule le status à faux


 # Scénarios
 <p align="center">
  <img width="100%" src="/plugin_info/img/scenario.png">
</p>

Ici vous ajoutez les scénarios que vous voulez gérer, et définissez les actions en entrée et en sortie de condition

* __Ajouter un scenario__ : ajoute une commande "scenario"
* cliquez sur l'icône à côté du champ scénario pour ouvrir le sélectionneur de scénario;
* choisissez les actions en entrée et en sortie parmi :
  * __Activer__ : activer le scénario
  * __Activer et lancer__ : active le scenario et le lance avec les tags dérfini dans le champs tags
  * __Désactiver__ : désactiver le scénario
  * __Ne rien Faire__ : n'agit pas sur le changement de condition (en entrée ou en sortie)
 
 

