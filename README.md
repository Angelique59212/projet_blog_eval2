**Blog Symfony**

**--> Micro Cahier des Charges**

    ==> Utilisateur:
        -> Ajouter des commentaires aux articles présent

    ==> Utilisateur / Auteur:
        -> Ajout d'articles + commentaires

    ==> Moderator:
        -> Editer + Suppression de commentaires + Ajout de commentaires

    ==> Administrateur:
        -> Ajout d'article + Ajout de comms + Editer / Supprimer des commentaires

**--> Eval**

    (==> Chaque article a une image de couverture)
    (==> L'utilisateur possède un avatar, si il n'en met pas il y en a un par défaut )
    (==> L'article en écriture s'enregistre en brouillon)
    ==> Tout le texte doit être en Anglais trad côté twig pour le français
    ==> il peut choisir sa langue
    (==> slug généré pour le titre)



**--> Commencement**

     **-> Réalisation MCD et MLD**

**--> Blog**

    -> Tout le monde peut lire les articles sans être connectés

**--> Utilisateurs**
    
    -> Inscription
    -> Connexion
    -> Déconnexion
    -> Ajout de comms
    
**--> Auteur** 
    
    -> Ajout d'articles mais peut également écrire des commentaires

**--> Modérateur**

    -> Peut à la fois ajouter des commentaires, les modifier et les supprimer

**--> Administrateur**
        
    -> Création de l'espace administrateur 
    -> Ajouter un article 
    -> Ajouter un commentaire
    -> Modifier un commentaire
    -> Supprimer un commentaire

**--> Rôle**

    -> Utilisateur
    -> Auteur
    -> Modérateur
    -> Administrateur

__**--> Cours correspondant**__

1. Ajouter public dans service pour les avatars 
2. Pour les articles (voir, modif, suppr) ==> **Gestion des routes**
3. Pour l'avatar ==> **Autowiring**
4. Messages success..., SideBar, Slug ==> **Gérer la partie front**
5. Pour définir la route vers l'article, importer l'image ==> {{**path**}}
6. Lever une exception si l'user n'a pas les droits ==> **Manipuler les données**
7. Pour brouillon ==> **ispublished(boolean) + submit multiples**
