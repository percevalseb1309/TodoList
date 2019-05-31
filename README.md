# ToDoList [![Codacy Badge](https://api.codacy.com/project/badge/Grade/76d72a296a3845aaa7c1b9d0863be8d8)](https://www.codacy.com/app/percevalseb1309/TodoList?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=percevalseb1309/TodoList&amp;utm_campaign=Badge_Grade)

__OpenClassrooms project :__ Improve an existing application

![Notebook](web/img/todolist_content.jpg)

## Summary

*   [Assignment](#assignment)

## Assignment

### Contexte

Vous venez d’intégrer une startup dont le coeur de métier est une application permettant de gérer ses tâches quotidiennes. L’entreprise vient tout juste d’être montée, et l’application a dû être développée à toute vitesse pour permettre de montrer à de potentiels investisseurs que le concept est viable (on parle de Minimum Viable Product ou MVP). Le choix du développeur précédent a été d’utiliser le framework PHP Symfony.

ToDo & Co a enfin réussi à lever des fonds pour permettre le développement de l’entreprise et surtout de l’application.

Votre rôle ici est donc d’améliorer la qualité de l’application. La qualité est un concept qui englobe bon nombre de sujets : on parle souvent de qualité de code, mais il y a également la qualité perçue par l’utilisateur de l’application ou encore la qualité perçue par les collaborateurs de l’entreprise et enfin la qualité que vous percevez lorsqu’il vous faut travailler sur le projet.

Ainsi, pour ce projet de spécialisation, vous êtes dans la peau d’un développeur expérimenté en charge des tâches suivantes :
*   l’implémentation de nouvelles fonctionnalités
*   la correction de quelques anomalies
*   l’implémentation de tests automatisés

Il vous est également demandé d’analyser le projet grâce à des outils vous permettant d’avoir une vision d’ensemble de la qualité du code et des différents axes de performance de l’application.

Il ne vous est pas demandé de corriger les points remontés par l’audit de qualité de code et de performance. Ceci dit, si le temps vous le permet, ToDo & Co sera ravi que vous réduisiez la dette technique de cette application.

### Description du besoin

#### Corrections d'anomalies

##### Une tâche doit être attachée à un utilisateur

Actuellement, lorsqu’une tâche est créée, celle-ci n’est pas rattachée à un utilisateur. Il vous est demandé d’apporter les corrections nécessaires afin qu’automatiquement, à la sauvegarde de la tâche, l’utilisateur actuellement authentifié soit rattaché à la tâche nouvellement créée.

Lors de la modification de la tâche, l’auteur ne peut pas être modifié.

Pour les tâches déjà créées, il faut qu’elles soient rattachées à un utilisateur “anonyme”.

##### Choisir un rôle pour un utilisateur

Lors de la création d’un utilisateur, il doit être possible de choisir un rôle pour celui-ci. Les rôles listés sont les suivants :
*   rôle utilisateur (ROLE_USER)
*   rôle administrateur (ROLE_ADMIN)

Lors de la modification d’un utilisateur, il est également possible de changer le rôle d’un utilisateur.

#### Implémentation de nouvelles fonctionnalités

##### Autorisation

Seuls les utilisateurs ayant le rôle administrateur (ROLE_ADMIN) doivent pouvoir accéder aux pages de gestion des utilisateurs.

Les tâches ne peuvent être supprimées que par les utilisateurs ayant créé les tâches en questions.

Les tâches rattachées à l’utilisateur “anonyme” ne peuvent être supprimées que par les utilisateurs ayant le rôle administrateur (ROLE_ADMIN).

##### Implémentation de tests automatisés

Il vous est demandé d’implémenter les tests automatisés (test unitaires et fonctionnels) pour s'assurer que le fonctionnement de l’application est bien en adéquation avec les demandes.

Ces tests doivent être implémentés avec PHPUnit.

Vous prévoirez des données de tests afin de pouvoir prouver le fonctionnement dans les cas explicités dans ce document.

Il vous est demandé de fournir un rapport de couverture de code au terme du projet. Il faut que le taux de couverture soit supérieur à 70%.

### Documentation technique

Il vous est demandé de produire une documentation expliquant comment l’implémentation de l'authentification a été faite. Cette documentation se destine aux prochains développeurs juniors qui rejoindront l’équipe dans quelques semaines. Dans cette documentation, il doit être possible pour un débutant avec le framework Symfony de :
*   comprendre quel(s) fichier(s) il faut modifier et pourquoi
*   comment s’opère l’authentification
*   où sont stockés les utilisateurs

Par ailleurs, vous ouvrez la marche en matière de collaboration à plusieurs sur ce projet. Il vous est également demandé de produire un document expliquant comment devront procéder tous les développeurs souhaitant apporter des modifications au projet.

Ce document devra aussi détailler le processus de qualité à utiliser ainsi que les règles à respecter.

### Audit de qualité du code & performance de l'application

Les fondateurs souhaitent pérenniser le développement de l’application, ceci dit, il souhaite dans un premier temps faire un état des lieux de la dette technique de l’application.

Au terme de votre travail effectué sur l’application il vous est demandé de produire un audit de code sur les deux axes suivants : la qualité de code et la performance.

Bien évidemment, il est fortement conseillé que vous utilisiez des outils vous permettant d’avoir des métriques pour appuyer vos propos.

Concernant l’audit de performances, l’usage de Blackfire est obligatoire, ce dernier vous permettra de produire des analyses précises et adaptées aux évolutions futures du projet.
