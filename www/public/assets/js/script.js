var nbComments = 0;
/* afficher tous les commentaires enregistrés à l'ouverture de l'article */
afficheCommentaires();

/* affichage d'un texte dans l'élément id */
function afficheTexte(texte, id) {
    document.getElementById(id).innerHTML = texte;
}

/* clic sur commenter pour ajouter un commentaire à l'article */
function comment(elt) {
    var nId = "id" + elt.id.toString();
    var textnId = "text" + elt.id.toString();
    var commentnId = "ul" + elt.id.toString();
    var errnId = "err" + elt.id.toString();

    if (document.getElementById(textnId).value != "") {
        nbComments++;
        document.getElementById(commentnId).innerHTML += "<li>" + document.getElementById(textnId).value + "</li>";
        ajouteCommentaire(document.getElementById(textnId).value);
        document.getElementById(textnId).value = "";
        document.getElementById(errnId).style.color = "black";
        document.getElementById(nId).innerHTML = nbComments.toString() + " commentaire(s)";
    } else {
        document.getElementById(errnId).style.color = "red";
    }


}

/* afficher le nombre de commentaires de l'article */
function AfficheNbComment(numid) {
    var nId = "id" + numid.toString();
    document.getElementById(nId).innerHTML = nbCommentMesange.toString() + " commentaires";

}

/* ajout d'un commentaire dans le localStorage de la page */
function ajouteCommentaire(texte) {
    var gNotifications = [];
    var comment = document.location.href.split("/").pop();
    comment = comment.split(".")[0];

    if (localStorage.getItem(comment) == null) {
        localStorage.setItem(comment, "");
    }
    if (localStorage.getItem(comment).length > 0) {
        gNotifications = JSON.parse(localStorage.getItem(comment));
    } else {
        gNotifications.length = 0;
    }
    gNotifications.push(texte);
    localStorage.setItem(comment, JSON.stringify(gNotifications));

}

/* afficher tous les commentaires enregistrés de l'article */
function afficheCommentaires() {
    nbComments = 0;
    var gNotifications = [];
    var comment = document.location.href.split("/").pop();
    comment = comment.split(".")[0];
    if (localStorage) {
        if (localStorage.getItem(comment) != null) {
            if (localStorage.getItem(comment).length > 0) {
                gNotifications = JSON.parse(localStorage.getItem(comment));
                for (var i = 0; i < gNotifications.length; i++) {
                    nbComments++;
                    document.getElementById("ul1").innerHTML += "<li>" + gNotifications[i] + "</li>";
                }
            }

        }

    }
}

/* recherche d'un texte dans les titres des articles de la page d'accueil */
function recherche() {
    var text = document.getElementById("search_button").value.toUpperCase();
    var listeH2 = document.querySelectorAll('h2');
    for (var i = 0; i < listeH2.length; i++) {
        if (listeH2[i].innerText.toUpperCase().indexOf(text) >= 0) {
            listeH2[i].style.color = "red";
        } else {
            listeH2[i].style.color = "black";
        }
    }
}

function search() {
    var texte = $("#search_button").val();
    var offset = 0;
    var span = "<span style='background-color:yellow'>";
    var span2 = "</span>";
    var re = new RegExp('(' + texte + ')(?![^<]*>)', "gi");
    $('span').contents().unwrap();

    var content = $('.wrapper').html();
    content = content.replace(re, span + '$&' + span2);
    $('.wrapper').html(content);

    $("#searchSaisie").val("");
}